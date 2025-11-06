<?php
/**
 * Signup orchestration service.
 *
 * @package WP_Ultimo
 * @subpackage Models
 * @since 2.0.0
 */

namespace WP_Ultimo\Models;

// Exit if accessed directly
defined('ABSPATH') || exit;

use WP_Error;
use WP_Ultimo\Checkout\Cart;
use WP_Ultimo\Checkout\Checkout;
use WP_Ultimo\Database\Memberships\Membership_Status;
use WP_Ultimo\Database\Payments\Payment_Status;
use WP_Ultimo\Database\Sites\Site_Type;
use WP_Ultimo\Helpers\Validator;
use WP_Ultimo\Managers\Payment_Manager;
use WP_Ultimo\Models\Customer;
use WP_Ultimo\Models\Membership;
use WP_Ultimo\Traits\Singleton;

/**
 * Dedicated signup orchestration service.
 *
 * @since 2.0.0
 */
class Signup_Service {

        use Singleton;

        /**
         * Checkout pipeline reference.
         *
         * @since 2.0.0
         * @var Checkout
         */
        protected $checkout;

        /**
         * Payment manager reference.
         *
         * @since 2.0.0
         * @var Payment_Manager
         */
        protected $payment_manager;

        /**
         * Canonical list of required parameters for signup requests.
         *
         * @since 2.0.0
         * @var array<string,string>
         */
        protected $required_parameter_map = [
                'email'        => 'customer.email — Email used to provision the WordPress user and customer profile.',
                'username'     => 'customer.username — Username associated with the WordPress user created for the membership.',
                'password'     => 'customer.password — Password used during customer creation when a user does not exist.',
                'site_title'   => 'site.site_title — Human friendly title for the provisioned site.',
                'site_slug'    => 'site.site_url — Slug/URL fragment used to derive the site domain and path.',
                'plan_product' => 'products — Selected plan/product identifiers used to hydrate the cart.',
                'gateway'      => 'payment_method.gateway — Gateway identifier used to capture or mark payments during signup.',
        ];

        /**
         * Boots dependencies and exposes filters.
         *
         * @since 2.0.0
         * @return void
         */
        public function init(): void {

                $this->checkout        = Checkout::get_instance();
                $this->payment_manager = Payment_Manager::get_instance();

                add_filter('wu_signup_form_allowed_fields', [$this, 'ensure_default_allowed_fields']);
        }

        /**
         * Returns the canonical required parameter list for signup payloads.
         *
         * @since 2.0.0
         * @return array<string,string>
         */
        public function get_required_parameter_map(): array {

                $map = apply_filters('wu_signup_service_required_parameter_map', $this->required_parameter_map, $this);

                return is_array($map) ? $map : $this->required_parameter_map;
        }

        /**
         * Ensures the signup template allows the default fields and exposes a filter for extensions.
         *
         * @since 2.0.0
         *
         * @param array $allowed Current allowed field identifiers.
         * @return array
         */
        public function ensure_default_allowed_fields($allowed): array {

                $allowed = (array) $allowed;

                $allowed = array_unique(array_merge($allowed, array_keys($this->get_required_parameter_map())));

                /**
                 * Filter the list of default allowed signup form fields exposed by the signup service.
                 *
                 * @since 2.0.0
                 *
                 * @param array          $allowed Allowed field identifiers.
                 * @param Signup_Service $service Signup service instance.
                 */
                return apply_filters('wu_signup_service_allowed_fields', $allowed, $this);
        }

        /**
         * Returns validation rules shared by the REST endpoint and theme helpers.
         *
         * @since 2.0.0
         * @return array<string,string>
         */
        public function get_validation_rules(): array {

                $rules = [
                        'customer_id'       => 'required_without:customer',
                        'customer'          => 'required_without:customer_id',
                        'customer.username' => 'required_without_all:customer_id,customer.user_id',
                        'customer.password' => 'required_without_all:customer_id,customer.user_id',
                        'customer.email'    => 'required_without_all:customer_id,customer.user_id',
                        'customer.user_id'  => 'required_without_all:customer_id,customer.username,customer.password,customer.email',
                        'site.site_url'     => 'required_with:site|alpha_num|min:4|lowercase|unique_site',
                        'site.site_title'   => 'required_with:site|min:4',
                ];

                /**
                 * Filters the signup validation rules used by the signup service.
                 *
                 * @since 2.0.0
                 *
                 * @param array          $rules   Validation rules.
                 * @param Signup_Service $service Signup service instance.
                 */
                return apply_filters('wu_signup_service_validation_rules', $rules, $this);
        }

        /**
         * Validates signup payloads.
         *
         * @since 2.0.0
         *
         * @param array $args Signup arguments.
         * @return true|WP_Error
         */
        public function validate($args) {

                $validator = new Validator();

                $validator->validate($args, $this->get_validation_rules());

                if ($validator->fails()) {
                        return $validator->get_errors();
                }

                return true;
        }

        /**
         * Process a signup request.
         *
         * @since 2.0.0
         *
         * @param array $params Signup request arguments.
         * @return array<string,mixed>|WP_Error
         */
        public function register(array $params) {

                global $wpdb;

                $params = apply_filters('wu_signup_service_pre_register', $params, $this);

                $wpdb->query('START TRANSACTION'); // phpcs:ignore WordPress.DB.DirectDatabaseQuery

                try {
                        $customer = $this->resolve_customer($params);

                        if (is_wp_error($customer)) {
                                return $this->rollback_and_return($customer);
                        }

                        $customer->update_last_login(true, true);

                        $customer->add_note([
                                'text'      => __('Created via REST API', 'ultimate-multisite'),
                                'author_id' => $customer->get_user_id(),
                        ]);

                        $payment_method = $this->normalize_payment_method($params);

                        $cart = $this->build_cart($params);

                        if (is_wp_error($cart)) {
                                return $this->rollback_and_return($cart);
                        }

                        list($membership, $membership_status) = $this->create_membership($params, $cart, $customer, $payment_method);

                        if (is_wp_error($membership)) {
                                return $this->rollback_and_return($membership);
                        }

                        list($payment, $payment_status) = $this->create_payment($params, $cart, $customer, $membership, $payment_method);

                        if (is_wp_error($payment)) {
                                return $this->rollback_and_return($payment);
                        }

                        $site = $this->maybe_provision_site($params, $membership);

                        if (is_wp_error($site)) {
                                return $this->rollback_and_return($site);
                        }

                        if ($membership->get_status() !== $membership_status) {
                                $membership->set_status($membership_status);
                                $membership->save();

                                if ($site) {
                                        $wp_site = get_site_by_path($site['domain'], $site['path']);

                                        if ($wp_site) {
                                                $site['id'] = $wp_site->blog_id;
                                        }
                                }
                        }

                        if ($payment->get_status() !== $payment_status) {
                                $payment->set_status($payment_status);
                                $payment->save();
                        }

                        if ($payment_status === Payment_Status::COMPLETED) {
                                $gateway = wu_get_gateway($payment->get_gateway());

                                if ($gateway) {
                                        $this->payment_manager->handle_payment_success($payment, $membership, $gateway);
                                }
                        }

                        /**
                         * Fires after the signup service finishes provisioning all resources.
                         *
                         * @since 2.0.0
                         *
                         * @param Membership     $membership Membership instance created.
                         * @param Customer       $customer   Customer instance used.
                         * @param \WP_Ultimo\Models\Payment $payment Payment instance created.
                         * @param array|false    $site       Site payload or false when no site was provisioned.
                         * @param array          $params     Original signup payload.
                         * @param Signup_Service $service    Signup service instance.
                         */
                        do_action('wu_signup_service_completed', $membership, $customer, $payment, $site, $params, $this);

                        $wpdb->query('COMMIT'); // phpcs:ignore WordPress.DB.DirectDatabaseQuery

                        return [
                                'membership' => $membership->to_array(),
                                'customer'   => $customer->to_array(),
                                'payment'    => $payment->to_array(),
                                'site'       => $site ?: ['id' => 0],
                        ];
                } catch (\Throwable $exception) {
                        $wpdb->query('ROLLBACK'); // phpcs:ignore WordPress.DB.DirectDatabaseQuery

                        return new WP_Error('registration_error', $exception->getMessage(), ['status' => 500]);
                }
        }

        /**
         * Retrieve the plan catalog using standard product helpers.
         *
         * @since 2.0.0
         *
         * @param array $query Optional product query arguments.
         * @return array<int,\WP_Ultimo\Models\Product>
         */
        public function get_plan_products($query = []): array {

                $query = apply_filters('wu_signup_service_plan_query_args', (array) $query, $this);

                $products = wu_get_plans($query);

                /**
                 * Filter the list of plan products resolved by the signup service.
                 *
                 * @since 2.0.0
                 *
                 * @param array          $products Product list.
                 * @param array          $query    Query arguments.
                 * @param Signup_Service $service  Signup service instance.
                 */
                return apply_filters('wu_signup_service_plan_products', $products, $query, $this);
        }

        /**
         * Retrieves plan options as id => label pairs for the front-end theme.
         *
         * @since 2.0.0
         *
         * @param array $query Optional product query arguments.
         * @return array<int,string>
         */
        public function get_plan_options($query = []): array {

                $options = [];

                foreach ($this->get_plan_products($query) as $product) {
                        $options[$product->get_id()] = $product->get_name();
                }

                /**
                 * Filter the list of plan options exposed by the signup service.
                 *
                 * @since 2.0.0
                 *
                 * @param array          $options Plan options in id => label format.
                 * @param array          $query   Query arguments.
                 * @param Signup_Service $service Signup service instance.
                 */
                return apply_filters('wu_signup_service_plan_options', $options, $query, $this);
        }

        /**
         * Rollback helper that keeps transaction handling in one place.
         *
         * @since 2.0.0
         *
         * @param WP_Error $error Error instance.
         * @return WP_Error
         */
        protected function rollback_and_return($error) {

                global $wpdb;

                $wpdb->query('ROLLBACK'); // phpcs:ignore WordPress.DB.DirectDatabaseQuery

                return $error;
        }

        /**
         * Build cart information used to derive membership and payment payloads.
         *
         * @since 2.0.0
         *
         * @param array $params Signup parameters.
         * @return Cart|WP_Error
         */
        protected function build_cart(array $params) {

                $cart_params = wp_parse_args($params, ['type' => 'new']);

                $cart_params = apply_filters('wu_signup_service_cart_parameters', $cart_params, $params, $this);

                $cart_params = apply_filters('wu_cart_parameters', $cart_params, $this->checkout);

                $cart = new Cart($cart_params);

                if ($cart->is_valid() && count($cart->get_line_items()) === 0) {
                        return new WP_Error(
                                'invalid_cart',
                                __('Products are required.', 'ultimate-multisite'),
                                array_merge(
                                        (array) $cart->done(),
                                        [
                                                'status' => 400,
                                        ]
                                )
                        );
                }

                return $cart;
        }

        /**
         * Normalize payment method parameters.
         *
         * @since 2.0.0
         *
         * @param array $params Signup parameters.
         * @return array
         */
        protected function normalize_payment_method(array $params): array {

                $payment_method = wp_parse_args(
                        wu_get_isset($params, 'payment_method'),
                        [
                                'gateway'                 => '',
                                'gateway_customer_id'     => '',
                                'gateway_subscription_id' => '',
                                'gateway_payment_id'      => '',
                        ]
                );

                /**
                 * Filter the normalized payment method payload used during signup.
                 *
                 * @since 2.0.0
                 *
                 * @param array          $payment_method Payment method data.
                 * @param array          $params         Original signup parameters.
                 * @param Signup_Service $service        Signup service instance.
                 */
                return apply_filters('wu_signup_service_payment_method', $payment_method, $params, $this);
        }

        /**
         * Create or fetch the customer associated with the signup payload.
         *
         * @since 2.0.0
         *
         * @param array $params Signup parameters.
         * @return Customer|WP_Error
         */
        protected function resolve_customer(array $params) {

                $customer_id = wu_get_isset($params, 'customer_id');

                if ($customer_id) {
                        $customer = wu_get_customer($customer_id);

                        if ( ! $customer) {
                                return new WP_Error('customer_not_found', __('The customer id sent does not correspond to a valid customer.', 'ultimate-multisite'), ['status' => 404]);
                        }

                        return $customer;
                }

                if ( ! isset($params['customer'])) {
                        return new WP_Error('missing_customer', __('Customer data is required to complete the signup request.', 'ultimate-multisite'), ['status' => 400]);
                }

                /**
                 * Filter the customer payload before creation during signup.
                 *
                 * @since 2.0.0
                 *
                 * @param array          $customer_data Customer data array.
                 * @param array          $params        Original signup parameters.
                 * @param Signup_Service $service       Signup service instance.
                 */
                $customer_data = apply_filters('wu_signup_service_customer_data', $params['customer'], $params, $this);

                return wu_create_customer($customer_data);
        }

        /**
         * Creates the membership entity and returns the instance plus the target status.
         *
         * @since 2.0.0
         *
         * @param array     $params         Signup parameters.
         * @param Cart      $cart           Cart instance.
         * @param Customer  $customer       Customer instance.
         * @param array     $payment_method Payment method payload.
         * @return array{0:Membership|WP_Error,1:string}
         */
        protected function create_membership(array $params, Cart $cart, Customer $customer, array $payment_method) {

                $membership_data = $cart->to_membership_data();

                $membership_data = array_merge(
                        $membership_data,
                        wu_get_isset(
                                $params,
                                'membership',
                                [
                                        'status' => Membership_Status::PENDING,
                                ]
                        )
                );

                $membership_data['customer_id']             = $customer->get_id();
                $membership_data['gateway']                 = wu_get_isset($payment_method, 'gateway');
                $membership_data['gateway_subscription_id'] = wu_get_isset($payment_method, 'gateway_subscription_id');
                $membership_data['gateway_customer_id']     = wu_get_isset($payment_method, 'gateway_customer_id');
                $membership_data['auto_renew']              = wu_get_isset($params, 'auto_renew');

                /**
                 * Filter the membership payload generated during signup.
                 *
                 * @since 2.0.0
                 *
                 * @param array          $membership_data Membership payload.
                 * @param array          $params          Signup parameters.
                 * @param Cart           $cart            Cart instance.
                 * @param Customer       $customer        Customer instance.
                 * @param array          $payment_method  Payment method payload.
                 * @param Signup_Service $service         Signup service instance.
                 */
                $membership_data = apply_filters('wu_signup_service_membership_data', $membership_data, $params, $cart, $customer, $payment_method, $this);

                $membership_status = wu_get_isset($membership_data, 'status', Membership_Status::PENDING);

                unset($membership_data['status']);

                $membership = wu_create_membership($membership_data);

                if (is_wp_error($membership)) {
                        return [$membership, $membership_status];
                }

                $membership->add_note([
                        'text'      => __('Created via REST API', 'ultimate-multisite'),
                        'author_id' => $customer->get_user_id(),
                ]);

                return [$membership, $membership_status];
        }

        /**
         * Creates payment data from the hydrated cart.
         *
         * @since 2.0.0
         *
         * @param array      $params         Signup parameters.
         * @param Cart       $cart           Cart instance.
         * @param Customer   $customer       Customer instance.
         * @param Membership $membership     Membership instance.
         * @param array      $payment_method Payment method payload.
         * @return array{0:\WP_Ultimo\Models\Payment|WP_Error,1:string}
         */
        protected function create_payment(array $params, Cart $cart, Customer $customer, Membership $membership, array $payment_method) {

                $payment_data = $cart->to_payment_data();

                $payment_data = array_merge(
                        $payment_data,
                        wu_get_isset(
                                $params,
                                'payment',
                                [
                                        'status' => Payment_Status::PENDING,
                                ]
                        )
                );

                $payment_status = wu_get_isset($payment_data, 'status', Payment_Status::PENDING);

                unset($payment_data['status']);

                $payment_data['customer_id']        = $customer->get_id();
                $payment_data['membership_id']      = $membership->get_id();
                $payment_data['gateway']            = wu_get_isset($payment_method, 'gateway');
                $payment_data['gateway_payment_id'] = wu_get_isset($payment_method, 'gateway_payment_id');

                /**
                 * Filter the payment payload generated during signup.
                 *
                 * @since 2.0.0
                 *
                 * @param array          $payment_data   Payment payload.
                 * @param array          $params         Signup parameters.
                 * @param Cart           $cart           Cart instance.
                 * @param Customer       $customer       Customer instance.
                 * @param Membership     $membership     Membership instance.
                 * @param array          $payment_method Payment method payload.
                 * @param Signup_Service $service        Signup service instance.
                 */
                $payment_data = apply_filters('wu_signup_service_payment_data', $payment_data, $params, $cart, $customer, $membership, $payment_method, $this);

                $payment = wu_create_payment($payment_data);

                if (is_wp_error($payment)) {
                        return [$payment, $payment_status];
                }

                $payment->add_note([
                        'text'      => __('Created via REST API', 'ultimate-multisite'),
                        'author_id' => $customer->get_user_id(),
                ]);

                return [$payment, $payment_status];
        }

        /**
         * Maybe provision a site associated with the membership.
         *
         * @since 2.0.0
         *
         * @param array      $params     Signup parameters.
         * @param Membership $membership Membership instance.
         * @return array|false|WP_Error
         */
        protected function maybe_provision_site(array $params, Membership $membership) {

                if ( ! wu_get_isset($params, 'site')) {
                        return false;
                }

                $site_data = $params['site'];

                $sites = $membership->get_sites();

                if ( ! empty($sites)) {
                        return current($sites);
                }

                $site_url = wu_get_isset($site_data, 'site_url');

                $domain_and_path = wu_get_site_domain_and_path($site_url);

                $results = wpmu_validate_blog_signup($site_url, wu_get_isset($site_data, 'site_title'), $membership->get_customer()->get_user());

                if ($results['errors']->has_errors()) {
                        return $results['errors'];
                }

                $transient = array_merge(
                        wu_get_isset($site_data, 'site_meta', []),
                        wu_get_isset($site_data, 'site_option', [])
                );

                $template_id = apply_filters('wu_checkout_template_id', (int) wu_get_isset($site_data, 'template_id'), $membership, $this);

                $payload = [
                        'domain'         => $domain_and_path->domain,
                        'path'           => $domain_and_path->path,
                        'title'          => wu_get_isset($site_data, 'site_title'),
                        'template_id'    => $template_id,
                        'customer_id'    => $membership->get_customer()->get_id(),
                        'membership_id'  => $membership->get_id(),
                        'transient'      => $transient,
                        'signup_meta'    => wu_get_isset($site_data, 'site_meta', []),
                        'signup_options' => wu_get_isset($site_data, 'site_option', []),
                        'type'           => Site_Type::CUSTOMER_OWNED,
                ];

                /**
                 * Filter the site payload used while provisioning a pending site during signup.
                 *
                 * @since 2.0.0
                 *
                 * @param array          $payload    Site payload.
                 * @param array          $site_data  Original site data passed in the payload.
                 * @param Membership     $membership Membership instance.
                 * @param Signup_Service $service    Signup service instance.
                 */
                $payload = apply_filters('wu_signup_service_site_data', $payload, $site_data, $membership, $this);

                $membership->create_pending_site($payload);

                $payload['id'] = 0;

                if (wu_get_isset($site_data, 'publish')) {
                        $membership->publish_pending_site();

                        $wp_site = get_site_by_path($payload['domain'], $payload['path']);

                        if ($wp_site) {
                                $payload['id'] = $wp_site->blog_id;
                        }
                }

                /**
                 * Action fired after the site payload has been prepared and potentially published.
                 *
                 * @since 2.0.0
                 *
                 * @param array          $payload    Final site payload array.
                 * @param array          $site_data  Original site data passed in the payload.
                 * @param Membership     $membership Membership instance.
                 * @param Signup_Service $service    Signup service instance.
                 */
                do_action('wu_signup_service_after_site_provision', $payload, $site_data, $membership, $this);

                return $payload;
        }
}

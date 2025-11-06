<?php
/**
 * Front-end registration controller.
 *
 * @package WP_Ultimo
 * @subpackage Controllers
 * @since 2.5.0
 */

namespace WP_Ultimo\Controllers;

use WP_Error;
use WP_Ultimo\Models\Signup_Service;
use WP_Ultimo\Services\Plan_Service;
use WP_Ultimo\Traits\Singleton;

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Handles classic form submissions for customer registrations.
 *
 * @since 2.5.0
 */
class Registration_Controller {

        use Singleton;

        /**
         * Signup service dependency.
         *
         * @since 2.5.0
         * @var Signup_Service
         */
        protected Signup_Service $signup_service;

        /**
         * Plan service dependency.
         *
         * @since 2.5.0
         * @var Plan_Service
         */
        protected Plan_Service $plan_service;

        /**
         * Boot the controller hooks.
         *
         * @since 2.5.0
         * @return void
         */
        public function init(): void {

                $this->signup_service = Signup_Service::get_instance();
                $this->plan_service   = Plan_Service::get_instance();

                add_action('admin_post_wu_registration_submit', [$this, 'handle_submission']);
                add_action('admin_post_nopriv_wu_registration_submit', [$this, 'handle_submission']);

                add_filter('wu_registration_available_plans', [$this, 'provide_plan_catalog'], 10, 2);
                add_action('wu_registration_controller_success', [$this, 'dispatch_registration_success_event'], 15, 3);
        }

        /**
         * Prepare a sanitized signup payload using the controller routines.
         *
         * Exposes the internal payload normalization so it can be reused by
         * other entry-points (e.g. REST controllers) without duplicating the
         * sanitization logic in this controller.
         *
         * @since 2.5.0
         *
         * @param array $request Raw request payload.
         * @return array<string,mixed>
         */
        public function prepare_signup_payload(array $request): array {

                return $this->build_signup_payload($request);
        }

        /**
         * Resolve the selected plan identifier from a raw request.
         *
         * @since 2.5.0
         *
         * @param array $request Raw request payload.
         * @return int|string|null
         */
        public function resolve_plan_identifier_from_request(array $request) {

                return $this->resolve_plan_identifier($request);
        }

        /**
         * Ensure the selected plan is present on the provided product list.
         *
         * @since 2.5.0
         *
         * @param array<int> $products Current product identifiers.
         * @param int        $plan_id  Plan product identifier.
         * @return array<int>
         */
        public function ensure_products_include_plan(array $products, int $plan_id): array {

                return $this->merge_products_with_plan($products, $plan_id);
        }

        /**
         * Returns the normalized plan catalog for consumers.
         *
         * @since 2.5.0
         *
         * @param array|null $plans Pre-populated plan collection.
         * @param array      $query Optional query arguments.
         * @return array<int,array<string,mixed>>
         */
        public function provide_plan_catalog($plans, $query = []): array {

                $query = is_array($query) ? $query : [];

                return $this->plan_service->get_normalized_plans($query);
        }

        /**
         * Process a registration form submission.
         *
         * @since 2.5.0
         * @return void
         */
        public function handle_submission(): void {

                if ('POST' !== strtoupper($_SERVER['REQUEST_METHOD'] ?? '')) {
                        return;
                }

                $request       = wp_unslash($_POST); // phpcs:ignore WordPress.Security.NonceVerification.Missing
                $redirect_url  = $this->determine_redirect_url($request);
                $plan_candidate = $this->resolve_plan_identifier($request);

                if ( ! $this->verify_nonce($request)) {
                        $error = new WP_Error('invalid_nonce', __('Unable to verify the registration request. Please try again.', 'ultimate-multisite'));

                        $this->redirect_with_error($error, [], $redirect_url);
                }

                $payload = $this->build_signup_payload($request);

                $plan = null;

                if ($plan_candidate) {
                        $plan = $this->plan_service->resolve_plan($plan_candidate);
                }

                if ( ! $plan && isset($payload['products'])) {
                        $plan = $this->plan_service->resolve_plan_from_list($payload['products']);
                }

                if ($plan) {
                        $payload['products'] = $this->merge_products_with_plan($payload['products'] ?? [], $plan->get_id());
                }

                if (empty($payload['products'])) {
                        $error = new WP_Error('missing_plan', __('Please select a subscription plan to continue.', 'ultimate-multisite'));

                        $this->redirect_with_error($error, $payload, $redirect_url);
                }

                /**
                 * Filter the signup payload generated by the registration controller before validation.
                 *
                 * @since 2.5.0
                 *
                 * @param array                    $payload Generated payload.
                 * @param array                    $request Raw request parameters.
                 * @param Registration_Controller $controller Controller instance.
                 */
                $payload = apply_filters('wu_registration_controller_signup_payload', $payload, $request, $this);

                $validation = $this->signup_service->validate($payload);

                if (is_wp_error($validation)) {
                        $this->redirect_with_error($validation, $payload, $redirect_url);
                }

                $result = $this->signup_service->register($payload);

                if (is_wp_error($result)) {
                        $this->redirect_with_error($result, $payload, $redirect_url);
                }

                $this->store_success_state($result, $payload);

                /**
                 * Fires when the registration controller successfully provisions a membership.
                 *
                 * @since 2.5.0
                 *
                 * @param array                    $result    Signup result payload.
                 * @param array                    $payload   Signup request payload.
                 * @param Registration_Controller $controller Controller instance.
                 */
                do_action('wu_registration_controller_success', $result, $payload, $this);

                $redirect = apply_filters(
                        'wu_registration_controller_success_redirect',
                        $this->with_query_flag($redirect_url, 'registration', 'success'),
                        $result,
                        $payload,
                        $this
                );

                wp_safe_redirect($redirect);
                exit;
        }

        /**
         * Dispatch the public registration success hook with normalized data.
         *
         * @since 2.6.0
         *
         * @param array<string,mixed> $result    Signup service result payload.
         * @param array<string,mixed> $payload   Original signup payload submitted.
         * @param mixed               $controller Controller instance triggering the event.
         * @return void
         */
        public function dispatch_registration_success_event(array $result, array $payload, $controller): void {

                $user = null;

                if (isset($result['customer']['user_id'])) {
                        $user_id = absint($result['customer']['user_id']);

                        if ($user_id > 0) {
                                $user = get_user_by('id', $user_id);
                        }
                }

                $site = isset($result['site']) && is_array($result['site']) ? $result['site'] : null;

                $plan = $this->resolve_plan_from_context($result, $payload);

                $payment_status = '';

                if (isset($result['status']['payment'])) {
                        $payment_status = (string) $result['status']['payment'];
                }

                /**
                 * Fires after the multisite registration flow completes successfully.
                 *
                 * @since 2.6.0
                 *
                 * @param \WP_User|null                     $user           WordPress user associated with the signup.
                 * @param array<string,mixed>|null           $site           Site payload returned by the signup service.
                 * @param \WP_Ultimo\Models\Product|null   $plan           Plan associated with the signup.
                 * @param string                             $payment_status Payment status resolved from the signup.
                 * @param array<string,mixed>                $result         Raw result payload returned by the signup service.
                 * @param array<string,mixed>                $payload        Payload originally submitted for signup.
                 */
                do_action('multisite_registration_after_success', $user, $site, $plan, $payment_status, $result, $payload);
        }

        /**
         * Attempt to resolve the plan associated with a signup result.
         *
         * @since 2.6.0
         *
         * @param array<string,mixed> $result  Result payload returned by the signup service.
         * @param array<string,mixed> $payload Original signup payload submitted.
         * @return \WP_Ultimo\Models\Product|null
         */
        protected function resolve_plan_from_context(array $result, array $payload) {

                $plan_identifier = null;

                if (isset($result['membership']) && is_array($result['membership']) && isset($result['membership']['plan_id'])) {
                        $plan_identifier = $result['membership']['plan_id'];
                } elseif (isset($payload['membership']) && is_array($payload['membership']) && isset($payload['membership']['plan_id'])) {
                        $plan_identifier = $payload['membership']['plan_id'];
                }

                if ($plan_identifier !== null) {
                        $plan = $this->plan_service->resolve_plan($plan_identifier);

                        if ($plan) {
                                return $plan;
                        }
                }

                if (isset($payload['products']) && is_array($payload['products'])) {
                        foreach ($payload['products'] as $product_identifier) {
                                $plan = $this->plan_service->resolve_plan($product_identifier);

                                if ($plan) {
                                        return $plan;
                                }
                        }
                }

                return null;
        }

        /**
         * Normalize the redirect location for the current request.
         *
         * @since 2.5.0
         *
         * @param array $request Raw request payload.
         * @return string
         */
        protected function determine_redirect_url(array $request): string {

                $redirect = $request['redirect_to'] ?? wp_get_referer();

                if (empty($redirect)) {
                        $redirect = home_url('/');
                }

                return esc_url_raw($redirect);
        }

        /**
         * Validate the registration nonce.
         *
         * @since 2.5.0
         *
         * @param array $request Raw request payload.
         * @return bool
         */
        protected function verify_nonce(array $request): bool {

                $nonce = $request['wu_registration_nonce'] ?? ($request['_wpnonce'] ?? '');

                return ! empty($nonce) && wp_verify_nonce($nonce, 'wu_registration_submit');
        }

        /**
         * Build the signup payload expected by the signup service.
         *
         * @since 2.5.0
         *
         * @param array $request Raw request payload.
         * @return array<string,mixed>
         */
        protected function build_signup_payload(array $request): array {

                $payload = [];

                $customer = $this->sanitize_customer_payload($request);

                if ($customer) {
                        $payload['customer'] = $customer;
                }

                $customer_id = $request['customer_id'] ?? null;

                if ($customer_id) {
                        $payload['customer_id'] = absint($customer_id);
                }

                $site = $this->sanitize_site_payload($request);

                if ($site) {
                        $payload['site'] = $site;
                }

                if (isset($request['membership']) && is_array($request['membership'])) {
                        $payload['membership'] = $this->sanitize_deep($request['membership']);
                }

                $products = $this->sanitize_products_list($request);

                if ($products) {
                        $payload['products'] = $products;
                }

                $payment_method = $this->sanitize_payment_method_payload($request);

                if ($payment_method) {
                        $payload['payment_method'] = $payment_method;
                }

                if (isset($request['type'])) {
                        $payload['type'] = sanitize_key($request['type']);
                } elseif (isset($request['cart_type'])) {
                        $payload['type'] = sanitize_key($request['cart_type']);
                }

                if (isset($request['auto_renew'])) {
                        $payload['auto_renew'] = wp_validate_boolean($request['auto_renew']);
                }

                if (isset($request['discount_code'])) {
                        $payload['discount_code'] = sanitize_text_field($request['discount_code']);
                }

                if (isset($request['coupon_code'])) {
                        $payload['coupon_code'] = sanitize_text_field($request['coupon_code']);
                }

                return $payload;
        }

        /**
         * Sanitize customer data extracted from the request.
         *
         * @since 2.5.0
         *
         * @param array $request Raw request payload.
         * @return array<string,mixed>
         */
        protected function sanitize_customer_payload(array $request): array {

                $customer = isset($request['customer']) && is_array($request['customer']) ? $request['customer'] : [];

                $email = $customer['email'] ?? ($request['email'] ?? ($request['customer_email'] ?? ''));

                if ($email !== '') {
                        $customer['email'] = sanitize_email($email);
                }

                $username = $customer['username'] ?? ($request['username'] ?? ($request['customer_username'] ?? ''));

                if ($username !== '') {
                        $customer['username'] = sanitize_user($username, true);
                }

                $password = $customer['password'] ?? ($request['password'] ?? ($request['customer_password'] ?? ''));

                if ($password !== '') {
                        $customer['password'] = (string) $password;
                }

                if (isset($customer['user_id']) || isset($request['user_id'])) {
                        $customer['user_id'] = absint($customer['user_id'] ?? $request['user_id']);
                }

                if (isset($customer['first_name']) || isset($request['first_name'])) {
                        $customer['first_name'] = sanitize_text_field($customer['first_name'] ?? $request['first_name']);
                }

                if (isset($customer['last_name']) || isset($request['last_name'])) {
                        $customer['last_name'] = sanitize_text_field($customer['last_name'] ?? $request['last_name']);
                }

                if (isset($customer['billing_address']) && is_array($customer['billing_address'])) {
                        $customer['billing_address'] = $this->sanitize_deep($customer['billing_address']);
                } elseif (isset($request['billing_address']) && is_array($request['billing_address'])) {
                        $customer['billing_address'] = $this->sanitize_deep($request['billing_address']);
                }

                return array_filter($customer, [$this, 'filter_empty_values']);
        }

        /**
         * Sanitize site payload values.
         *
         * @since 2.5.0
         *
         * @param array $request Raw request payload.
         * @return array<string,mixed>
         */
        protected function sanitize_site_payload(array $request): array {

                $site = isset($request['site']) && is_array($request['site']) ? $request['site'] : [];

                if (isset($request['site_title'])) {
                        $site['site_title'] = $request['site_title'];
                }

                if (isset($request['site_name'])) {
                        $site['site_title'] = $request['site_name'];
                }

                if (isset($request['site_url'])) {
                        $site['site_url'] = $request['site_url'];
                }

                if (isset($request['site_slug'])) {
                        $site['site_url'] = $request['site_slug'];
                }

                if (isset($request['template_id'])) {
                        $site['template_id'] = absint($request['template_id']);
                }

                if (isset($site['site_title'])) {
                        $site['site_title'] = sanitize_text_field($site['site_title']);
                }

                if (isset($site['site_url'])) {
                        $site['site_url'] = sanitize_title($site['site_url']);
                }

                if (isset($site['template_id'])) {
                        $site['template_id'] = absint($site['template_id']);
                }

                return array_filter($site, [$this, 'filter_empty_values']);
        }

        /**
         * Sanitize payment method payload.
         *
         * @since 2.5.0
         *
         * @param array $request Raw request payload.
         * @return array<string,mixed>
         */
        protected function sanitize_payment_method_payload(array $request): array {

                $payment_method = isset($request['payment_method']) && is_array($request['payment_method']) ? $request['payment_method'] : [];

                if (isset($request['gateway'])) {
                        $payment_method['gateway'] = $request['gateway'];
                }

                $sanitized = [];

                if (isset($payment_method['gateway'])) {
                        $sanitized['gateway'] = sanitize_key($payment_method['gateway']);
                }

                if (isset($payment_method['gateway_customer_id'])) {
                        $sanitized['gateway_customer_id'] = sanitize_text_field($payment_method['gateway_customer_id']);
                }

                if (isset($payment_method['gateway_subscription_id'])) {
                        $sanitized['gateway_subscription_id'] = sanitize_text_field($payment_method['gateway_subscription_id']);
                }

                if (isset($payment_method['gateway_payment_id'])) {
                        $sanitized['gateway_payment_id'] = sanitize_text_field($payment_method['gateway_payment_id']);
                }

                if (isset($payment_method['meta']) && is_array($payment_method['meta'])) {
                        $sanitized['meta'] = $this->sanitize_deep($payment_method['meta']);
                }

                return array_filter($sanitized, [$this, 'filter_empty_values']);
        }

        /**
         * Sanitize a list of product identifiers.
         *
         * @since 2.5.0
         *
         * @param array $request Raw request payload.
         * @return array<int>
         */
        protected function sanitize_products_list(array $request): array {

                $products = $request['products'] ?? [];

                if (is_string($products)) {
                        $products = preg_split('/[,|]/', $products) ?: [];
                }

                if ( ! is_array($products)) {
                        $products = [$products];
                }

                $normalized = [];

                foreach ($products as $identifier) {
                        if (is_numeric($identifier)) {
                                $normalized[] = absint($identifier);
                                continue;
                        }

                        if (is_string($identifier) && $identifier !== '') {
                                $product = wu_get_product_by_slug(sanitize_title($identifier));

                                if ($product) {
                                        $normalized[] = (int) $product->get_id();
                                }
                        }
                }

                $normalized = array_values(array_filter(array_unique($normalized)));

                return $normalized;
        }

        /**
         * Ensure the selected plan is present on the product list.
         *
         * @since 2.5.0
         *
         * @param array<int> $products Current product list.
         * @param int        $plan_id  Plan product identifier.
         * @return array<int>
         */
        protected function merge_products_with_plan(array $products, int $plan_id): array {

                $products[] = $plan_id;

                $products = array_map('absint', $products);
                $products = array_filter($products);
                $products = array_unique($products);

                return array_values($products);
        }

        /**
         * Attempt to resolve the plan identifier from the request.
         *
         * @since 2.5.0
         *
         * @param array $request Raw request payload.
         * @return int|string|null
         */
        protected function resolve_plan_identifier(array $request) {

                $candidates = [
                        $request['plan_product'] ?? null,
                        $request['plan_id'] ?? null,
                        $request['plan'] ?? null,
                        $request['plan_slug'] ?? null,
                ];

                foreach ($candidates as $candidate) {
                        if ($this->filter_empty_values($candidate)) {
                                return $candidate;
                        }
                }

                return null;
        }

        /**
         * Store error data and redirect back to the provided location.
         *
         * @since 2.5.0
         *
         * @param WP_Error $error        Error object.
         * @param array    $payload      Signup payload.
         * @param string   $redirect_url Redirect URL.
         * @return void
         */
        protected function redirect_with_error(WP_Error $error, array $payload, string $redirect_url): void {

                $this->store_error_state($error, $payload);

                /**
                 * Fires when the registration controller fails to provision a membership.
                 *
                 * @since 2.5.0
                 *
                 * @param WP_Error                 $error      Error object.
                 * @param array                    $payload    Signup payload.
                 * @param Registration_Controller $controller Controller instance.
                 */
                do_action('wu_registration_controller_error', $error, $payload, $this);

                $redirect = apply_filters(
                        'wu_registration_controller_error_redirect',
                        $this->with_query_flag(
                                $redirect_url,
                                'registration',
                                'error',
                                [
                                        'registration_error' => $error->get_error_code(),
                                ]
                        ),
                        $error,
                        $payload,
                        $this
                );

                wp_safe_redirect($redirect);
                exit;
        }

        /**
         * Store an error state in the signup session.
         *
         * @since 2.5.0
         *
         * @param WP_Error $error   Error instance.
         * @param array    $payload Signup payload.
         * @return void
         */
        protected function store_error_state(WP_Error $error, array $payload): void {

                $session = wu_get_session('signup');

                $session->set('errors', $error);
                $session->set('registration_payload', $payload);
                $session->set('registration_result', null);
                $session->commit();
        }

        /**
         * Store a successful registration result in the signup session.
         *
         * @since 2.5.0
         *
         * @param array $result  Signup result payload.
         * @param array $payload Signup payload.
         * @return void
         */
        protected function store_success_state(array $result, array $payload): void {

                $session = wu_get_session('signup');

                $session->set('registration_result', $result);
                $session->set('registration_payload', $payload);
                $session->set('errors', null);
                $session->commit();
        }

        /**
         * Append flag query arguments to a redirect URL.
         *
         * @since 2.5.0
         *
         * @param string $url    Base URL.
         * @param string $key    Query key to set.
         * @param string $value  Query value to set.
         * @param array  $extras Extra query arguments.
         * @return string
         */
        protected function with_query_flag(string $url, string $key, string $value, array $extras = []): string {

                $query_keys = array_merge([$key], array_keys($extras));
                $clean_url  = remove_query_arg($query_keys, $url);

                return add_query_arg(array_merge([$key => $value], $extras), $clean_url);
        }

        /**
         * Recursively sanitize array payloads.
         *
         * @since 2.5.0
         *
         * @param mixed $value Value to sanitize.
         * @return mixed
         */
        protected function sanitize_deep($value) {

                if (is_array($value)) {
                        return array_map([$this, 'sanitize_deep'], $value);
                }

                if (is_scalar($value)) {
                        return sanitize_text_field((string) $value);
                }

                return $value;
        }

        /**
         * Filter empty string and null values while preserving numeric zeroes.
         *
         * @since 2.5.0
         *
         * @param mixed $value Value to check.
         * @return bool
         */
        protected function filter_empty_values($value): bool {

                return ! ($value === '' || $value === null);
        }
}

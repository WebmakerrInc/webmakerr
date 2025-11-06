<?php
/**
 * REST endpoints for the public registration flow.
 *
 * @package WP_Ultimo
 * @subpackage Controllers
 * @since 2.5.0
 */

namespace WP_Ultimo\Controllers;

use stdClass;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;
use WP_Ultimo\Models\Product;
use WP_Ultimo\Models\Signup_Service;
use WP_Ultimo\Services\Plan_Service;
use WP_Ultimo\Traits\Singleton;

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Exposes REST endpoints powering the front-end registration UI.
 *
 * @since 2.5.0
 */
class Registration_Rest_Controller {

        use Singleton;

        /**
         * REST namespace used by the registration endpoints.
         *
         * @since 2.5.0
         * @var string
         */
        protected string $namespace = 'multisite/api';

        /**
         * Plan service dependency.
         *
         * @since 2.5.0
         * @var Plan_Service
         */
        protected Plan_Service $plan_service;

        /**
         * Signup service dependency.
         *
         * @since 2.5.0
         * @var Signup_Service
         */
        protected Signup_Service $signup_service;

        /**
         * Classic registration controller dependency.
         *
         * @since 2.5.0
         * @var Registration_Controller
         */
        protected Registration_Controller $registration_controller;

        /**
         * Boot the controller and register the routes.
         *
         * @since 2.5.0
         * @return void
         */
        public function init(): void {

                $this->plan_service             = Plan_Service::get_instance();
                $this->signup_service           = Signup_Service::get_instance();
                $this->registration_controller  = Registration_Controller::get_instance();

                add_action('rest_api_init', [$this, 'register_routes']);
        }

        /**
         * Register the REST routes exposed by this controller.
         *
         * @since 2.5.0
         * @return void
         */
        public function register_routes(): void {

                $namespace = $this->get_namespace();

                register_rest_route(
                        $namespace,
                        '/register/plans',
                        [
                                'methods'             => WP_REST_Server::READABLE,
                                'callback'            => [$this, 'get_plans'],
                                'permission_callback' => '__return_true',
                        ]
                );

                register_rest_route(
                        $namespace,
                        '/register/validate',
                        [
                                'methods'             => WP_REST_Server::READABLE,
                                'callback'            => [$this, 'validate_availability'],
                                'permission_callback' => '__return_true',
                                'args'                => [
                                        'email' => [
                                                'sanitize_callback' => function ($value) {

                                                        return is_string($value) ? sanitize_email($value) : '';
                                                },
                                        ],
                                        'site'  => [
                                                'sanitize_callback' => function ($value) {

                                                        return is_string($value) ? sanitize_text_field($value) : '';
                                                },
                                        ],
                                ],
                        ]
                );

                register_rest_route(
                        $namespace,
                        '/register/submit',
                        [
                                'methods'             => WP_REST_Server::CREATABLE,
                                'callback'            => [$this, 'handle_submission'],
                                'permission_callback' => [$this, 'validate_submission_permission'],
                        ]
                );
        }

        /**
         * Return the normalized plan catalog for the registration flow.
         *
         * @since 2.5.0
         *
         * @param WP_REST_Request $request REST request instance.
         * @return WP_REST_Response
         */
        public function get_plans(WP_REST_Request $request): WP_REST_Response {

                $nonce_check = $this->validate_nonce_or_error($request, 'wu_registration_request');

                if (is_wp_error($nonce_check)) {

                        return $this->prepare_error_response($nonce_check);
                }

                $query = $request->get_params();

                $plans = apply_filters('wu_registration_available_plans', null, $query);

                if ($plans === null) {
                        $plans = $this->plan_service->get_normalized_plans($query);
                }

                $plans = apply_filters('multisite_registration_plan_list', (array) $plans, $query, $request);

                if (! is_array($plans)) {
                        $plans = (array) $plans;
                }

                return $this->prepare_success_response(
                        [
                                'plans' => array_values($plans),
                        ]
                );
        }

        /**
         * Validate email and site slug availability for the registration UI.
         *
         * @since 2.5.0
         *
         * @param WP_REST_Request $request REST request instance.
         * @return WP_REST_Response
         */
        public function validate_availability(WP_REST_Request $request): WP_REST_Response {

                $nonce_check = $this->validate_nonce_or_error($request, 'wu_registration_request');

                if (is_wp_error($nonce_check)) {

                        return $this->prepare_error_response($nonce_check);
                }

                $email = (string) $request->get_param('email');
                $site  = (string) $request->get_param('site');

                return $this->prepare_success_response(
                        [
                                'email' => $this->evaluate_email_availability($email),
                                'site'  => $this->evaluate_site_availability($site),
                        ]
                );
        }

        /**
         * Permission callback for the submission endpoint.
         *
         * @since 2.5.0
         *
         * @param WP_REST_Request $request REST request instance.
         * @return bool|WP_Error
         */
        public function validate_submission_permission(WP_REST_Request $request) {

                $nonce_check = $this->validate_nonce_or_error($request, 'wu_registration_submit');

                if (is_wp_error($nonce_check)) {

                        return $nonce_check;
                }

                return true;
        }

        /**
         * Handle a registration request coming through the REST endpoint.
         *
         * @since 2.5.0
         *
         * @param WP_REST_Request $request REST request instance.
         * @return WP_REST_Response|WP_Error
         */
        public function handle_submission(WP_REST_Request $request) {

                $raw_params = $this->prepare_request_parameters($request);

                $payload = $this->registration_controller->prepare_signup_payload($raw_params);

                $plan_identifier = $this->registration_controller->resolve_plan_identifier_from_request($raw_params);

                $plan = null;

                if ($plan_identifier) {
                        $plan = $this->plan_service->resolve_plan($plan_identifier);
                }

                if ( ! $plan && isset($payload['products'])) {
                        $plan = $this->plan_service->resolve_plan_from_list($payload['products']);
                }

                $preflight = $this->validate_submission_payload($raw_params, $payload, $plan);

                if (is_wp_error($preflight)) {
                        return $preflight;
                }

                $payload             = $preflight['payload'];
                $plan                = $preflight['plan'];
                $existing_user_id    = $preflight['existing_user_id'];
                $password_to_update  = $preflight['password_to_update'];

                if (empty($payload['products'])) {
                        $error = new WP_Error(
                                'missing_plan',
                                __('Please select a subscription plan to continue.', 'ultimate-multisite'),
                                [
                                        'status' => 400,
                                ]
                        );

                        return $error;
                }

                /**
                 * Filter the signup payload generated by the registration controller before validation.
                 *
                 * @since 2.5.0
                 *
                 * @param array<string,mixed>     $payload    Generated payload.
                 * @param array<string,mixed>     $raw_params Raw request parameters.
                 * @param Registration_Controller $controller Registration controller instance.
                 */
                $payload = apply_filters('wu_registration_controller_signup_payload', $payload, $raw_params, $this->registration_controller);

                $validation = $this->signup_service->validate($payload);

                if (is_wp_error($validation)) {
                        $validation->add_data([
                                'status' => 400,
                        ]);

                        return $validation;
                }

                $result = $this->signup_service->register($payload);

                if (is_wp_error($result)) {
                        $data = $result->get_error_data();

                        if ( ! is_array($data) || ! isset($data['status'])) {
                                $result->add_data([
                                        'status' => 500,
                                ]);
                        }

                        return $result;
                }

                if ($existing_user_id && $password_to_update !== '') {
                        wp_set_password($password_to_update, $existing_user_id);
                }

                do_action('wu_registration_controller_success', $result, $payload, $this->registration_controller);

                $response = rest_ensure_response(
                        [
                                'success' => true,
                                'result'  => $result,
                        ]
                );

                $response->set_status(201);

                return $response;
        }

        /**
         * Evaluate the availability status for a given email address.
         *
         * @since 2.5.0
         *
         * @param string $email Email address to evaluate.
         * @return array<string,string>
         */
        protected function evaluate_email_availability(string $email): array {

                $email = sanitize_email($email);

                $status = [
                        'value'  => $email,
                        'status' => $email === '' ? 'empty' : 'available',
                ];

                if ($email === '') {
                        return $status;
                }

                if ( ! is_email($email)) {
                        $status['status'] = 'invalid';

                        return $status;
                }

                $status['status'] = email_exists($email) ? 'taken' : 'available';

                return $status;
        }

        /**
         * Evaluate the availability status for a given site slug.
         *
         * @since 2.5.0
         *
         * @param string $site Site identifier provided by the user.
         * @return array<string,string>
         */
        protected function evaluate_site_availability(string $site): array {

                $raw = is_string($site) ? $site : '';
                $slug = $raw !== '' ? sanitize_title($raw) : '';

                $status = [
                        'value'      => $slug,
                        'normalized' => $slug,
                        'status'     => $raw === '' ? 'empty' : 'available',
                ];

                if ($raw === '') {
                        return $status;
                }

                if ($slug === '' || strlen($slug) < 4) {
                        $status['status'] = 'invalid';

                        return $status;
                }

                $validation = wpmu_validate_blog_signup($slug, 'Site Title');

                if (is_array($validation) && isset($validation['errors']) && $validation['errors'] instanceof WP_Error) {
                        if ($validation['errors']->has_errors()) {
                                $codes = $validation['errors']->get_error_codes();

                                $status['status']  = in_array('blogname', $codes, true) ? 'taken' : 'invalid';
                                $status['message'] = $validation['errors']->get_error_message();

                                return $status;
                        }
                }

                return $status;
        }

        /**
         * Retrieve the namespace used by the REST controller.
         *
         * @since 2.5.0
         *
         * @return string
         */
        protected function get_namespace(): string {

                /**
                 * Filter the REST namespace used by the registration controller.
                 *
                 * @since 2.5.0
                 *
                 * @param string                         $namespace  Default namespace.
                 * @param Registration_Rest_Controller $controller Controller instance.
                 */
                return apply_filters('wu_registration_rest_namespace', $this->namespace, $this);
        }

        /**
         * Extract and sanitize the nonce value from a REST request.
         *
         * @since 2.5.0
         *
         * @param WP_REST_Request $request REST request instance.
         * @return string
         */
        protected function extract_nonce(WP_REST_Request $request): string {

                $candidates = [
                        $request->get_header('x-wu-registration-nonce'),
                        $request->get_header('x_wp_nonce'),
                        $request->get_param('wu_registration_nonce'),
                        $request->get_param('_wpnonce'),
                        $request->get_param('nonce'),
                ];

                foreach ($candidates as $candidate) {
                        if (is_string($candidate) && $candidate !== '') {
                                return sanitize_text_field(wp_unslash($candidate));
                        }
                }

                return '';
        }

        /**
         * Validate the nonce present on the request or return an error.
         *
         * @since 2.7.0
         *
         * @param WP_REST_Request $request REST request instance.
         * @param string          $action  Nonce action string to validate against.
         * @return true|WP_Error
         */
        protected function validate_nonce_or_error(WP_REST_Request $request, string $action)
        {

                $nonce = $this->extract_nonce($request);

                if ($nonce !== '' && wp_verify_nonce($nonce, $action)) {

                        return true;
                }

                return new WP_Error(
                        'invalid_nonce',
                        __('Unable to verify the registration request. Please refresh the page and try again.', 'ultimate-multisite'),
                        [
                                'status' => 403,
                        ]
                );
        }

        /**
         * Normalize a success response to keep a consistent schema.
         *
         * @since 2.7.0
         *
         * @param array<string,mixed> $data Response payload.
         * @return WP_REST_Response
         */
        protected function prepare_success_response(array $data): WP_REST_Response {

                $response = rest_ensure_response(
                        [
                                'success' => true,
                                'data'    => $data,
                                'errors'  => [],
                        ]
                );

                return $response;
        }

        /**
         * Normalize error responses returned by the controller.
         *
         * @since 2.7.0
         *
         * @param WP_Error $error Error instance to convert into a REST response.
         * @return WP_REST_Response
         */
        protected function prepare_error_response(WP_Error $error): WP_REST_Response {

                $status = $this->resolve_error_status($error, 400);

                $normalized_errors = [];

                foreach ($error->get_error_codes() as $code) {

                        $messages = $error->get_error_messages($code);
                        $data     = $error->get_error_data($code);

                        if ($messages === []) {
                                continue;
                        }

                        foreach ($messages as $message) {

                                $entry = [
                                        'code'    => $code,
                                        'message' => $message,
                                ];

                                if (is_array($data) && $data !== []) {
                                        $entry['data'] = $data;
                                }

                                $normalized_errors[] = $entry;
                        }
                }

                if ($normalized_errors === []) {
                        $normalized_errors[] = [
                                'code'    => 'unknown_error',
                                'message' => __('An unknown error occurred.', 'ultimate-multisite'),
                        ];
                }

                $response = rest_ensure_response(
                        [
                                'success' => false,
                                'data'    => new stdClass(),
                                'errors'  => $normalized_errors,
                        ]
                );

                $response->set_status($status);

                return $response;
        }

        /**
         * Derive the appropriate HTTP status code for a WP_Error instance.
         *
         * @since 2.7.0
         *
         * @param WP_Error $error   Error instance.
         * @param int      $default Default HTTP status code.
         * @return int
         */
        protected function resolve_error_status(WP_Error $error, int $default = 400): int {

                foreach ($error->get_error_codes() as $code) {

                        $data = $error->get_error_data($code);

                        if (is_array($data) && isset($data['status']) && is_numeric($data['status'])) {

                                return (int) $data['status'];
                        }

                        if (is_numeric($data)) {

                                return (int) $data;
                        }
                }

                return $default;
        }

        /**
         * Normalize request parameters to feed the signup payload builder.
         *
         * @since 2.5.0
         *
         * @param WP_REST_Request $request REST request instance.
         * @return array<string,mixed>
         */
        protected function prepare_request_parameters(WP_REST_Request $request): array {

                $json_params = $request->get_json_params();
                $body_params = $request->get_body_params();

                $json_params = is_array($json_params) ? $json_params : [];
                $body_params = is_array($body_params) ? $body_params : [];

                return array_merge($body_params, $json_params);
        }

        /**
         * Validate and normalize the submission payload before hitting the signup pipeline.
         *
         * @since 2.6.0
         *
         * @param array<string,mixed>      $raw_params Raw request parameters.
         * @param array<string,mixed>      $payload    Sanitized payload generated by the controller.
         * @param Product|null             $plan       Resolved plan instance, when available.
         * @return array<string,mixed>|WP_Error
         */
        protected function validate_submission_payload(array $raw_params, array $payload, ?Product $plan)
        {

                $errors                 = [];
                $customer_payload       = isset($payload['customer']) && is_array($payload['customer']) ? $payload['customer'] : [];
                $site_payload           = isset($payload['site']) && is_array($payload['site']) ? $payload['site'] : [];
                $products               = isset($payload['products']) && is_array($payload['products']) ? $payload['products'] : [];
                $payment_method_payload = isset($payload['payment_method']) && is_array($payload['payment_method']) ? $payload['payment_method'] : [];

                $email = sanitize_email(
                        $raw_params['email']
                                ?? ($customer_payload['email'] ?? ($raw_params['customer_email'] ?? ''))
                );

                $existing_user     = null;
                $existing_customer = null;

                if ($email === '') {
                        $errors['email'] = __('Please provide a valid email address to continue.', 'ultimate-multisite');
                } elseif ( ! is_email($email)) {
                        $errors['email'] = __('The email address appears to be invalid.', 'ultimate-multisite');
                } else {
                        $existing_user = get_user_by('email', $email);

                        if ($existing_user) {
                                $existing_customer = wu_get_customer_by_user_id($existing_user->ID);

                                if ($existing_customer) {
                                        $payload['customer_id'] = $existing_customer->get_id();
                                        $customer_payload       = [];
                                } else {
                                        $customer_payload['user_id'] = (int) $existing_user->ID;
                                        $customer_payload['email']   = $existing_user->user_email;
                                }
                        } else {
                                $username = isset($customer_payload['username']) && $customer_payload['username'] !== ''
                                        ? sanitize_user($customer_payload['username'], true)
                                        : $this->generate_username_from_email($email);

                                $user_validation = wpmu_validate_user_signup($username, $email);

                                if ($user_validation['errors']->has_errors()) {
                                        if ($user_validation['errors']->get_error_message('user_email')) {
                                                $errors['email'] = $user_validation['errors']->get_error_message('user_email');
                                        } else {
                                                $errors['email'] = $user_validation['errors']->get_error_message();
                                        }

                                        if ($user_validation['errors']->get_error_message('user_name')) {
                                                $errors['username'] = $user_validation['errors']->get_error_message('user_name');
                                        }
                                } else {
                                        $customer_payload['email']    = $user_validation['user_email'];
                                        $customer_payload['username'] = $user_validation['user_name'];
                                }
                        }
                }

                $password = (string) (
                        $raw_params['password']
                                ?? ($customer_payload['password'] ?? ($raw_params['customer_password'] ?? ''))
                );

                $password_to_update = '';

                if ($existing_user) {
                        if ($password !== '') {
                                if ( ! $this->is_password_strong_enough($password)) {
                                        $errors['password'] = sprintf(
                                                /* translators: %d: minimum password length */
                                                __('Passwords must be at least %d characters long.', 'ultimate-multisite'),
                                                $this->get_password_min_length()
                                        );
                                } else {
                                        $password_to_update = $password;
                                }
                        }
                } else {
                        if ($password === '') {
                                $errors['password'] = __('Please choose a password to continue.', 'ultimate-multisite');
                        } elseif ( ! $this->is_password_strong_enough($password)) {
                                $errors['password'] = sprintf(
                                        /* translators: %d: minimum password length */
                                        __('Passwords must be at least %d characters long.', 'ultimate-multisite'),
                                        $this->get_password_min_length()
                                );
                        } else {
                                $customer_payload['password'] = $password;
                        }
                }

                if ($plan === null) {
                        $plan_identifier = $this->registration_controller->resolve_plan_identifier_from_request($raw_params);

                        if ($plan_identifier) {
                                $plan = $this->plan_service->resolve_plan($plan_identifier);
                        }

                        if ( ! $plan && isset($payload['products'])) {
                                $plan = $this->plan_service->resolve_plan_from_list($payload['products']);
                        }
                }

                if ( ! $plan) {
                        $errors['plan'] = __('The selected plan is not available. Please choose another plan.', 'ultimate-multisite');
                } else {
                        $products = $this->registration_controller->ensure_products_include_plan($products, $plan->get_id());

                        if (empty($payment_method_payload['gateway'])) {
                                if ($plan->is_free()) {
                                        $payment_method_payload['gateway'] = 'manual';
                                } else {
                                        $errors['payment'] = __('Please select a payment method to continue.', 'ultimate-multisite');
                                }
                        }
                }

                $site_slug  = $raw_params['site_slug'] ?? ($raw_params['site_url'] ?? ($site_payload['site_url'] ?? ''));
                $site_title = $raw_params['site_title'] ?? ($raw_params['site_name'] ?? ($site_payload['site_title'] ?? ''));

                if ($site_slug === '') {
                        $errors['site'] = __('Please choose a site address for your new website.', 'ultimate-multisite');
                } else {
                        $normalized_slug  = sanitize_title($site_slug);
                        $normalized_title = $site_title !== '' ? sanitize_text_field($site_title) : __('My new site', 'ultimate-multisite');

                        if ($normalized_slug === '') {
                                $errors['site'] = __('Please choose a valid site address for your new website.', 'ultimate-multisite');
                        } else {
                                $site_validation = wpmu_validate_blog_signup($normalized_slug, $normalized_title);

                                if ($site_validation['errors']->has_errors()) {
                                        $errors['site'] = $site_validation['errors']->get_error_message('blogname')
                                                ?: $site_validation['errors']->get_error_message();
                                } else {
                                        $site_payload['site_url']   = $site_validation['blogname'];
                                        $site_payload['site_title'] = $site_title !== '' ? sanitize_text_field($site_title) : $site_validation['blog_title'];
                                }
                        }
                }

                if ( ! empty($errors)) {
                        return new WP_Error(
                                'wu_registration_validation_failed',
                                __('There were problems with your submission. Please review the highlighted fields and try again.', 'ultimate-multisite'),
                                [
                                        'status' => 400,
                                        'errors' => $errors,
                                ]
                        );
                }

                if ( ! empty($customer_payload)) {
                        $payload['customer'] = $customer_payload;
                } else {
                        unset($payload['customer']);
                }

                if ( ! empty($site_payload)) {
                        $payload['site'] = $site_payload;
                }

                $payload['products']        = $products;
                $payload['payment_method']  = $payment_method_payload;

                return [
                        'payload'            => $payload,
                        'plan'               => $plan,
                        'existing_user_id'   => $existing_user ? (int) $existing_user->ID : 0,
                        'password_to_update' => $password_to_update,
                ];
        }

        /**
         * Determine if the provided password meets the minimum strength requirements.
         *
         * @since 2.6.0
         *
         * @param string $password Password string to evaluate.
         * @return bool
         */
        protected function is_password_strong_enough(string $password): bool {

                $minimum_length = $this->get_password_min_length();

                /**
                 * Filter the evaluation of password strength for the registration REST endpoint.
                 *
                 * @since 2.5.0
                 *
                 * @param bool                           $is_strong  Whether the password is strong enough.
                 * @param string                         $password   Password string.
                 * @param int                            $min_length Minimum password length requirement.
                 * @param Registration_Rest_Controller   $controller Controller instance.
                 */
                return (bool) apply_filters(
                        'wu_registration_rest_password_is_strong',
                        strlen($password) >= $minimum_length,
                        $password,
                        $minimum_length,
                        $this
                );
        }

        /**
         * Retrieve the minimum password length enforced by the registration endpoint.
         *
         * @since 2.6.0
         *
         * @return int
         */
        protected function get_password_min_length(): int {

                $default_length = 8;

                /**
                 * Filter the minimum password length required by the registration REST endpoint.
                 *
                 * @since 2.5.0
                 *
                 * @param int                            $default_length Default minimum length.
                 * @param Registration_Rest_Controller   $controller     Controller instance.
                 */
                $length = (int) apply_filters('wu_registration_rest_password_min_length', $default_length, $this);

                return max(6, $length);
        }

        /**
         * Generate a default username based on the provided email address.
         *
         * @since 2.6.0
         *
         * @param string $email Email address used as the base for the username.
         * @return string
         */
        protected function generate_username_from_email(string $email): string {

                $candidates = [];

                if ($email !== '') {
                        $parts = explode('@', $email);

                        if (isset($parts[0])) {
                                $candidates[] = $parts[0];
                        }

                        $candidates[] = str_replace(['@', '+', '.', '-'], '', $email);
                }

                $candidates[] = 'user' . wp_rand(1000, 999999);

                foreach ($candidates as $candidate) {
                        $sanitized = sanitize_user($candidate, true);

                        if ($sanitized !== '') {
                                /**
                                 * Filter the default username used during registration when one is not provided.
                                 *
                                 * @since 2.5.0
                                 *
                                 * @param string                         $sanitized  Generated username.
                                 * @param string                         $email      Email used to derive the username.
                                 * @param Registration_Rest_Controller   $controller Controller instance.
                                 */
                                return (string) apply_filters('wu_registration_rest_default_username', $sanitized, $email, $this);
                        }
                }

                return (string) apply_filters('wu_registration_rest_default_username', 'user' . wp_rand(1000, 9999), $email, $this);
        }
}


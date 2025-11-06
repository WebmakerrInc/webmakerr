<?php
/**
 * REST endpoints for the public registration flow.
 *
 * @package WP_Ultimo
 * @subpackage Controllers
 * @since 2.5.0
 */

namespace WP_Ultimo\Controllers;

use WP_Error;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;
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

                $query = $request->get_params();

                $plans = apply_filters('wu_registration_available_plans', null, $query);

                if ($plans === null) {
                        $plans = $this->plan_service->get_normalized_plans($query);
                }

                $response = [
                        'plans' => array_values((array) $plans),
                ];

                return rest_ensure_response($response);
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

                $email = (string) $request->get_param('email');
                $site  = (string) $request->get_param('site');

                $response = [
                        'email' => $this->evaluate_email_availability($email),
                        'site'  => $this->evaluate_site_availability($site),
                ];

                return rest_ensure_response($response);
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

                $nonce = $this->extract_nonce($request);

                if ($nonce !== '' && wp_verify_nonce($nonce, 'wu_registration_submit')) {
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

                if ($plan) {
                        $payload['products'] = $this->registration_controller->ensure_products_include_plan(
                                $payload['products'] ?? [],
                                $plan->get_id()
                        );
                }

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
                        $request->get_header('x-wp-nonce'),
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
}


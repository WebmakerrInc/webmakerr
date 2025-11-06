<?php
/**
 * The Register API endpoint.
 *
 * @package WP_Ultimo
 * @subpackage API
 * @since 2.0.0
 */

namespace WP_Ultimo\API;

use WP_Ultimo\Models\Signup_Service;
use WP_Ultimo\Objects\Billing_Address;

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * The Register API endpoint.
 *
 * @since 2.0.0
 */
class Register_Endpoint {

	use \WP_Ultimo\Traits\Singleton;

	/**
	 * Loads the initial register route hooks.
	 *
	 * @since 2.0.0
	 * @return void
	 */
	public function init(): void {

		add_action('wu_register_rest_routes', [$this, 'register_route']);
	}

	/**
	 * Adds a new route to the wu namespace, for the register endpoint.
	 *
	 * @since 2.0.0
	 *
	 * @param \WP_Ultimo\API $api The API main singleton.
	 * @return void
	 */
	public function register_route($api): void {

		$namespace = $api->get_namespace();

		register_rest_route(
			$namespace,
			'/register',
			[
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => [$this, 'handle_get'],
				'permission_callback' => \Closure::fromCallable([$api, 'check_authorization']),
			]
		);

		register_rest_route(
			$namespace,
			'/register',
			[
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => [$this, 'handle_endpoint'],
				'permission_callback' => \Closure::fromCallable([$api, 'check_authorization']),
				'args'                => $this->get_rest_args(),
			]
		);
	}

	/**
	 * Handle the register endpoint get for zapier integration reasons.
	 *
	 * @since 2.0.0
	 *
	 * @param \WP_REST_Request $request WP Request Object.
	 * @return array
	 */
	public function handle_get($request) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
		/** @var $request */
		return [
			'registration_status' => wu_get_setting('enable_registration', true) ? 'open' : 'closed',
		];
	}

	/**
	 * Handle the register endpoint logic.
	 *
	 * @since 2.0.0
	 *
	 * @param \WP_REST_Request $request WP Request Object.
	 * @return array|\WP_Error
	 */
        public function handle_endpoint($request) {

                $params = json_decode($request->get_body(), true);

                if (\WP_Ultimo\API::get_instance()->should_log_api_calls()) {
                        wu_log_add('api-calls', wp_json_encode($params, JSON_PRETTY_PRINT));
                }

                $service = Signup_Service::get_instance();

                $validation_errors = $service->validate($params);

                if (is_wp_error($validation_errors)) {
                        $validation_errors->add_data([
                                'status' => 400,
                        ]);

                        return $validation_errors;
                }

                $result = $service->register($params);

                if (is_wp_error($result)) {
                        $data = $result->get_error_data();

                        if ( ! is_array($data) || ! isset($data['status'])) {
                                $result->add_data([
                                        'status' => 500,
                                ]);
                        }

                        return $result;
                }

                return $result;
        }

	/**
	 * Returns the list of arguments allowed on to the endpoint.
	 *
	 * This is also used to build the documentation page for the endpoint.
	 *
	 * @since 2.0.0
	 * @return array
	 */
	public function get_rest_args() {
		/*
		 * Billing Address Fields
		 */
		$billing_address_fields = Billing_Address::fields_for_rest(false);

		$customer_args = [
			'customer_id' => [
				'description' => __('The customer ID, if the customer already exists. If you also need to create a customer/wp user, use the "customer" property.', 'ultimate-multisite'),
				'type'        => 'integer',
			],
			'customer'    => [
				'description' => __('Customer data. Needs to be present when customer id is not.', 'ultimate-multisite'),
				'type'        => 'object',
				'properties'  => [
					'user_id'         => [
						'description' => __('Existing WordPress user id to attach this customer to. If you also need to create a WordPress user, pass the properties "username", "password", and "email".', 'ultimate-multisite'),
						'type'        => 'integer',
					],
					'username'        => [
						'description' => __('The customer username. This is used to create the WordPress user.', 'ultimate-multisite'),
						'type'        => 'string',
						'minLength'   => 4,
					],
					'password'        => [
						'description' => __('The customer password. This is used to create the WordPress user. Note that no validation is performed here to enforce strength.', 'ultimate-multisite'),
						'type'        => 'string',
						'minLength'   => 6,
					],
					'email'           => [
						'description' => __('The customer email address. This is used to create the WordPress user.', 'ultimate-multisite'),
						'type'        => 'string',
						'format'      => 'email',
					],
					'billing_address' => [
						'type'       => 'object',
						'properties' => $billing_address_fields,
					],
				],
			],
		];

		$membership_args = [
			'membership' => [
				'description' => __('The membership data is automatically generated based on the cart info passed (e.g. products) but can be overridden with this property.', 'ultimate-multisite'),
				'type'        => 'object',
				'properties'  => [
					'status'                      => [
						'description' => __('The membership status.', 'ultimate-multisite'),
						'type'        => 'string',
						'enum'        => array_values(Membership_Status::get_allowed_list()),
						'default'     => Membership_Status::PENDING,
					],
					'date_expiration'             => [
						'description' => __('The membership expiration date. Must be a valid PHP date format.', 'ultimate-multisite'),
						'type'        => 'string',
						'format'      => 'date-time',
					],
					'date_trial_end'              => [
						'description' => __('The membership trial end date. Must be a valid PHP date format.', 'ultimate-multisite'),
						'type'        => 'string',
						'format'      => 'date-time',
					],
					'date_activated'              => [
						'description' => __('The membership activation date. Must be a valid PHP date format.', 'ultimate-multisite'),
						'type'        => 'string',
						'format'      => 'date-time',
					],
					'date_renewed'                => [
						'description' => __('The membership last renewed date. Must be a valid PHP date format.', 'ultimate-multisite'),
						'type'        => 'string',
						'format'      => 'date-time',
					],
					'date_cancellation'           => [
						'description' => __('The membership cancellation date. Must be a valid PHP date format.', 'ultimate-multisite'),
						'type'        => 'string',
						'format'      => 'date-time',
					],
					'date_payment_plan_completed' => [
						'description' => __('The membership completion date. Used when the membership is limited to a limited number of billing cycles. Must be a valid PHP date format.', 'ultimate-multisite'),
						'type'        => 'string',
						'format'      => 'date-time',
					],
				],
			],
		];

		$payment_args = [
			'payment'        => [
				'description' => __('The payment data is automatically generated based on the cart info passed (e.g. products) but can be overridden with this property.', 'ultimate-multisite'),
				'type'        => 'object',
				'properties'  => [
					'status' => [
						'description' => __('The payment status.', 'ultimate-multisite'),
						'type'        => 'string',
						'enum'        => array_values(Payment_Status::get_allowed_list()),
						'default'     => Payment_Status::PENDING,
					],
				],
			],
			'payment_method' => [
				'description' => __('Payment method information. Useful when using the REST API to integrate other payment methods.', 'ultimate-multisite'),
				'type'        => 'object',
				'properties'  => [
					'gateway'                 => [
						'description' => __('The gateway name. E.g. stripe.', 'ultimate-multisite'),
						'type'        => 'string',
					],
					'gateway_customer_id'     => [
						'description' => __('The customer ID on the gateway system.', 'ultimate-multisite'),
						'type'        => 'string',
					],
					'gateway_subscription_id' => [
						'description' => __('The subscription ID on the gateway system.', 'ultimate-multisite'),
						'type'        => 'string',
					],
					'gateway_payment_id'      => [
						'description' => __('The payment ID on the gateway system.', 'ultimate-multisite'),
						'type'        => 'string',
					],
				],
			],
		];

		$site_args = [
			'site' => [
				'type'       => 'object',
				'properties' => [
					'site_url'    => [
						'type'        => 'string',
						'description' => __('The site subdomain or subdirectory (depending on your Multisite install). This would be "test" in "test.your-network.com".', 'ultimate-multisite'),
						'minLength'   => 4,
						'required'    => true,
					],
					'site_title'  => [
						'type'        => 'string',
						'description' => __('The site title. E.g. My Amazing Site', 'ultimate-multisite'),
						'minLength'   => 4,
						'required'    => true,
					],
					'publish'     => [
						'description' => __('If we should publish this site regardless of membership/payment status. Sites are created as pending by default, and are only published when a payment is received or the status of the membership changes to "active". This flag allows you to bypass the pending state.', 'ultimate-multisite'),
						'type'        => 'boolean',
						'default'     => false,
					],
					'template_id' => [
						'description' => __('The template ID we should copy when creating this site. If left empty, the value dictated by the products will be used.', 'ultimate-multisite'),
						'type'        => 'integer',
					],
					'site_meta'   => [
						'description' => __('An associative array of key values to be saved as site_meta.', 'ultimate-multisite'),
						'type'        => 'object',
					],
					'site_option' => [
						'description' => __('An associative array of key values to be saved as site_options. Useful for changing plugin settings and other site configurations.', 'ultimate-multisite'),
						'type'        => 'object',
					],
				],
			],
		];

		$cart_args = [
			'products'      => [
				'description' => __('The products to be added to this membership. Takes an array of product ids or slugs.', 'ultimate-multisite'),
				'uniqueItems' => true,
				'type'        => 'array',
			],
			'duration'      => [
				'description' => __('The membership duration.', 'ultimate-multisite'),
				'type'        => 'integer',
				'required'    => false,
			],
			'duration_unit' => [
				'description' => __('The membership duration unit.', 'ultimate-multisite'),
				'type'        => 'string',
				'default'     => 'month',
				'enum'        => [
					'day',
					'week',
					'month',
					'year',
				],
			],
			'discount_code' => [
				'description' => __('A discount code. E.g. PROMO10.', 'ultimate-multisite'),
				'type'        => 'string',
			],
			'auto_renew'    => [
				'description' => __('The membership auto-renew status. Useful when integrating with other payment options via this REST API.', 'ultimate-multisite'),
				'type'        => 'boolean',
				'default'     => false,
				'required'    => true,
			],
			'country'       => [
				'description' => __('The customer country. Used to calculate taxes and check if registration is allowed for that country.', 'ultimate-multisite'),
				'type'        => 'string',
				'default'     => '',
			],
			'currency'      => [
				'description' => __('The currency to be used.', 'ultimate-multisite'),
				'type'        => 'string',
			],
		];

		$args = array_merge($customer_args, $membership_args, $cart_args, $payment_args, $site_args);

		return apply_filters('wu_rest_register_endpoint_args', $args, $this);
	}

}

<?php
/**
 * Centralized logging and monitoring for registration and payment flows.
 *
 * @package WP_Ultimo
 * @subpackage Monitoring
 * @since 2.0.0
 */

namespace WP_Ultimo\Monitoring;

use Psr\Log\LogLevel;
use WP_Error;
use WP_Ultimo\Controllers\Registration_Controller;
use WP_Ultimo\Database\Payments\Payment_Status;
use WP_Ultimo\Gateways\Base_Gateway;
use WP_Ultimo\Models\Customer;
use WP_Ultimo\Models\Membership;
use WP_Ultimo\Models\Payment;
use WP_Ultimo\Models\Signup_Service;
use WP_Ultimo\Traits\Singleton;

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Hooks into the registration pipeline to provide structured logging
 * and lightweight alerting.
 *
 * @since 2.0.0
 */
class Registration_Monitor {

        use Singleton;

        /**
         * Dedicated log handle for registration events.
         *
         * @since 2.0.0
         * @var string
         */
        protected const LOG_HANDLE = 'registration-monitor';

        /**
         * Boot hooks.
         *
         * @since 2.0.0
         * @return void
         */
        public function init(): void {

                add_filter('wu_signup_service_pre_register', [$this, 'log_signup_attempt'], 10, 2);
                add_action('wu_signup_service_completed', [$this, 'log_signup_completion'], 10, 6);
                add_action('wu_registration_controller_error', [$this, 'handle_registration_error'], 10, 3);
                add_action('wu_gateway_payment_processed', [$this, 'log_payment_success'], 10, 3);
                add_action('wu_transition_payment_status', [$this, 'log_payment_transition'], 10, 3);
                add_action('wu_recurring_payment_failed', [$this, 'handle_recurring_payment_failure'], 10, 2);
        }

        /**
         * Records the start of a signup request.
         *
         * @since 2.0.0
         *
         * @param array          $params  Raw signup payload.
         * @param Signup_Service $service Signup service instance.
         * @return array
         */
        public function log_signup_attempt($params, Signup_Service $service): array {

                $summary = $this->describe_signup_payload((array) $params);

                $message = sprintf(
                        'Signup initiated for %s. Context: %s',
                        $summary['customer_email'] ?: __('unknown customer', 'ultimate-multisite'),
                        $summary['context']
                );

                wu_log_add(self::LOG_HANDLE, $message);

                return $params;
        }

        /**
         * Records the completion of a signup request.
         *
         * @since 2.0.0
         *
         * @param Membership     $membership Membership instance created.
         * @param Customer       $customer   Customer instance.
         * @param Payment        $payment    Payment instance.
         * @param array|false    $site       Site payload.
         * @param array          $params     Original payload.
         * @param Signup_Service $service    Signup service.
         * @return void
         */
        public function log_signup_completion(Membership $membership, Customer $customer, Payment $payment, $site, array $params, Signup_Service $service): void {

                $site_identifier = 'none';

                if (is_array($site)) {
                        $site_identifier = trim(($site['domain'] ?? '') . ($site['path'] ?? ''));
                        $site_identifier = $site_identifier !== '' ? $site_identifier : 'pending';
                }

                $message = sprintf(
                        'Signup completed for membership #%1$d (customer #%2$d). Membership status: %3$s. Payment status: %4$s. Payment total: %5$s. Site: %6$s.',
                        $membership->get_id(),
                        $customer->get_id(),
                        $membership->get_status(),
                        $payment->get_status(),
                        $this->format_currency($payment->get_total(), $payment->get_currency()),
                        $site_identifier
                );

                wu_log_add(self::LOG_HANDLE, $message);
        }

        /**
         * Records successful payment captures.
         *
         * @since 2.0.0
         *
         * @param Payment      $payment    Payment instance.
         * @param Membership   $membership Membership instance.
         * @param Base_Gateway $gateway    Gateway instance.
         * @return void
         */
        public function log_payment_success(Payment $payment, Membership $membership, Base_Gateway $gateway): void {

                $message = sprintf(
                        'Payment #%1$d captured successfully via %2$s. Membership #%3$d now has status %4$s. Payment total: %5$s.',
                        $payment->get_id(),
                        $gateway->get_title(),
                        $membership->get_id(),
                        $membership->get_status(),
                        $this->format_currency($payment->get_total(), $payment->get_currency())
                );

                wu_log_add(self::LOG_HANDLE, $message);
        }

        /**
         * Logs payment status transitions and alerts on failures.
         *
         * @since 2.0.0
         *
         * @param string $old_status Previous status.
         * @param string $new_status New status.
         * @param int    $payment_id Payment identifier.
         * @return void
         */
        public function log_payment_transition($old_status, $new_status, $payment_id): void {

                $payment = function_exists('wu_get_payment') ? wu_get_payment($payment_id) : null;

                $message = sprintf(
                        'Payment #%1$d status transitioned from %2$s to %3$s.',
                        $payment_id,
                        $old_status,
                        $new_status
                );

                wu_log_add(self::LOG_HANDLE, $message);

                if ( ! $payment instanceof Payment) {
                        return;
                }

                $normalized_status = strtolower((string) $new_status);

                if (in_array($normalized_status, [Payment_Status::FAILED, Payment_Status::CANCELLED], true)) {
                        $this->alert_admin(
                                sprintf(__('Payment issue detected for payment #%d', 'ultimate-multisite'), $payment_id),
                                $this->build_payment_alert_body($payment, $normalized_status)
                        );
                }
        }

        /**
         * Handles recurring payment failure notifications.
         *
         * @since 2.0.0
         *
         * @param Membership   $membership Membership instance.
         * @param Base_Gateway $gateway    Gateway instance.
         * @return void
         */
        public function handle_recurring_payment_failure(Membership $membership, Base_Gateway $gateway): void {

                $message = sprintf(
                        'Recurring payment failure detected for membership #%1$d via %2$s. Current membership status: %3$s.',
                        $membership->get_id(),
                        $gateway->get_title(),
                        $membership->get_status()
                );

                wu_log_add(self::LOG_HANDLE, $message, LogLevel::ERROR);

                $this->alert_admin(
                        sprintf(__('Recurring payment failure for membership #%d', 'ultimate-multisite'), $membership->get_id()),
                        $this->build_recurring_failure_body($membership, $gateway)
                );
        }

        /**
         * Records registration errors and notifies administrators.
         *
         * @since 2.0.0
         *
         * @param WP_Error                $error      Error instance.
         * @param array<string,mixed>     $payload    Signup payload.
         * @param Registration_Controller $controller Controller instance.
         * @return void
         */
        public function handle_registration_error(WP_Error $error, array $payload, Registration_Controller $controller): void {

                $summary = $this->describe_signup_payload($payload);

                $message = sprintf(
                        'Registration failed for %1$s. Error: %2$s (code: %3$s). Context: %4$s',
                        $summary['customer_email'] ?: __('unknown customer', 'ultimate-multisite'),
                        $error->get_error_message(),
                        $error->get_error_code(),
                        $summary['context']
                );

                wu_log_add(self::LOG_HANDLE, $message, LogLevel::ERROR);

                $this->alert_admin(
                        sprintf(__('Registration failure: %s', 'ultimate-multisite'), $error->get_error_code()),
                        $this->build_registration_alert_body($error, $summary)
                );
        }

        /**
         * Builds a sanitized summary for logging.
         *
         * @since 2.0.0
         *
         * @param array $payload Signup payload.
         * @return array<string,string>
         */
        protected function describe_signup_payload(array $payload): array {

                $customer_email = '';

                if (isset($payload['customer']['email'])) {
                        $customer_email = sanitize_email((string) $payload['customer']['email']);
                }

                $plan = '';

                if (isset($payload['plan_product'])) {
                        $plan = sanitize_text_field((string) $payload['plan_product']);
                } elseif (isset($payload['products']) && is_array($payload['products'])) {
                        $plan = implode(',', array_map('sanitize_text_field', array_map('strval', $payload['products'])));
                }

                $site = '';

                if (isset($payload['site']['site_slug'])) {
                        $site = sanitize_title((string) $payload['site']['site_slug']);
                } elseif (isset($payload['site']['site_url'])) {
                        $site = sanitize_title((string) $payload['site']['site_url']);
                }

                $gateway = '';

                if (isset($payload['payment_method']['gateway'])) {
                        $gateway = sanitize_text_field((string) $payload['payment_method']['gateway']);
                } elseif (isset($payload['gateway'])) {
                        $gateway = sanitize_text_field((string) $payload['gateway']);
                }

                $cart_type = '';

                if (isset($payload['type'])) {
                        $cart_type = sanitize_text_field((string) $payload['type']);
                } elseif (isset($payload['cart_type'])) {
                        $cart_type = sanitize_text_field((string) $payload['cart_type']);
                }

                $context = array_filter(
                        [
                                'plan'      => $plan,
                                'gateway'   => $gateway,
                                'site'      => $site,
                                'cart_type' => $cart_type,
                        ],
                        static fn($value) => $value !== ''
                );

                return [
                        'customer_email' => $customer_email,
                        'context'        => wp_json_encode($context, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                ];
        }

        /**
         * Formats currency output safely.
         *
         * @since 2.0.0
         *
         * @param float|int|string $amount   Amount.
         * @param string|null      $currency Currency code.
         * @return string
         */
        protected function format_currency($amount, $currency): string {

                if (function_exists('wu_format_currency')) {
                        return wu_format_currency($amount, $currency);
                }

                return sprintf('%s %s', (string) $amount, strtoupper((string) $currency));
        }

        /**
         * Sends an alert email to the configured recipients.
         *
         * @since 2.0.0
         *
         * @param string $subject Email subject.
         * @param string $body    Email body.
         * @return void
         */
        protected function alert_admin(string $subject, string $body): void {

                $recipients = apply_filters(
                        'webmakerr_monitoring_recipients',
                        $this->default_recipients(),
                        $subject,
                        $body
                );

                $recipients = array_filter(array_map('sanitize_email', (array) $recipients));

                if (empty($recipients)) {
                        return;
                }

                wp_mail($recipients, $subject, $body, ['Content-Type: text/plain; charset=UTF-8']);
        }

        /**
         * Determines the default notification recipients.
         *
         * @since 2.0.0
         * @return array<int,string>
         */
        protected function default_recipients(): array {

                $admin_email = sanitize_email((string) get_option('admin_email'));

                if ($admin_email === '') {
                        return [];
                }

                return [$admin_email];
        }

        /**
         * Builds the registration alert body.
         *
         * @since 2.0.0
         *
         * @param WP_Error $error   Error instance.
         * @param array    $summary Sanitized context.
         * @return string
         */
        protected function build_registration_alert_body(WP_Error $error, array $summary): string {

                $lines = [
                        sprintf(__('Site: %s', 'ultimate-multisite'), get_bloginfo('name')),
                        sprintf(__('Error code: %s', 'ultimate-multisite'), $error->get_error_code()),
                        sprintf(__('Error message: %s', 'ultimate-multisite'), $error->get_error_message()),
                        sprintf(__('Customer email: %s', 'ultimate-multisite'), $summary['customer_email'] ?: __('unknown', 'ultimate-multisite')),
                        sprintf(__('Context: %s', 'ultimate-multisite'), $summary['context']),
                        sprintf(__('Timestamp: %s', 'ultimate-multisite'), current_time('mysql')),
                ];

                return implode("\n", $lines);
        }

        /**
         * Builds the payment alert body for failed transactions.
         *
         * @since 2.0.0
         *
         * @param Payment $payment Payment instance.
         * @param string  $status  Payment status.
         * @return string
         */
        protected function build_payment_alert_body(Payment $payment, string $status): string {

                $membership_id = $payment->get_membership_id();
                $customer_id   = $payment->get_customer_id();

                $customer_email = '';

                if ($customer_id && function_exists('wu_get_customer')) {
                        $customer = wu_get_customer($customer_id);

                        if ($customer instanceof Customer) {
                                $customer_email = $customer->get_email();
                        }
                }

                $lines = [
                        sprintf(__('Site: %s', 'ultimate-multisite'), get_bloginfo('name')),
                        sprintf(__('Payment ID: %d', 'ultimate-multisite'), $payment->get_id()),
                        sprintf(__('Membership ID: %d', 'ultimate-multisite'), $membership_id),
                        sprintf(__('Customer email: %s', 'ultimate-multisite'), $customer_email ?: __('unknown', 'ultimate-multisite')),
                        sprintf(__('Status: %s', 'ultimate-multisite'), $status),
                        sprintf(__('Gateway: %s', 'ultimate-multisite'), $payment->get_gateway() ?: __('unknown', 'ultimate-multisite')),
                        sprintf(__('Amount: %s', 'ultimate-multisite'), $this->format_currency($payment->get_total(), $payment->get_currency())),
                        sprintf(__('Timestamp: %s', 'ultimate-multisite'), current_time('mysql')),
                ];

                return implode("\n", $lines);
        }

        /**
         * Builds the alert body for recurring payment failures without a payment record.
         *
         * @since 2.0.0
         *
         * @param Membership   $membership Membership instance.
         * @param Base_Gateway $gateway    Gateway instance.
         * @return string
         */
        protected function build_recurring_failure_body(Membership $membership, Base_Gateway $gateway): string {

                $customer = $membership->get_customer();

                $lines = [
                        sprintf(__('Site: %s', 'ultimate-multisite'), get_bloginfo('name')),
                        sprintf(__('Membership ID: %d', 'ultimate-multisite'), $membership->get_id()),
                        sprintf(__('Membership status: %s', 'ultimate-multisite'), $membership->get_status()),
                        sprintf(__('Gateway: %s', 'ultimate-multisite'), $gateway->get_title()),
                        sprintf(__('Customer email: %s', 'ultimate-multisite'), $customer ? $customer->get_email() : __('unknown', 'ultimate-multisite')),
                        sprintf(__('Timestamp: %s', 'ultimate-multisite'), current_time('mysql')),
                ];

                return implode("\n", $lines);
        }
}

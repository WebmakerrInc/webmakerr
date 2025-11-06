<?php

namespace WP_Ultimo\Controllers;

use WP_UnitTestCase;
use WP_Ultimo\Controllers\Registration_Controller;
use WP_Ultimo\Models\Product;

class Registration_Controller_Test extends WP_UnitTestCase {

        private Registration_Controller $controller;

        /**
         * @var array<int,Product>
         */
        private array $created_products = [];

        public function set_up(): void {
                parent::set_up();

                $this->controller = Registration_Controller::get_instance();
        }

        public function tear_down(): void {
                foreach ($this->created_products as $product) {
                        $product->delete();
                }

                $this->created_products = [];

                parent::tear_down();
        }

        public function test_prepare_signup_payload_sanitizes_request_data(): void {
                $plan = $this->create_plan([
                        'slug' => 'controller-plan-' . wp_generate_password(6, false),
                ]);

                $request = [
                        'email'        => 'USER@example.COM ',
                        'username'     => ' Test User ',
                        'password'     => 'SecretPassword123!',
                        'first_name'   => ' <b>Jane</b> ',
                        'last_name'    => ' Doe ',
                        'customer'     => [
                                'billing_address' => [
                                        'city' => ' New York ',
                                ],
                        ],
                        'site_title'   => ' My <em>Site</em> ',
                        'site_url'     => 'My Site URL',
                        'membership'   => [
                                'plan_id' => $plan->get_id(),
                        ],
                        'products'     => [$plan->get_slug(), (string) $plan->get_id()],
                        'auto_renew'   => 'yes',
                        'discount_code'=> ' SUMMER2024 ',
                        'coupon_code'  => ' BONUS10 ',
                        'type'         => 'New-Signup',
                ];

                $payload = $this->controller->prepare_signup_payload($request);

                $this->assertArrayHasKey('customer', $payload);
                $this->assertSame('user@example.com', $payload['customer']['email']);
                $this->assertSame('testuser', $payload['customer']['username']);
                $this->assertSame('Jane', $payload['customer']['first_name']);
                $this->assertSame('Doe', $payload['customer']['last_name']);
                $this->assertSame('New York', $payload['customer']['billing_address']['city']);

                $this->assertArrayHasKey('site', $payload);
                $this->assertSame('My Site', $payload['site']['site_title']);
                $this->assertSame(sanitize_title('My Site URL'), $payload['site']['site_url']);

                $this->assertArrayHasKey('products', $payload);
                $this->assertSame([$plan->get_id()], $payload['products']);

                $this->assertTrue($payload['auto_renew']);
                $this->assertSame('SUMMER2024', $payload['discount_code']);
                $this->assertSame('BONUS10', $payload['coupon_code']);
                $this->assertSame('new-signup', $payload['type']);
        }

        public function test_resolve_plan_identifier_from_request_prioritizes_first_valid_value(): void {
                $identifier = $this->controller->resolve_plan_identifier_from_request([
                        'plan_product' => '',
                        'plan_id'      => 42,
                        'plan'         => 'ignored-plan',
                        'plan_slug'    => 'final-plan',
                ]);

                $this->assertSame(42, $identifier);

                $fallback = $this->controller->resolve_plan_identifier_from_request([
                        'plan_slug' => 'slug-plan',
                ]);

                $this->assertSame('slug-plan', $fallback);
        }

        public function test_ensure_products_include_plan_appends_missing_identifier(): void {
                $products = [10, 20];

                $result = $this->controller->ensure_products_include_plan($products, 20);
                $this->assertSame([10, 20], $result);

                $result_with_new_plan = $this->controller->ensure_products_include_plan($products, 30);
                sort($result_with_new_plan);
                $this->assertSame([10, 20, 30], $result_with_new_plan);
        }

        private function create_plan(array $overrides = []): Product {
                $defaults = [
                        'name'          => 'Controller Plan ' . wp_generate_password(6, false),
                        'slug'          => 'controller-plan-' . wp_generate_password(6, false),
                        'type'          => 'plan',
                        'active'        => true,
                        'amount'        => 25,
                        'pricing_type'  => 'paid',
                        'currency'      => 'USD',
                        'recurring'     => true,
                        'duration'      => 1,
                        'duration_unit' => 'month',
                ];

                $product = wu_create_product(array_merge($defaults, $overrides));

                if (is_wp_error($product)) {
                        $this->fail('Unable to create product for registration controller test: ' . $product->get_error_message());
                }

                $this->created_products[] = $product;

                return $product;
        }
}

<?php

namespace WP_Ultimo\Services;

use WP_UnitTestCase;
use WP_Ultimo\Models\Product;

class Plan_Service_Test extends WP_UnitTestCase {

        private Plan_Service $plan_service;

        /**
         * Track products created during tests so we can clean them up.
         *
         * @var array<int,Product>
         */
        private array $created_products = [];

        public function set_up(): void {
                parent::set_up();

                $this->plan_service = Plan_Service::get_instance();
        }

        public function tear_down(): void {
                foreach ($this->created_products as $product) {
                        $product->delete();
                }

                $this->created_products = [];

                parent::tear_down();
        }

        public function test_get_normalized_plans_returns_sanitized_payload(): void {
                $product = $this->create_plan([
                        'name'           => 'Normalized Plan',
                        'slug'           => 'normalized-plan-' . wp_generate_password(6, false),
                        'amount'         => 29.99,
                        'trial_duration' => 14,
                        'currency'       => 'USD',
                ]);

                $product->set_feature_list([' First Feature ', '', '<strong>Second Feature</strong>']);
                $product->set_price_variations([
                        [
                                'duration'      => 12,
                                'duration_unit' => 'month',
                                'amount'        => 299.90,
                        ],
                ]);
                $product->save();

                $plans = $this->plan_service->get_normalized_plans([
                        'include' => [$product->get_id()],
                ]);

                $this->assertNotEmpty($plans, 'Normalized plans should include the created plan.');

                $normalized = $plans[0];

                $this->assertSame($product->get_id(), $normalized['id']);
                $this->assertSame(['First Feature', 'Second Feature'], $normalized['feature_list']);
                $this->assertTrue($normalized['has_trial']);
                $this->assertNotEmpty($normalized['price_variations']);

                $first_variation = $normalized['price_variations'][0];
                $this->assertSame(12, $first_variation['duration']);
                $this->assertSame('month', $first_variation['duration_unit']);
                $this->assertSame(299.90, $first_variation['amount']);
        }

        public function test_resolve_plan_from_signup_context_handles_membership_and_product_lists(): void {
                $plan = $this->create_plan([
                        'name' => 'Signup Context Plan',
                        'slug' => 'signup-context-' . wp_generate_password(6, false),
                ]);

                $result_payload = [
                        'membership' => [
                                'plan_id' => $plan->get_slug(),
                        ],
                ];
                $request_payload = [
                        'products' => [$plan->get_id()],
                ];

                $resolved_from_membership = $this->plan_service->resolve_plan_from_signup_context($result_payload, $request_payload);
                $this->assertInstanceOf(Product::class, $resolved_from_membership);
                $this->assertSame($plan->get_id(), $resolved_from_membership->get_id());

                $resolved_from_products = $this->plan_service->resolve_plan_from_signup_context([], [
                        'products' => [$plan->get_slug()],
                ]);

                $this->assertInstanceOf(Product::class, $resolved_from_products);
                $this->assertSame($plan->get_id(), $resolved_from_products->get_id());
        }

        public function test_resolve_onboarding_destination_prioritizes_valid_candidates(): void {
                $plan = $this->create_plan([
                        'name'            => 'Onboarding Plan',
                        'slug'            => 'onboarding-plan-' . wp_generate_password(6, false),
                        'onboarding_url'  => 'https://example.com/onboarding',
                ]);

                $context = [
                        'settings_onboarding_url' => 'https://example.com/settings',
                        'request'                 => [
                                'redirect_to' => '/custom-dashboard',
                        ],
                        'default_redirect'       => 'https://example.com/default',
                        'result'                 => [
                                'site'     => [
                                        'admin_url' => 'https://example.com/wp-admin',
                                ],
                                'customer' => [
                                        'user_id' => 1,
                                ],
                        ],
                ];

                $destination = $this->plan_service->resolve_onboarding_destination($plan, $context);

                $this->assertSame('https://example.com/onboarding', $destination);

                $fallback_destination = $this->plan_service->resolve_onboarding_destination(null, [
                        'request' => [
                                'redirect_to' => '/fallback-path',
                        ],
                ]);

                $this->assertSame(esc_url_raw(home_url('/fallback-path')), $fallback_destination);
        }

        private function create_plan(array $overrides = []): Product {
                $defaults = [
                        'name'          => 'Test Plan ' . wp_generate_password(6, false),
                        'slug'          => 'test-plan-' . wp_generate_password(6, false),
                        'type'          => 'plan',
                        'active'        => true,
                        'amount'        => 10,
                        'pricing_type'  => 'paid',
                        'currency'      => 'USD',
                        'recurring'     => true,
                        'duration'      => 1,
                        'duration_unit' => 'month',
                ];

                $product = wu_create_product(array_merge($defaults, $overrides));

                if (is_wp_error($product)) {
                        $this->fail('Failed to create product for plan service test: ' . $product->get_error_message());
                }

                $this->created_products[] = $product;

                return $product;
        }
}

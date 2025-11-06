<?php
/**
 * Template Name: Register
 * Description: Registration page featuring hero, plan selector, and sign-up form.
 *
 * @package Webmakerr
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();

$form_action = function_exists('network_site_url')
    ? network_site_url('wp-signup.php')
    : site_url('wp-signup.php');

$plan_data = function_exists('webmakerr_register_get_plan_data')
    ? webmakerr_register_get_plan_data()
    : [];

?>
<main class="register-page" id="main-content">
    <section class="register-hero">
        <div class="register-container">
            <p class="register-eyebrow"><?php echo esc_html__('Try Webmakerr free for 14 days', 'webmakerr'); ?></p>
            <h1 class="register-hero__title"><?php echo esc_html__('Build your store like it is 2024', 'webmakerr'); ?></h1>
            <p class="register-hero__subtitle">
                <?php
                echo esc_html__(
                    'Launch faster with designer-made templates, marketing automations, and the commerce toolkit built to scale with you.',
                    'webmakerr'
                );
                ?>
            </p>
        </div>
    </section>

    <section class="register-plans" aria-labelledby="register-plans-heading">
        <div class="register-container">
            <div class="register-section-heading">
                <h2 class="register-section-heading__title" id="register-plans-heading">
                    <?php echo esc_html__('Choose a plan that fits your ambition', 'webmakerr'); ?>
                </h2>
                <p class="register-section-heading__subtitle">
                    <?php echo esc_html__('Upgrade, downgrade, or cancel anytime. Every plan includes all essential commerce features.', 'webmakerr'); ?>
                </p>
            </div>

            <div class="register-plan-wrapper" data-register-plan-wrapper>
                <div
                    class="register-plan-list"
                    data-register-plans
                    aria-live="polite"
                    role="radiogroup"
                    tabindex="-1"
                >
                    <?php if (! empty($plan_data)) : ?>
                        <?php foreach ($plan_data as $index => $plan) : ?>
                            <button
                                type="button"
                                class="register-plan-card"
                                data-plan-id="<?php echo esc_attr($plan['id']); ?>"
                                <?php echo ! empty($plan['recommended']) ? 'data-plan-recommended="true"' : ''; ?>
                            >
                                <span class="register-plan-card__badge" aria-hidden="true">
                                    <?php echo esc_html__('Popular', 'webmakerr'); ?>
                                </span>
                                <span class="register-plan-card__name"><?php echo esc_html($plan['name']); ?></span>
                                <?php if (! empty($plan['price'])) : ?>
                                    <span class="register-plan-card__price">
                                        <?php echo esc_html($plan['price']); ?>
                                        <?php if (! empty($plan['priceSuffix'])) : ?>
                                            <span class="register-plan-card__price-suffix"><?php echo esc_html($plan['priceSuffix']); ?></span>
                                        <?php endif; ?>
                                    </span>
                                <?php endif; ?>
                                <?php if (! empty($plan['description'])) : ?>
                                    <span class="register-plan-card__description"><?php echo esc_html($plan['description']); ?></span>
                                <?php endif; ?>
                                <?php if (! empty($plan['features']) && is_array($plan['features'])) : ?>
                                    <ul class="register-plan-card__features">
                                        <?php foreach ($plan['features'] as $feature) : ?>
                                            <li><?php echo esc_html($feature); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </button>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="register-plan-empty" data-register-plan-empty>
                            <?php echo esc_html__('Plans are loading. Hang tight…', 'webmakerr'); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="register-form" aria-labelledby="register-form-heading">
        <div class="register-container register-form__container">
            <div class="register-form__intro">
                <h2 class="register-section-heading__title" id="register-form-heading">
                    <?php echo esc_html__('Create your store', 'webmakerr'); ?>
                </h2>
                <p class="register-section-heading__subtitle">
                    <?php echo esc_html__('We just need a few details to spin up your storefront.', 'webmakerr'); ?>
                </p>
                <div class="register-plan-summary" data-register-plan-summary-wrapper>
                    <span class="register-plan-summary__label"><?php echo esc_html__('Selected plan', 'webmakerr'); ?>:</span>
                    <span class="register-plan-summary__value" data-register-plan-name><?php echo esc_html__('None selected yet', 'webmakerr'); ?></span>
                </div>
            </div>

            <form
                class="register-signup-form"
                data-register-form
                action="<?php echo esc_url($form_action); ?>"
                method="post"
                novalidate
            >
                <input type="hidden" name="plan_id" value="" data-register-selected-plan>
                <?php wp_nonce_field('wu_registration_submit', 'wu_registration_nonce'); ?>

                <div class="register-field">
                    <label class="register-field__label" for="register-full-name"><?php echo esc_html__('Full name', 'webmakerr'); ?></label>
                    <input
                        class="register-field__input"
                        type="text"
                        id="register-full-name"
                        name="full_name"
                        autocomplete="name"
                        required
                        data-register-field="name"
                        placeholder="<?php echo esc_attr__('Jordan Doe', 'webmakerr'); ?>"
                    >
                    <p class="register-field__feedback" data-feedback-for="name"></p>
                </div>

                <div class="register-field">
                    <label class="register-field__label" for="register-email"><?php echo esc_html__('Email address', 'webmakerr'); ?></label>
                    <input
                        class="register-field__input"
                        type="email"
                        id="register-email"
                        name="user_email"
                        autocomplete="email"
                        required
                        data-register-field="email"
                        data-register-email
                        placeholder="<?php echo esc_attr__('you@company.com', 'webmakerr'); ?>"
                    >
                    <p class="register-field__feedback" data-feedback-for="email"></p>
                </div>

                <div class="register-field">
                    <label class="register-field__label" for="register-site-name"><?php echo esc_html__('Store address', 'webmakerr'); ?></label>
                    <div class="register-site-input">
                        <input
                            class="register-field__input"
                            type="text"
                            id="register-site-name"
                            name="blogname"
                            autocomplete="off"
                            inputmode="lowercase"
                            pattern="[a-z0-9-]{4,}"
                            minlength="4"
                            required
                            data-register-field="site"
                            data-register-site
                            placeholder="<?php echo esc_attr__('my-store', 'webmakerr'); ?>"
                        >
                        <span class="register-site-suffix"><?php echo esc_html__('.webmakerr.com', 'webmakerr'); ?></span>
                    </div>
                    <p class="register-field__feedback" data-feedback-for="site"></p>
                </div>

                <div class="register-field">
                    <label class="register-field__label" for="register-password"><?php echo esc_html__('Password', 'webmakerr'); ?></label>
                    <input
                        class="register-field__input"
                        type="password"
                        id="register-password"
                        name="user_password"
                        autocomplete="new-password"
                        minlength="8"
                        required
                        data-register-field="password"
                        placeholder="<?php echo esc_attr__('Create a strong password', 'webmakerr'); ?>"
                    >
                    <p class="register-field__feedback" data-feedback-for="password"></p>
                </div>

                <button type="submit" class="register-submit" data-register-submit>
                    <?php echo esc_html__('Start free trial', 'webmakerr'); ?>
                </button>

                <p class="register-terms">
                    <?php
                    printf(
                        wp_kses(
                            /* translators: 1: terms of service link, 2: privacy policy link */
                            __('By continuing you agree to our <a href="%1$s">Terms of Service</a> and <a href="%2$s">Privacy Policy</a>.', 'webmakerr'),
                            [
                                'a' => [
                                    'href'   => [],
                                    'target' => [],
                                    'rel'    => [],
                                ],
                            ]
                        ),
                        esc_url(home_url('/terms/')),
                        esc_url(home_url('/privacy/'))
                    );
                    ?>
                </p>
            </form>
        </div>
    </section>
</main>
<?php
get_footer();

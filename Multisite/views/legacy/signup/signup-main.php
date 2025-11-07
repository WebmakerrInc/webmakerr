<?php
/**
 * The Template for displaying the signup flow for the end user
 *
 * This template can be overridden by copying it to yourtheme/wp-ultimo/signup/signup-header.php.
 *
 * HOWEVER, on occasion Ultimate Multisite will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @author      NextPress
 * @package     WP_Ultimo/Views
 * @version     1.4.0
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

/** WordPress Administration Screen API */
require_once ABSPATH . 'wp-admin/includes/class-wp-screen.php';
require_once ABSPATH . 'wp-admin/includes/screen.php';

// Load the admin actions removed in WordPress 6.0
$admin_actions = [
	'admin_print_scripts'        => [
		'print_head_scripts' => 20,
	],
	'admin_print_styles'         => [
		'print_admin_styles' => 20,
	],
	'admin_head'                 => [
		'wp_color_scheme_settings' => 10,
		'wp_admin_canonical_url'   => 10,
		'wp_site_icon'             => 10,
		'wp_admin_viewport_meta'   => 10,
	],
	'admin_print_footer_scripts' => [
		'_wp_footer_scripts' => 10,
	],
];

foreach ($admin_actions as $action => $handlers) {
	foreach ($handlers as $handler => $priority) {
		if ( ! has_action($action, $handler) && function_exists($handler)) {
			add_action($action, $handler, $priority);
		}
	}
}

do_action('wu_checkout_scripts');

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

	<head>
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title>
		<?php // translators: %s title of the current site ?>
		<?php echo esc_html(apply_filters('wu_signup_page_title', sprintf(__('%s - Signup', 'ultimate-multisite'), get_bloginfo('Name'), get_bloginfo('Name')))); ?>
	</title>

	<?php // Signup do action, like the default ?>
	<?php do_action('signup_header'); ?>
	<?php do_action('login_enqueue_scripts'); ?>
	<?php do_action('wu_signup_enqueue_scripts'); ?>
	<?php do_action('admin_print_scripts'); ?>
        <?php do_action('admin_print_styles'); ?>

        <?php // do_action('admin_head'); ?>

        <style id="wu-legacy-signup-styles">
                body.wu-legacy-signup-body {
                        margin: 0;
                        min-height: 100vh;
                        font-family: var(--wp--preset--font-family--body-font, 'Inter', 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif);
                        background: #f8fafc;
                        color: #0f172a;
                }

                .wu-legacy-signup-page {
                        position: relative;
                        display: flex;
                        flex-direction: column;
                        min-height: 100vh;
                        background: linear-gradient(180deg, #0f172a 0%, #111827 42%, #f8fafc 42%, #f8fafc 100%);
                }

                .wu-legacy-signup-hero {
                        padding: 4rem 1.5rem 6.5rem;
                        color: #f8fafc;
                }

                .wu-legacy-signup-hero__content {
                        max-width: 68rem;
                        margin: 0 auto;
                        text-align: center;
                        display: grid;
                        gap: 1.25rem;
                }

                .wu-legacy-signup-kicker {
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        gap: 0.5rem;
                        padding: 0.5rem 1rem;
                        border-radius: 999px;
                        background-color: rgba(148, 163, 184, 0.25);
                        font-size: 0.875rem;
                        letter-spacing: 0.04em;
                        text-transform: uppercase;
                        font-weight: 600;
                }

                .wu-legacy-signup-hero__content h1 {
                        font-size: clamp(2.5rem, 5vw, 3.5rem);
                        line-height: 1.1;
                        font-weight: 600;
                        margin: 0;
                }

                .wu-legacy-signup-hero__content p {
                        margin: 0;
                        font-size: clamp(1rem, 2.4vw, 1.25rem);
                        line-height: 1.7;
                        color: rgba(241, 245, 249, 0.9);
                }

                .wu-legacy-signup-layout {
                        width: min(1200px, 100%);
                        margin: -5.5rem auto 4rem;
                        padding: 0 1.5rem 3rem;
                        display: flex;
                        flex-direction: column;
                        gap: 2rem;
                }

                .wu-legacy-signup-main {
                        flex: 1 1 0;
                }

                .wu-legacy-signup-card {
                        background: #ffffff;
                        border-radius: 1.5rem;
                        padding: 2.5rem;
                        box-shadow: 0 30px 80px -40px rgba(15, 23, 42, 0.55), 0 20px 40px -30px rgba(15, 23, 42, 0.35);
                        display: flex;
                        flex-direction: column;
                        gap: 2rem;
                }

                #login {
                        margin: 0;
                        padding: 0;
                        width: 100%;
                        background: transparent;
                        box-shadow: none;
                }

                #wu-setup-logo {
                        margin: 0;
                        text-align: left;
                }

                #wu-setup-logo a {
                        color: #0f172a;
                        font-size: 1.75rem;
                        font-weight: 600;
                        text-decoration: none;
                }

                #loginform {
                        margin: 0;
                        padding: 0;
                        box-shadow: none;
                        background: transparent;
                        display: flex;
                        flex-direction: column;
                        gap: 1.25rem;
                }

                .wu-legacy-signup-card input[type="text"],
                .wu-legacy-signup-card input[type="email"],
                .wu-legacy-signup-card input[type="password"],
                .wu-legacy-signup-card input[type="tel"],
                .wu-legacy-signup-card input[type="url"],
                .wu-legacy-signup-card input[type="number"],
                .wu-legacy-signup-card select,
                .wu-legacy-signup-card textarea {
                        width: 100%;
                        border-radius: 0.85rem;
                        border: 1px solid #e2e8f0;
                        padding: 0.85rem 1rem;
                        font-size: 1rem;
                        line-height: 1.5;
                        transition: border-color 0.2s ease, box-shadow 0.2s ease;
                        background: #f8fafc;
                }

                .wu-legacy-signup-card input:focus,
                .wu-legacy-signup-card select:focus,
                .wu-legacy-signup-card textarea:focus {
                        border-color: #2563eb;
                        outline: none;
                        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.18);
                        background: #ffffff;
                }

                .wu-legacy-signup-card .button,
                .wu-legacy-signup-card button,
                .wu-legacy-signup-card input[type="submit"] {
                        border-radius: 999px;
                        padding: 0.9rem 1.75rem;
                        font-size: 1rem;
                        font-weight: 600;
                        border: none;
                        background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
                        color: #ffffff;
                        cursor: pointer;
                        box-shadow: 0 18px 40px -20px rgba(37, 99, 235, 0.7);
                        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
                }

                .wu-legacy-signup-card .button:hover,
                .wu-legacy-signup-card button:hover,
                .wu-legacy-signup-card input[type="submit"]:hover {
                        transform: translateY(-1px);
                        box-shadow: 0 22px 45px -20px rgba(37, 99, 235, 0.8);
                }

                .wu-legacy-signup-card .button:disabled,
                .wu-legacy-signup-card button:disabled,
                .wu-legacy-signup-card input[type="submit"][disabled] {
                        cursor: not-allowed;
                        opacity: 0.65;
                        box-shadow: none;
                }

                .wu-signup-secondary {
                        border-top: 1px solid #e2e8f0;
                        padding-top: 1.5rem;
                        display: flex;
                        flex-direction: column;
                        gap: 1.25rem;
                }

                #nav {
                        margin: 0;
                        display: flex;
                        flex-wrap: wrap;
                        gap: 0.75rem 1.5rem;
                        justify-content: flex-start;
                        font-size: 0.95rem;
                        color: #475569;
                }

                #nav a {
                        color: #2563eb;
                        text-decoration: none;
                        font-weight: 600;
                }

                #nav a:hover {
                        text-decoration: underline;
                }

                .wu-legacy-signup-sidebar {
                        display: flex;
                        flex-direction: column;
                        gap: 1.5rem;
                }

                .wu-legacy-signup-sidebar-card,
                .wu-legacy-signup-feature-card {
                        background: rgba(15, 23, 42, 0.85);
                        color: #e2e8f0;
                        border-radius: 1.5rem;
                        padding: 2rem;
                        box-shadow: 0 25px 60px -35px rgba(15, 23, 42, 0.65);
                        backdrop-filter: blur(6px);
                }

                .wu-legacy-signup-sidebar-card h2,
                .wu-legacy-signup-feature-card h2,
                .wu-legacy-signup-feature-card h3 {
                        margin: 0 0 1rem 0;
                        font-size: 1.25rem;
                        font-weight: 600;
                }

                .wu-setup-steps {
                        list-style: none;
                        margin: 1.25rem 0 0;
                        padding: 0;
                        display: flex;
                        flex-direction: column;
                        gap: 0.75rem;
                        counter-reset: wu-signup-step;
                }

                .wu-setup-steps li {
                        position: relative;
                        counter-increment: wu-signup-step;
                        padding: 0.85rem 1rem 0.85rem 3.25rem;
                        border-radius: 999px;
                        background: rgba(148, 163, 184, 0.18);
                        color: #cbd5f5;
                        font-weight: 500;
                        width: 100% !important;
                        transition: background 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
                }

                .wu-setup-steps li::before {
                        content: counter(wu-signup-step);
                        position: absolute;
                        inset-inline-start: 1rem;
                        top: 50%;
                        transform: translateY(-50%);
                        height: 2rem;
                        width: 2rem;
                        border-radius: 999px;
                        display: grid;
                        place-items: center;
                        font-weight: 700;
                        background: rgba(148, 163, 184, 0.35);
                        color: #e2e8f0;
                }

                .wu-setup-steps li.done {
                        background: rgba(59, 130, 246, 0.18);
                        color: #bfdbfe;
                        box-shadow: inset 0 0 0 1px rgba(59, 130, 246, 0.35);
                }

                .wu-setup-steps li.done::before {
                        background: rgba(37, 99, 235, 0.4);
                        color: #eff6ff;
                }

                .wu-setup-steps li.active {
                        background: linear-gradient(135deg, #2563eb 0%, #6366f1 100%);
                        color: #f8fafc;
                        box-shadow: 0 10px 25px -15px rgba(59, 130, 246, 0.75);
                }

                .wu-setup-steps li.active::before {
                        background: #f8fafc;
                        color: #2563eb;
                }

                .wu-signup-back {
                        margin-top: 1.5rem;
                        text-align: left;
                }

                .wu-signup-back-link {
                        color: #93c5fd;
                        font-size: 0.95rem;
                        font-weight: 500;
                        text-decoration: none;
                        transition: color 0.2s ease;
                }

                .wu-signup-back-link:hover {
                        color: #bfdbfe;
                }

                .wu-legacy-signup-feature-card ul {
                        list-style: none;
                        margin: 1rem 0 0;
                        padding: 0;
                        display: grid;
                        gap: 0.85rem;
                }

                .wu-legacy-signup-feature-card li {
                        display: flex;
                        align-items: flex-start;
                        gap: 0.75rem;
                        font-size: 0.95rem;
                        line-height: 1.5;
                        color: rgba(226, 232, 240, 0.92);
                }

                .wu-legacy-signup-feature-card li::before {
                        content: '✔';
                        color: #34d399;
                        font-weight: 700;
                        margin-top: 0.1rem;
                }

                @media (min-width: 640px) {
                        .wu-legacy-signup-card {
                                padding: 3rem;
                        }

                        .wu-legacy-signup-hero {
                                padding: 5rem 2rem 7rem;
                        }

                        .wu-legacy-signup-hero__content {
                                text-align: left;
                        }

                        .wu-legacy-signup-kicker {
                                justify-content: flex-start;
                        }
                }

                @media (min-width: 1024px) {
                        .wu-legacy-signup-layout {
                                flex-direction: row;
                        }

                        .wu-legacy-signup-sidebar {
                                flex: 0 0 340px;
                        }
                }

                @media (prefers-reduced-motion: reduce) {
                        .wu-legacy-signup-card .button,
                        .wu-legacy-signup-card button,
                        .wu-legacy-signup-card input[type="submit"] {
                                transition: none;
                        }

                        .wu-setup-steps li,
                        .wu-signup-back-link,
                        .wu-legacy-signup-card input,
                        .wu-legacy-signup-card select,
                        .wu-legacy-signup-card textarea {
                                transition: none;
                        }
                }
        </style>

        </head>

        <body class="login wp-core-ui wu-legacy-signup-body">

        <?php
        while (have_posts()) :
                the_post();

                $site_name     = get_bloginfo('name');
                $site_tagline  = get_bloginfo('description');
                $signup_step   = wu_request('step', $signup->step ?? 'default');
                ?>

                <div class="wu-legacy-signup-page">

                <?php
                        /**
                         * Fires right after the start body tag is printed
                         *
                         * @since 1.6.2
                         */
                        do_action('wu_signup_header');

                ?>

                        <section class="wu-legacy-signup-hero" aria-labelledby="wu-legacy-signup-headline">
                                <div class="wu-legacy-signup-hero__content">
                                        <span class="wu-legacy-signup-kicker">
                                                <?php echo esc_html(apply_filters('wu_signup_branding_kicker', sprintf(__('%s Network', 'ultimate-multisite'), $site_name))); ?>
                                        </span>
                                        <h1 id="wu-legacy-signup-headline">
                                                <?php echo esc_html(apply_filters('wu_signup_headline', __('Launch your next website in minutes', 'ultimate-multisite'))); ?>
                                        </h1>
                                        <?php if ($site_tagline) : ?>
                                                <p><?php echo esc_html($site_tagline); ?></p>
                                        <?php else : ?>
                                                <p><?php esc_html_e('Create, customize, and publish with a streamlined experience crafted for ambitious builders.', 'ultimate-multisite'); ?></p>
                                        <?php endif; ?>
                                </div>
                        </section>

                        <main class="wu-legacy-signup-layout" role="main">

                                <section class="wu-legacy-signup-main" aria-labelledby="wu-setup-logo">
                                        <div class="wu-legacy-signup-card">
                                                <div class="wu-setup-content wu-content-<?php echo esc_attr($signup_step); ?>">
                                                        <div id="login">

                                                                <h1 id="wu-setup-logo">
                                                                <a href="<?php echo esc_attr(get_site_url(get_current_site()->site_id)); ?>">
                                                                        <?php // translators: %s title of the current site ?>
                                                                        <?php printf(esc_html__('%s - Signup', 'ultimate-multisite'), esc_html($site_name)); ?>
                                                                </a>
                                                                </h1>

                                                                <?php
                                                                /**
                                                                 * Fires before the site sign-up form.
                                                                 */
                                                                do_action('wu_before_signup_form');

                                                                ?>

                                                                <div class="wu-legacy-signup-form" data-signup-step="<?php echo esc_attr($signup_step); ?>">

                                                                        <div name="loginform" id="loginform" class="wu-legacy-signup-form-content">

                                                                                <?php the_content(); ?>

                                                                        </div>

                                                                </div>

                                                                <?php
                                                                /**
                                                                 * Fires after the sign-up forms, before signup-footer
                                                                 */
                                                                do_action('wu_after_signup_form');

                                                                ?>

                                                                <div class="wu-signup-secondary">
                                                                <?php
                                                                        /**
                                                                         * Nav Links
                                                                         */
                                                                        wu_get_template('legacy/signup/signup-nav-links', ['signup' => $signup]);
                                                                ?>
                                                                </div>

                                                        </div> <!-- /login -->
                                                </div>
                                        </div>
                                </section>

                                <aside class="wu-legacy-signup-sidebar" aria-label="<?php esc_attr_e('Signup progress', 'ultimate-multisite'); ?>">
                                        <div class="wu-legacy-signup-sidebar-card">
                                                <h2><?php esc_html_e('Your progress', 'ultimate-multisite'); ?></h2>
                                                <?php
                                                        /**
                                                         * Navigation Steps
                                                         */
                                                        wu_get_template('legacy/signup/signup-steps-navigation', ['signup' => $signup]);
                                                ?>
                                        </div>
                                        <div class="wu-legacy-signup-feature-card">
                                                <h3><?php printf(esc_html__('%s advantages', 'ultimate-multisite'), esc_html($site_name)); ?></h3>
                                                <ul>
                                                        <li><?php esc_html_e('Flexible site templates designed for rapid launches.', 'ultimate-multisite'); ?></li>
                                                        <li><?php esc_html_e('Modern, responsive layouts that adapt to every device.', 'ultimate-multisite'); ?></li>
                                                        <li><?php esc_html_e('Expert guidance and resources to grow your audience.', 'ultimate-multisite'); ?></li>
                                                </ul>
                                        </div>
                                </aside>

                        </main>

                <?php
                        /**
                         * Fires right after the start body tag is printed
                         *
                         * @since 1.6.2
                         */
                        do_action('wu_signup_footer');

                ?>

                </div>

        <?php endwhile; ?>

	<?php

		global $wp_scripts;

		// $wp_scripts will output and format the tag correctly and safely.
		echo $wp_scripts->get_inline_script_tag('wu-checkout'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	?>

	<?php
		/**
		 * We also need to print the footer admin scripts, to make sure we are enqueing some of the scripts dependencies
		 * our scripts need in order to function properly
		 */
		do_action('admin_print_footer_scripts');
	?>

	</body>

</html>

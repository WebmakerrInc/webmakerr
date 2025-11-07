<?php
/**
 * Template Name: Contact
 * Description: Contact page template with a two-column layout and contact form.
 *
 * @package Webmakerr
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$webmakerr_contact_errors = array();
$webmakerr_contact_success = false;

if ('POST' === $_SERVER['REQUEST_METHOD'] && isset($_POST['webmakerr_contact_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['webmakerr_contact_nonce'])), 'webmakerr_contact_form')) {
    $full_name     = isset($_POST['full_name']) ? sanitize_text_field(wp_unslash($_POST['full_name'])) : '';
    $company_name  = isset($_POST['company_name']) ? sanitize_text_field(wp_unslash($_POST['company_name'])) : '';
    $company_email = isset($_POST['company_email']) ? sanitize_email(wp_unslash($_POST['company_email'])) : '';
    $use_case      = isset($_POST['use_case']) ? sanitize_text_field(wp_unslash($_POST['use_case'])) : '';
    $description   = isset($_POST['description']) ? sanitize_textarea_field(wp_unslash($_POST['description'])) : '';
    $newsletter    = isset($_POST['newsletter']) ? __('Yes', 'webmakerr') : __('No', 'webmakerr');

    if (empty($full_name)) {
        $webmakerr_contact_errors[] = __('Please provide your full name.', 'webmakerr');
    }

    if (empty($company_email) || ! is_email($company_email)) {
        $webmakerr_contact_errors[] = __('Please provide a valid company email address.', 'webmakerr');
    }

    if (empty($description)) {
        $webmakerr_contact_errors[] = __('Please provide a brief description of your project.', 'webmakerr');
    }

    if (empty($webmakerr_contact_errors)) {
        $admin_email = get_option('admin_email');
        $subject     = sprintf(__('New contact form submission from %s', 'webmakerr'), $full_name);

        $message_body  = sprintf("%s %s\n", __('Name:', 'webmakerr'), $full_name);
        $message_body .= sprintf("%s %s\n", __('Company:', 'webmakerr'), $company_name);
        $message_body .= sprintf("%s %s\n", __('Email:', 'webmakerr'), $company_email);
        $message_body .= sprintf("%s %s\n", __('Use case:', 'webmakerr'), $use_case);
        $message_body .= sprintf("%s %s\n\n", __('Newsletter signup:', 'webmakerr'), $newsletter);
        $message_body .= sprintf("%s\n%s", __('Description:', 'webmakerr'), $description);

        // Placeholder for future integration. For now, attempt to send an email to the site admin.
        wp_mail($admin_email, $subject, $message_body, array('Reply-To' => $company_email));

        $webmakerr_contact_success = true;
    }
}

get_header();
?>

<main id="primary" class="bg-white py-16 sm:py-20 lg:py-24">
  <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
    <div class="grid gap-16 lg:grid-cols-[minmax(0,_1.1fr)_minmax(0,_1fr)] lg:gap-24">
      <section class="flex flex-col gap-10 text-left">
        <div class="flex flex-col gap-6">
          <p class="text-sm font-semibold uppercase tracking-[0.3em] text-primary"><?php esc_html_e('Contact', 'webmakerr'); ?></p>
          <h1 class="mt-4 text-4xl font-medium tracking-tight [text-wrap:balance] text-zinc-950 sm:text-5xl"><?php esc_html_e('Get in touch', 'webmakerr'); ?></h1>
          <p class="max-w-xl text-base leading-7 text-zinc-600 sm:text-lg"><?php esc_html_e('Ready to build with Webmakerr? Tell us a bit about your team and how we can help streamline your next launch.', 'webmakerr'); ?></p>
        </div>

        <ul class="flex list-disc flex-col gap-3 pl-5 text-sm font-semibold text-zinc-900">
          <li><a class="inline-flex items-center text-zinc-950 transition hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline" href="mailto:hello@example.com"><?php esc_html_e('Email us directly at hello@example.com', 'webmakerr'); ?></a></li>
          <li><a class="inline-flex items-center text-zinc-950 transition hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline" href="<?php echo esc_url(home_url('/pricing')); ?>"><?php esc_html_e('View pricing and plans', 'webmakerr'); ?></a></li>
          <li><a class="inline-flex items-center text-zinc-950 transition hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline" href="<?php echo esc_url(home_url('/support')); ?>"><?php esc_html_e('Visit our support center', 'webmakerr'); ?></a></li>
        </ul>

        <div class="rounded border border-zinc-200 bg-zinc-50 p-6 shadow-sm sm:p-8">
          <figure class="flex flex-col gap-6">
            <blockquote class="text-lg font-medium text-zinc-900 sm:text-xl">
              “<?php esc_html_e('Webmakerr gave our team the momentum to launch in weeks instead of months. The layout is minimal, accessible, and lightning fast.', 'webmakerr'); ?>”
            </blockquote>
            <figcaption class="flex items-center gap-4">
              <div class="h-12 w-12 rounded bg-zinc-200"></div>
              <div>
                <p class="text-sm font-semibold text-zinc-900"><?php esc_html_e('Amelia Carter', 'webmakerr'); ?></p>
                <p class="text-sm text-zinc-600"><?php esc_html_e('Head of Product, Northwind', 'webmakerr'); ?></p>
              </div>
            </figcaption>
          </figure>
          <div class="mt-8 flex flex-wrap items-center gap-6 text-xs font-semibold uppercase tracking-[0.3em] text-zinc-500">
            <span class="rounded border border-zinc-200 px-4 py-2 text-[11px] text-zinc-700"><?php esc_html_e('Northwind', 'webmakerr'); ?></span>
            <span class="rounded border border-zinc-200 px-4 py-2 text-[11px] text-zinc-700"><?php esc_html_e('Globex', 'webmakerr'); ?></span>
            <span class="rounded border border-zinc-200 px-4 py-2 text-[11px] text-zinc-700"><?php esc_html_e('Acme', 'webmakerr'); ?></span>
          </div>
        </div>
      </section>

      <section>
        <div class="rounded border border-zinc-200 bg-white p-6 shadow-sm sm:p-8 lg:p-10">
          <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl"><?php esc_html_e('Tell us about your project', 'webmakerr'); ?></h2>
          <p class="mt-3 text-sm leading-6 text-zinc-600"><?php esc_html_e('Fill out the form and we’ll follow up within two business days.', 'webmakerr'); ?></p>

          <?php if ($webmakerr_contact_success) : ?>
            <div class="mt-6 rounded border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
              <?php esc_html_e('Thanks for reaching out! We’ll get back to you soon.', 'webmakerr'); ?>
            </div>
          <?php elseif (! empty($webmakerr_contact_errors)) : ?>
            <div class="mt-6 space-y-2">
              <?php foreach ($webmakerr_contact_errors as $error_message) : ?>
                <p class="rounded border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"><?php echo esc_html($error_message); ?></p>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <form class="mt-8 flex flex-col gap-6" action="" method="post">
            <?php wp_nonce_field('webmakerr_contact_form', 'webmakerr_contact_nonce'); ?>

            <div class="grid gap-6 sm:grid-cols-2">
              <div class="flex flex-col gap-2">
                <label class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500" for="full_name"><?php esc_html_e('Full name', 'webmakerr'); ?> <span class="text-red-500">*</span></label>
                <input class="w-full rounded border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm transition focus:border-dark focus:outline-none focus:ring-2 focus:ring-dark/10" type="text" id="full_name" name="full_name" required />
              </div>
              <div class="flex flex-col gap-2">
                <label class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500" for="company_name"><?php esc_html_e('Company name', 'webmakerr'); ?></label>
                <input class="w-full rounded border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm transition focus:border-dark focus:outline-none focus:ring-2 focus:ring-dark/10" type="text" id="company_name" name="company_name" />
              </div>
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500" for="company_email"><?php esc_html_e('Company email', 'webmakerr'); ?> <span class="text-red-500">*</span></label>
              <input class="w-full rounded border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm transition focus:border-dark focus:outline-none focus:ring-2 focus:ring-dark/10" type="email" id="company_email" name="company_email" required />
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500" for="use_case"><?php esc_html_e('Use case', 'webmakerr'); ?></label>
              <select class="w-full rounded border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm transition focus:border-dark focus:outline-none focus:ring-2 focus:ring-dark/10" id="use_case" name="use_case">
                <option value="" disabled selected><?php esc_html_e('Select an option', 'webmakerr'); ?></option>
                <option value="launch"><?php esc_html_e('Launching a new product', 'webmakerr'); ?></option>
                <option value="migration"><?php esc_html_e('Migrating an existing site', 'webmakerr'); ?></option>
                <option value="revamp"><?php esc_html_e('Refreshing our brand', 'webmakerr'); ?></option>
                <option value="other"><?php esc_html_e('Something else', 'webmakerr'); ?></option>
              </select>
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500" for="description"><?php esc_html_e('Project description', 'webmakerr'); ?> <span class="text-red-500">*</span></label>
              <textarea class="min-h-[160px] w-full rounded border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm transition focus:border-dark focus:outline-none focus:ring-2 focus:ring-dark/10" id="description" name="description" required></textarea>
            </div>

            <div class="flex items-start gap-3">
              <input class="mt-1 h-4 w-4 rounded border border-zinc-200 text-dark focus:ring-dark/40" type="checkbox" id="newsletter" name="newsletter" />
              <label class="text-sm leading-6 text-zinc-600" for="newsletter"><?php esc_html_e('Keep me up to date with product updates, tips, and launches.', 'webmakerr'); ?></label>
            </div>

            <div class="pt-2">
              <button class="inline-flex w-full justify-center rounded bg-dark px-4 py-1.5 text-sm font-semibold text-white transition hover:bg-dark/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark" type="submit">
                <?php esc_html_e('Submit form', 'webmakerr'); ?>
              </button>
            </div>
          </form>
        </div>
      </section>
    </div>
  </div>
</main>

<?php
$form_id         = 0;
$popup_headline  = '';
$popup_config    = get_template_directory() . '/templates/config/popup-content.php';
$template_handle = basename(__FILE__);

if (is_readable($popup_config)) {
    $popup_settings = include $popup_config;
    if (is_array($popup_settings) && isset($popup_settings[$template_handle]) && is_array($popup_settings[$template_handle])) {
        $template_settings = $popup_settings[$template_handle];
        $form_id           = isset($template_settings['form_id']) ? absint($template_settings['form_id']) : 0;
        $popup_headline    = isset($template_settings['headline']) ? (string) $template_settings['headline'] : '';
    }
}

if ($form_id > 0) {
    $popup_partial = get_template_directory() . '/partials/fluentform-popup.php';
    if (is_readable($popup_partial)) {
        include $popup_partial;
    }
}

get_footer();

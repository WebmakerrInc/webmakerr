<?php
/**
 * Template Name: Builder
 * Description: Provides an overview of the visual builder with feature highlights and media sections.
 *
 * @package Webmakerr
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();
?>

<main id="primary" class="bg-white py-16 sm:py-20 lg:py-24">
  <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
    <?php while (have_posts()) : the_post(); ?>
      <article <?php post_class('flex flex-col gap-16'); ?>>
        <header class="flex flex-col gap-4 text-left">
          <p class="text-sm font-semibold uppercase tracking-[0.3em] text-primary"><?php esc_html_e('Builder', 'webmakerr'); ?></p>
          <?php the_title('<h1 class="mt-4 text-4xl font-medium tracking-tight [text-wrap:balance] text-zinc-950 sm:text-5xl">', '</h1>'); ?>
          <p class="max-w-3xl text-base leading-7 text-zinc-600 sm:text-lg"><?php echo wp_kses_post(get_post_meta(get_the_ID(), '_webmakerr_builder_intro', true)); ?></p>
        </header>

        <section class="grid gap-8 lg:grid-cols-[minmax(0,_1fr)_minmax(0,_1.2fr)]">
          <div class="flex flex-col gap-6">
            <?php
            $highlights = get_post_meta(get_the_ID(), '_webmakerr_builder_features', true);
            if (! empty($highlights) && is_array($highlights)) :
                foreach ($highlights as $highlight) :
                    $title = isset($highlight['title']) ? sanitize_text_field($highlight['title']) : '';
                    $copy  = isset($highlight['copy']) ? wp_kses_post($highlight['copy']) : '';
                    ?>
                    <div class="rounded border border-zinc-200 bg-white p-6 shadow-sm">
                      <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl"><?php echo esc_html($title); ?></h2>
                      <div class="mt-3 text-sm leading-6 text-zinc-600"><?php echo $copy; ?></div>
                    </div>
                    <?php
                endforeach;
            else :
                ?>
                <div class="rounded border border-dashed border-zinc-300 bg-zinc-50 p-8 text-center text-sm font-medium text-zinc-500">
                  <?php esc_html_e('Add builder highlights in the page editor to display them here.', 'webmakerr'); ?>
                </div>
                <?php
            endif;
            ?>
          </div>

          <div class="flex items-center justify-center rounded border border-zinc-200 bg-zinc-50 p-10">
            <?php
            $media = get_post_meta(get_the_ID(), '_webmakerr_builder_media', true);
            if (! empty($media)) :
                $media_id  = absint($media);
                $media_src = wp_get_attachment_image_src($media_id, 'large');
                if ($media_src) :
                    ?>
                    <img class="h-auto w-full max-w-3xl rounded shadow-lg" src="<?php echo esc_url($media_src[0]); ?>" alt="<?php echo esc_attr(get_post_meta($media_id, '_wp_attachment_image_alt', true)); ?>" />
                    <?php
                endif;
            else :
                ?>
                <div class="h-48 w-full max-w-3xl rounded border border-dashed border-zinc-300 bg-white"></div>
                <?php
            endif;
            ?>
          </div>
        </section>

        <div class="prose max-w-none text-zinc-700 sm:prose-lg">
          <?php the_content(); ?>
        </div>
      </article>
    <?php endwhile; ?>
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

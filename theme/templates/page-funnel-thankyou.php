<?php
/**
 * Template Name: Funnel Thank You Page
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="bg-white py-20 sm:py-24">
  <div class="mx-auto w-full max-w-3xl px-4 text-center sm:px-6 lg:px-8">
    <?php while (have_posts()) : the_post(); ?>
      <article <?php post_class('flex flex-col items-center gap-8 text-center'); ?>>
        <header class="flex flex-col gap-4">
          <h1 class="text-4xl font-medium tracking-tight text-zinc-950 sm:text-5xl">
            <?php the_title(); ?>
          </h1>
          <p class="text-base leading-7 text-zinc-600 sm:text-lg">
            <?php esc_html_e('Your call is booked! We look forward to speaking with you.', 'webmakerr'); ?>
          </p>
        </header>
        <div class="flex justify-center">
          <a class="btn btn-primary inline-flex items-center justify-center rounded-[5px] bg-black px-6 py-3 font-semibold text-white !no-underline" href="<?php echo esc_url(home_url('/case-study')); ?>">
            <?php esc_html_e('View Our Case Study', 'webmakerr'); ?>
          </a>
        </div>
      </article>
    <?php endwhile; ?>
  </div>
</main>

<?php
get_footer();

<?php
/**
 * Single post template file.
 *
 * @package Webmakerr
 */

get_header();
?>

<main id="primary" class="flex flex-col bg-white">
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
      <?php get_template_part('template-parts/content', 'single'); ?>

      <?php if (comments_open() || get_comments_number()) : ?>
        <section class="border-t border-zinc-200">
          <div class="container mx-auto px-6 py-16 sm:py-24 lg:px-8">
            <?php comments_template(); ?>
          </div>
        </section>
      <?php endif; ?>
    <?php endwhile; ?>
  <?php endif; ?>
</main>

<?php
get_footer();

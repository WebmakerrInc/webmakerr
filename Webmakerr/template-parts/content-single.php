<?php
$post_content = get_post_field('post_content', get_the_ID());
$is_customer_profile_page = is_page() && (
    has_shortcode($post_content, 'webmakerr_customer_profile') ||
    has_shortcode($post_content, 'fluent_cart_customer_profile')
);

$content_container_classes = 'container mx-auto flex flex-col gap-16 px-6 py-16 sm:py-24 lg:px-8';
$intro_container_classes = 'container mx-auto px-6 py-20 sm:py-24 lg:px-8';
$intro_inner_classes = 'mx-auto max-w-3xl text-center';

if ($is_customer_profile_page) {
    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('flex flex-col font-sans'); ?>>
      <section class="bg-white">
        <div class="mx-auto w-full max-w-6xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
          <div class="w-full">
            <?php the_content(); ?>
          </div>
        </div>
      </section>
    </article>
    <?php
    return;
}

$entry_typography_classes = 'font-sans text-base leading-8 text-zinc-600 sm:text-lg [&_a]:text-primary [&_a]:underline [&_a:hover]:text-primary/80 [&_blockquote]:border-l-4 [&_blockquote]:border-primary [&_blockquote]:pl-6 [&_blockquote]:text-zinc-950 [&_blockquote]:font-medium [&_h2]:mt-16 [&_h2]:text-3xl [&_h2]:font-semibold [&_h2]:text-zinc-950 [&_h2]:sm:text-4xl [&_h3]:mt-12 [&_h3]:text-xl [&_h3]:font-semibold [&_h3]:text-zinc-950 [&_h4]:mt-10 [&_h4]:text-lg [&_h4]:font-semibold [&_h4]:text-zinc-950 [&_ol]:mt-8 [&_ol]:list-decimal [&_ol]:space-y-3 [&_ol]:pl-6 [&_p]:mt-6 [&_p]:text-base [&_p]:leading-8 [&_p]:text-zinc-600 [&_p]:sm:text-lg [&_strong]:text-zinc-950 [&_ul]:mt-8 [&_ul]:list-disc [&_ul]:space-y-3 [&_ul]:pl-6';
$entry_base_classes = 'entry-content mx-auto w-full max-w-3xl';

$entry_classes = trim($entry_base_classes . ' ' . $entry_typography_classes);
$is_fluent_product = get_post_type() === 'fluent-products';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('flex flex-col font-sans'); ?>>
  <?php if (! $is_fluent_product) : ?>
    <section class="border-b border-zinc-200 bg-white">
      <div class="<?php echo esc_attr($intro_container_classes); ?>">
        <div class="<?php echo esc_attr($intro_inner_classes); ?>">
          <?php if (! is_page()) : ?>
            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>" itemprop="datePublished" class="text-xs font-semibold uppercase tracking-[0.3em] text-primary">
              <?php echo esc_html(get_the_date()); ?>
            </time>
          <?php endif; ?>

          <h1 class="mt-4 text-4xl font-medium tracking-tight [text-wrap:balance] text-zinc-950 sm:text-5xl">
            <?php echo esc_html(get_the_title()); ?>
          </h1>

          <?php
          $post_excerpt = get_the_excerpt();

          if (! empty($post_excerpt)) :
            ?>
            <p class="mx-auto mt-6 max-w-2xl text-base leading-8 text-zinc-600 sm:text-lg">
              <?php echo wp_kses_post($post_excerpt); ?>
            </p>
          <?php endif; ?>

          <?php if (! is_page()) : ?>
            <p class="mt-6 text-sm font-semibold text-zinc-600">
              <?php printf(esc_html__('by %s', 'webmakerr'), esc_html(get_the_author())); ?>
            </p>
          <?php endif; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <section class="bg-white">
    <div class="<?php echo esc_attr($content_container_classes); ?>">
      <?php if (has_post_thumbnail()) : ?>
        <div class="overflow-hidden rounded bg-light">
          <?php the_post_thumbnail('large', array('class' => 'aspect-16/10 w-full object-cover')); ?>
        </div>
      <?php endif; ?>

      <div class="<?php echo esc_attr($entry_classes); ?>">
        <?php the_content(); ?>
      </div>
    </div>
  </section>
</article>

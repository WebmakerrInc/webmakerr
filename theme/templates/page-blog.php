<?php
/**
 * Template Name: Blog Page
 * Description: Dynamic blog landing page powered by WordPress posts.
 */

if (! defined('ABSPATH')) {
    exit;
}

$popup_settings = webmakerr_get_template_popup_settings(__FILE__);
$popup_enabled  = (bool) ($popup_settings['enabled'] ?? false);

get_header();

$page_id = get_queried_object_id();
$contact_cta_url = home_url('/contact');
$contact_cta_link = webmakerr_get_popup_link_attributes($contact_cta_url, $popup_enabled);
$hero_title = get_the_title($page_id);
$hero_intro = '';

if ($page_id) {
    if (has_excerpt($page_id)) {
        $hero_intro = get_the_excerpt($page_id);
    } else {
        $hero_intro = wp_trim_words(
            wp_strip_all_tags(get_post_field('post_content', $page_id)),
            28,
            '…'
        );
    }
}

$paged = max(1, absint(get_query_var('paged')), absint(get_query_var('page')));
$posts_per_page = (int) get_option('posts_per_page');
$posts_per_page = $posts_per_page > 0 ? $posts_per_page : 10;

$featured_post_id = 0;
$featured_post = null;

if (1 === $paged) {
    $featured_query = new WP_Query(
        array(
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'posts_per_page'      => 1,
            'ignore_sticky_posts' => false,
        )
    );

    if ($featured_query->have_posts()) {
        $featured_query->the_post();
        $featured_post_id = get_the_ID();
        $featured_post    = get_post($featured_post_id);
    }

    wp_reset_postdata();
}

$posts_args = array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'paged'               => $paged,
    'ignore_sticky_posts' => false,
);

if (1 === $paged && $featured_post_id) {
    $posts_args['posts_per_page'] = max($posts_per_page - 1, 1);
    $posts_args['post__not_in']   = array($featured_post_id);
} else {
    $posts_args['posts_per_page'] = $posts_per_page;
}

$posts_query = new WP_Query($posts_args);

$categories = get_categories(
    array(
        'orderby'    => 'name',
        'order'      => 'ASC',
        'hide_empty' => true,
    )
);

$tags = get_tags(
    array(
        'number'     => 12,
        'orderby'    => 'count',
        'order'      => 'DESC',
        'hide_empty' => true,
    )
);
?>

<main id="primary" class="bg-white py-16 sm:py-20 lg:py-24">
  <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
    <header class="relative overflow-hidden rounded-[5px] border border-zinc-200 bg-gradient-to-br from-white via-white to-primary/10 px-6 py-14 text-center sm:px-10 sm:py-16 lg:px-16">
      <div class="absolute -left-24 -top-24 h-64 w-64 rounded-full bg-primary/10 blur-3xl"></div>
      <div class="absolute -bottom-32 -right-10 h-72 w-72 rounded-full bg-dark/5 blur-3xl"></div>
      <div class="relative mx-auto flex max-w-3xl flex-col items-center gap-6">
        <span class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.26em] text-primary">
          <?php esc_html_e('Webmakerr Blog', 'webmakerr'); ?>
        </span>
        <h1 class="text-4xl font-medium tracking-tight text-zinc-950 [text-wrap:balance] sm:text-5xl">
          <?php echo esc_html($hero_title); ?>
        </h1>
        <?php if (! empty($hero_intro)) : ?>
          <p class="text-base leading-7 text-zinc-600 sm:text-lg">
            <?php echo wp_kses_post($hero_intro); ?>
          </p>
        <?php endif; ?>
        <div class="mt-6 flex flex-col items-center justify-center gap-3 sm:flex-row sm:flex-wrap sm:gap-3">
          <a class="inline-flex w-full items-center justify-center gap-2 rounded-[5px] bg-dark px-5 py-2 text-sm font-semibold text-white transition hover:bg-dark/90 !no-underline sm:w-auto" href="#latest-posts">
            <?php esc_html_e('Explore the latest', 'webmakerr'); ?>
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M10 3v14m0 0 5-5m-5 5-5-5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </a>
          <a class="inline-flex w-full items-center justify-center gap-2 rounded-[5px] border border-zinc-200 px-5 py-2 text-sm font-semibold text-zinc-900 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline sm:w-auto" href="<?php echo esc_url(get_permalink(get_option('page_for_posts')) ?: home_url('/blog')); ?>">
            <?php esc_html_e('View classic archive', 'webmakerr'); ?>
          </a>
        </div>
        <p class="mt-3 text-center text-xs font-medium text-zinc-500 sm:text-sm">
          <?php esc_html_e('★★★★★ Editors’ Choice — Trusted by 12,000+ readers every week', 'webmakerr'); ?>
        </p>
      </div>
    </header>

    <?php if ($featured_post instanceof WP_Post) : ?>
      <?php
      $featured_permalink = get_permalink($featured_post);
      $featured_title     = get_the_title($featured_post);
      $featured_excerpt   = wp_trim_words(get_the_excerpt($featured_post), 36, '…');
      $featured_date      = get_the_date('', $featured_post);
      $featured_author    = get_the_author_meta('display_name', $featured_post->post_author);
      ?>
      <section class="mt-16 rounded-[5px] border border-zinc-200 bg-white shadow-sm">
        <div class="grid gap-8 overflow-hidden lg:grid-cols-[1.05fr_0.95fr] lg:items-stretch">
          <div class="relative h-full min-h-[280px] overflow-hidden">
            <?php if (has_post_thumbnail($featured_post)) : ?>
              <?php echo wp_kses_post(get_the_post_thumbnail($featured_post, 'large', array('class' => 'h-full w-full object-cover transition duration-500 hover:scale-[1.03]'))); ?>
            <?php else : ?>
              <div class="flex h-full w-full items-center justify-center bg-zinc-100 text-sm font-semibold text-zinc-500">
                <?php esc_html_e('Featured insight', 'webmakerr'); ?>
              </div>
            <?php endif; ?>
            <div class="pointer-events-none absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
          </div>
          <div class="flex flex-col justify-center gap-6 px-8 py-10 sm:px-10">
            <div class="flex flex-wrap items-center gap-3 text-xs font-semibold uppercase tracking-[0.26em] text-primary">
              <span><?php esc_html_e('Featured Story', 'webmakerr'); ?></span>
              <span class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.3em] text-primary/80">
                <?php echo esc_html($featured_date); ?>
              </span>
            </div>
            <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
              <a class="text-current !no-underline transition hover:text-primary" href="<?php echo esc_url($featured_permalink); ?>">
                <?php echo esc_html($featured_title); ?>
              </a>
            </h2>
            <p class="text-base leading-7 text-zinc-600">
              <?php echo esc_html($featured_excerpt); ?>
            </p>
            <div class="flex flex-wrap items-center gap-4 text-sm text-zinc-500">
              <span><?php echo esc_html($featured_author); ?></span>
            </div>
            <div class="flex items-center gap-3">
              <a class="inline-flex items-center gap-2 rounded-[5px] bg-dark px-5 py-2 text-sm font-semibold text-white transition hover:bg-dark/90 !no-underline" href="<?php echo esc_url($featured_permalink); ?>">
                <?php esc_html_e('Read the story', 'webmakerr'); ?>
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path d="M5 10h10m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </a>
              <a class="inline-flex items-center gap-2 rounded-[5px] border border-zinc-200 px-5 py-2 text-sm font-semibold text-zinc-900 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline" href="<?php echo esc_url($featured_permalink); ?>#comments">
                <?php esc_html_e('Join the conversation', 'webmakerr'); ?>
              </a>
            </div>
          </div>
        </div>
      </section>
    <?php endif; ?>

    <section id="latest-posts" class="mt-16 grid gap-10 lg:grid-cols-[minmax(0,1fr)_320px] lg:items-start lg:gap-14">
      <div class="flex flex-col gap-8">
        <header class="flex flex-col gap-2">
          <span class="text-xs font-semibold uppercase tracking-[0.3em] text-primary">
            <?php esc_html_e('Latest Articles', 'webmakerr'); ?>
          </span>
          <h2 class="text-3xl font-semibold text-zinc-950">
            <?php esc_html_e('Fresh ideas to grow your business', 'webmakerr'); ?>
          </h2>
        </header>

        <?php if ($posts_query->have_posts()) : ?>
          <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
            <?php
            while ($posts_query->have_posts()) :
                $posts_query->the_post();
                $post_id    = get_the_ID();
                $permalink  = get_permalink($post_id);
                $title      = get_the_title($post_id);
                $excerpt    = wp_trim_words(get_the_excerpt($post_id), 26, '…');
                $date       = get_the_date('', $post_id);
                $card_thumb = '';

                if (has_post_thumbnail($post_id)) {
                    $card_thumb = get_the_post_thumbnail(
                        $post_id,
                        'medium_large',
                        array(
                            'class' => 'h-full w-full object-cover transition duration-500 group-hover:scale-[1.05]'
                        )
                    );
                }
            ?>
              <article <?php post_class('group flex h-full flex-col overflow-hidden rounded-[5px] border border-zinc-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-primary/40 hover:shadow-lg', $post_id); ?>>
                <div class="relative aspect-[4/3] overflow-hidden bg-zinc-100">
                  <?php if (! empty($card_thumb)) : ?>
                    <?php echo wp_kses_post($card_thumb); ?>
                  <?php else : ?>
                    <div class="flex h-full w-full items-center justify-center text-sm font-semibold text-zinc-400">
                      <?php esc_html_e('New post coming soon', 'webmakerr'); ?>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="flex flex-1 flex-col gap-4 px-6 py-6">
                  <div class="flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.3em] text-primary">
                    <span><?php echo esc_html($date); ?></span>
                  </div>
                  <h3 class="text-xl font-semibold text-zinc-950">
                    <a class="text-current !no-underline transition hover:text-primary" href="<?php echo esc_url($permalink); ?>">
                      <?php echo esc_html($title); ?>
                    </a>
                  </h3>
                  <p class="flex-1 text-sm leading-6 text-zinc-600">
                    <?php echo esc_html($excerpt); ?>
                  </p>
                  <div class="mt-auto flex items-center justify-between pt-2 text-sm font-semibold text-primary">
                    <a class="inline-flex items-center gap-2 text-current !no-underline transition hover:text-primary/80" href="<?php echo esc_url($permalink); ?>">
                      <?php esc_html_e('Read more', 'webmakerr'); ?>
                      <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M5 10h10m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </a>
                    <span class="text-xs font-medium uppercase tracking-[0.3em] text-zinc-400">
                      <?php esc_html_e('WordPress', 'webmakerr'); ?>
                    </span>
                  </div>
                </div>
              </article>
            <?php endwhile; ?>
          </div>

          <?php
          $pagination_links = paginate_links(
              array(
                  'total'   => $posts_query->max_num_pages,
                  'current' => $paged,
                  'mid_size'=> 2,
                  'prev_text' => __('Previous', 'webmakerr'),
                  'next_text' => __('Next', 'webmakerr'),
                  'type'    => 'array',
              )
          );

          if (! empty($pagination_links)) :
              $base_classes    = 'inline-flex items-center justify-center rounded-full border px-3 py-1.5 text-sm font-semibold transition';
              $inactive_classes = $base_classes . ' border-zinc-200 text-zinc-700 hover:border-primary/40 hover:text-primary';
              $active_classes   = $base_classes . ' border-dark bg-dark text-white';
          ?>
            <nav class="mt-10" aria-label="<?php esc_attr_e('Blog pagination', 'webmakerr'); ?>">
              <ul class="flex flex-wrap items-center gap-2">
                <?php foreach ($pagination_links as $link) : ?>
                  <?php
                  if (false !== strpos($link, 'page-numbers')) {
                      if (false !== strpos($link, 'current')) {
                          $link = preg_replace('/class="page-numbers([^"]*)"/', 'class="page-numbers ' . $active_classes . '$1"', $link);
                      } else {
                          $link = preg_replace('/class="page-numbers([^"]*)"/', 'class="page-numbers ' . $inactive_classes . '$1"', $link);
                      }
                  }
                  ?>
                  <li><?php echo wp_kses_post($link); ?></li>
                <?php endforeach; ?>
              </ul>
            </nav>
          <?php endif; ?>
        <?php else : ?>
          <div class="rounded-[5px] border border-dashed border-zinc-200 bg-zinc-50 px-6 py-12 text-center text-sm text-zinc-500">
            <?php esc_html_e('No posts available right now. Check back soon for fresh insights.', 'webmakerr'); ?>
          </div>
        <?php endif; ?>
      </div>

      <aside class="flex flex-col gap-8 rounded-[5px] border border-zinc-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4">
          <h3 class="text-lg font-semibold text-zinc-950">
            <?php esc_html_e('Browse categories', 'webmakerr'); ?>
          </h3>
          <?php if (! empty($categories)) : ?>
            <ul class="flex flex-col gap-2 text-sm">
              <?php foreach ($categories as $category) : ?>
                <li>
                  <a class="flex items-center justify-between gap-4 rounded-[5px] border border-transparent px-4 py-2 font-medium text-zinc-700 transition hover:border-primary/40 hover:bg-primary/5 hover:text-primary !no-underline" href="<?php echo esc_url(get_category_link($category)); ?>">
                    <span><?php echo esc_html($category->name); ?></span>
                    <span class="text-xs font-semibold text-zinc-400"><?php echo esc_html($category->count); ?></span>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php else : ?>
            <p class="text-sm text-zinc-500">
              <?php esc_html_e('Categories will appear here once you publish posts.', 'webmakerr'); ?>
            </p>
          <?php endif; ?>
        </div>

        <div class="flex flex-col gap-4">
          <h3 class="text-lg font-semibold text-zinc-950">
            <?php esc_html_e('Popular tags', 'webmakerr'); ?>
          </h3>
          <?php if (! empty($tags)) : ?>
            <div class="flex flex-wrap gap-2">
              <?php foreach ($tags as $tag) : ?>
                <a class="inline-flex items-center gap-2 rounded-full bg-zinc-100 px-3 py-1 text-xs font-semibold text-zinc-600 transition hover:bg-primary/10 hover:text-primary !no-underline" href="<?php echo esc_url(get_tag_link($tag)); ?>">
                  <span>#<?php echo esc_html($tag->slug); ?></span>
                </a>
              <?php endforeach; ?>
            </div>
          <?php else : ?>
            <p class="text-sm text-zinc-500">
              <?php esc_html_e('Tag your posts to surface quick filters for readers.', 'webmakerr'); ?>
            </p>
          <?php endif; ?>
        </div>

        <div class="rounded-[5px] border border-dashed border-primary/30 bg-primary/5 p-5 text-sm text-zinc-600">
          <h4 class="text-base font-semibold text-zinc-950">
            <?php esc_html_e('Never miss an update', 'webmakerr'); ?>
          </h4>
          <p class="mt-2 text-sm leading-6 text-zinc-600">
            <?php esc_html_e('Subscribe to get the latest product drops, guides, and strategies delivered weekly.', 'webmakerr'); ?>
          </p>
          <a class="mt-4 inline-flex items-center gap-2 rounded-[5px] bg-primary px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-white transition hover:bg-primary/90 !no-underline" href="<?php echo esc_url($contact_cta_link['href']); ?>"<?php echo $contact_cta_link['attributes']; ?>>
            <?php esc_html_e('Join our newsletter', 'webmakerr'); ?>
          </a>
        </div>
      </aside>
    </section>
  </div>
</main>

<?php
wp_reset_postdata();

webmakerr_render_template_popup($popup_settings);

get_footer();

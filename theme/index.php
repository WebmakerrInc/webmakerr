<?php
/**
 * Main template file for displaying posts.
 *
 * @package Webmakerr
 */

get_header();

$is_customer_profile_page = false;

if (is_page()) {
    $queried_object = get_queried_object();

    if (is_a($queried_object, 'WP_Post')) {
        $is_customer_profile_page = has_shortcode($queried_object->post_content, 'webmakerr_customer_profile')
            || has_shortcode($queried_object->post_content, 'fluent_cart_customer_profile');
    }
}

$wrapper_base_classes = 'space-y-24 lg:space-y-32';

if ($is_customer_profile_page) {
    $wrapper_classes = 'mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8 ' . $wrapper_base_classes;
} else {
    $wrapper_classes = 'container mx-auto ' . $wrapper_base_classes;
}
?>

<div class="<?php echo esc_attr($wrapper_classes); ?>">
	<?php if (!is_singular()): ?>
                <?php if (is_archive()): ?>
                        <header class="mb-8">
                                <h1 class="text-3xl font-semibold">
                                        <?php echo esc_html(get_the_archive_title()); ?>
                                </h1>
                        </header>
                <?php elseif (is_category()): ?>
                        <header class="mb-8">
                                <h1 class="text-3xl font-semibold">
                                        <?php echo esc_html(single_cat_title('', false)); ?>
                                </h1>
                        </header>
                <?php elseif (is_tag()): ?>
                        <header class="mb-8">
                                <h1 class="text-3xl font-semibold">
                                        <?php echo esc_html(single_tag_title('', false)); ?>
                                </h1>
                        </header>
                <?php elseif (is_author()): ?>
                        <header class="mb-8">
                                <h1 class="text-3xl font-semibold">
                                        <?php printf(esc_html__('Posts by %s', 'webmakerr'), esc_html(get_the_author())); ?>
                                </h1>
                        </header>
                <?php elseif (is_day()): ?>
                        <header class="mb-8">
                                <h1 class="text-3xl font-semibold">
                                        <?php printf(esc_html__('Daily Archives: %s', 'webmakerr'), esc_html(get_the_date())); ?>
                                </h1>
                        </header>
                <?php elseif (is_month()): ?>
                        <header class="mb-8">
                                <h1 class="text-3xl font-semibold">
                                        <?php printf(esc_html__('Monthly Archives: %s', 'webmakerr'), esc_html(get_the_date('F Y'))); ?>
                                </h1>
                        </header>
                <?php elseif (is_year()): ?>
                        <header class="mb-8">
                                <h1 class="text-3xl font-semibold">
                                        <?php printf(esc_html__('Yearly Archives: %s', 'webmakerr'), esc_html(get_the_date('Y'))); ?>
                                </h1>
                        </header>
                <?php elseif (is_search()): ?>
                        <header class="mb-8">
                                <h1 class="text-3xl font-semibold">
                                        <?php printf(esc_html__('Search results for: %s', 'webmakerr'), esc_html(get_search_query())); ?>
                                </h1>
                        </header>
		<?php elseif (is_404()): ?>
                        <header class="mb-8">
                                <h1 class="text-3xl font-semibold">
                                        <?php esc_html_e('Page Not Found', 'webmakerr'); ?>
                                </h1>
                        </header>
		<?php endif; ?>
	<?php endif; ?>

    <?php if (have_posts()): ?>
        <?php while (have_posts()): the_post(); ?>
            <?php get_template_part('template-parts/content', is_singular() ? 'single' : ''); ?>
        <?php endwhile; ?>

        <?php Webmakerr\Pagination::render(); ?>
    <?php endif; ?>
</div>

<?php
get_footer();

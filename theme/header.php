<?php
/**
 * Theme header template.
 *
 * @package Webmakerr
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php echo esc_attr(get_bloginfo('charset')); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php echo esc_url(get_bloginfo('pingback_url')); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-white text-zinc-900 antialiased'); ?>>
<?php do_action('webmakerr_site_before'); ?>

<div id="page" class="min-h-screen flex flex-col">
    <?php do_action('webmakerr_header'); ?>

    <header class="sticky top-0 z-50 bg-white shadow-md">
        <div
            class="mx-auto w-full max-w-6xl px-6 py-4 lg:px-8 flex items-center justify-between gap-6 relative"
            data-header-container
        >
            <div class="flex items-center gap-4 md:gap-6">
                <?php if (has_custom_logo()): ?>
                    <div class="site-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else: ?>
                    <div class="flex items-center gap-2">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="!no-underline lowercase font-medium text-lg">
                            <?php echo esc_html(get_bloginfo('name')); ?>
                        </a>
                        <?php if ($description = get_bloginfo('description')): ?>
                            <span class="text-sm font-light text-dark/80">|</span>
                            <span class="text-sm font-light text-dark/80"><?php echo esc_html($description); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="flex items-center gap-4 md:flex-1 md:justify-end">
                <div class="flex items-center gap-3 md:hidden">
                    <?php if (has_nav_menu('primary')): ?>
                        <button
                            type="button"
                            aria-label="Toggle navigation"
                            id="primary-menu-toggle"
                            aria-controls="primary-navigation"
                            aria-expanded="false"
                        >
                            <svg xmlns="https://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                    <?php endif; ?>

                    <a
                        class="inline-flex items-center justify-center rounded bg-dark p-[5px] text-sm font-semibold text-white transition hover:bg-dark/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline hover:no-underline md:hidden"
                        href="<?php echo esc_url(home_url('/contact')); ?>"
                        aria-label="<?php esc_attr_e('Contact Us', 'webmakerr'); ?>"
                    >
                        <?php esc_html_e('Contact Us', 'webmakerr'); ?>
                    </a>
                </div>

                <div
                    id="primary-navigation"
                    class="absolute left-0 right-0 top-full mx-4 mt-3 hidden max-h-[calc(100vh-6rem)] flex-col items-stretch gap-6 overflow-y-auto rounded-[5px] border border-light bg-white p-4 opacity-0 shadow-lg transition-all duration-200 ease-out pointer-events-none -translate-y-2 md:static md:mx-0 md:mt-0 md:flex md:w-full md:max-w-none md:flex-row md:items-center md:justify-between md:gap-6 md:overflow-visible md:border-none md:bg-transparent md:p-0 md:opacity-100 md:shadow-none md:translate-y-0 md:pointer-events-auto md:transition-none"
                    aria-hidden="true"
                    data-mobile-nav
                >
                    <nav class="md:flex md:flex-1 md:items-center md:gap-6">
                        <div class="md:mx-4" data-solutions>
                            <button
                                type="button"
                                class="flex items-center gap-2 rounded-[5px] border border-zinc-200 p-[5px] text-sm font-medium text-dark transition-colors hover:border-blue-500/40 hover:text-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-dark focus-visible:ring-offset-2 focus-visible:ring-offset-white"
                                aria-haspopup="true"
                                aria-expanded="false"
                                aria-controls="solutions-menu"
                                data-solutions-toggle
                            >
                                <?php esc_html_e('Solutions', 'webmakerr'); ?>
                                <svg class="h-3.5 w-3.5 transition-transform" data-solutions-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>

                            <div
                                id="solutions-menu"
                                class="hidden mt-4 w-full max-h-[80vh] overflow-y-auto rounded-[5px] border border-zinc-200 bg-white p-[10px] shadow-lg transition md:absolute md:left-1/2 md:top-full md:z-50 md:mt-6 md:w-[min(960px,calc(100vw-3rem))] md:-translate-x-1/2 md:max-h-none md:overflow-visible md:p-[15px] md:shadow-xl [&_a]:!no-underline [&_a]:decoration-transparent [&_a:hover]:!no-underline [&_a:hover]:decoration-transparent [&_a:focus-visible]:!no-underline [&_a:focus-visible]:decoration-transparent"
                                data-solutions-menu
                                aria-hidden="true"
                            >
                                <section class="flex flex-col gap-[15px] md:flex-row md:gap-[20px]">
                                    <div class="flex-1 space-y-[10px]">
                                        <h3 class="text-[0.7rem] font-semibold uppercase tracking-wide text-zinc-500">
                                            <?php esc_html_e('By team size', 'webmakerr'); ?>
                                        </h3>

                                        <div class="space-y-[10px]">
                                            <a href="#" class="flex items-start gap-3 rounded-[5px] border border-zinc-200 bg-white p-[5px] no-underline transition hover:border-zinc-300 hover:bg-zinc-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-dark/30 focus-visible:ring-offset-2 focus-visible:ring-offset-white hover:no-underline">
                                                <span class="flex h-8 w-8 items-center justify-center rounded-[5px] bg-zinc-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A3 3 0 017 17h10a3 3 0 011.879.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </span>
                                                <span>
                                                    <span class="block text-sm font-semibold text-dark"><?php esc_html_e('For Individuals', 'webmakerr'); ?></span>
                                                    <span class="block text-xs text-zinc-500"><?php esc_html_e('Personal scheduling made simple', 'webmakerr'); ?></span>
                                                </span>
                                            </a>

                                            <a href="#" class="flex items-start gap-3 rounded-[5px] border border-blue-500/40 bg-blue-50 p-[5px] no-underline transition hover:border-blue-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/60 focus-visible:ring-offset-2 focus-visible:ring-offset-white hover:no-underline">
                                                <span class="flex h-8 w-8 items-center justify-center rounded-[5px] bg-zinc-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5-2.236M2 20h5v-2a3 3 0 00-5-2.236M9 12a3 3 0 106 0 3 3 0 00-6 0z" />
                                                    </svg>
                                                </span>
                                                <span>
                                                    <span class="block text-sm font-semibold text-dark"><?php esc_html_e('For Teams', 'webmakerr'); ?></span>
                                                    <span class="block text-xs text-zinc-500"><?php esc_html_e('Collaborative scheduling for groups', 'webmakerr'); ?></span>
                                                </span>
                                            </a>

                                            <a href="#" class="flex items-start gap-3 rounded-[5px] border border-zinc-200 bg-white p-[5px] no-underline transition hover:border-zinc-300 hover:bg-zinc-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-dark/30 focus-visible:ring-offset-2 focus-visible:ring-offset-white hover:no-underline">
                                                <span class="flex h-8 w-8 items-center justify-center rounded-[5px] bg-zinc-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.5a12.083 12.083 0 01-6.16-10.922L12 14z" />
                                                    </svg>
                                                </span>
                                                <span>
                                                    <span class="block text-sm font-semibold text-dark"><?php esc_html_e('For Enterprises', 'webmakerr'); ?></span>
                                                    <span class="block text-xs text-zinc-500"><?php esc_html_e('Enterprise-level scheduling solutions', 'webmakerr'); ?></span>
                                                </span>
                                            </a>

                                            <a href="#" class="flex items-start gap-3 rounded-[5px] border border-zinc-200 bg-white p-[5px] no-underline transition hover:border-zinc-300 hover:bg-zinc-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-dark/30 focus-visible:ring-offset-2 focus-visible:ring-offset-white hover:no-underline">
                                                <span class="flex h-8 w-8 items-center justify-center rounded-[5px] bg-zinc-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197 3.197a4 4 0 01-5.656-5.656l3.197-3.197m4.242 0a4 4 0 015.656 5.656l-3.197 3.197" />
                                                    </svg>
                                                </span>
                                                <span>
                                                    <span class="block text-sm font-semibold text-dark"><?php esc_html_e('For Developers', 'webmakerr'); ?></span>
                                                    <span class="block text-xs text-zinc-500"><?php esc_html_e('Powerful features and integrations', 'webmakerr'); ?></span>
                                                </span>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="flex-1">
                                        <h3 class="text-[0.7rem] font-semibold uppercase tracking-wide text-zinc-500">
                                            <?php esc_html_e('By use case', 'webmakerr'); ?>
                                        </h3>

                                        <div class="mt-[10px] grid grid-cols-2 gap-[10px] sm:grid-cols-3">
                                            <?php
                                            $use_cases = [
                                                __('Recruiting', 'webmakerr'),
                                                __('Support', 'webmakerr'),
                                                __('Sales', 'webmakerr'),
                                                __('Healthcare', 'webmakerr'),
                                                __('HR', 'webmakerr'),
                                                __('Telehealth', 'webmakerr'),
                                                __('Education', 'webmakerr'),
                                                __('Marketing', 'webmakerr'),
                                            ];

                                            foreach ($use_cases as $use_case):
                                                ?>
                                                <a href="#" class="rounded-[5px] border border-zinc-200 bg-white p-[5px] text-sm font-medium text-dark no-underline transition hover:border-zinc-300 hover:bg-zinc-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-dark/30 focus-visible:ring-offset-2 focus-visible:ring-offset-white hover:no-underline">
                                                    <?php echo esc_html($use_case); ?>
                                                </a>
                                                <?php
                                            endforeach;
                                            ?>
                                        </div>
                                    </div>

                                    <div class="flex w-full flex-col justify-between overflow-hidden rounded-[5px] bg-gradient-to-br from-black via-neutral-800 to-neutral-900 p-[15px] text-white md:max-w-[220px]">
                                        <span class="self-start rounded-full bg-white/20 px-[10px] py-[5px] text-xs font-semibold tracking-wide text-white/90">
                                            <?php esc_html_e('Try Webmakerr', 'webmakerr'); ?>
                                        </span>
                                        <div class="mt-8">
                                            <h3 class="text-2xl font-semibold">Webmakerr</h3>
                                            <p class="mt-2 text-sm text-white/80">
                                                <?php esc_html_e('Supercharged scheduling with AI-powered calls', 'webmakerr'); ?>
                                            </p>
                                        </div>
                                        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="mt-8 inline-flex items-center justify-center rounded-[5px] bg-white p-[5px] text-xs font-semibold text-dark no-underline transition hover:bg-white/90 focus:outline-none focus-visible:ring-2 focus-visible:ring-dark/20 focus-visible:ring-offset-2 focus-visible:ring-offset-white hover:no-underline">
                                            <?php esc_html_e('Contact Sales', 'webmakerr'); ?>
                                        </a>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <?php if (current_user_can('administrator') && !has_nav_menu('primary')): ?>
                            <a href="<?php echo esc_url(admin_url('nav-menus.php')); ?>" class="text-sm text-zinc-600"><?php esc_html_e('Edit Menus', 'webmakerr'); ?></a>
                        <?php else: ?>
                            <?php
                            wp_nav_menu([
                                'container_id'    => 'primary-menu',
                                'container_class' => '',
                                'menu_class'      => 'md:flex md:items-center md:space-x-8 space-y-3 md:space-y-0 [&_a]:!no-underline [&_a]:border [&_a]:border-transparent [&_a]:rounded-[5px] [&_a]:transition-colors [&_a]:duration-200 [&_a]:ease-out [&_a:hover]:border-blue-500/40',
                                'theme_location'  => 'primary',
                                'li_class'        => '',
                                'fallback_cb'     => false,
                            ]);
                            ?>
                        <?php endif; ?>
                    </nav>

                    <div class="inline-block mt-4 md:mt-0 md:ml-auto"><?php get_search_form(); ?></div>

                    <a
                        class="hidden md:inline-flex md:w-auto justify-center rounded bg-dark p-[5px] text-sm font-semibold text-white transition hover:bg-dark/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dark !no-underline hover:no-underline"
                        href="<?php echo esc_url(home_url('/contact')); ?>"
                        aria-label="<?php esc_attr_e('Contact Us', 'webmakerr'); ?>"
                    >
                        <?php esc_html_e('Contact Us', 'webmakerr'); ?>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div id="content" class="site-content grow">
        <?php do_action('webmakerr_content_start'); ?>
        <main>

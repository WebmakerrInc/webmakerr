<?php
/**
 * Template Name: Home Page
 * Description: Webmakerr-inspired AI skills landing page for Webmakerr.
 *
 * @package Webmakerr
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>

<style>
  .scrollbar-hide::-webkit-scrollbar {
    display: none;
  }

  .scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
  }

  body.page-template-page-home {
    overflow-x: hidden;
  }

  @media (max-width: 768px) {
    .home-review-card {
      width: min(60vw, 320px);
      min-width: min(60vw, 320px);
      max-width: min(60vw, 320px);
      min-height: 220px;
    }

    .home-review-card p {
      display: -webkit-box;
      -webkit-line-clamp: 6;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
  }
</style>

<main id="primary" class="bg-[#f5f7ff]">
  <?php while (have_posts()) : the_post(); ?>
    <article <?php post_class('flex flex-col'); ?>>
      <?php
      $discover_tiles = array(
          array(
              'title' => __('Launch a new career', 'webmakerr'),
              'description' => __('Follow guided learning paths that transition you into AI-focused roles.', 'webmakerr'),
              'icon' => 'launch-career.svg',
              'url' => home_url('/career-launch'),
          ),
          array(
              'title' => __('Gain in-demand skills', 'webmakerr'),
              'description' => __('Master practical workflows curated by industry leaders.', 'webmakerr'),
              'icon' => 'in-demand-skills.svg',
              'url' => home_url('/skill-building'),
          ),
          array(
              'title' => __('Earn a degree', 'webmakerr'),
              'description' => __('Pursue accredited programs with top universities and companies.', 'webmakerr'),
              'icon' => 'earn-degree.svg',
              'url' => home_url('/degrees'),
          ),
      );

      $content_highlights = array(
          array(
              'title' => __('Guided Projects', 'webmakerr'),
              'description' => __('Complete bite-sized, hands-on builds you can finish in under two hours.', 'webmakerr'),
              'tag' => __('Hands-on practice', 'webmakerr'),
              'icon' => 'content-guided-projects.svg',
              'url' => home_url('/guided-projects'),
              'background' => 'from-[#eef2ff] via-[#e0f2ff] to-[#f7f9ff]',
          ),
          array(
              'title' => __('Courses', 'webmakerr'),
              'description' => __('Learn from experts with structured lessons, quizzes, and real-world examples.', 'webmakerr'),
              'tag' => __('Most popular', 'webmakerr'),
              'icon' => 'content-courses.svg',
              'url' => home_url('/courses'),
              'background' => 'from-[#fff4de] via-[#ffeacd] to-[#fff9ee]',
          ),
          array(
              'title' => __('Professional Certificates', 'webmakerr'),
              'description' => __('Earn employer-recognized credentials designed with top companies.', 'webmakerr'),
              'tag' => __('Career credentials', 'webmakerr'),
              'icon' => 'content-certificates.svg',
              'url' => home_url('/certificates'),
              'background' => 'from-[#e5f9f3] via-[#d8f3ec] to-[#f0fffb]',
          ),
          array(
              'title' => __('Degrees', 'webmakerr'),
              'description' => __('Pursue flexible, accredited online degrees from leading universities.', 'webmakerr'),
              'tag' => __('Go further', 'webmakerr'),
              'icon' => 'content-degrees.svg',
              'url' => home_url('/degrees'),
              'background' => 'from-[#f5eeff] via-[#ece4ff] to-[#faf7ff]',
          ),
      );
      ?>

      <section class="relative overflow-hidden">
        <div class="relative isolate overflow-hidden bg-gradient-to-br from-[#1f3a83] via-[#1c2f6d] to-[#062364]">
          <div class="absolute -right-28 top-12 h-[420px] w-[420px] rounded-full bg-[radial-gradient(circle_at_top,#ff6bd6,transparent_60%)] opacity-60 blur-3xl"></div>
          <div class="absolute -left-20 bottom-10 h-72 w-72 rounded-full bg-[radial-gradient(circle_at_top,#4fa5ff,transparent_65%)] opacity-70 blur-3xl"></div>
          <div class="absolute right-8 top-8 hidden h-32 w-32 rotate-12 rounded-[36px] border border-white/20 bg-white/10 backdrop-blur-md lg:block">
            <div class="absolute left-6 top-6 h-3 w-3 rounded-full bg-white/80"></div>
            <div class="absolute right-10 top-10 h-5 w-5 rounded-full bg-primary"></div>
            <div class="absolute bottom-8 right-6 h-8 w-8 rounded-full border border-white/60"></div>
          </div>
          <div class="relative mx-auto flex w-full max-w-7xl flex-col gap-16 px-6 pb-32 pt-24 md:flex-row md:items-center md:justify-between md:px-8">
            <div class="max-w-2xl text-white">
              <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-white/80">
                <span class="h-2 w-2 rounded-full bg-[#7fe6ff]"></span>
                <?php esc_html_e('Future-ready learning', 'webmakerr'); ?>
              </span>
              <h1 class="mt-6 text-4xl font-medium tracking-tight [text-wrap:balance] text-white sm:text-5xl lg:text-[3.5rem] lg:leading-[1.05]">
                <?php esc_html_e('Gain essential AI skills to enhance your career', 'webmakerr'); ?>
              </h1>
              <p class="mt-4 max-w-xl text-base leading-7 text-white/75 sm:text-lg">
                <?php esc_html_e('Build job-ready expertise with courses and credentials created alongside the world’s leading universities and companies.', 'webmakerr'); ?>
              </p>
              <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a class="inline-flex w-full justify-center rounded bg-white px-4 py-2 text-sm font-semibold text-zinc-950 shadow-sm transition hover:bg-white/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/70 sm:w-auto !no-underline" href="<?php echo esc_url(home_url('/programs')); ?>">
                  <?php esc_html_e('Explore programs', 'webmakerr'); ?>
                </a>
                <a class="inline-flex w-full justify-center rounded border border-white/60 bg-transparent px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/70 sm:w-auto !no-underline" href="<?php echo esc_url(home_url('/business')); ?>">
                  <?php esc_html_e('Try Webmakerr for Business', 'webmakerr'); ?>
                </a>
              </div>
            </div>
            <div class="relative mx-auto w-full max-w-md">
              <div class="absolute -right-6 -top-6 h-16 w-16 rounded-full bg-white/30 blur-xl"></div>
              <div class="absolute -bottom-10 left-12 h-20 w-20 rounded-full bg-[#ff6bd6]/40 blur-2xl"></div>
              <div class="relative overflow-hidden rounded-[5px] border border-white/20 bg-white/5 p-10 shadow-[0_24px_60px_rgba(3,19,63,0.35)] backdrop-blur">
                <?php
                $hero_path = get_template_directory() . '/assets/svg/home/hero-illustration.svg';
                if (file_exists($hero_path)) {
                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo file_get_contents($hero_path);
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="relative z-[1] -mt-16 pb-16 sm:pb-20 lg:pb-24">
        <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
          <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <?php foreach ($discover_tiles as $tile) : ?>
            <a class="group flex h-full flex-col gap-5 rounded-[5px] border border-zinc-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg !no-underline" href="<?php echo esc_url($tile['url']); ?>">
              <span class="inline-flex h-12 w-12 items-center justify-center rounded-[5px] bg-primary/10 text-primary">
                <?php
                $icon_path = get_template_directory() . '/assets/svg/home/icons/' . $tile['icon'];
                if (file_exists($icon_path)) {
                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo file_get_contents($icon_path);
                }
                ?>
              </span>
              <div class="flex flex-col gap-2">
                <span class="text-xl font-semibold text-zinc-950">
                  <?php echo esc_html($tile['title']); ?>
                </span>
                <p class="text-sm leading-6 text-zinc-600">
                  <?php echo esc_html($tile['description']); ?>
                </p>
              </div>
              <span class="mt-auto inline-flex items-center gap-2 text-sm font-semibold text-primary transition group-hover:text-primary/80">
                <?php esc_html_e('Start exploring', 'webmakerr'); ?>
                <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M5.5 3.5L10.5 8L5.5 12.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </a>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section class="bg-light py-20">
        <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
          <h2 class="mb-10 text-3xl font-semibold text-zinc-950 sm:text-4xl">Trending courses</h2>

          <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

            <!-- Column 1 -->
            <div class="flex h-full flex-col gap-5 rounded-[5px] border border-zinc-200 bg-white p-6 shadow-sm">
              <div class="flex items-center justify-between">
                <div>
                  <span class="text-xs font-semibold uppercase tracking-[0.26em] text-primary">Most popular</span>
                  <h3 class="mt-2 text-lg font-semibold text-zinc-950">Featured picks</h3>
                </div>
                <a href="#" class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-zinc-200 text-sm font-semibold text-zinc-500 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline">→</a>
              </div>

              <div class="space-y-3">
                <!-- Course -->
                <div class="flex items-center gap-3 rounded-[5px] border border-zinc-100 bg-light p-3 transition hover:border-zinc-200">
                  <img src="https://via.placeholder.com/48x48" alt="Google" class="h-12 w-12 rounded-[5px]">
                  <div>
                    <h4 class="text-sm font-medium text-zinc-900">Google Digital Marketing &amp; E-commerce</h4>
                    <p class="text-xs text-zinc-500">Professional Certificate • ⭐ 4.8</p>
                  </div>
                </div>

                <div class="flex items-center gap-3 rounded-[5px] border border-zinc-100 bg-light p-3 transition hover:border-zinc-200">
                  <img src="https://via.placeholder.com/48x48" alt="Google" class="h-12 w-12 rounded-[5px]">
                  <div>
                    <h4 class="text-sm font-medium text-zinc-900">Google Project Management</h4>
                    <p class="text-xs text-zinc-500">Professional Certificate • ⭐ 4.8</p>
                  </div>
                </div>

                <div class="flex items-center gap-3 rounded-[5px] border border-zinc-100 bg-light p-3 transition hover:border-zinc-200">
                  <img src="https://via.placeholder.com/48x48" alt="Meta" class="h-12 w-12 rounded-[5px]">
                  <div>
                    <h4 class="text-sm font-medium text-zinc-900">Meta Full Stack Developer: Front-End &amp; Back-End</h4>
                    <p class="text-xs text-zinc-500">Specialization • ⭐ 4.7</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Column 2 -->
            <div class="flex h-full flex-col gap-5 rounded-[5px] border border-zinc-200 bg-white p-6 shadow-sm">
              <div class="flex items-center justify-between">
                <div>
                  <span class="text-xs font-semibold uppercase tracking-[0.26em] text-primary">Weekly spotlight</span>
                  <h3 class="mt-2 text-lg font-semibold text-zinc-950">Fresh this week</h3>
                </div>
                <a href="#" class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-zinc-200 text-sm font-semibold text-zinc-500 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline">→</a>
              </div>

              <div class="space-y-3">
                <div class="flex items-center gap-3 rounded-[5px] border border-zinc-100 bg-light p-3 transition hover:border-zinc-200">
                  <img src="https://via.placeholder.com/48x48" alt="DeepLearning.AI" class="h-12 w-12 rounded-[5px]">
                  <div>
                    <h4 class="text-sm font-medium text-zinc-900">PyTorch for Deep Learning</h4>
                    <p class="text-xs text-zinc-500">Professional Certificate • ⭐ 4.8</p>
                  </div>
                </div>

                <div class="flex items-center gap-3 rounded-[5px] border border-zinc-100 bg-light p-3 transition hover:border-zinc-200">
                  <img src="https://via.placeholder.com/48x48" alt="Meta" class="h-12 w-12 rounded-[5px]">
                  <div>
                    <h4 class="text-sm font-medium text-zinc-900">Meta Social Media Marketing</h4>
                    <p class="text-xs text-zinc-500">Professional Certificate • ⭐ 4.8</p>
                  </div>
                </div>

                <div class="flex items-center gap-3 rounded-[5px] border border-zinc-100 bg-light p-3 transition hover:border-zinc-200">
                  <img src="https://via.placeholder.com/48x48" alt="Macquarie" class="h-12 w-12 rounded-[5px]">
                  <div>
                    <h4 class="text-sm font-medium text-zinc-900">Excel Skills for Business</h4>
                    <p class="text-xs text-zinc-500">Specialization • ⭐ 4.9</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Column 3 -->
            <div class="flex h-full flex-col gap-5 rounded-[5px] border border-zinc-200 bg-white p-6 shadow-sm">
              <div class="flex items-center justify-between">
                <div>
                  <span class="text-xs font-semibold uppercase tracking-[0.26em] text-primary">In-demand AI skills</span>
                  <h3 class="mt-2 text-lg font-semibold text-zinc-950">Build AI fluency</h3>
                </div>
                <a href="#" class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-zinc-200 text-sm font-semibold text-zinc-500 transition hover:border-zinc-300 hover:text-zinc-950 !no-underline">→</a>
              </div>

              <div class="space-y-3">
                <div class="flex items-center gap-3 rounded-[5px] border border-zinc-100 bg-light p-3 transition hover:border-zinc-200">
                  <img src="https://via.placeholder.com/48x48" alt="Vanderbilt" class="h-12 w-12 rounded-[5px]">
                  <div>
                    <h4 class="text-sm font-medium text-zinc-900">Prompt Engineering</h4>
                    <p class="text-xs text-zinc-500">Specialization • ⭐ 4.8</p>
                  </div>
                </div>

                <div class="flex items-center gap-3 rounded-[5px] border border-zinc-100 bg-light p-3 transition hover:border-zinc-200">
                  <img src="https://via.placeholder.com/48x48" alt="Google" class="h-12 w-12 rounded-[5px]">
                  <div>
                    <h4 class="text-sm font-medium text-zinc-900">Google AI Essentials</h4>
                    <p class="text-xs text-zinc-500">Specialization • ⭐ 4.8</p>
                  </div>
                </div>

                <div class="flex items-center gap-3 rounded-[5px] border border-zinc-100 bg-light p-3 transition hover:border-zinc-200">
                  <img src="https://via.placeholder.com/48x48" alt="IBM" class="h-12 w-12 rounded-[5px]">
                  <div>
                    <h4 class="text-sm font-medium text-zinc-900">Building AI Agents and Agentic Workflows</h4>
                    <p class="text-xs text-zinc-500">Specialization • ⭐ 4.8</p>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </section>

      <section class="bg-white py-20">
        <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
          <h2 class="mb-6 text-3xl font-semibold text-zinc-950 sm:text-4xl">Explore categories</h2>

          <div class="mb-10 flex gap-3 overflow-x-auto scrollbar-hide snap-x snap-mandatory">
            <span class="flex-none snap-start inline-flex items-center gap-2 rounded-full border border-zinc-200 bg-light px-4 py-2 text-sm font-medium text-zinc-700 transition hover:border-zinc-300 hover:text-zinc-950">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M9 21h6M4 10l1.89 9.45A2 2 0 007.85 21h8.3a2 2 0 001.96-1.55L20 10M12 3v7" />
              </svg>
              Business
            </span>
            <span class="flex-none snap-start inline-flex items-center rounded-full border border-zinc-200 bg-light px-4 py-2 text-sm font-medium text-zinc-700 transition hover:border-zinc-300 hover:text-zinc-950">Artificial Intelligence</span>
            <span class="flex-none snap-start inline-flex items-center rounded-full border border-zinc-200 bg-light px-4 py-2 text-sm font-medium text-zinc-700 transition hover:border-zinc-300 hover:text-zinc-950">Data Science</span>
            <span class="flex-none snap-start inline-flex items-center rounded-full border border-zinc-200 bg-light px-4 py-2 text-sm font-medium text-zinc-700 transition hover:border-zinc-300 hover:text-zinc-950">Computer Science</span>
            <span class="flex-none snap-start inline-flex items-center rounded-full border border-zinc-200 bg-light px-4 py-2 text-sm font-medium text-zinc-700 transition hover:border-zinc-300 hover:text-zinc-950">Information Technology</span>
            <span class="flex-none snap-start inline-flex items-center rounded-full border border-zinc-200 bg-light px-4 py-2 text-sm font-medium text-zinc-700 transition hover:border-zinc-300 hover:text-zinc-950">Personal Development</span>
            <span class="flex-none snap-start inline-flex items-center rounded-full border border-zinc-200 bg-light px-4 py-2 text-sm font-medium text-zinc-700 transition hover:border-zinc-300 hover:text-zinc-950">Healthcare</span>
            <span class="flex-none snap-start inline-flex items-center rounded-full border border-zinc-200 bg-light px-4 py-2 text-sm font-medium text-zinc-700 transition hover:border-zinc-300 hover:text-zinc-950">Language Learning</span>
          </div>

          <div class="flex gap-6 overflow-x-auto scrollbar-hide snap-x snap-mandatory md:grid md:grid-cols-4">
            <div class="flex-none snap-start w-72 rounded-[5px] border border-zinc-200 bg-gradient-to-br from-primary/10 via-white to-light p-8 text-left shadow-sm md:w-auto">
              <h3 class="text-xl font-semibold text-zinc-950">Hot new releases</h3>
              <p class="mt-3 text-sm text-zinc-600">Stay ahead with programs launching this month from top partners.</p>
              <a href="#" class="mt-6 inline-flex items-center gap-2 rounded border border-transparent bg-dark px-4 py-2 text-sm font-semibold text-white transition hover:bg-dark/90 !no-underline">
                Explore courses
                <span class="text-base">→</span>
              </a>
            </div>

            <div class="flex-none snap-start w-72 overflow-hidden rounded-[5px] border border-zinc-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg md:w-auto">
              <img src="https://via.placeholder.com/400x200" alt="Google Course" class="h-40 w-full object-cover">
              <div class="p-4">
                <div class="mb-2 flex items-center gap-2">
                  <img src="https://via.placeholder.com/20x20" alt="Google" class="h-5 w-5 rounded-full">
                  <span class="text-sm font-medium text-zinc-600">Google</span>
                </div>
                <h4 class="text-base font-semibold text-zinc-950">Google People Management Essentials</h4>
                <p class="mt-1 text-sm text-zinc-500">Specialization • ⭐ 4.8</p>
              </div>
            </div>

            <div class="flex-none snap-start w-72 overflow-hidden rounded-[5px] border border-zinc-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg md:w-auto">
              <img src="https://via.placeholder.com/400x200" alt="Google Data Analysis" class="h-40 w-full object-cover">
              <div class="p-4">
                <div class="mb-2 flex items-center gap-2">
                  <img src="https://via.placeholder.com/20x20" alt="Google" class="h-5 w-5 rounded-full">
                  <span class="text-sm font-medium text-zinc-600">Google</span>
                </div>
                <h4 class="text-base font-semibold text-zinc-950">Google Data Analysis with Python</h4>
                <p class="mt-1 text-sm text-zinc-500">Specialization • ⭐ 4.8</p>
              </div>
            </div>

            <div class="flex-none snap-start w-72 overflow-hidden rounded-[5px] border border-zinc-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg md:w-auto">
              <img src="https://via.placeholder.com/400x200" alt="Google Stakeholder Management" class="h-40 w-full object-cover">
              <div class="p-4">
                <div class="mb-2 flex items-center gap-2">
                  <img src="https://via.placeholder.com/20x20" alt="Google" class="h-5 w-5 rounded-full">
                  <span class="text-sm font-medium text-zinc-600">Google</span>
                </div>
                <h4 class="text-base font-semibold text-zinc-950">Google Stakeholder Management</h4>
                <p class="mt-1 text-sm text-zinc-500">Specialization • ⭐ 4.6</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="bg-white py-20">
        <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
          <div class="grid gap-6 md:grid-cols-2">

            <div class="relative flex h-full flex-col justify-between overflow-hidden rounded-[5px] border border-zinc-200 bg-gradient-to-br from-primary/10 via-white to-light p-8 text-left text-zinc-950 shadow-sm">
              <div>
                <p class="text-xs font-semibold uppercase tracking-[0.26em] text-primary">Webmakerr <span class="text-zinc-950">Plus</span></p>
                <h2 class="mt-4 text-2xl font-semibold leading-snug text-zinc-950">
                  Unlock access to 10,000+ courses with a subscription
                </h2>
                <p class="mt-3 text-sm text-zinc-600">Start exploring the entire catalog and learn at your own pace.</p>
                <a href="#" class="mt-6 inline-flex w-fit items-center justify-center gap-2 rounded border border-transparent bg-dark px-4 py-2 text-sm font-semibold text-white transition hover:bg-dark/90 !no-underline">
                  Start 7-day free trial
                  <span aria-hidden="true">→</span>
                </a>
              </div>
              <img src="https://via.placeholder.com/180x180" alt="Promo illustration" class="pointer-events-none absolute -right-6 bottom-0 h-40 w-40 opacity-80">
            </div>

            <div class="relative flex h-full flex-col justify-between overflow-hidden rounded-[5px] border border-zinc-200 bg-light p-8 text-left shadow-sm">
              <div>
                <p class="text-xs font-semibold uppercase tracking-[0.26em] text-primary">Webmakerr for business</p>
                <h2 class="mt-4 text-2xl font-semibold leading-snug text-zinc-950">
                  Drive your business forward and empower your teams
                </h2>
                <p class="mt-3 text-sm text-zinc-600">Upskill your workforce with curated AI and leadership programs.</p>
                <a href="#" class="mt-6 inline-flex w-fit items-center justify-center gap-2 rounded border border-transparent bg-dark px-4 py-2 text-sm font-semibold text-white transition hover:bg-dark/90 !no-underline">
                  Try Webmakerr for Business
                  <span aria-hidden="true">→</span>
                </a>
              </div>
              <img src="https://via.placeholder.com/180x180" alt="Promo illustration" class="pointer-events-none absolute -right-4 bottom-0 h-40 w-40 opacity-90">
            </div>

          </div>
        </div>
      </section>

      <section class="bg-light py-20">
        <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
          <h2 class="mb-10 text-3xl font-semibold text-zinc-950 sm:text-4xl">Why people choose Webmakerr</h2>

          <div class="flex gap-6 overflow-x-auto pb-2 scrollbar-hide snap-x snap-mandatory md:grid md:grid-cols-4">

            <div class="home-review-card flex h-full flex-none snap-start flex-col gap-3 rounded-[5px] border border-zinc-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
              <div class="flex items-center gap-3">
                <img src="https://via.placeholder.com/60x60" alt="Sarah" class="h-12 w-12 rounded-full">
                <h4 class="text-sm font-semibold text-zinc-950">Sarah W.</h4>
              </div>
              <p class="text-sm leading-relaxed text-zinc-600">
                "Webmakerr's reputation for high-quality content, paired with its flexible structure, made it possible for me to dive into data analytics while managing family, health, and everyday life."
              </p>
            </div>

            <div class="home-review-card flex h-full flex-none snap-start flex-col gap-3 rounded-[5px] border border-zinc-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
              <div class="flex items-center gap-3">
                <img src="https://via.placeholder.com/60x60" alt="Noeris" class="h-12 w-12 rounded-full">
                <h4 class="text-sm font-semibold text-zinc-950">Noeris B.</h4>
              </div>
              <p class="text-sm leading-relaxed text-zinc-600">
                "Webmakerr rebuilt my confidence and showed me I could dream bigger. It wasn't just about gaining knowledge—it was about believing in my potential again."
              </p>
            </div>

            <div class="home-review-card flex h-full flex-none snap-start flex-col gap-3 rounded-[5px] border border-zinc-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
              <div class="flex items-center gap-3">
                <img src="https://via.placeholder.com/60x60" alt="Abdullahi" class="h-12 w-12 rounded-full">
                <h4 class="text-sm font-semibold text-zinc-950">Abdullahi M.</h4>
              </div>
              <p class="text-sm leading-relaxed text-zinc-600">
                "I now feel more prepared to take on leadership roles and have already started mentoring some of my colleagues."
              </p>
            </div>

            <div class="home-review-card flex h-full flex-none snap-start flex-col gap-3 rounded-[5px] border border-zinc-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
              <div class="flex items-center gap-3">
                <img src="https://via.placeholder.com/60x60" alt="Anas" class="h-12 w-12 rounded-full">
                <h4 class="text-sm font-semibold text-zinc-950">Anas A.</h4>
              </div>
              <p class="text-sm leading-relaxed text-zinc-600">
                "Learning with Webmakerr has expanded my professional expertise by giving me access to cutting-edge research, practical tools, and global perspectives."
              </p>
            </div>
          </div>
        </div>
      </section>

      <section class="py-16 sm:py-20 lg:py-24">
        <div class="mx-auto flex w-full max-w-6xl flex-col gap-10 px-4 sm:px-6 lg:px-8">
          <div class="flex flex-col items-center gap-3 text-center">
            <h2 class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
              <?php esc_html_e('Explore content', 'webmakerr'); ?>
            </h2>
            <p class="max-w-2xl text-base leading-7 text-zinc-600">
              <?php esc_html_e('Find the learning experience that fits your schedule, goals, and level of support.', 'webmakerr'); ?>
            </p>
          </div>
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
            <?php foreach ($content_highlights as $content) : ?>
              <a class="group flex h-full flex-col gap-6 rounded-[5px] border border-zinc-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg !no-underline" href="<?php echo esc_url($content['url']); ?>">
                <span class="inline-flex w-fit items-center gap-2 rounded-full border border-primary/20 bg-primary/10 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-primary">
                  <?php echo esc_html($content['tag']); ?>
                </span>
                <div class="flex items-center gap-4">
                  <div class="flex h-14 w-14 items-center justify-center rounded-[5px] border border-zinc-100 bg-light">
                    <?php
                    $content_icon = get_template_directory() . '/assets/svg/home/content/' . $content['icon'];
                    if (file_exists($content_icon)) {
                        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        echo file_get_contents($content_icon);
                    }
                    ?>
                  </div>
                  <div class="flex flex-col gap-2 text-left">
                    <h3 class="text-xl font-semibold text-zinc-900">
                      <?php echo esc_html($content['title']); ?>
                    </h3>
                    <p class="text-sm leading-6 text-zinc-600">
                      <?php echo esc_html($content['description']); ?>
                    </p>
                  </div>
                </div>
                <span class="mt-auto inline-flex items-center gap-2 text-sm font-semibold text-primary transition group-hover:text-primary/80">
                  <?php esc_html_e('Browse now', 'webmakerr'); ?>
                  <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.5 3.5L10.5 8L5.5 12.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </span>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section class="relative overflow-hidden py-16 sm:py-20 lg:py-24">
        <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-primary/20 to-transparent"></div>
        <div class="relative mx-auto flex w-full max-w-5xl flex-col items-center gap-8 overflow-hidden rounded-[5px] border border-zinc-200 bg-white px-6 py-14 text-center shadow-lg shadow-primary/10 sm:px-10">
          <div class="absolute -right-14 -top-12 h-32 w-32 rounded-full bg-primary/10 blur-3xl"></div>
          <div class="absolute -left-12 bottom-0 h-36 w-36 rounded-full bg-primary/5 blur-3xl"></div>
          <div class="relative">
            <span class="inline-flex items-center gap-2 rounded-full border border-zinc-200 bg-zinc-50 px-4 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-primary">
              <?php esc_html_e('Get started today', 'webmakerr'); ?>
            </span>
            <h2 class="mt-6 text-3xl font-semibold text-zinc-950 sm:text-4xl">
              <?php esc_html_e('What brings you to Webmakerr today?', 'webmakerr'); ?>
            </h2>
            <p class="mt-4 text-base leading-7 text-zinc-600">
              <?php esc_html_e('Choose the path that matches your goals and we’ll surface the right courses, credentials, and support.', 'webmakerr'); ?>
            </p>
          </div>
          <div class="relative flex flex-col gap-4 sm:flex-row">
            <a class="inline-flex items-center justify-center gap-2 rounded border border-zinc-200 bg-white px-5 py-2 text-sm font-semibold text-zinc-950 shadow-sm transition hover:border-primary hover:text-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/40 !no-underline" href="<?php echo esc_url(home_url('/learn')); ?>">
              <?php esc_html_e('I want to learn new skills', 'webmakerr'); ?>
            </a>
            <a class="inline-flex items-center justify-center gap-2 rounded border border-transparent bg-primary px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 focus-visible:ring-offset-white !no-underline" href="<?php echo esc_url(home_url('/business-solutions')); ?>">
              <?php esc_html_e("I'm exploring for my business", 'webmakerr'); ?>
            </a>
          </div>
        </div>
      </section>

      <?php if (trim(get_the_content())) : ?>
        <section class="py-16 sm:py-20 lg:py-24">
          <div class="prose prose-lg mx-auto w-full max-w-4xl px-4 text-zinc-600 prose-headings:text-zinc-950 sm:px-6 lg:px-8">
            <?php the_content(); ?>
          </div>
        </section>
      <?php endif; ?>
    </article>
  <?php endwhile; ?>
</main>

<?php get_footer(); ?>

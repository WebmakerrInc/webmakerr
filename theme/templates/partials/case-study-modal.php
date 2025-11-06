<?php
if (! defined('ABSPATH')) {
    exit;
}
?>

<div
  class="fixed inset-0 z-[60] hidden items-center justify-center px-4 py-8"
  data-case-study-modal
  aria-hidden="true"
  role="dialog"
  aria-modal="true"
  aria-labelledby="case-study-modal-title"
  aria-describedby="case-study-modal-summary"
>
  <div class="absolute inset-0 bg-zinc-900/80 opacity-0 transition-opacity duration-300 ease-out" data-case-study-modal-backdrop></div>
  <div class="relative z-10 flex h-full w-full items-center justify-center overflow-y-auto">
    <div
      class="relative w-full max-w-3xl scale-95 transform rounded-[5px] border border-zinc-200 bg-white shadow-2xl opacity-0 transition-all duration-300 ease-out"
      data-case-study-modal-dialog
    >
      <button
        type="button"
        class="absolute right-4 top-4 inline-flex h-10 w-10 items-center justify-center rounded-full border border-transparent text-zinc-400 transition hover:border-zinc-200 hover:text-zinc-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black"
        data-case-study-modal-close
        aria-label="<?php esc_attr_e('Close case study', 'webmakerr'); ?>"
      >
        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path d="M6 6l8 8m0-8-8 8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>
      <div class="relative flex flex-col gap-8 px-8 pb-10 pt-12 sm:px-12 sm:pb-12 sm:pt-14">
        <header class="flex flex-col gap-4 text-center sm:text-left">
          <h2 id="case-study-modal-title" class="text-3xl font-semibold text-zinc-950 sm:text-4xl">
            <?php esc_html_e('Launchfuel SaaS Website Rebuild', 'webmakerr'); ?>
          </h2>
          <p id="case-study-modal-summary" class="text-base leading-7 text-zinc-600">
            <?php esc_html_e('How we redesigned a scaling SaaS brand’s digital experience to 3x their qualified pipeline in six weeks.', 'webmakerr'); ?>
          </p>
        </header>

        <div class="grid gap-8 sm:grid-cols-3">
          <div class="flex flex-col gap-3">
            <h3 class="text-sm font-semibold uppercase tracking-[0.26em] text-primary">
              <?php esc_html_e('Challenge', 'webmakerr'); ?>
            </h3>
            <p class="text-sm leading-6 text-zinc-600">
              <?php esc_html_e('Fragmented messaging, dated design, and low conversion paths across their marketing site and demo funnel.', 'webmakerr'); ?>
            </p>
          </div>
          <div class="flex flex-col gap-3">
            <h3 class="text-sm font-semibold uppercase tracking-[0.26em] text-primary">
              <?php esc_html_e('Solution', 'webmakerr'); ?>
            </h3>
            <p class="text-sm leading-6 text-zinc-600">
              <?php esc_html_e('Rebuilt the site architecture, crafted narrative-driven copy, and launched modular pages with CRO testing baked in.', 'webmakerr'); ?>
            </p>
          </div>
          <div class="flex flex-col gap-3">
            <h3 class="text-sm font-semibold uppercase tracking-[0.26em] text-primary">
              <?php esc_html_e('Results', 'webmakerr'); ?>
            </h3>
            <ul class="space-y-2 text-sm leading-6 text-zinc-600">
              <li><strong class="font-semibold text-[#1877F2]">218% </strong><?php esc_html_e('growth in qualified demos', 'webmakerr'); ?></li>
              <li><strong class="font-semibold text-[#1877F2]">3.8x </strong><?php esc_html_e('pipeline ROI in first quarter', 'webmakerr'); ?></li>
              <li><strong class="font-semibold text-[#1877F2]">42% </strong><?php esc_html_e('increase in paid conversions', 'webmakerr'); ?></li>
            </ul>
          </div>
        </div>

        <div class="flex flex-col gap-4">
          <h3 class="text-sm font-semibold uppercase tracking-[0.26em] text-primary">
            <?php esc_html_e('Visual Proof', 'webmakerr'); ?>
          </h3>
          <?php
          get_template_part('templates/partials/case-study-visual-proof', null, [
              'wrapper_classes' => 'grid gap-4 sm:grid-cols-2',
              'figure_classes'  => 'flex h-full flex-col gap-3 rounded-[5px] border border-zinc-200 bg-white p-5 shadow-sm'
          ]);
          ?>
        </div>

        <div class="flex flex-col items-center gap-3 sm:flex-row sm:justify-start">
          <a class="inline-flex w-full items-center justify-center rounded bg-dark px-6 py-3 text-sm font-semibold text-white transition hover:bg-dark/90 !no-underline sm:w-auto" href="<?php echo esc_url(home_url('/contact')); ?>">
            <?php esc_html_e('Get Similar Results →', 'webmakerr'); ?>
          </a>
          <a class="text-xs font-medium uppercase tracking-[0.26em] text-zinc-500 transition hover:text-zinc-900" href="<?php echo esc_url(home_url('/case-study.html')); ?>">
            <?php esc_html_e('Read Full Case Study →', 'webmakerr'); ?>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
(function() {
  if (typeof window === 'undefined') {
    return;
  }

  var modal = document.querySelector('[data-case-study-modal]');
  if (!modal) {
    return;
  }

  if (modal.dataset.caseStudyModalReady === 'true') {
    return;
  }
  modal.dataset.caseStudyModalReady = 'true';

  var openers = document.querySelectorAll('[data-case-study-modal-trigger]');
  var backdrop = modal.querySelector('[data-case-study-modal-backdrop]');
  var dialog = modal.querySelector('[data-case-study-modal-dialog]');
  var closers = modal.querySelectorAll('[data-case-study-modal-close]');
  var activeClass = 'case-study-modal-active';

  if (!backdrop || !dialog) {
    return;
  }

  var previousActiveElement = null;

  var openModal = function(event) {
    if (event) {
      event.preventDefault();
      previousActiveElement = document.activeElement;
    }

    modal.classList.remove('hidden');
    requestAnimationFrame(function() {
      modal.classList.add(activeClass);
      backdrop.classList.remove('opacity-0');
      dialog.classList.remove('opacity-0', 'scale-95');
      dialog.classList.add('scale-100');
      var focusTarget = dialog.querySelector('[data-case-study-modal-close]');
      if (focusTarget && typeof focusTarget.focus === 'function') {
        focusTarget.focus();
      }
    });
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('overflow-hidden');
  };

  var closeModal = function() {
    if (!modal.classList.contains(activeClass)) {
      modal.classList.add('hidden');
      modal.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('overflow-hidden');
      return;
    }

    backdrop.classList.add('opacity-0');
    dialog.classList.add('opacity-0');
    dialog.classList.remove('scale-100');
    dialog.classList.add('scale-95');
    modal.setAttribute('aria-hidden', 'true');

    setTimeout(function() {
      modal.classList.remove(activeClass);
      modal.classList.add('hidden');
      document.body.classList.remove('overflow-hidden');
      if (previousActiveElement && typeof previousActiveElement.focus === 'function') {
        previousActiveElement.focus();
      }
      previousActiveElement = null;
    }, 300);
  };

  openers.forEach(function(opener) {
    opener.addEventListener('click', openModal);
  });

  closers.forEach(function(closer) {
    closer.addEventListener('click', function(event) {
      event.preventDefault();
      closeModal();
    });
  });

  dialog.addEventListener('click', function(event) {
    var closeTarget = event.target.closest('[data-case-study-modal-close]');
    if (closeTarget) {
      event.preventDefault();
      closeModal();
    }
  });

  modal.addEventListener('click', function(event) {
    if (!dialog.contains(event.target)) {
      closeModal();
    }
  });

  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
      closeModal();
    }
  });
})();
</script>

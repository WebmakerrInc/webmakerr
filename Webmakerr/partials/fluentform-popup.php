<?php
if (! defined('ABSPATH')) {
    exit;
}

if (! isset($form_id)) {
    return;
}

$form_id        = absint($form_id);
$popup_headline = isset($popup_headline) ? trim((string) $popup_headline) : '';

if ($form_id <= 0) {
    return;
}

$dialog_label_attribute = $popup_headline !== '' ? ' aria-labelledby="ff-popup-heading"' : '';
?>

<div id="ff-popup" class="fixed inset-0 z-50 hidden flex h-full w-full items-center justify-center bg-black/70 px-4 py-6 sm:py-12" role="dialog" aria-modal="true" aria-hidden="true"<?php echo $dialog_label_attribute; ?>>
  <div class="relative w-full max-w-lg overflow-hidden rounded-[5px] border border-gray-200 bg-white shadow-lg" data-popup-content>
    <button type="button" class="absolute right-4 top-4 inline-flex h-10 w-10 items-center justify-center text-2xl font-light text-gray-500 transition hover:text-gray-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black" data-popup-close aria-label="<?php esc_attr_e('Close popup', 'webmakerr'); ?>">&times;</button>
    <div class="max-h-[85vh] overflow-y-auto p-6 text-center font-sans text-gray-900 sm:p-8">
      <div class="mx-auto flex max-w-md flex-col gap-6">
        <?php if ($popup_headline !== '') : ?>
          <div class="flex flex-col items-center gap-3 text-center">
            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary" aria-hidden="true">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 3v4"></path>
                <path d="M12 17v4"></path>
                <path d="M3 12h4"></path>
                <path d="M17 12h4"></path>
                <path d="m18.36 5.64-2.36 2.36"></path>
                <path d="m8 16-2.36 2.36"></path>
                <path d="m5.64 5.64 2.36 2.36"></path>
                <path d="m16 16 2.36 2.36"></path>
                <circle cx="12" cy="12" r="2"></circle>
              </svg>
            </span>
            <h2 id="ff-popup-heading" class="text-lg font-semibold text-gray-900">
              <?php echo esc_html($popup_headline); ?>
            </h2>
          </div>
        <?php endif; ?>
        <div class="fluentform-wrapper text-left">
          <?php echo do_shortcode('[fluentform id="' . esc_attr($form_id) . '"]'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
(function() {
  if (window.webmakerrFluentFormPopupInitialized) {
    return;
  }
  window.webmakerrFluentFormPopupInitialized = true;

  var addFormEnhancements = function(context) {
    var scope = context || document;
    if (!scope.querySelectorAll) {
      return;
    }

    var fieldSelector = 'input:not([type="checkbox"]):not([type="radio"]):not([type="hidden"]), select, textarea';
    scope.querySelectorAll(fieldSelector).forEach(function(field) {
      field.classList.add('w-full', 'border', 'border-gray-300', 'focus:border-black', 'focus:ring-0', 'text-gray-800', 'rounded-[5px]', 'px-3', 'py-2');
    });

    scope.querySelectorAll('.ff-el-form-check input[type="checkbox"], .ff-el-form-check input[type="radio"]').forEach(function(field) {
      field.classList.add('border-gray-300');
    });

    scope.querySelectorAll('.ff-btn-submit, .ff_submit_btn_wrapper button, button[type="submit"]').forEach(function(button) {
      button.classList.add('btn', 'btn-primary', 'rounded-[5px]');
    });
  };

  var setup = function() {
    var triggers = document.querySelectorAll('[data-popup-trigger]');
    if (!triggers.length) {
      return;
    }

    var popup = document.getElementById('ff-popup');
    if (!popup) {
      return;
    }

    var closeButtons = popup.querySelectorAll('[data-popup-close]');
    var popupContent = popup.querySelector('[data-popup-content]');
    var lastTrigger = null;

    var focusFirstElement = function() {
      var focusable = popup.querySelector('input, select, textarea, button, [href], [tabindex]:not([tabindex="-1"])');
      if (focusable && typeof focusable.focus === 'function') {
        focusable.focus();
      }
    };

    var openPopup = function(event) {
      if (event) {
        event.preventDefault();
        lastTrigger = event.currentTarget;
      }

      popup.classList.remove('hidden');
      popup.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';

      if (popupContent) {
        popupContent.scrollTop = 0;
      }

      window.requestAnimationFrame(focusFirstElement);
    };

    var closePopup = function() {
      if (popup.classList.contains('hidden')) {
        return;
      }

      popup.classList.add('hidden');
      popup.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';

      if (lastTrigger && typeof lastTrigger.focus === 'function') {
        lastTrigger.focus();
      }

      lastTrigger = null;
    };

    triggers.forEach(function(trigger) {
      trigger.addEventListener('click', openPopup);
    });

    closeButtons.forEach(function(button) {
      button.addEventListener('click', closePopup);
    });

    popup.addEventListener('click', function(event) {
      if (event.target === popup) {
        closePopup();
      }
    });

    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape') {
        closePopup();
      }
    });

    addFormEnhancements(popup);

    if ('MutationObserver' in window) {
      var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
          Array.prototype.forEach.call(mutation.addedNodes, function(node) {
            if (node.nodeType === 1) {
              addFormEnhancements(node);
            }
          });
        });
      });

      observer.observe(popup, { childList: true, subtree: true });
    }
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setup);
  } else {
    setup();
  }
})();
</script>

<?php
if (! defined('ABSPATH')) {
    exit;
}

$wrapper_classes = $args['wrapper_classes'] ?? 'grid gap-6 md:grid-cols-2';
$figure_classes  = $args['figure_classes'] ?? 'flex h-full flex-col gap-4 rounded-[5px] border border-zinc-200 bg-white p-6 shadow-sm';
?>
<div class="<?php echo esc_attr($wrapper_classes); ?>">
  <figure class="<?php echo esc_attr($figure_classes); ?>">
    <figcaption class="text-sm font-semibold uppercase tracking-[0.26em] text-zinc-500"><?php esc_html_e('Before', 'webmakerr'); ?></figcaption>
    <div class="flex flex-1 items-center justify-center">
      <svg
        class="h-auto w-full max-w-md text-zinc-400"
        viewBox="0 0 420 260"
        role="img"
        aria-labelledby="case-study-visual-before-title case-study-visual-before-desc"
        xmlns="http://www.w3.org/2000/svg"
      >
        <title id="case-study-visual-before-title"><?php esc_html_e('Legacy analytics showing inconsistent performance', 'webmakerr'); ?></title>
        <desc id="case-study-visual-before-desc"><?php esc_html_e('Muted dashboard illustration with a declining trend line and scattered data bars.', 'webmakerr'); ?></desc>
        <rect x="1.5" y="1.5" width="417" height="257" rx="16" fill="none" stroke="currentColor" stroke-width="3" />
        <rect x="1.5" y="1.5" width="417" height="44" rx="16" fill="none" stroke="currentColor" stroke-width="3" />
        <circle cx="32" cy="24" r="6" class="fill-current" />
        <circle cx="58" cy="24" r="6" class="fill-current" />
        <circle cx="84" cy="24" r="6" class="fill-current" />
        <rect x="120" y="18" width="72" height="12" rx="6" class="fill-current" />
        <line x1="40" y1="90" x2="380" y2="90" stroke="currentColor" stroke-width="2" stroke-dasharray="8 8" />
        <line x1="40" y1="140" x2="380" y2="140" stroke="currentColor" stroke-width="2" stroke-dasharray="8 8" />
        <line x1="40" y1="190" x2="380" y2="190" stroke="currentColor" stroke-width="2" stroke-dasharray="8 8" />
        <rect x="70" y="160" width="36" height="60" rx="6" class="fill-current opacity-60" />
        <rect x="130" y="120" width="36" height="100" rx="6" class="fill-current opacity-70" />
        <rect x="190" y="150" width="36" height="70" rx="6" class="fill-current opacity-60" />
        <rect x="250" y="110" width="36" height="110" rx="6" class="fill-current opacity-50" />
        <rect x="310" y="170" width="36" height="50" rx="6" class="fill-current opacity-70" />
        <path d="M60 200 L130 150 L200 170 L270 130 L340 160" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M330 170 L348 144" stroke="currentColor" stroke-width="4" stroke-linecap="round" />
        <path d="M324 150 L346 146 L342 168" fill="currentColor" opacity="0.7" />
      </svg>
    </div>
  </figure>
  <figure class="<?php echo esc_attr($figure_classes); ?>">
    <figcaption class="text-sm font-semibold uppercase tracking-[0.26em] text-zinc-500"><?php esc_html_e('After', 'webmakerr'); ?></figcaption>
    <div class="flex flex-1 items-center justify-center">
      <svg
        class="h-auto w-full max-w-md text-zinc-900"
        viewBox="0 0 420 260"
        role="img"
        aria-labelledby="case-study-visual-after-title case-study-visual-after-desc"
        xmlns="http://www.w3.org/2000/svg"
      >
        <title id="case-study-visual-after-title"><?php esc_html_e('Modern analytics dashboard showing growth', 'webmakerr'); ?></title>
        <desc id="case-study-visual-after-desc"><?php esc_html_e('Professional dashboard with upward trend line, growth bars, and conversion funnel arrow.', 'webmakerr'); ?></desc>
        <rect x="1.5" y="1.5" width="417" height="257" rx="16" fill="none" stroke="currentColor" stroke-width="3" />
        <rect x="1.5" y="1.5" width="417" height="44" rx="16" fill="none" stroke="currentColor" stroke-width="3" />
        <circle cx="32" cy="24" r="6" class="fill-zinc-200" />
        <circle cx="58" cy="24" r="6" class="fill-zinc-200" />
        <circle cx="84" cy="24" r="6" class="fill-zinc-200" />
        <rect x="120" y="18" width="96" height="12" rx="6" class="fill-zinc-200" />
        <rect x="234" y="18" width="72" height="12" rx="6" class="fill-zinc-200" />
        <line x1="40" y1="90" x2="380" y2="90" stroke="#E4E4E7" stroke-width="2" />
        <line x1="40" y1="140" x2="380" y2="140" stroke="#E4E4E7" stroke-width="2" />
        <line x1="40" y1="190" x2="380" y2="190" stroke="#E4E4E7" stroke-width="2" />
        <rect x="70" y="130" width="36" height="90" rx="6" class="fill-[#1877F2]" />
        <rect x="130" y="110" width="36" height="110" rx="6" class="fill-[#2563EB]" />
        <rect x="190" y="90" width="36" height="130" rx="6" class="fill-[#1D4ED8]" />
        <rect x="250" y="70" width="36" height="150" rx="6" class="fill-[#1E3A8A]" />
        <rect x="310" y="60" width="36" height="160" rx="6" class="fill-[#111827]" opacity="0.9" />
        <path d="M60 200 L130 160 L200 150 L270 110 L340 70" fill="none" stroke="#1877F2" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M340 70 L325 60" stroke="#1877F2" stroke-width="6" stroke-linecap="round" />
        <polygon points="340,52 360,72 332,76" fill="#1877F2" />
        <rect x="260" y="32" width="120" height="36" rx="10" class="fill-[#111827]" opacity="0.95" />
        <text x="320" y="55" text-anchor="middle" font-family="'Roboto', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif" font-size="16" fill="#FFFFFF" font-weight="600">
          <?php esc_html_e('3.8x ROI', 'webmakerr'); ?>
        </text>
        <g transform="translate(70 210)">
          <rect x="0" y="0" width="280" height="28" rx="14" class="fill-[#2563EB]" opacity="0.15" />
          <rect x="0" y="0" width="210" height="28" rx="14" class="fill-[#2563EB]" opacity="0.35" />
          <rect x="0" y="0" width="150" height="28" rx="14" class="fill-[#2563EB]" opacity="0.7" />
          <text x="140" y="19" text-anchor="middle" font-family="'Roboto', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif" font-size="13" fill="#1E3A8A" font-weight="600">
            <?php esc_html_e('Conversion Lift', 'webmakerr'); ?>
          </text>
        </g>
      </svg>
    </div>
  </figure>
</div>

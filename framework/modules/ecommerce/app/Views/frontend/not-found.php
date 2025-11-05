<div class="fc-not-found-container" role="main" aria-labelledby="fc-not-found-title">
    <div class="fc-not-found-content">
        <?php if (!empty($notFoundImg)): ?>
            <img class="fc-not-found-image"
                 src="<?php echo esc_url($notFoundImg ?? ''); ?>"
                 alt="<?php esc_attr_e('Page not found illustration', 'fluent-cart'); ?>"
            >
        <?php endif; ?>

        <?php if (isset($title)): ?>
            <h1 id="fc-not-found-title" class="fc-not-found-title">
                <?php echo wp_kses_post($title); ?>
            </h1>
        <?php endif; ?>

        <?php if (isset($text)): ?>
            <p class="fc-not-found-text">
                <?php echo wp_kses_post($text); ?>
            </p>
        <?php endif; ?>

        <?php if (isset($buttonText)): ?>
            <a 
                href="<?php echo empty($buttonUrl) ? home_url() : esc_url($buttonUrl); ?>" class="fc-not-found-button" 
                role="button"
                aria-label="<?php printf(esc_attr__('Return to %s', 'fluent-cart'), esc_html($buttonText)); ?>"
            >
                <?php echo esc_html($buttonText); ?>
            </a>
        <?php endif; ?>
    </div>
</div>

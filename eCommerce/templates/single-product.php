<?php
/**
 * FluentCart Single Product Template
 */

if (!defined('ABSPATH')) {
    exit;
}

use FluentCart\Api\Resource\ShopResource;
use FluentCart\Api\StoreSettings;
use FluentCart\App\Helpers\Helper;
use FluentCart\App\Modules\Data\ProductDataSetup;
use FluentCart\App\Services\Renderer\ProductListRenderer;
use FluentCart\App\Services\Renderer\ProductRenderer;
use FluentCart\Framework\Support\Arr;

global $post;

$product = $GLOBALS['fct_product'] ?? null;

if (!$product && $post instanceof WP_Post) {
    $product = ProductDataSetup::getProductModel($post->ID);
}

if (!$product || !$product->detail) {
    the_content();
    return;
}

$storeSettings = new StoreSettings();

$renderer = new ProductRenderer($product, [
    'view_type'   => $storeSettings->get('variation_view', 'both'),
    'column_type' => $storeSettings->get('variation_columns', 'masonry'),
]);

$description = '';
if ($post instanceof WP_Post) {
    $description = apply_filters('the_content', $post->post_content);
}

$variants = [];
if ($product->variants && !$product->variants->isEmpty()) {
    $variants = $product->variants->sortBy('serial_index')->values();
}

?>
<div class="fc-single-product-page fc-single-product-page--fiverr" data-fluent-cart-single-product-page>
    <div class="fc-product-hero fc-container">
        <div class="fc-product-hero__grid">
            <div class="fc-product-hero__gallery" data-fluent-cart-product-gallery-area>
                <?php $renderer->renderGallery(); ?>
            </div>

            <aside class="fc-product-hero__summary" data-fluent-cart-product-summary>
                <div class="fc-product-summary-card" id="fc-product-summary" data-fluent-cart-sticky-summary>
                    <?php
                    $renderer->renderTitle();
                    $renderer->renderStockAvailability();
                    $renderer->renderExcerpt();
                    $renderer->renderPrices();
                    $renderer->renderBuySection();
                    ?>
                </div>
            </aside>
        </div>
    </div>

    <div class="fc-product-sections fc-container">
        <section class="fc-product-section fc-product-section--about" id="fc-product-about">
            <header class="fc-product-section__header">
                <h2 class="fc-product-section__title"><?php esc_html_e('About this product', 'fluent-cart'); ?></h2>
            </header>
            <div class="fc-product-section__body fc-product-description">
                <?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
        </section>

        <?php if (!empty($variants)) : ?>
            <section class="fc-product-section fc-product-section--packages" id="fc-product-packages">
                <header class="fc-product-section__header">
                    <h2 class="fc-product-section__title"><?php esc_html_e("What's included", 'fluent-cart'); ?></h2>
                    <p class="fc-product-section__subtitle"><?php esc_html_e('Compare packages to choose the best fit for you.', 'fluent-cart'); ?></p>
                </header>
                <div class="fc-product-section__body">
                    <div class="fc-package-grid" role="list">
                        <?php foreach ($variants as $variant) :
                            $features = [];
                            $featureKeys = ['features', 'deliverables', 'what_you_get', 'items'];
                            foreach ($featureKeys as $featureKey) {
                                $data = Arr::get($variant->other_info, $featureKey, []);
                                if (is_string($data)) {
                                    $data = array_filter(array_map('trim', preg_split('/[\r\n]+|,/', $data)));
                                }
                                if (is_array($data)) {
                                    $features = array_merge($features, $data);
                                }
                            }
                            $features = array_filter(array_unique(array_map('trim', $features)));
                            $packageDescription = Arr::get($variant->other_info, 'description', '');
                            ?>
                            <article class="fc-package-card" role="listitem">
                                <div class="fc-package-card__header">
                                    <h3 class="fc-package-card__title"><?php echo esc_html($variant->variation_title); ?></h3>
                                    <div class="fc-package-card__price" aria-label="<?php esc_attr_e('Package price', 'fluent-cart'); ?>">
                                        <?php echo esc_html(Helper::toDecimal($variant->item_price)); ?>
                                    </div>
                                    <?php if ($variant->compare_price && $variant->compare_price > $variant->item_price) : ?>
                                        <div class="fc-package-card__compare">
                                            <del><?php echo esc_html(Helper::toDecimal($variant->compare_price)); ?></del>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($packageDescription)) : ?>
                                    <p class="fc-package-card__description"><?php echo wp_kses_post($packageDescription); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($features)) : ?>
                                    <ul class="fc-package-card__features">
                                        <?php foreach ($features as $feature) : ?>
                                            <li><?php echo esc_html($feature); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                                <div class="fc-package-card__footer">
                                    <a class="button fc-button-link" href="#fc-product-summary" data-fluent-cart-scroll-to-summary data-variation-id="<?php echo esc_attr($variant->id); ?>">
                                        <?php esc_html_e('View package details', 'fluent-cart'); ?>
                                    </a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <section class="fc-product-section fc-product-section--reviews" id="fc-product-reviews">
            <header class="fc-product-section__header">
                <h2 class="fc-product-section__title"><?php esc_html_e('Reviews', 'fluent-cart'); ?></h2>
            </header>
            <div class="fc-product-section__body fc-product-reviews">
                <?php comments_template(); ?>
            </div>
        </section>

        <?php
        $relatedProducts = ShopResource::getSimilarProducts($product->ID, false);
        $relatedList = $relatedProducts ? Arr::get($relatedProducts, 'products') : null;
        if ($relatedList && $relatedList->count()) :
            ob_start();
            (new ProductListRenderer($relatedList, __('Related Products', 'fluent-cart'), 'fc-similar-product-list-container fc-product-section--related'))->render();
            $relatedMarkup = ob_get_clean();
            ?>
            <section class="fc-product-section fc-product-section--related" id="fc-product-related">
                <?php echo $relatedMarkup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </section>
        <?php endif; ?>
    </div>
</div>

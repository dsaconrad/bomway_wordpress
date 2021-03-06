<?php remove_action('woocommerce_before_shop_loop_item_title','maxstoreplus_shop_loop_item_contdown',20);?>
<?php
global $product;

if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
    return;
}
$class_rate = '';
if ( !$rating_html = wc_get_rating_html( $product->get_average_rating() ) ) {
    $class_rate = ' no-rating';
}
?>
<div class="product-inner<?php echo esc_attr($class_rate)?>">
    <?php
    /**
     * woocommerce_before_shop_loop_item hook.
     *
     * @hooked woocommerce_template_loop_product_link_open - 10
     */
    do_action( 'woocommerce_before_shop_loop_item' );
    ?>
    <div class="product-thumb">
        <?php
        /**
         * woocommerce_before_shop_loop_item_title hook.
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
        do_action( 'woocommerce_before_shop_loop_item_title' );
        ?>
        <div class="product-button">
            <div class="inner">
                <?php
                do_action('maxstoreplus_function_shop_loop_item_wishlist');
                do_action('maxstoreplus_function_shop_loop_item_quickview');
                do_action('maxstoreplus_function_shop_loop_item_compare');
                ?>
            </div>
        </div>

    </div>
    <div class="info-product">
        <?php
        /**
         * woocommerce_shop_loop_item_title hook.
         *
         * @hooked woocommerce_template_loop_product_title - 10
         */
        do_action( 'woocommerce_shop_loop_item_title' );
        /**
         * woocommerce_after_shop_loop_item_title hook.
         *
         * @hooked woocommerce_template_loop_rating - 5
         * @hooked woocommerce_template_loop_price - 10
         */
        do_action( 'woocommerce_after_shop_loop_item_title' );
        /**
         * woocommerce_after_shop_loop_item hook.
         *
         * @hooked woocommerce_template_loop_product_link_close - 5
         * @hooked woocommerce_template_loop_add_to_cart - 10
         */
        do_action( 'woocommerce_after_shop_loop_item' );
        ?>
    </div>
</div>
<?php add_action('woocommerce_before_shop_loop_item_title','maxstoreplus_shop_loop_item_contdown',20); ?>

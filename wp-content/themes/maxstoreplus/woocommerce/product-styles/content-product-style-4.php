<?php remove_action('woocommerce_before_shop_loop_item_title','maxstoreplus_shop_loop_item_contdown',20);?>
<?php
global $product;

if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )
    return;
?>
<div class="product-inner">
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
    </div>
    <div class="info-product">
        <?php
        /**
         * woocommerce_shop_loop_item_title hook.
         *
         * @hooked woocommerce_template_loop_product_title - 10
         */
        do_action( 'woocommerce_shop_loop_item_title' );
        ?>
		<?php $price_html = $product->get_price_html() ?>
        <?php if ( $price_html ) : ?>
            <span class="price pj-price">
                <?php
                    if ( ( !$product->is_on_sale() ) && ( !$product->is_type( 'grouped' ) )  ) {
                        echo esc_html__('Price:','maxstoreplus');
                    }
                ?>
                <?php echo $price_html; ?>
            </span>
        <?php endif; ?>
    </div>
</div>
<?php add_action('woocommerce_before_shop_loop_item_title','maxstoreplus_shop_loop_item_contdown',20); ?>

<?php get_header();?>
<?php

/*Shop layout*/
$woo_shop_layout = maxstoreplus_get_option('woo_shop_layout','left');

if( is_product() ){
    $woo_shop_layout = maxstoreplus_get_option('woo_single_product_layout','left');
}

/*Main container class*/
$main_container_class = array();
$main_container_class[] = 'main-contentshop shop-page';
if( $woo_shop_layout == 'full'){
    $main_container_class[] = 'no-sidebar';
}else{
    $main_container_class[] = $woo_shop_layout.'-sidebar';

}

/*Setting single product*/

$main_content_class = array();
$main_content_class[] = 'main-content';
if( $woo_shop_layout == 'full' ){
    $main_content_class[] ='col-sm-12';
}else{
    $main_content_class[] = 'col-md-9 col-sm-8 has-sidebar';
}

$slidebar_class = array();
$slidebar_class[] = 'sidebar';
if( $woo_shop_layout != 'full'){
    $slidebar_class[] = 'col-md-3 col-sm-4';
}

?>
    <?php
    /**
     * trueshop_before_main_content hook
     *
     * @hooked maxstoreplus_shop_banners - 1
     */
    do_action( 'maxstoreplus_before_main_content' );
    ?>
    <div class="<?php echo esc_attr( implode(' ', $main_container_class) );?>">
        <div class="container">
            <?php
            /**
             * woocommerce_before_main_content hook
             *
             * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
             * @hooked woocommerce_breadcrumb - 20
             */
            do_action( 'woocommerce_before_main_content' );
            ?>
            <div class="row">
                <div class="<?php echo esc_attr( implode(' ', $main_content_class) );?>">
                    <div class="overlay-shop"></div>
                    <?php woocommerce_content(); ?>
                    
                </div>
                <?php if( $woo_shop_layout != "full" ):?>
                    <div class="<?php echo esc_attr( implode(' ', $slidebar_class) );?>">
                        <?php get_sidebar('shop');?>
                    </div>
                <?php endif;?>
            </div>
            <?php
            /**
             * woocommerce_before_main_content hook
             *
             * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
             * @hooked woocommerce_breadcrumb - 20
             */
            do_action( 'woocommerce_after_main_content' );
            ?>
        </div>
    </div>
    <?php
    do_action( 'maxstoreplus_after_main_content' );
    ?>
<?php get_footer();?>
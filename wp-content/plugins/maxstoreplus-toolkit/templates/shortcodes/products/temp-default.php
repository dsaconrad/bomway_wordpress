<?php
if( $atts ){
    extract ( $atts );
}

$category_slug = array();
if( $taxonomy ){
    $category_slug = explode(',', $taxonomy);
}
$categorys = get_terms( array(
    'taxonomy' => 'product_cat',
    'hide_empty' => false,
    'slug'=> $category_slug
) );

$atts_data  = json_encode($atts);

$check_bootstrap = 0;

if ( $boostrap_lg_items == 12 ) {
    $check_bootstrap = 1;
}   elseif ( $boostrap_lg_items == 6 ) {
    $check_bootstrap = 2;
}   elseif ( $boostrap_lg_items == 4 ) {
    $check_bootstrap = 3;
}   elseif ( $boostrap_lg_items == 3 ) {
    $check_bootstrap = 4;
}   elseif ( $boostrap_lg_items == 15 ) {
    $check_bootstrap = 5;
}   elseif ( $boostrap_lg_items == 2 ) {
    $check_bootstrap = 6;
}
$data_style = str_replace('content-product-style-','',$style_product);
?>
<div id="content-<?php echo esc_attr($id)?>" class="<?php echo esc_attr( $list_class ) ?> <?php echo esc_attr( $css_class );?>" <?php if ($productsliststyle == 'owl') { echo $owl_carousel; } ?>>
    <?php while ( $products->have_posts() ) : $products->the_post();  ?>
        <div data-cat="<?php echo esc_attr($taxonomy)?>" data-id="post-<?php echo get_the_ID() ?>" <?php post_class( $grid_bootstrap ) ?> data-style="<?php echo esc_attr($data_style)?>" data-number="<?php echo $check_bootstrap ?>" data-width="<?php echo esc_attr($thumb_width)?>" data-height="<?php echo esc_attr($thumb_height)?>">
            <?php wc_get_template_part('product-styles/'.$style_product.''); ?>
        </div>
    <?php endwhile;?>
</div>
<?php if ( $productsliststyle == 'grid' ) : ?>
    <?php if ( $loadmore == 'loadmore' ) : ?>
        <div class="ms-loadmore">
            <a id="private-<?php echo esc_attr($id)?>" class="button ms-button-loadmore" href="#">
                <?php echo esc_html__('load more items','maxstoreplus'); ?>
                <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
            </a>
        </div>
    <?php elseif ( $loadmore == 'viewall' ) : ?>
        <?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
            <div class="ms-loadmore">
                <p class="return-to-shop">
                    <a class="button wc-backward" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
                        <?php _e( 'View All', 'maxstoreplus' ) ?>
                    </a>
                </p>
            </div>
        <?php endif; ?>
    <?php elseif ( $loadmore == 'none' ) : ?>
    <?php endif; ?>
<?php endif; ?>
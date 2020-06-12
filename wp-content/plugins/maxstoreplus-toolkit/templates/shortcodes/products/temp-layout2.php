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
?>
<div class="<?php echo esc_attr( $list_class ) ?> <?php echo esc_attr( $css_class );?>" <?php if ($productsliststyle == 'owl') { echo $owl_carousel; } ?>>
    <?php while ( $products->have_posts() ) : $products->the_post();  ?>
        <div <?php post_class( $grid_bootstrap ) ?>>
            <?php wc_get_template_part('product-styles/'.$style_product.''); ?>
        </div>
    <?php endwhile;?>
</div>

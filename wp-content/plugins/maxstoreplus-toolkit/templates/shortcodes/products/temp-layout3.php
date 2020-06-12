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

$args = array(
    'a' => array(
        'href' => array(),
        'title' => array()
    ),
    'br' => array(),
    'em' => array(),
    'strong' => array(),
);
$main_title    = wp_kses($main_title, $args);

$atts_data  = json_encode($atts);
?>
<div class="ms-content-deal <?php echo esc_attr( $css_class );?>">
    <div class="content-count">
        <?php if ( $title ) : ?>
            <h3 class="title main-title"><?php echo $title?></h3>
        <?php endif; ?>
        <div class="ms-cowntdown-deal">
            <?php
            $date = strtotime($time);

            if ($date != 0) {

                $deal_date = date_i18n( 'Y/m/d g:i:s', $date );

            } else {

                $deal_date = date_i18n( 'Y/m/d g:i:s', '0' );

            }
            ?>
            <?php if ($date != '') : ?>
                <div data-time="<?php echo esc_attr( $deal_date ); ?>" class="cp-countdown">
                    <span class="day"></span>
                    <span class="hour"></span>
                    <span class="minute"></span>
                    <span class="second"></span>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="block-content">
        <div class="<?php echo esc_attr( $list_class ) ?>" <?php if ($productsliststyle == 'owl') { echo $owl_carousel; } ?>>
            <?php while ( $products->have_posts() ) : $products->the_post();  ?>
                <div data-cat="<?php echo esc_attr($taxonomy)?>" data-id="post-<?php echo get_the_ID() ?>" <?php post_class( $grid_bootstrap ) ?>>
                    <?php wc_get_template_part('product-styles/'.$style_product.''); ?>
                </div>
            <?php endwhile;?>
        </div>
    </div>
</div>

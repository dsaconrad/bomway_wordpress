<?php
if ( $atts ) {
	extract( $atts );
}

$category_slug = array();
if ( $taxonomy ) {
	$category_slug = explode( ',', $taxonomy );
}
$categorys = get_terms( array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => false,
		'slug'       => $category_slug,
	)
);

$args       = array(
	'a'      => array(
		'href'  => array(),
		'title' => array(),
	),
	'br'     => array(),
	'em'     => array(),
	'strong' => array(),
);
$main_title = wp_kses( $main_title, $args );

$atts_data = json_encode( $atts );
?>
<div class="ms-content-deal <?php echo esc_attr( $css_class ); ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="block-content deal-left">
					<?php if ( $title ) : ?>
                        <h2 class="super-title left"><?php echo esc_html( $title ) ?></h2>
					<?php endif; ?>
					<?php if ( $main_title ) : ?>
                        <h1 class="title main-title"><?php echo $main_title ?></h1>
					<?php endif; ?>
                    <div class="ms-cowntdown-deal">
						<?php if ( $time ) : ?>
                            <div data-time="<?php echo esc_attr( $time ); ?>" class="cp-countdown">
                                <span class="day"></span>
                                <span class="hour"></span>
                                <span class="minute"></span>
                                <span class="second"></span>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="block-content deal-right">
                <div class="<?php echo esc_attr( $list_class ) ?>" <?php if ( $productsliststyle == 'owl' ) {
					echo $owl_carousel;
				} ?>>
					<?php while ( $products->have_posts() ) : $products->the_post(); ?>
                        <div data-cat="<?php echo esc_attr( $taxonomy ) ?>"
                             data-id="post-<?php echo get_the_ID() ?>" <?php post_class( $grid_bootstrap ) ?>>
							<?php wc_get_template_part( 'product-styles/' . $style_product . '' ); ?>
                        </div>
					<?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</div>

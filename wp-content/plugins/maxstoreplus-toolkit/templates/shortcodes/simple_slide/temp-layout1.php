<?php
if ( $atts ) {
	extract( $atts );
}
$items = vc_param_group_parse_atts( $item_owl );

?>
<div class="simple-slide owl-carousel <?php echo esc_attr( $css_class ); ?>" <?php echo $owl_carousel ?>>
	<?php foreach ( $items as $item ): ?>
		<?php
		if ( !empty( $item[ 'link' ] ) ) {
			$link = vc_build_link( $item[ 'link' ] );
		} else {
			$link = array( 'url' => '#', 'title' => '', 'target' => '_self', 'rel' => '' );
		}
		$kt_lazy_image = maxstoreplus_get_option( 'kt_enable_lazy', '' ) == 0 ? false : true;
		$image_thumb   = maxstoreplus_resize_image( $item[ 'bg_img' ], null, 612, 450, true, $kt_lazy_image );
		?>
        <div class="item-slide">
            <a href="<?php echo esc_url( $link[ 'url' ] ) ?>" target="<?php echo esc_attr( $link[ 'target' ] ) ?>">
                <figure>
					<?php echo htmlspecialchars_decode( $image_thumb[ 'img' ] ); ?>
                </figure>
                <div class="content-item <?php echo esc_attr( $item[ 'style_stick' ] ) ?>">
					<?php if ( !empty( $item[ 'stick' ] ) ) : ?>
                        <h3 class="stick">
							<?php echo esc_html( $item[ 'stick' ] ) ?>
                        </h3>
					<?php endif; ?>
					<?php if ( !empty( $item[ 'title' ] ) ) : ?>
                        <h1 class="title">
							<?php echo esc_html( $item[ 'title' ] ) ?>
                        </h1>
					<?php endif; ?>
					<?php if ( !empty( $item[ 'des' ] ) ) : ?>
                        <h3 class="des">
							<?php echo esc_html( $item[ 'des' ] ) ?>
                        </h3>
					<?php endif; ?>
                </div>
            </a>
        </div>
	<?php endforeach; ?>
</div>

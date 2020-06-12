<?php
if ( $atts ) {
	extract( $atts );
}
$items      = vc_param_group_parse_atts( $items );
$check_view = '';
if ( $views == 'owl' ) {
	$check_view = 'owl-carousel';
}
?>
<div class="simple-slide <?php echo esc_attr( $css_class ); ?> <?php echo esc_attr( $list_text_align ) ?> <?php echo esc_attr( $check_view ) ?>"<?php if ( $views == 'owl' ) : ?><?php echo $owl_carousel ?><?php endif; ?>>
	<?php foreach ( $items as $item ): ?>
		<?php
		if ( !empty( $item[ 'link' ] ) ) {
			$link = vc_build_link( $item[ 'link' ] );
		} else {
			$link = array( 'url' => '#', 'title' => '', 'target' => '_self', 'rel' => '' );
		}
		$image         = wp_get_attachment_image_src( $item[ 'bg_img' ], 'full' );
		$kt_lazy_image = maxstoreplus_get_option( 'kt_enable_lazy', '' ) == 0 ? false : true;
		$image_thumb   = maxstoreplus_resize_image( $item[ 'bg_img' ], null, $image[ 1 ], $image[ 2 ], true, $kt_lazy_image );
		?>
        <a href="<?php echo esc_url( $link[ 'url' ] ) ?>" target="<?php echo esc_attr( $link[ 'target' ] ) ?>"
           style="margin-left: <?php echo esc_attr( $list_margin ) ?>px">
			<?php echo htmlspecialchars_decode( $image_thumb[ 'img' ] ); ?>
        </a>
	<?php endforeach; ?>
</div>

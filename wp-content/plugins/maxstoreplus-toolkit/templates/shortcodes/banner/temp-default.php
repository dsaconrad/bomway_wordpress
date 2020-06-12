<?php
if ( isset( $atts ) ) {
	extract( $atts );
}
if ( $link ) {
	$link = vc_build_link( $link );
} else {
	$link = array( 'url' => '', 'title' => '', 'target' => '_self', 'rel' => '' );
}
?>
<div class="block-banner <?php echo esc_attr( $css_class ); ?>">
    <span class="effect"></span>
	<?php if ( $bg_banner ) : ?>
        <figure>
			<?php
			$kt_lazy_image = maxstoreplus_get_option( 'kt_enable_lazy', '' ) == 0 ? false : true;
			$image_thumb   = maxstoreplus_resize_image( $bg_banner, null, $width, $height, true, $kt_lazy_image );
			echo htmlspecialchars_decode( $image_thumb[ 'img' ] );
			?>
        </figure>
	<?php endif; ?>
    <div class="inner-banner">
		<?php if ( $title ) : ?>
            <h2 class="title title-banner"><?php echo $title ?></h2>
		<?php endif; ?>
		<?php if ( $des ) : ?>
            <p class="description des-banner"><?php echo $des ?></p>
		<?php endif; ?>
		<?php if ( $link[ 'url' ] != '' ) : ?>
            <a href="<?php echo esc_url( $link[ 'url' ] ) ?>" target="<?php echo esc_html( $link[ 'target' ] ) ?>"
               class="button">
				<?php echo esc_html( $link[ 'title' ] ); ?>
            </a>
		<?php endif; ?>
    </div>
</div>

<?php
$names         = get_the_terms( $post->ID, 'category_portfolio' );
$size_img      = get_post_meta( get_the_ID(), 'image_ratio_post_select', true );
$kt_lazy_image = maxstoreplus_get_option( 'kt_enable_lazy', '' ) == 0 ? false : true;
if ( $size_img == '' || $size_img == 'img1x1' ) {
	$thumb_w = 384;
	$thumb_h = 384;
	$crop    = true;
} elseif ( $size_img == 'img1x2' ) {
	$thumb_w = 768;
	$thumb_h = 384;
	$crop    = true;
} else {
	$thumb_w = 768;
	$thumb_h = 768;
	$crop    = true;
}
?>
<div id="<?php echo 'post-' . get_the_ID() ?>" class="<?php echo esc_attr( $size_img ) ?> blog-item item-portfolio
    <?php
if ( !empty( $names ) && !is_wp_error( $names ) ) {
	foreach ( $names as $name ) {
		echo $name->slug . ' ';
	}
}
?>
">
    <div class="post-format post-masonry">
        <div class="pj-image">
            <figure>
				<?php if ( !is_single() ) : ?>
                    <a href="<?php the_permalink(); ?>">
						<?php
						$image_thumb = maxstoreplus_resize_image( get_post_thumbnail_id(), null, $thumb_w, $thumb_h, $crop, $kt_lazy_image );
						?>
						<?php echo htmlspecialchars_decode( $image_thumb[ 'img' ] ); ?>
                    </a>
				<?php else : ?>
					<?php the_post_thumbnail( 'full' ); ?>
				<?php endif; ?>
            </figure>
            <h3 class="pj-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        </div>
        <div class="pj-hover">
            <a href="<?php the_permalink(); ?>">
                <p class="des">
					<?php echo esc_html__( 'Descriptions here', 'maxstoreplus' ) ?>
                </p>
            </a>
        </div>
    </div>
</div>
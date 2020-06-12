<?php
$size_img      = get_post_meta( get_the_ID(), 'image_ratio_post_select', true );
$kt_lazy_image = maxstoreplus_get_option( 'kt_enable_lazy', '' ) == 0 ? false : true;

if ( $size_img == '' || $size_img == 'img1x1' ) {
	$thumb_w = 370;
	$thumb_h = 275;
	$crop    = true;
} elseif ( $size_img == 'img1x2' ) {
	$thumb_w = 370;
	$thumb_h = 305;
	$crop    = true;
} else {
	$thumb_w = 370;
	$thumb_h = 411;
	$crop    = true;
}
?>
<div id="post-<?php echo get_the_ID() ?>" class="<?php echo esc_attr( $size_img ) ?> blog-item item-portfolio">
    <div class="post-item-info">
        <div class="post-format post-masonry">
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
        </div>
        <div class="main-content-post">
            <ul class="meta-post meta-style1">
                <li class="author">
                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>">
						<?php the_author() ?>
						<?php echo esc_html__( ',', 'maxstoreplus' ) ?>
                    </a>
                </li>
                <li class="time-post"><?php echo maxstoreplus_time_ago(); ?></li>
            </ul>
            <h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <ul class="meta-post meta-style2">
                <li class="like">
					<?php echo get_simple_likes_button( get_the_ID() ); ?>
                </li>
                <li class="comment-count">
                    <i class="fa fa-comment" aria-hidden="true"></i>
					<?php comments_number(
						esc_html__( '0 Comment', 'maxstoreplus' ),
						esc_html__( '1 Comment', 'maxstoreplus' ),
						esc_html__( '% Comments', 'maxstoreplus' )
					);
					?>
                </li>
                <li class="view">
                    <i class="fa fa-eye" aria-hidden="true"></i>
					<?php echo maxstoreplus_get_post_views( get_the_ID() ); ?>
                </li>
            </ul>
            <div class="post-excerpt"><?php echo wp_trim_words( apply_filters( 'the_excerpt', get_the_excerpt() ), 20, esc_html__( '...', 'maxstoreplus' ) ); ?></div>
            <a class="post-readmore outline-button"
               href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'maxstoreplus' ) ?></a>
        </div>
    </div>
</div>
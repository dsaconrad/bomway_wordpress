<?php
$format     = get_post_format( get_the_ID() );
$video_icon = '';
if ( $format == 'video' ) {
	$video_icon = '<a href="' . get_permalink() . '" class="icon-video"><i class="fa fa-play" aria-hidden="true"></i></a>';
}
?>
<div class="blog-item">
    <div class="post-format">
		<?php echo $video_icon; ?>
        <span class="days">
            <?php echo get_the_time( 'M j' ) ?>
        </span>
		<?php
		$kt_lazy_image = maxstoreplus_get_option( 'kt_enable_lazy', '' ) == 0 ? false : true;
		$image_thumb   = maxstoreplus_resize_image( get_post_thumbnail_id(), null, 370, 250, true, $kt_lazy_image );
		?>
        <a href="<?php the_permalink() ?>">
			<?php echo htmlspecialchars_decode( $image_thumb[ 'img' ] ); ?>
        </a>
    </div>
    <div class="main-content-post">
        <h3 class="post-title">
            <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
        </h3>
        <div class="meta-post meta-style2">
            <ul>
                <li class="like">
					<?php echo get_simple_likes_button( get_the_ID() ); ?>
                </li>
                <li><a href="<?php the_permalink() ?>">
                        <i class="fa fa-comment"></i>
						<?php comments_number(
							esc_html__( '0 Comment', 'maxstoreplus' ),
							esc_html__( '1 Comment', 'maxstoreplus' ),
							esc_html__( '% Comments', 'maxstoreplus' )
						);
						?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="post-excerpt"><?php echo wp_trim_words( apply_filters( 'the_excerpt', get_the_excerpt() ), 15, '...' ); ?></div>
        <a class="post-readmore" href="<?php the_permalink() ?>">
			<?php echo esc_html__( 'Read more', 'maxstoreplus' ) ?>
        </a>
    </div>
</div>
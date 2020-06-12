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
		<?php
		$kt_lazy_image = maxstoreplus_get_option( 'kt_enable_lazy', '' ) == 0 ? false : true;
		$image_thumb   = maxstoreplus_resize_image( get_post_thumbnail_id(), null, 370, 250, true, $kt_lazy_image );
		?>
        <a href="<?php the_permalink() ?>">
			<?php echo htmlspecialchars_decode( $image_thumb[ 'img' ] ); ?>
        </a>
    </div>
    <div class="avatar-author">
		<?php echo get_avatar( get_the_author_meta( 'email' ), '50' ); ?>
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
        <h3 class="post-title">
            <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
        </h3>
    </div>
    <ul class="meta-post meta-style2">
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
        <li class="view">
            <i class="fa fa-eye" aria-hidden="true"></i>
			<?php echo maxstoreplus_get_post_views( get_the_ID() ); ?>
        </li>
    </ul>
</div>
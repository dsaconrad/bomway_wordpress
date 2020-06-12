<?php
$orig_post = $post;
global $post;
// Setting 
$opt_blog_related_post = maxstoreplus_get_option( 'opt_blog_related_post', 0 );

$opt_related_posts_per_page = maxstoreplus_get_option( 'opt_related_posts_per_page', 5 );
$opt_blog_related_lg_items  = maxstoreplus_get_option( 'opt_blog_related_lg_items', 3 );
$opt_blog_related_md_items  = maxstoreplus_get_option( 'opt_blog_related_md_items', 2 );
$opt_blog_related_sm_items  = maxstoreplus_get_option( 'opt_blog_related_sm_items', 2 );
$opt_blog_related_xs_items  = maxstoreplus_get_option( 'opt_blog_related_xs_items', 1 );
$opt_blog_related_ts_items  = maxstoreplus_get_option( 'opt_blog_related_ts_items', 1 );

if ( $opt_blog_related_post == 0 ) {
	return;
}

$data_reponsive = array(
	'0'    => array(
		'items' => $opt_blog_related_ts_items,
	),
	'480'  => array(
		'items' => $opt_blog_related_xs_items,
	),
	'768'  => array(
		'items' => $opt_blog_related_sm_items,
	),
	'992'  => array(
		'items' => $opt_blog_related_md_items,
	),
	'1200' => array(
		'items' => $opt_blog_related_lg_items,
	),
);
$data_reponsive = json_encode( $data_reponsive );

$categories = get_the_category( $post->ID );
if ( $categories ) :
	$category_ids = array();
	foreach ( $categories as $individual_category ) {
		$category_ids[] = $individual_category->term_id;
	}
	$args      = array(
		'category__in'        => $category_ids,
		'post__not_in'        => array( $post->ID ),
		'posts_per_page'      => $opt_related_posts_per_page,
		'ignore_sticky_posts' => 1,
		'orderby'             => 'rand',
	);
	$new_query = new wp_query( $args );
	?>
	<?php if ( $new_query->have_posts() ) : ?>
	<?php
	if ( $new_query->post_count > 1 ) {
		$loop = 'true';
	}
	?>
    <div class="cp-relate-post">
        <h4 class="relate-title super-title"><?php esc_html_e( 'You may also like', 'maxstoreplus' ); ?></h4>
        <div class="cp-blog blog-style5 owl-carousel" data-dots="false" data-nav="false" data-margin="30"
             data-loop="true" data-responsive='<?php echo esc_attr( $data_reponsive ); ?>'>
			<?php while ( $new_query->have_posts() ): $new_query->the_post(); ?>
				<?php get_template_part( 'templates/blogs/fomat/content-fomat', '2' ); ?>
			<?php endwhile; ?>
        </div>
    </div>
<?php endif; ?>
<?php endif;
$post = $orig_post;
wp_reset_postdata();
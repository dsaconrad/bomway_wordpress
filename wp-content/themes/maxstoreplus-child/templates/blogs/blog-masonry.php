<?php
get_post_format();
$opt_blog_masonry_columns = maxstoreplus_get_option('opt_blog_masonry_columns',3);
if( have_posts()){
	?>
	<div class="cp-blog blog-style2 cp-portfolio pf-gap30">
		<div class="portfolio-grid cp-blog-content" data-layoutMode="masonry" data-cols="<?php echo esc_attr($opt_blog_masonry_columns);?>">
            <?php while( have_posts()) : the_post(); ?>
                <?php get_template_part('templates/blogs/fomat/content-fomat','3'); ?>
            <?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
	<?php
    maxstoreplus_paging_nav();
}else{
	get_template_part( 'content', 'none' );
}
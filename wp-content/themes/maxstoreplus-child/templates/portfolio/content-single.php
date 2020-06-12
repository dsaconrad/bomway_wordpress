<?php
$opt_portfolio_about_author = maxstoreplus_get_option('opt_portfolio_about_author',0);
?>
<div class="cp-blog-single blog-single">
	<?php
	while( have_posts()) : the_post(); ?>
		<?php maxstoreplus_set_post_views(get_the_ID()); ?>
		<div <?php post_class('blog-item');?> >
			<h1 class="post-title"><?php the_title();?></h1>
			<ul class="meta-post meta-style2">
				<li class="like">
					<?php echo get_simple_likes_button( get_the_ID() ); ?>
				</li>
				<li class="comment-count">
					<i class="fa fa-comment" aria-hidden="true"></i>
					<?php comments_number(
						esc_html__('0 Comment', 'maxstoreplus'),
						esc_html__('1 Comment', 'maxstoreplus'),
						esc_html__('% Comments', 'maxstoreplus')
					);
					?>
				</li>
				<li class="view">
					<i class="fa fa-eye" aria-hidden="true"></i>
					<?php echo maxstoreplus_get_post_views(get_the_ID()); ?>
				</li>
			</ul>
			<div class="post-format post-single">
				<?php the_post_thumbnail('full'); ?>
			</div>
			<div class="post-content">
				<?php the_content();?>
			</div>
		</div>
		<?php
	endwhile;
	wp_link_pages( array(
		'before'      => '<div class="page-links">',
		'after'       => '</div>',
		'link_before' => '<span>',
		'link_after'  => '</span>',
		'pagelink'    => '%',
		'separator'   => '',
	) );
	?>
	<?php wp_reset_postdata(); ?>
	<?php if( $opt_portfolio_about_author == 1 ):?>
		<?php get_template_part('templates/blogs/blog','bio');?>
	<?php endif;?>
	<?php get_template_part('templates/portfolio/content','related');?>
</div>
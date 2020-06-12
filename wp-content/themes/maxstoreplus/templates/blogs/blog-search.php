<?php
if( have_posts()){
	?>
	<div class="cp-blog blog-style1 standard style-search">
        <?php
		while( have_posts()){
			the_post();
			?>
            <div <?php post_class('blog-item');?>>
                <h3 class="post-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                <div class="post-content">
                    <?php echo wp_trim_words(get_the_content(), 50 ,'[...]'); ?>
                </div>
            </div>
			<?php
		}
		?>
	</div>
	<?php
	maxstoreplus_paging_nav();
}else{
	get_template_part('template-parts/content','none');
}
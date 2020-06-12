<?php
if( have_posts()){
	?>
	<div class="cp-blog blog-style1 standard">
		<div class="cp-blog-content">
        <?php
		while( have_posts()){
			the_post();
			?>
            <div <?php post_class('blog-item');?>>
                <div class="post-item-info">
                    <div class="thumb-blog">
						<?php the_post_thumbnail('full'); ?>
                    </div>
                    <div class="main-content-post">
	        			<h3 class="post-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
	        			<ul class="meta-post">
	        				<li class="date"><i class="fa fa-calendar-o"></i><?php echo get_the_date('M j');?></li>
	        				<li class="comment-count">
	        					<i class="fa fa-comment-o"></i>
								<?php comments_number(
	                                esc_html__('0', 'maxstoreplus'),
	                                esc_html__('1', 'maxstoreplus'),
	                                esc_html__('%', 'maxstoreplus')
	                            );
	                            ?>
	        				</li>
	        				<li class="author"><i class="fa fa-user"></i><?php the_author_link(); ?></li>
	        				<?php
                    		if ( is_sticky() && is_home() && ! is_paged() ) {
                    			printf( '<li class="sticky-post"><i class="fa fa-flag"></i>%s</li>', esc_html__( 'Sticky', 'maxstoreplus' ) );
                    		}
                    		?>
	        			</ul>
	        			<?php if( has_tag() ):?>
	        			<div class="tag-post">
	        				<span><i class="fa fa-tag"></i><?php esc_html_e('Tags','maxstoreplus');?>:</span>
	        				<?php the_tags( '',''); ?> 
	        			</div>
	        			<?php endif;?>
	        			<div class="post-content">
	        				<?php 
	        				the_content( sprintf(
								__( 'Continue reading %s', 'maxstoreplus' ),
								the_title( '<span class="screen-reader-text">', '</span>', false )
							) );
	        				?>
	        				<?php
							wp_link_pages( array(
							    'before'      => '<div class="page-links">',
							    'after'       => '</div>',
							    'link_before' => '<span>',
							    'link_after'  => '</span>',
							    'pagelink'    => '%',
							    'separator'   => '',
							) );
							?>
	        			</div>
	        		</div>
                </div>
            </div>
			<?php
		}
		?>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
	<?php
	maxstoreplus_paging_nav();
}else{
	get_template_part( 'content', 'none' );
}
<?php
/**
 * Created by PhpStorm.
 * User: hoangkhanh
 * Date: 12/24/2016
 * Time: 10:17 AM
 */
$title_post_type = sprintf( __( '%s','maxstoreplus' ), post_type_archive_title( '', false ) );
if( have_posts()){ ?>
	<div class="cp-blog blog-style3 cp-portfolio">
		<div class="titlepage-fillter">
			<div class="title-page">
				<h2 class="super-title"><?php echo esc_html__('portfolio','maxstoreplus')?></h2>
			</div>
			<div class="portfolio_fillter project-fillter">
				<div data-filter="*" class="item-fillter fillter-active"><?php echo esc_html__('All','maxstoreplus') ?></div>
				<?php
				$terms = get_terms( 'category_portfolio' );
				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
					foreach ( $terms as $term ) {
						echo '<div data-filter=".' . $term->slug . '" class="item-fillter">
                        ' . $term->name . '
                        </div>';
					}
				}
				?>
			</div>
		</div>
		<div class="portfolio-grid cp-loadmore-content" data-layoutMode="packery">
			<?php while (have_posts()) : the_post() ?>
				<?php get_template_part('templates/portfolio/fomat/content-fomat','1'); ?>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
	<?php
}else{
	echo '<h1 style="text-align: center"> Nothing to show ...!</h1>';
}
?>
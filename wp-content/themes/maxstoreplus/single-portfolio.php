<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package corporatepro
 */
?>
<?php get_header(); ?>
<?php

/* portfolio Layout */
$maxstoreplus_portfolio_layout = maxstoreplus_get_option('opt_single_portfolio_layout','left');
$maxstoreplus_container_class = array('main-container');

if( $maxstoreplus_portfolio_layout == 'full'){
	$maxstoreplus_container_class[] = 'no-sidebar';
}else{
	$maxstoreplus_container_class[] = 'sidebar-'.$maxstoreplus_portfolio_layout;
}
$maxstoreplus_content_class = array();
$maxstoreplus_content_class[] = 'main-content';
if( $maxstoreplus_portfolio_layout == 'full' ){
	$maxstoreplus_content_class[] ='col-sm-12';
}else{
	$maxstoreplus_content_class[] = 'col-md-9 col-sm-8';
}

$maxstoreplus_slidebar_class = array();
$maxstoreplus_slidebar_class[] = 'sidebar';
if( $maxstoreplus_portfolio_layout != 'full'){
	$maxstoreplus_slidebar_class[] = 'col-md-3 col-sm-4';
}



/* portfolio Style */
$maxstoreplus_portfolio_list_style = maxstoreplus_get_option('opt_portfolio_list_style','standard');
?>
<div class="<?php echo esc_attr( implode(' ', $maxstoreplus_container_class) );?>">
	<div class="container">
		<div class="row">
			<div class="<?php echo esc_attr( implode(' ', $maxstoreplus_content_class) );?>">
				<?php get_template_part('template-parts/part','breadcrumb');?>
				<?php get_template_part('templates/portfolio/content','single');?>
				<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>
			</div>
			<?php if( $maxstoreplus_portfolio_layout != "full" ):?>
				<div class="<?php echo esc_attr( implode(' ', $maxstoreplus_slidebar_class) );?>">
					<?php get_sidebar();?>
				</div>
			<?php endif;?>
		</div>
	</div>
</div>
<?php get_footer(); ?>

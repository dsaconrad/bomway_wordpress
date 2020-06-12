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

/* Blog Layout */
$maxstoreplus_blog_layout = maxstoreplus_get_option('opt_blog_layout','left');
$maxstoreplus_container_class = array('main-container');

if( $maxstoreplus_blog_layout == 'full'){
    $maxstoreplus_container_class[] = 'no-sidebar';
}else{
    $maxstoreplus_container_class[] = 'sidebar-'.$maxstoreplus_blog_layout;
}
$maxstoreplus_content_class = array();
$maxstoreplus_content_class[] = 'main-content';
if( $maxstoreplus_blog_layout == 'full' ){
    $maxstoreplus_content_class[] ='col-sm-12';
}else{
    $maxstoreplus_content_class[] = 'col-md-9 col-sm-8';
}

$maxstoreplus_slidebar_class = array();
$maxstoreplus_slidebar_class[] = 'sidebar';
if( $maxstoreplus_blog_layout != 'full'){
    $maxstoreplus_slidebar_class[] = 'col-md-3 col-sm-4';
}

/* Blog Style */
$maxstoreplus_blog_list_style = maxstoreplus_get_option('opt_blog_list_style','standard');
?>
<div class="<?php echo esc_attr( implode(' ', $maxstoreplus_container_class) );?>">
    <div class="container">
        <div class="row">
            <div class="<?php echo esc_attr( implode(' ', $maxstoreplus_content_class) );?>" data-layout="<?php echo $maxstoreplus_blog_list_style ?>">
                <?php get_template_part('template-parts/part','breadcrumb'); ?>
                <?php if ( is_home() && ! is_front_page() ) : ?>
                <?php endif; ?>
                <?php get_template_part('templates/blogs/blog',$maxstoreplus_blog_list_style);?>
            </div>
            <?php if( $maxstoreplus_blog_layout != "full" ):?>
                <div class="<?php echo esc_attr( implode(' ', $maxstoreplus_slidebar_class) );?>">
                    <?php get_sidebar();?>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>
<?php get_footer(); ?>

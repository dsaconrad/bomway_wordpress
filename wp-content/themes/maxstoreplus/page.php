<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package TrueShop
 */
get_header();
$_corporatepro_page_layout = corporatepro_get_post_meta(get_the_ID(),'_corporatepro_page_layout','left');
$corporatepro_container_class = array('main-container');

if( $_corporatepro_page_layout == 'full'){
    $corporatepro_container_class[] = 'no-sidebar';
}else{
    $corporatepro_container_class[] = 'sidebar-'.$_corporatepro_page_layout;
}
$corporatepro_content_class = array();
$corporatepro_content_class[] = 'main-content';
if( $_corporatepro_page_layout == 'full' ){
    $corporatepro_content_class[] ='col-sm-12';
}else{
    $corporatepro_content_class[] = 'col-md-9 col-sm-8';
}


?>

<?php get_template_part('template-parts/page','banner');?>
<div class="<?php echo esc_attr( implode(' ', $corporatepro_container_class) );?>">
    <div class="container">
        <div class="row">
            <div class="<?php echo esc_attr( implode(' ', $corporatepro_content_class) );?>">
                <?php get_template_part('template-parts/content','page');?>
                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
                ?>
            </div>
            <?php if( $_corporatepro_page_layout !='full'):?>
            <div class="col-md-3 col-sm-4 sidebar">
                <?php get_sidebar('page'); ?>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>
<?php get_footer(); ?>

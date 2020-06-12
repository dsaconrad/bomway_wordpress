<?php
/**
 * Template Name: Full Width Have Breadcrumbs
 *
 * @package WordPress
 * @subpackage trueshop
 * @since trueshop 1.0
 */
get_header();
?>
    <div class="fullwidth-template">
        <div class="container">
            <?php get_template_part('template-parts/part','breadcrumb');?>
            <?php
            // Start the loop.
            while ( have_posts() ) : the_post();
                ?>
                <?php the_content( );?>
                <?php
                // End the loop.
            endwhile;
            ?>
        </div>
    </div>
<?php
get_footer();
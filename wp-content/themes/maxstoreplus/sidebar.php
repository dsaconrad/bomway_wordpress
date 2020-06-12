<?php
$opt_blog_used_sidebar = maxstoreplus_get_option( 'opt_blog_used_sidebar', 'widget-area' );
if( is_single()){
    $opt_blog_used_sidebar = maxstoreplus_get_option( 'opt_single_blog_used_sidebar', 'widget-area' );
}
?>
<?php if ( is_active_sidebar( $opt_blog_used_sidebar ) ) : ?>
<div id="widget-area" class="widget-area sidebar-blog">
	<?php dynamic_sidebar( $opt_blog_used_sidebar ); ?>
</div><!-- .widget-area -->
<?php endif; ?>

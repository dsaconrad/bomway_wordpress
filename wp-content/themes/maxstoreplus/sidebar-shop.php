<?php
/**
 * The sidebar containing the main widget area
 *
 */
?>
<?php
$woo_shop_used_sidebar = maxstoreplus_get_option( 'woo_shop_used_sidebar', 'shop-widget-area' );
if( is_product() ){
	$woo_shop_used_sidebar = maxstoreplus_get_option('woo_single_used_sidebar','shop-widget-area');
}

?>

<?php if ( is_active_sidebar( $woo_shop_used_sidebar ) ) : ?>
<div id="widget-area" class="widget-area shop-sidebar">
	<?php dynamic_sidebar( $woo_shop_used_sidebar ); ?>
</div><!-- .widget-area -->
<?php endif; ?>

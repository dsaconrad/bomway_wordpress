<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || !$product->is_visible() ) {
	return;
}
// Custom columns
$woo_shop_lg_items = maxstoreplus_get_option( 'woo_shop_lg_items', 4 );
$woo_shop_md_items = maxstoreplus_get_option( 'woo_shop_md_items', 4 );
$woo_shop_sm_items = maxstoreplus_get_option( 'woo_shop_sm_items', 6 );
$woo_shop_xs_items = maxstoreplus_get_option( 'woo_shop_xs_items', 6 );
$woo_shop_ts_items = maxstoreplus_get_option( 'woo_shop_ts_items', 12 );

$kt_woo_product_style = maxstoreplus_get_option( 'woo_shop_product_style', 1 );

$shop_display_mode = maxstoreplus_get_option( 'woo_shop_list_style', 'grid' );

if ( isset( $_SESSION['shop_display_mode'] ) ) {
	$shop_display_mode = $_SESSION['shop_display_mode'];
}

$classes[] = 'product-item product';
$classes[] = 'style' . $kt_woo_product_style;

if ( $shop_display_mode == "grid" ) {
	$classes[] = 'col-lg-' . $woo_shop_lg_items;
	$classes[] = 'col-md-' . $woo_shop_md_items;
	$classes[] = 'col-sm-' . $woo_shop_sm_items;
	$classes[] = 'col-xs-' . $woo_shop_xs_items;
	$classes[] = 'col-ts-' . $woo_shop_ts_items;
} else {
	$classes[] = 'list col-sm-12';
}
$template_style = 'style-' . $kt_woo_product_style;
?>

<li <?php wc_product_class( $classes, $product ); ?>>
	<?php if ( $shop_display_mode == "grid" ): ?>
		<?php wc_get_template_part( 'product-styles/content-product', $template_style ); ?>
	<?php else: ?>
		<?php wc_get_template_part( 'content-product', 'list' ); ?>
	<?php endif; ?>
</li>


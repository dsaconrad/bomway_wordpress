<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.3.0
 */
?>
<?php
$shop_display_mode = maxstoreplus_get_option( 'woo_shop_list_style', 'grid' );
if ( isset( $_SESSION['shop_display_mode'] ) ) {
	$shop_display_mode = $_SESSION['shop_display_mode'];
}
?>
<?php if ( $shop_display_mode == 'grid' ): ?>
<ul class="row products product-grid auto-clear">
	<?php else: ?>
    <ul class="row products product-list product-list-sidebar">
		<?php endif; ?>

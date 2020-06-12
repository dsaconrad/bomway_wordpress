<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage maxstoreplus
 * @since maxstoreplus 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0" />
    <link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
$style_header = maxstoreplus_get_option( 'opt_header_layout', '' );
$class_add    = '';
if ( $style_header == 'style-12' ) {
	$class_add = ' dark-header';
} else if ( $style_header == 'style-10' ) {
	$class_add = ' main-color-header';
}
?>
<div class="body-ovelay"></div>
<!-- MENU MOBILE -->
<div id="box-mobile-menu" class="box-mobile-menu custom-header-mobile"
     data-header="<?php echo esc_attr( $style_header ) ?>">
    <div class="box-inner">
        <a href="#" class="close-menu"><span class="flaticon-close1"></span></a>
    </div>
    <div class="logo logo-header">
		<?php corporatepro_get_logo(); ?>
    </div>
    <div class="header-right">
        <div class="navigation-bar">
			<?php get_template_part( 'template-parts/header', 'userlink' ); ?>
        </div>
        <div class="wishlist-switch">
            <div class="wishlist-icon">
                <a href="<?php echo get_permalink( get_page_by_path( 'wishlist' ) ) ?>" class="icon-text">
                    <i class="flaticon-heart1"></i>
                </a>
            </div>
        </div>
        <div class="shopcart-switch">
            <!-- block mini cart -->
			<?php if ( class_exists( 'WooCommerce' ) ) {
				woocommerce_mini_cart();
			} ?>
            <!-- block mini cart -->
        </div>
        <a href="javascript:void(0)" class="open-menu"><span class="flaticon-bars1"></span></a>
    </div>
</div>
<!-- MENU MOBILE -->
<!-- MENU FIXED MENU-->
<div id="header-top-fixed" class="main-menu-wapper fixed-menu-header<?php echo esc_attr( $class_add ) ?>">
    <div class="header-logo">
        <div class="logo logo-header">
			<?php corporatepro_get_logo(); ?>
        </div>
    </div>
    <div class="header-menu">
        <div class="menu-fixed-inner ms-main-menu"></div>
    </div>
    <div class="header-right">
        <div class="wishlist-switch">
            <div class="wishlist-icon">
                <a href="<?php echo get_permalink( get_page_by_path( 'wishlist' ) ) ?>" class="icon-text">
                    <i class="flaticon-heart1"></i>
                </a>
            </div>
        </div>
        <div class="shopcart-switch">
            <!-- block mini cart -->
			<?php if ( class_exists( 'WooCommerce' ) ) {
				woocommerce_mini_cart();
			} ?>
            <!-- block mini cart -->
        </div>
    </div>
</div>
<!-- MENU FIXED MENU-->
<?php maxstoreplus_get_header(); ?>

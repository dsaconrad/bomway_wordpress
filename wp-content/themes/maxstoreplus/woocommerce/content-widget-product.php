<?php
/**
 * The template for displaying product widget entries
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see    https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( !is_a( $product, 'WC_Product' ) ) {
	return;
}
?>

<li class="product">

	<?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>

    <div class="product-thumb">
		<?php $image_thumb = maxstoreplus_resize_image( $product->get_image_id(), null, 70, 70, true, true, false ); ?>
        <img class="img-responsive" src="<?php echo esc_attr( $image_thumb['url'] ); ?>"
             width="<?php echo intval( $image_thumb['width'] ) ?>"
             height="<?php echo intval( $image_thumb['height'] ) ?>" alt="<?php the_title() ?>">
    </div>
    <div class="info-product">
        <h3 class="title-product">
            <a href="<?php echo esc_url( $product->get_permalink() ); ?>">
				<?php echo wp_kses_post( $product->get_name() ); ?>
            </a>
        </h3>
		<?php if ( $price_html = $product->get_price_html() ) : ?>
            <span class="price pj-price"><?php echo $price_html; ?></span>
		<?php endif; ?>
		<?php if ( !empty( $show_rating ) ) : ?>
			<?php echo wc_get_rating_html( $product->get_average_rating() ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php else : ?>
            <div class="box-rating"></div>
		<?php endif; ?>
    </div>

	<?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>

</li>

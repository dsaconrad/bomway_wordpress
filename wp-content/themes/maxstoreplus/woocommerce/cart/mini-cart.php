<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $woocommerce;

$header_layout = maxstoreplus_get_option( 'opt_header_layout' );
?>
<?php do_action( 'woocommerce_before_mini_cart' ); ?>

    <div class="mode-mini-cart header-cart">
        <a class="shopcart-icon" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
            <span class="style style-7">
                <i class="flaticon-cart"></i>
                <span class="cart-name"><?php echo esc_html__( 'my cart', 'maxstoreplus' ) ?></span>
                <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
            </span>
            <span class="style style-3">
                <i class="flaticon-cart"></i>
                <span class="cart-name"><?php echo esc_html__( 'shopping cart', 'maxstoreplus' ) ?></span>
                <span class="cart-count"><?php echo '<span>(</span>' . WC()->cart->get_cart_contents_count() . '<span>)</span>' ?></span>
            </span>
            <span class="style all-page">
                <i class="flaticon-cart"></i>
                <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
            </span>
        </a>
		<?php if ( !WC()->cart->is_empty() ) : ?>
            <div class="shopcart-description">
                <div class="load"><span></span></div>
                <div class="minicart-content-wrapper">
                    <div class="subtitle">
						<?php printf( esc_html__( 'You have %1$s item(s) in your cart', 'maxstoreplus' ), WC()->cart->get_cart_contents_count() ); ?>
                    </div>
                    <div class="minicart-items-wrapper">
                        <ul class="minicart-items woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">

							<?php do_action( 'woocommerce_before_mini_cart_contents' ); ?>

							<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ): ?>
								<?php
								$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
								$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
								?>

								<?php if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ): ?>

									<?php
									$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
									$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( array( 80, 95 ) ), $cart_item, $cart_item_key );
									$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
									$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
									$product_permalink = empty( $product_permalink ) ? $product_permalink : '#';
									?>
                                    <li class="product-item woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
                                        <a class="product-media"
                                           href="<?php echo esc_url( $product_permalink ) ?>">
											<?php echo wp_kses_post( $thumbnail ); ?>
                                        </a>
                                        <div class="product-details">
                                            <h3 class="product-name">
                                                <a href="<?php echo esc_url( $product_permalink ) ?>">
													<?php echo esc_html( $product_name ); ?>
                                                    <span><?php echo esc_html( '(' . $cart_item['quantity'] . ')' ); ?></span>
                                                </a>
                                            </h3>
                                            <div class="product-qty">
                                                <span class="number"><?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="qty">' . sprintf( '%s', $product_price ) . '</span>', $cart_item, $cart_item_key ); ?></span>
                                            </div>
                                        </div>
                                        <div class="product-delete">
											<?php
											echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
												'<a data-layout="%s" href="%s" class="remove remove_from_cart_button" title="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><span>%s</span></a>',
												esc_attr( $header_layout ),
												esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
												esc_html__( 'Remove this item', 'maxstoreplus' ),
												esc_attr( $product_id ),
												esc_attr( $cart_item_key ),
												esc_attr( $_product->get_sku() ),
												sprintf( '<i class="flaticon-close2"></i>', 'maxstoreplus' )
											), $cart_item_key
											);
											?>
                                        </div>
                                    </li>
								<?php endif; ?>
							<?php endforeach; ?>

							<?php do_action( 'woocommerce_mini_cart_contents' ); ?>

                        </ul>
                    </div>

					<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

                    <div class="subtotal">
                        <span class="title"><?php esc_html_e( 'Grand Total: ', 'maxstoreplus' ); ?></span>
                        <span class="price"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                    </div>
                    <div class="actions">
						<?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?>
                    </div>

					<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

                </div>
            </div>
		<?php else : ?>
            <div class="shopcart-description shopcart-empty">
                <p class="empty-text"><?php echo esc_html__( 'You have no item(s) in your cart', 'maxstoreplus' ) ?></p>
            </div>
		<?php endif; ?>
    </div>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
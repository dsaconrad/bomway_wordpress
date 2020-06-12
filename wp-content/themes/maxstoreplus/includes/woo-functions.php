<?php
/**
 *
 * REMOVE DESCRIPTION HEADING, INFOMATION HEADING
 */
add_filter( 'woocommerce_product_description_heading', 'maxstoreplus_product_description_heading' );
if ( !function_exists( 'maxstoreplus_product_description_heading' ) ) {
	function maxstoreplus_product_description_heading()
	{
		return '';
	}
}
add_filter( 'woocommerce_product_additional_information_heading', 'maxstoreplus_product_additional_information_heading' );
if ( !function_exists( 'maxstoreplus_product_additional_information_heading' ) ) {
	function maxstoreplus_product_additional_information_heading()
	{
		return '';
	}
}
/*Remove woocommerce_template_loop_product_link_open */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
/*Remove each style one by one*/
add_filter( 'woocommerce_enqueue_styles', 'maxstoreplus_dequeue_styles' );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 15 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'maxstoreplus_template_loop_product_title', 10 );
/*Custom product thumb*/
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'maxstoreplus_template_loop_product_thumbnail', 10 );
// Remove the sorting dropdown from Woocommerce
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
add_action( 'woocommerce_before_shop_loop', 'maxstoreplus_shop_control', 30 );
// Remove the result count from WooCommerce
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'maxstoreplus_before_main_content', 'maxstoreplus_shop_banners', 1 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
/* Category */
remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_template_loop_category_link_open', 10 );
remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );
remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );
add_action( 'woocommerce_before_subcategory_title', 'maxstoreplus_woocommerce_subcategory_thumbnail', 10 );
remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );
add_action( 'woocommerce_shop_loop_subcategory_title', 'maxstoreplus_woocommerce_template_loop_category_title', 10 );
/*Custom product per page*/
add_filter( 'loop_shop_per_page', 'maxstoreplus_loop_shop_per_page', 20 );
add_filter( 'woof_products_query', 'maxstoreplus_woof_products_query', 20 );
/* SINGLE PRODUCT */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 50 );
add_action( 'woocommerce_single_product_summary', 'maxstoreplus_share_link', 40 );
/* UPSELL */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product', 'maxstoreplus_upsell_display', 15 );
/* RELATED */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action( 'woocommerce_after_single_product', 'maxstoreplus_related_products', 20 );
/* CROSS SELL */
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_after_cart', 'maxstoreplus_cross_sell_products', 10 );
/* QUICK VIEW */
remove_action( 'yith_wcqv_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'yith_wcqv_product_summary', 'woocommerce_template_single_meta', 30 );
add_action( 'yith_wcqv_product_summary', 'maxstoreplus_wc_loop_product_wishlist_btn', 30 );
add_action( 'yith_wcqv_product_summary', 'maxstoreplus_wc_loop_product_compare_btn', 30 );
add_action( 'yith_wcqv_product_summary', 'maxstoreplus_button_quickview', 40 );
if ( !function_exists( 'maxstoreplus_carousel_products' ) ) {
	function maxstoreplus_carousel_products( $prefix, $data_args )
	{
		$woo_lg_items   = maxstoreplus_get_option( '' . $prefix . '_lg_items', 3 );
		$woo_md_items   = maxstoreplus_get_option( '' . $prefix . '_md_items', 3 );
		$woo_sm_items   = maxstoreplus_get_option( '' . $prefix . '_sm_items', 2 );
		$woo_xs_items   = maxstoreplus_get_option( '' . $prefix . '_xs_items', 1 );
		$woo_ts_items   = maxstoreplus_get_option( '' . $prefix . '_ts_items', 1 );
		$data_reponsive = array(
			'0'    => array(
				'items' => $woo_ts_items,
			),
			'480'  => array(
				'items' => $woo_xs_items,
			),
			'768'  => array(
				'items' => $woo_sm_items,
			),
			'992'  => array(
				'items' => $woo_md_items,
			),
			'1200' => array(
				'items' => $woo_lg_items,
			),
		);
		$data_reponsive = json_encode( $data_reponsive );
		$title          = maxstoreplus_get_option( '' . $prefix . '_products_title', '' );
		if ( $data_args ) : ?>
            <section class="products cp-product-latest">
                <h2 class="title super-title"><?php echo esc_html( $title ) ?></h2>
                <div class="product-grid product-slide owl-carousel nav-style4" data-margin="30"
                     data-nav="true" data-dots="false" data-loop="false"
                     data-responsive='<?php echo esc_attr( $data_reponsive ); ?>'>
					<?php foreach ( $data_args as $value ) : ?>
                        <div <?php wc_product_class( 'product-item product', $value ); ?>>
							<?php
							$post_object = get_post( $value->get_id() );
							setup_postdata( $GLOBALS['post'] =& $post_object );
							wc_get_template_part( 'product-styles/content-product', 'style-1' ); ?>
                        </div>
					<?php endforeach; ?>
                </div>
            </section>
		<?php endif;
		wp_reset_postdata();
	}
}
if ( !function_exists( 'maxstoreplus_cross_sell_products' ) ) {
	function maxstoreplus_cross_sell_products( $limit = 2, $columns = 2, $orderby = 'rand', $order = 'desc' )
	{
		if ( is_checkout() ) {
			return;
		}
		// Get visible cross sells then sort them at random.
		$cross_sells                 = array_filter( array_map( 'wc_get_product', WC()->cart->get_cross_sells() ), 'wc_products_array_filter_visible' );
		$woocommerce_loop['name']    = 'cross-sells';
		$woocommerce_loop['columns'] = apply_filters( 'woocommerce_cross_sells_columns', $columns );
		// Handle orderby and limit results.
		$orderby     = apply_filters( 'woocommerce_cross_sells_orderby', $orderby );
		$cross_sells = wc_products_array_orderby( $cross_sells, $orderby, $order );
		$limit       = apply_filters( 'woocommerce_cross_sells_total', $limit );
		$cross_sells = $limit > 0 ? array_slice( $cross_sells, 0, $limit ) : $cross_sells;
		maxstoreplus_carousel_products( 'woo_cross_sell', $cross_sells );
	}
}
if ( !function_exists( 'maxstoreplus_related_products' ) ) {
	function maxstoreplus_related_products()
	{
		global $product;
		$ppp      = maxstoreplus_get_option( 'woo_related_products_limit_num_of_products', 6 );
		$defaults = array(
			'posts_per_page' => $ppp,
			'columns'        => 6,
			'orderby'        => 'rand',
			'order'          => 'desc',
		);
		$args     = wp_parse_args( $defaults );
		// Get visible related products then sort them at random.
		$args['related_products']    = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );
		$args['related_products']    = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );
		$woocommerce_loop['name']    = 'related';
		$woocommerce_loop['columns'] = apply_filters( 'woocommerce_related_products_columns', $args['columns'] );
		$related_products            = $args['related_products'];
		maxstoreplus_carousel_products( 'woo_related_product', $related_products );
	}
}
if ( !function_exists( 'maxstoreplus_upsell_display' ) ) {
	function maxstoreplus_upsell_display( $orderby = 'rand', $order = 'desc', $limit = '-1', $columns = 4 )
	{
		global $product;
		// Handle the legacy filter which controlled posts per page etc.
		$args                        = array(
			'posts_per_page' => 4,
			'orderby'        => 'rand',
			'columns'        => 4,
		);
		$woocommerce_loop['name']    = 'up-sells';
		$woocommerce_loop['columns'] = apply_filters( 'woocommerce_upsells_columns', isset( $args['columns'] ) ? $args['columns'] : $columns );
		$orderby                     = apply_filters( 'woocommerce_upsells_orderby', isset( $args['orderby'] ) ? $args['orderby'] : $orderby );
		$limit                       = apply_filters( 'woocommerce_upsells_total', isset( $args['posts_per_page'] ) ? $args['posts_per_page'] : $limit );
		// Get visible upsells then sort them at random, then limit result set.
		$upsells = wc_products_array_orderby( array_filter( array_map( 'wc_get_product', $product->get_upsell_ids() ), 'wc_products_array_filter_visible' ), $orderby, $order );
		$upsells = $limit > 0 ? array_slice( $upsells, 0, $limit ) : $upsells;
		maxstoreplus_carousel_products( 'woo_up_sells', $upsells );
	}
}
if ( !function_exists( 'maxstoreplus_button_quickview' ) ) {
	function maxstoreplus_button_quickview()
	{
		ob_start();
		?>
        <a class="link_to" href="<?php the_permalink( get_the_ID() ) ?>">
			<?php echo esc_html__( 'view full details', 'maxstoreplus' ) ?>
            <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
        </a>
		<?php
		$html = ob_get_clean();
		echo balanceTags( $html );
	}
}
if ( !function_exists( 'maxstoreplus_template_loop_product_thumbnail' ) ) {
	function maxstoreplus_template_loop_product_thumbnail()
	{
		global $product;
		$thumb_inner_class                 = array( 'thumb-inner' );
		$kt_using_two_image                = maxstoreplus_get_option( 'woo_style_hover', '1' );
		$kt_lazy_image                     = maxstoreplus_get_option( 'kt_enable_lazy', '' ) == 0 ? false : true;
		$kt_disable_using_two_image_mobile = 'yes';
		// GET SIZE IMAGE SETTING
		$w    = 400;
		$h    = 400;
		$crop = true;
		$size = wc_get_image_size( 'shop_catalog' );
		if ( $size ) {
			$w = $size['width'];
			$h = $size['height'];
			if ( !$size['crop'] ) {
				$crop = false;
			}
		}
		$w          = apply_filters( 'maxstoreolus_shop_pruduct_thumb_width', $w );
		$h          = apply_filters( 'maxstoreolus_shop_pruduct_thumb_height', $h );
		$back_image = array();
		if ( $kt_using_two_image == "1" ) {
			$attachment_ids = $product->get_gallery_image_ids();
			if ( wp_is_mobile() && $kt_disable_using_two_image_mobile == "yes" ) {
				$attachment_ids = false;
			}
			if ( $attachment_ids ) {
				$back_image          = maxstoreplus_resize_image( $attachment_ids[0], null, $w, $h, $crop, $kt_lazy_image );
				$thumb_inner_class[] = 'hover-default';
			} else {
				$thumb_inner_class[] = 'hover-style1';
			}
		} else {
			$thumb_inner_class[] = 'hover-style1';
		}
		ob_start();
		?>
        <div class="<?php echo esc_attr( implode( ' ', $thumb_inner_class ) ); ?>">
            <a class="thumb-link" href="<?php the_permalink(); ?>">
				<?php if ( !empty( $back_image ) ): ?>
                    <span class="back-image"><?php echo htmlspecialchars_decode( $back_image['img'] ); ?></span>
				<?php endif; ?>
				<?php $image_thumb = maxstoreplus_resize_image( get_post_thumbnail_id( $product->get_id() ), null, $w, $h, $crop, $kt_lazy_image ); ?>
				<?php echo htmlspecialchars_decode( $image_thumb['img'] ); ?>
            </a>
        </div>

		<?php
		echo ob_get_clean();
	}
}
if ( !function_exists( 'maxstoreplus_dequeue_styles' ) ) {
	function maxstoreplus_dequeue_styles( $enqueue_styles )
	{
		unset( $enqueue_styles['woocommerce-general'] );    // Remove the gloss
		unset( $enqueue_styles['woocommerce-layout'] );        // Remove the layout
		unset( $enqueue_styles['woocommerce-smallscreen'] );    // Remove the smallscreen optimisation

		return $enqueue_styles;
	}
}
if ( !function_exists( 'maxstoreplus_template_loop_product_title' ) ) {
	function maxstoreplus_template_loop_product_title()
	{
		$title_class = array( 'title-product product_title pj-title' );
		?>
        <h3 class="<?php echo esc_attr( implode( ' ', $title_class ) ); ?>"><a
                    href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php
	}
}
if ( !function_exists( 'maxstoreplus_woocommerce_subcategory_thumbnail' ) ) {
	function maxstoreplus_woocommerce_subcategory_thumbnail( $category )
	{
		/*GET SIZE IMAGE SETTING*/
		$w            = 470;
		$h            = 400;
		$crop         = true;
		$w            = apply_filters( 'koolshop_shop_category_thumb_width', $w );
		$h            = apply_filters( 'koolshop_shop_category_thumb_height', $h );
		$thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
		$image_thumb  = maxstoreplus_resize_image( $thumbnail_id, null, $w, $h, $crop, true, false );
		?>
        <div class="img-cat">
            <figure>
                <img width="<?php echo esc_attr( $image_thumb['width'] ); ?>"
                     height="<?php echo esc_attr( $image_thumb['height'] ); ?>"
                     class="attachment-post-thumbnail wp-post-image"
                     src="<?php echo esc_attr( $image_thumb['url'] ) ?>" alt=""/>
            </figure>
        </div>
		<?php
	}
}
if ( !function_exists( 'maxstoreplus_share_link' ) ) {
	function maxstoreplus_share_link()
	{
		global $product;
		$share_link_title = 'Product on ' . ucfirst( wp_get_theme()->get( 'Name' ) );
		$share_link_url   = get_permalink( $product->get_id() );
		$share_image_url  = wp_get_attachment_url( get_post_thumbnail_id( $product->get_id() ) );
		ob_start();
		?>
        <div class="group-share">
            <h4 class="title"><?php echo esc_html__( 'share on:', 'maxstoreplus' ) ?></h4>
            <ul>
                <li style="list-style-type: none; display: inline-block;">
                    <a target="_blank" class="facebook"
                       href="https://www.facebook.com/sharer.php?s=100&amp;p%5Btitle%5D=<?php echo $share_link_title ?>&amp;p%5Burl%5D=<?php echo urlencode( $share_link_url ) ?>"
                       title="<?php esc_html__( 'Facebook', 'maxstoreplus' ) ?>">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                    </a>
                </li>
                <li style="list-style-type: none; display: inline-block;">
                    <a target="_blank" class="twitter"
                       href="https://twitter.com/share?url=<?php echo urlencode( $share_link_url ) ?>&amp;text=<?php echo $share_link_title ?>"
                       title="<?php esc_html__( 'Twitter', 'maxstoreplus' ) ?>">
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                    </a>
                </li>
                <li style="list-style-type: none; display: inline-block;">
                    <a target="_blank" class="pinterest"
                       href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode( $share_link_url ) ?>&amp;description=<?php echo $share_link_title ?>&amp;media=<?php echo esc_url( $share_image_url ) ?>"
                       title="<?php esc_html__( 'Pinterest', 'maxstoreplus' ) ?>"
                       onclick="window.open(this.href); return false;">
                        <i class="fa fa-pinterest" aria-hidden="true"></i>
                    </a>
                </li>
                <li style="list-style-type: none; display: inline-block;">
                    <a target="_blank" class="googleplus"
                       href="https://plus.google.com/share?url=<?php echo urlencode( $share_link_url ) ?>&amp;title=<?php echo $share_link_title ?>"
                       title="<?php esc_html__( 'Google+', 'maxstoreplus' ) ?>"
                       onclick='javascript:window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;'>
                        <i class="fa fa-google-plus" aria-hidden="true"></i>
                    </a>
                </li>
                <li style="list-style-type: none; display: inline-block;">
                    <a class="email"
                       href="mailto:?subject=<?php echo urlencode( esc_html__( 'I wanted you to see this site', 'maxstoreplus' ) ) ?>&amp;body=<?php echo urlencode( $share_link_url ) ?>&amp;title=<?php echo $share_link_title ?>"
                       title="<?php _e( 'Email', 'maxstoreplus' ) ?>">
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    </a>
                </li>
            </ul>
        </div>
		<?php
		$html = ob_get_clean();
		echo balanceTags( $html );
	}
}
add_action( 'woocommerce_before_shop_loop_item_title', 'maxstoreplus_shop_loop_item_contdown', 20 );
if ( !function_exists( 'maxstoreplus_shop_loop_item_contdown' ) ) {
	function maxstoreplus_shop_loop_item_contdown()
	{
		global $product;
		$date = maxstoreplus_get_max_date_sale( $product->get_id() );
		?>
		<?php if ( $date > 0 ):
		$y = date( 'Y', $date );
		$m    = date( 'm', $date );
		$d    = date( 'd', $date );
		$h    = date( 'h', $date );
		$i    = date( 'i', $date );
		$s    = date( 's', $date );
		$time = date( "Y/m/d H:i:s", $date );
		?>
        <div class="cp-countdown" data-time="<?php echo esc_attr( $time ); ?>">
            <span class="icon"><i class="fa fa-clock-o"></i></span>
            <span class="hour"></span> :
            <span class="minute"></span> :
            <span class="second"></span>&nbsp;
            <span class="text"><?php esc_html_e( 'Left', 'maxstoreplus' ); ?></span>
        </div>
	<?php endif; ?>
		<?php
	}
}
// GET DATE SALE
if ( !function_exists( 'maxstoreplus_get_max_date_sale' ) ) {
	function maxstoreplus_get_max_date_sale( $product_id )
	{
		$time = 0;
		// Get variations
		$args          = array(
			'post_type'   => 'product_variation',
			'post_status' => array( 'private', 'publish' ),
			'numberposts' => -1,
			'orderby'     => 'menu_order',
			'order'       => 'asc',
			'post_parent' => $product_id,
		);
		$variations    = get_posts( $args );
		$variation_ids = array();
		if ( $variations ) {
			foreach ( $variations as $variation ) {
				$variation_ids[] = $variation->ID;
			}
		}
		$sale_price_dates_to = false;
		if ( !empty( $variation_ids ) ) {
			global $wpdb;
			$sale_price_dates_to = $wpdb->get_var( "
                SELECT
                meta_value
                FROM $wpdb->postmeta
                WHERE meta_key = '_sale_price_dates_to' and post_id IN(" . join( ',', $variation_ids ) . ")
                ORDER BY meta_value DESC
                LIMIT 1
            "
			);
			if ( $sale_price_dates_to != '' ) {
				return $sale_price_dates_to;
			}
		}
		if ( !$sale_price_dates_to ) {
			$sale_price_dates_to = get_post_meta( $product_id, '_sale_price_dates_to', true );
			if ( $sale_price_dates_to == '' ) {
				$sale_price_dates_to = '0';
			}

			return $sale_price_dates_to;
		}
	}
}
/*Custom hook quick view*/
if ( class_exists( 'YITH_WCQV_Frontend' ) ) {
	// Class frontend
	$enable           = get_option( 'yith-wcqv-enable' ) == 'yes' ? true : false;
	$enable_on_mobile = get_option( 'yith-wcqv-enable-mobile' ) == 'yes' ? true : false;
	// Class frontend
	if ( ( !wp_is_mobile() && $enable ) || ( wp_is_mobile() && $enable_on_mobile && $enable ) ) {
		remove_action( 'woocommerce_after_shop_loop_item', array( YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button' ), 15 );
		add_action( 'maxstoreplus_function_shop_loop_item_quickview', array( YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button' ), 5 );
	}
}
/* Compare */
if ( class_exists( 'YITH_Woocompare' ) && get_option( 'yith_woocompare_compare_button_in_products_list' ) == 'yes' ) {
	global $yith_woocompare;
	$is_ajax = ( defined( 'DOING_AJAX' ) && DOING_AJAX );
	if ( $yith_woocompare->is_frontend() || $is_ajax ) {
		if ( $is_ajax ) {
			if ( !class_exists( 'YITH_Woocompare_Frontend' ) ) {
				if ( file_exists( YITH_WOOCOMPARE_DIR . 'includes/class.yith-woocompare-frontend.php' ) ) {
					require_once( YITH_WOOCOMPARE_DIR . 'includes/class.yith-woocompare-frontend.php' );
				}
			}
			$yith_woocompare->obj = new YITH_Woocompare_Frontend();
		}
		/* Remove button */
		remove_action( 'woocommerce_after_shop_loop_item', array( $yith_woocompare->obj, 'add_compare_link' ), 20 );
		/* Add compare button */
		if ( !function_exists( 'maxstoreplus_wc_loop_product_compare_btn' ) ) {
			function maxstoreplus_wc_loop_product_compare_btn()
			{
				if ( shortcode_exists( 'yith_compare_button' ) ) {
					echo do_shortcode( '[yith_compare_button product_id="' . get_the_ID() . '"]' );
				} // End if ( shortcode_exists( 'yith_compare_button' ) )
				else {
					if ( class_exists( 'YITH_Woocompare_Frontend' ) ) {
						$YITH_Woocompare_Frontend = new YITH_Woocompare_Frontend();
						echo do_shortcode( '[yith_compare_button product_id="' . get_the_ID() . '"]' );
					}
				}
			}
		}
		add_action( 'maxstoreplus_function_shop_loop_item_compare', 'maxstoreplus_wc_loop_product_compare_btn', 1 );
	}
}
/*Wishlist*/
if ( class_exists( 'YITH_WCWL' ) && get_option( 'yith_wcwl_enabled' ) == 'yes' ) {
	if ( !function_exists( 'maxstoreplus_wc_loop_product_wishlist_btn' ) ) {
		function maxstoreplus_wc_loop_product_wishlist_btn()
		{
			if ( is_user_logged_in() ) {
				if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
					echo do_shortcode( '[yith_wcwl_add_to_wishlist product_id="' . get_the_ID() . '"]' );
				}
			} else {
				$html = '';
				$html .= '<div class="yith-wcwl-add-to-wishlist disabled_element">';
				$html .= '<div class="yith-wcwl-add-button show">';
				$html .= '<a href="#" class="add_to_wishlist"></a>';
				$html .= '</div>';
				$html .= '</div>';
				echo balanceTags( $html );
			}
		}
	}
	add_action( 'maxstoreplus_function_shop_loop_item_wishlist', 'maxstoreplus_wc_loop_product_wishlist_btn', 1 );
}
/* Shop control*/
if ( !function_exists( 'maxstoreplus_shop_control' ) ) {
	function maxstoreplus_shop_control()
	{
		get_template_part( 'template-parts/shop', 'control' );
	}
}
if ( !function_exists( 'maxstoreplus_shop_view_more' ) ) {
	function maxstoreplus_shop_view_more()
	{
		$shop_display_mode = maxstoreplus_get_option( 'woo_shop_list_style', 'grid' );
		if ( isset( $_SESSION['shop_display_mode'] ) ) {
			$shop_display_mode = $_SESSION['shop_display_mode'];
		}
		?>
        <ul class="display-product-option">
            <li data-mode="grid"
                class="display-mode view-as-grid <?php if ( $shop_display_mode == "grid" ): ?>selected<?php endif; ?>"></li>
            <li data-mode="list"
                class="display-mode view-as-list <?php if ( $shop_display_mode == "list" ): ?>selected<?php endif; ?>"></li>
        </ul>
		<?php
	}
}
if ( !function_exists( 'maxstoreplus_shop_banners' ) ) {
	function maxstoreplus_shop_banners()
	{
		get_template_part( 'template-parts/shop', 'banners' );
	}
}
add_filter( 'woocommerce_show_page_title', 'maxstoreplus_hide_page_title' );
/**
 * maxstoreplus_hide_page_title
 *
 * Removes the "shop" title on the main shop page
 *
 * @access      public
 * @return      void
 * @since       1.0
 */
if ( !function_exists( 'maxstoreplus_hide_page_title' ) ) {
	function maxstoreplus_hide_page_title()
	{
		return false;
	}
}
if ( !function_exists( 'maxstoreplus_woocommerce_template_loop_category_title' ) ) {
	function maxstoreplus_woocommerce_template_loop_category_title( $category )
	{
		?>
        <h3>
            <a href="<?php echo esc_url( get_term_link( $category, 'product_cat' ) ); ?>">
				<?php
				echo $category->name;
				if ( $category->count > 0 )
					echo apply_filters( 'woocommerce_subcategory_count_html', ' <span class="number-item">(' . $category->count . ' items)</span>', $category );
				?>

            </a>
        </h3>
		<?php
	}
}
if ( !function_exists( 'maxstoreplus_loop_shop_per_page' ) ) {
	function maxstoreplus_loop_shop_per_page()
	{
		$woo_products_perpage = maxstoreplus_get_option( 'woo_products_perpage', '12' );

		return $woo_products_perpage;
	}
}
if ( !function_exists( 'maxstoreplus_woof_products_query' ) ) {
	function maxstoreplus_woof_products_query( $wr )
	{
		$woo_products_perpage = maxstoreplus_get_option( 'woo_products_perpage', '12' );
		$wr['posts_per_page'] = $woo_products_perpage;

		return $wr;
	}
}
add_filter( 'woocommerce_product_tabs', 'maxstoreplus_rename_tabs', 98 );
if ( !function_exists( 'maxstoreplus_rename_tabs' ) ) {
	function maxstoreplus_rename_tabs( $tabs )
	{
		if ( isset( $tabs['additional_information'] ) && $tabs['additional_information'] ) {
			$tabs['additional_information']['title'] = esc_html__( 'Information', 'maxstoreplus' );  // Rename the additional information tab
		}

		return $tabs;
	}
}
if ( !function_exists( 'maxstoreplus_mini_cart' ) ) {
	/**
	 * Output the Mini-cart - used by cart widget.
	 *
	 * @param array $args
	 */
	function maxstoreplus_mini_cart( $args = array() )
	{
		$defaults = array(
			'list_class' => '',
		);
		$args     = wp_parse_args( $args, $defaults );
		wc_get_template( 'cart/mini-cart.php', $args );
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'maxstoreplus_header_add_to_cart_fragment' );
if ( !function_exists( 'maxstoreplus_header_add_to_cart_fragment' ) ) {
	function maxstoreplus_header_add_to_cart_fragment( $fragments )
	{
		ob_start();
		maxstoreplus_mini_cart();
		$fragments['div.header-cart'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_get_image_size_gallery_thumbnail', 'maxstoreplus_woocommerce_get_image_size_gallery_thumbnail' );
if ( !function_exists( 'maxstoreplus_woocommerce_get_image_size_gallery_thumbnail' ) ) {
	function maxstoreplus_woocommerce_get_image_size_gallery_thumbnail( $size )
	{
		$size['width']  = 145;
		$size['height'] = 160;
		$size['crop']   = 1;

		return $size;
	}
}
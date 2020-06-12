<?php

/**
 * Customize css for maxstoreplus theme
 **/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !function_exists( 'maxstoreplus_get_custom_css' ) ) {
    function maxstoreplus_get_custom_css() {
        $opt_general_accent_color = maxstoreplus_get_option('opt_general_accent_color',array( 'color' => '#4c6689', 'alpha' => 1 ));
        
        $base_color = isset( $opt_general_accent_color ) ? $opt_general_accent_color : array( 'color' => '#4c6689', 'alpha' => 1 );
        $root_base_color = $base_color['color'];
        if ( !isset( $base_color['alpha'] ) ) {
            $base_color['alpha'] = 1;
        }
        $base_color = maxstoreplus_color_hex2rgba( $base_color['color'], $base_color['alpha'] );
        $css = '';
        $css .= '
            a:hover,
            a:focus,
            .star-rating,
            .footer .copyright a,
            .widget-connect .social-f li:hover a,
            .shopcart-switch .shopcart-description .subtotal .price,
            .shopcart-switch .shopcart-description .minicart-items-wrapper .product-item .product-details .product-name span,
            .blog-item .post-title:hover,
            .blog-item .post-readmore,
            .block-banner.layout3 .inner-banner .title-banner,
            .block-icon > a,
            .block-icon .icon-text a:hover,
            .block-banner.layout4 .title-banner,
            .block-banner.layout7 .des-banner-top,
            .block-banner.layout9 .inner-banner .title-banner,
            .block-banner.layout10 .inner-banner .des-banner,
            .block-banner.layout11 .inner-banner .des-banner,
            .footer-style-6 .widget_nav_menu .menu .menu-item:hover,
            .main-menu .primary-menu > .menu-item.show-submenu > a,
            .main-menu .primary-menu > .menu-item.show-submenu > .caret,
            .search-bar .search-button:hover,
            .search-bar .search-bar-form span button:hover,
            footer.footer.footer-style-2 .widget-connect .social-f li:hover a,
            .blog-item .meta-post li a:hover i,
            .blog-item .meta-post .like .sl-loader span::before,
            .product .product-thumb .product-button .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover,
            .product .product-thumb .product-button .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover,
            .product .product-thumb .product-button .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover,
            .product .product-thumb .product-button .compare-button .compare:hover,
            .product .info-product .add-to-cart:hover,
            .product .info-product .added_to_cart:hover,
            .content-product-style-4 .info-product .price ins,
            .ms-loadmore .ms-button-loadmore:hover,
            .header-style-2 .header-menu .main-menu .primary-menu .menu-item > a:hover,
            .header-style-2 .header-menu .main-menu .primary-menu .menu-item > .caret:hover,
            .header-style-2 .header-menu .main-menu .primary-menu .menu-item .sub-menu .menu-item > a:hover,
            .header-style-3 .header-top .shopcart-switch .shopcart-icon:hover .cart-count,
            .header-style-3 .header-top .shopcart-switch .shopcart-icon:hover::after,
            .fixed-menu-header.dark-header .main-menu .primary-menu > .menu-item.show-submenu > a,
            .fixed-menu-header.dark-header .main-menu .primary-menu > .menu-item.show-submenu > .caret,
            .entry-summary .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover,
            .entry-summary a.compare:hover,
            .entry-summary a.share-email:hover,
            .entry-summary .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover,
            .entry-summary .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover,
            #tab-reviews #review_form_wrapper .comment-form .comment-form-rating .stars a:hover,
            .search-bar .search-content .close-touch:hover,
            #yith-quick-view-close:hover,
            .shopcart-description .load i,
            .widget_product_categories .cat-item a:hover,
            .widget_product_categories .cat-item .carets:hover,
            .widget_layered_nav .inline-group a:hover .term-name, 
            .widget_layered_nav .inline-group a:hover .count,
            .widget_layered_nav .inline-group a.selected .term-name, 
            .widget_layered_nav .inline-group a.selected .count,
            .blog-comment .comments-area .comment-list .comment .comment-body .comment-content .reply:hover a,
            .blog-comment .comments-area .comment-list .comment .comment-body .comment-content .reply:hover i,
            .entry-summary a.compare:hover,
            .entry-summary a.share-email:hover,
            .search-bar .search-content .result-search .blog-item .price >span,
            .entry-summary .cart .out-of-stock,
            .blog-item.sticky .meta-post .sticky-post,
            .blog-item.sticky .meta-post .sticky-post i
            {
                color:'.$base_color.';
            }
            .newsletter-form-wrap.layout1 .form-newsletter .submit-newsletter,
            .block-banner .inner-banner .button:hover,
            input[type="submit"], input[type="button"], button, .button,
            .shopcart-switch .shopcart-icon .cart-count,
            .ms-cowntdown-deal .day:hover, 
            .ms-cowntdown-deal .hour:hover, 
            .ms-cowntdown-deal .minute:hover, 
            .ms-cowntdown-deal .second:hover,
            .block-icon.default:hover > a span,
            .product .product-thumb .product-button .price,
            .newsletter-form-wrap.layout1 .form-newsletter span .submit-newsletter,
            .owl-carousel.nav-style-2 .owl-nav .owl-prev i:hover, 
            .owl-carousel.nav-style-2 .owl-nav .owl-next i:hover,
            .tab-style-2 .tabs-link .active a::after,
            .blog-style5 .blog-item .post-format .days,
            .maxstoreplus_custommenu.layout1 .widget_nav_menu .widgettitle,
            .footer .widget_tag_cloud .tagcloud a:hover,
            .header-style-10 .header-menu,
            .block-cat.default:hover .button,
            .header-style-9 .header-categories-menu .search-bar .search-button,
            a.backtotop,
            .owl-carousel .owl-dots .owl-dot:not(.active):hover,
            .select2-container .select2-results .select2-results__option--highlighted[aria-selected],
            .block-banner.layout13 .inner-banner .button,
            .widget_product_tag_cloud .tagcloud a:hover, 
            .widget_tag_cloud .tagcloud a:hover,
            .widget_product_tag_cloud .tagcloud a.selected,
            .widget_tag_cloud .tagcloud a.selected,
            .entry-summary .cart .variation .value .attribute-pa_size .change-value:not(.active):hover,
            .product-gallery .video-box a,
            .page-links a:hover span,
.newsletter-form-wrap.processing .input-group::after,
.newsletter-form-wrap.processing .form-newsletter::after
            {
                background-color:'.$base_color.';
            }
            .ms-cowntdown-deal .day:hover, 
            .ms-cowntdown-deal .hour:hover, 
            .ms-cowntdown-deal .minute:hover, 
            .ms-cowntdown-deal .second:hover,
            .block-cat.layout1 .content-cat:hover figure,
            .maxstoreplus_custommenu.layout1 .widget_nav_menu .menu,
            .content-fomat-6 .the-time,
            .maxstoreplus_custommenu.layout1 .widget_nav_menu .menu .menu-item .sub-menu,
            .shopcart-description .minicart-items-wrapper .product-item .product-media:hover,
            .block-cat.default:hover .button,
            .entry-summary .cart .variation .value .attribute-pa_size .change-value:not(.active):hover,
            .woocommerce .woocommerce-error,
            .woocommerce .woocommerce-info,
            .woocommerce .woocommerce-message
            {
                border-color:'.$base_color.';
            }
            .block-cat.default:hover .button::before, 
            .block-cat.default:hover .button::after
            {
                border-bottom-color: '.$base_color.';
                border-top-color: '.$base_color.';
            }
            .chosen-container .chosen-drop .chosen-results .highlighted,
            .hover-button1:hover button,
            .entry-summary .cart .variation .value .attribute-pa_color .change-value:not(.active):hover
            {
                background:'.$base_color.' !important;
            }
            input[type="text"]:focus,
            input[type="number"]:focus,
            input[type="submit"]:focus,
            input[type="search"]:focus,
            input[type="email"]:focus,
            input[type="password"]:focus,
            input[type="tel"]:focus,
            textarea:focus,
            a:focus,
            button:focus,
            select:focus
            {
                outline-color:'.$base_color.';
            }
            .header-style-6 .header-menu .main-menu .primary-menu > .menu-item:first-child >a,
            .header-style-6 .header-menu .main-menu .primary-menu > .menu-item.show-submenu >a
            {
                -moz-box-shadow: 0 -2px 0 0 '.$base_color.' inset;
                -o-box-shadow: 0 -2px 0 0 '.$base_color.' inset;
                -ms-box-shadow: 0 -2px 0 0 '.$base_color.' inset;
                -webkit-box-shadow: 0 -2px 0 0 '.$base_color.' inset;
                box-shadow: 0 -2px 0 0 '.$base_color.' inset;
            }
            .header-style-9 .header-categories-menu .categories-menu .header-menu .main-menu .primary-menu > .menu-item.show-submenu > a
            {
                -moz-box-shadow: 0 -3px 0 0 '.$base_color.' inset;
                -o-box-shadow: 0 -3px 0 0 '.$base_color.' inset;
                -ms-box-shadow: 0 -3px 0 0 '.$base_color.' inset;
                -webkit-box-shadow: 0 -3px 0 0 '.$base_color.' inset;
                box-shadow: 0 -3px 0 0 '.$base_color.' inset;
            }
        ';
        $custom_css = isset( $maxstoreplus['opt_general_css_code'] ) ? $maxstoreplus['opt_general_css_code'] : '';

        $css .= $custom_css;

        return $css;
    }
}

if( !function_exists('maxstoreplus_footer_custom_css')){
    function maxstoreplus_footer_custom_css(){
        $opt_footer_style = maxstoreplus_get_option('opt_footer_style','');

        $shortcodes_custom_css = get_post_meta( $opt_footer_style, '_wpb_shortcodes_custom_css', true );
        return $shortcodes_custom_css;
    }
}

if ( !function_exists( 'maxstoreplus_custom_css' ) ) {
    function maxstoreplus_custom_css() {

        $css  = maxstoreplus_get_custom_css();
        $css .= maxstoreplus_footer_custom_css();
        $css .= maxstoreplus_get_option('opt_general_css_code','');

        wp_add_inline_style( 'maxstoreplus_style', $css );
    }
}

add_action( 'wp_enqueue_scripts', 'maxstoreplus_custom_css', 99 );

if( !function_exists( 'maxstoreplus_custom_js ' )){
	function maxstoreplus_custom_js(){
		$maxstoreplus_custom_js = maxstoreplus_get_option('opt_general_js_code','');
		wp_add_inline_script( 'maxstoreplus-scripts', $maxstoreplus_custom_js);
	}
}
add_action( 'wp_enqueue_scripts', 'maxstoreplus_custom_js' );


if ( !function_exists( 'maxstoreplus_color_hex2rgba' ) ) {
    function maxstoreplus_color_hex2rgba( $hex, $alpha = 1 ) {
        $hex = str_replace( "#", "", $hex );

        if ( strlen( $hex ) == 3 ) {
            $r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
            $g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
            $b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
        }
        else {
            $r = hexdec( substr( $hex, 0, 2 ) );
            $g = hexdec( substr( $hex, 2, 2 ) );
            $b = hexdec( substr( $hex, 4, 2 ) );
        }
        $rgb = array( $r, $g, $b );

        return 'rgba( ' . implode( ', ', $rgb ) . ', ' . $alpha . ' )'; // returns the rgb values separated by commas
    }
}

if ( !function_exists( 'maxstoreplus_color_rgb2hex' ) ) {
    function maxstoreplus_color_rgb2hex( $rgb ) {
        $hex = '#';
        $hex .= str_pad( dechex( $rgb[0] ), 2, '0', STR_PAD_LEFT );
        $hex .= str_pad( dechex( $rgb[1] ), 2, '0', STR_PAD_LEFT );
        $hex .= str_pad( dechex( $rgb[2] ), 2, '0', STR_PAD_LEFT );

        return $hex; // returns the hex value including the number sign (#)
    }
}

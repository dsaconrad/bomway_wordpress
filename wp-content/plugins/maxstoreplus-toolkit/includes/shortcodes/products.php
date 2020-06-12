<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'vc_before_init', 'maxstore_products_settings' );
function maxstore_products_settings()
{
	// CUSTOM PRODUCT SIZE
	$product_size_width_list = array();
	$width                   = 300;
	$height                  = 300;
	$crop                    = 1;
	if ( function_exists( 'wc_get_image_size' ) ) {
		$size   = wc_get_image_size( 'shop_catalog' );
		$width  = isset( $size['width'] ) ? $size['width'] : $width;
		$height = isset( $size['height'] ) ? $size['height'] : $height;
		$crop   = isset( $size['crop'] ) ? $size['crop'] : $crop;
	}
	for ( $i = 100; $i < $width; $i = $i + 10 ) {
		array_push( $product_size_width_list, $i );
	}
	$product_size_list                         = array();
	$product_size_list[$width . 'x' . $height] = $width . 'x' . $height;
	foreach ( $product_size_width_list as $k => $w ) {
		$w = intval( $w );
		if ( isset( $width ) && $width > 0 ) {
			$h = round( $height * $w / $width );
		} else {
			$h = $w;
		}
		$product_size_list[$w . 'x' . $h] = $w . 'x' . $h;
	}
	$product_size_list['Custom'] = 'custom';
	$attributes_tax              = wc_get_attribute_taxonomies();
	$attributes                  = array();
	foreach ( $attributes_tax as $attribute ) {
		$attributes[$attribute->attribute_label] = $attribute->attribute_name;
	}
	$params       = array(
		array(
			'type'        => 'kt_select_preview',
			'heading'     => __( 'Layout', 'maxstoreplus-toolkit' ),
			'value'       => array(
				'default' => array(
					'alt' => __( 'Products 01', 'maxstoreplus-toolkit' ),
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'products/default.jpg',
				),
				'layout2' => array(
					'alt' => __( 'Owl products 01', 'maxstoreplus-toolkit' ),
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'products/layout2.jpg',
				),
				'layout1' => array(
					'alt' => __( 'Deal Product 01', 'maxstoreplus-toolkit' ),
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'products/layout1.jpg',
				),
				'layout3' => array(
					'alt' => __( 'Deal Product 02', 'maxstoreplus-toolkit' ),
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'products/layout3.jpg',
				),
			),
			'default'     => 'default',
			'admin_label' => true,
			'param_name'  => 'layout',
			'description' => __( 'Select a layout.', 'maxstoreplus-toolkit' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => __( 'Title', 'maxstoreplus-toolkit' ),
			'param_name'  => 'title',
			'description' => __( 'The title of shortcode', 'maxstoreplus-toolkit' ),
			'admin_label' => true,
			'std'         => '',
		),
		array(
			'type'        => 'textarea',
			'heading'     => __( 'Main Title', 'maxstoreplus-toolkit' ),
			'param_name'  => 'main_title',
			'description' => __( 'The main title of shortcode', 'maxstoreplus-toolkit' ),
			'std'         => '',
			"dependency"  => array( "element" => "layout", "value" => array( 'layout1' ) ),
		),
		array(
			'type'        => 'kt_datetimepicker',
			'heading'     => __( 'Time', 'maxstoreplus-toolkit' ),
			'param_name'  => 'time',
			'admin_label' => true,
			"dependency"  => array( "element" => "layout", "value" => array( 'layout1', 'layout3' ) ),
		),
		array(
			"type"       => "dropdown",
			"heading"    => __( "Products list style", 'maxstoreplus-toolkit' ),
			"param_name" => "productsliststyle",
			"value"      => array(
				__( 'Carousel', 'maxstoreplus-toolkit' ) => 'owl',
				__( 'grid', 'maxstoreplus-toolkit' )     => 'grid',
			),
			'std'        => 'grid',
		),
		array(
			'type'        => 'dropdown',
			'heading'     => __( 'Product image thumb size', 'maxstoreplus-toolkit' ),
			'param_name'  => 'product_image_size',
			'value'       => $product_size_list,
			'description' => __( 'Select a size for product', 'maxstoreplus-toolkit' ),
		),
		array(
			"type"       => "kt_number",
			"heading"    => __( "Width", 'maxstoreplus-toolkit' ),
			"param_name" => "product_custom_thumb_width",
			"value"      => $width,
			"suffix"     => __( "px", 'maxstoreplus-toolkit' ),
			"dependency" => array( "element" => "product_image_size", "value" => array( 'custom' ) ),
		),
		array(
			"type"       => "kt_number",
			"heading"    => __( "Height", 'maxstoreplus-toolkit' ),
			"param_name" => "product_custom_thumb_height",
			"value"      => $height,
			"suffix"     => __( "px", 'maxstoreplus-toolkit' ),
			"dependency" => array( "element" => "product_image_size", "value" => array( 'custom' ) ),
		),
		array(
			"type"        => "dropdown",
			"heading"     => __( "Products Title", 'maxstoreplus-toolkit' ),
			'description' => __( 'choose view title product.', 'maxstoreplus-toolkit' ),
			"param_name"  => "title_style",
			"value"       => array(
				__( 'In a line', 'maxstoreplus-toolkit' ) => 'all-a-line',
				__( 'Auto', 'maxstoreplus-toolkit' )      => 'resize-height',
			),
			'std'         => 'all-a-line',
		),
		array(
			"type"       => "dropdown",
			"heading"    => __( "Load More Product", 'maxstoreplus-toolkit' ),
			"param_name" => "loadmore",
			"value"      => array(
				__( 'LOAD MORE', 'maxstoreplus-toolkit' ) => 'loadmore',
				__( 'VIEW ALL', 'maxstoreplus-toolkit' )  => 'viewall',
				__( 'NONE', 'maxstoreplus-toolkit' )      => 'none',
			),
			'std'        => 'no',
			"dependency" => array( "element" => "productsliststyle", "value" => array( 'grid' ) ),
		),
		/*Products */
		array(
			'type'        => 'kt_select_preview',
			'heading'     => __( 'Layout', 'maxstoreplus-toolkit' ),
			'value'       => array(
				'content-product-style-1' => array(
					'alt' => __( 'Product Style 01', 'maxstoreplus-toolkit' ),
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'products/style/style1.jpg',
				),
				'content-product-style-2' => array(
					'alt' => __( 'Product Style 02', 'maxstoreplus-toolkit' ),
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'products/style/style2.jpg',
				),
				'content-product-style-3' => array(
					'alt' => __( 'Product Style 03', 'maxstoreplus-toolkit' ),
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'products/style/style3.jpg',
				),
				'content-product-style-4' => array(
					'alt' => __( 'Product Style 04', 'maxstoreplus-toolkit' ),
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'products/style/style4.jpg',
				),
				'content-product-style-5' => array(
					'alt' => __( 'Product Style 05', 'maxstoreplus-toolkit' ),
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'products/style/style5.jpg',
				),
				'content-product-style-6' => array(
					'alt' => __( 'Product Style 06', 'maxstoreplus-toolkit' ),
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'products/style/style6.jpg',
				),
			),
			'default'     => 'default',
			'admin_label' => true,
			'param_name'  => 'style_product',
			'description' => __( 'Select a style.', 'maxstoreplus-toolkit' ),
			'group'       => esc_html__( 'Products options', 'maxstoreplus-toolkit' ),
		),
		array(
			"type"        => "kt_taxonomy",
			"taxonomy"    => "product_cat",
			"class"       => "",
			"heading"     => __( "Category", 'maxstoreplus-toolkit' ),
			"param_name"  => "taxonomy",
			"value"       => '',
			'parent'      => '',
			'multiple'    => true,
			'hide_empty'  => false,
			'placeholder' => __( 'Choose category', 'maxstoreplus-toolkit' ),
			"description" => __( "Note: If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'maxstoreplus-toolkit' ),
			'std'         => '',
			'group'       => esc_html__( 'Products options', 'maxstoreplus-toolkit' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => __( 'Target', 'maxstoreplus-toolkit' ),
			'param_name'  => 'target',
			'value'       => array(
				__( 'Best Selling Products', 'maxstoreplus-toolkit' ) => 'best-selling',
				__( 'Top Rated Products', 'maxstoreplus-toolkit' )    => 'top-rated',
				__( 'Recent Products', 'maxstoreplus-toolkit' )       => 'recent-product',
				__( 'Product Category', 'maxstoreplus-toolkit' )      => 'product-category',
				__( 'Products', 'maxstoreplus-toolkit' )              => 'products',
				__( 'Featured Products', 'maxstoreplus-toolkit' )     => 'featured_products',
				__( 'On Sale', 'maxstoreplus-toolkit' )               => 'on_sale',
			),
			'description' => __( 'Choose the target to filter products', 'maxstoreplus-toolkit' ),
			'std'         => 'recent-product',
			'group'       => esc_html__( 'Products options', 'maxstoreplus-toolkit' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => __( 'Attribute', 'maxstoreplus-toolkit' ),
			'param_name'  => 'attribute',
			'value'       => $attributes,
			'save_always' => true,
			'description' => __( 'List of product taxonomy attribute', 'maxstoreplus-toolkit' ),
			"dependency"  => array( "element" => "target", "value" => array( 'product_attribute' ) ),
			'group'       => esc_html__( 'Products options', 'maxstoreplus-toolkit' ),
		),
		array(
			"type"        => "dropdown",
			"heading"     => __( "Order by", 'maxstoreplus-toolkit' ),
			"param_name"  => "orderby",
			"value"       => array(
				'',
				__( 'Date', 'maxstoreplus-toolkit' )          => 'date',
				__( 'ID', 'maxstoreplus-toolkit' )            => 'ID',
				__( 'Author', 'maxstoreplus-toolkit' )        => 'author',
				__( 'Title', 'maxstoreplus-toolkit' )         => 'title',
				__( 'Modified', 'maxstoreplus-toolkit' )      => 'modified',
				__( 'Random', 'maxstoreplus-toolkit' )        => 'rand',
				__( 'Comment count', 'maxstoreplus-toolkit' ) => 'comment_count',
				__( 'Menu order', 'maxstoreplus-toolkit' )    => 'menu_order',
				__( 'Sale price', 'maxstoreplus-toolkit' )    => '_sale_price',
			),
			'std'         => 'date',
			"description" => __( "Select how to sort retrieved posts.", 'maxstoreplus-toolkit' ),
			"dependency"  => array( "element" => "target", "value" => array( 'top-rated', 'recent-product', 'product-category', 'featured_products', 'on_sale', 'product_attribute' ) ),
			'group'       => esc_html__( 'Products options', 'maxstoreplus-toolkit' ),
		),
		array(
			"type"        => "dropdown",
			"heading"     => __( "Order", 'maxstoreplus-toolkit' ),
			"param_name"  => "order",
			"value"       => array(
				__( 'ASC', 'maxstoreplus-toolkit' )  => 'ASC',
				__( 'DESC', 'maxstoreplus-toolkit' ) => 'DESC',
			),
			'std'         => 'DESC',
			"description" => __( "Designates the ascending or descending order.", 'maxstoreplus-toolkit' ),
			"dependency"  => array( "element" => "target", "value" => array( 'top-rated', 'recent-product', 'product-category', 'featured_products', 'on_sale', 'product_attribute' ) ),
			'group'       => esc_html__( 'Products options', 'maxstoreplus-toolkit' ),
		),
		array(
			'type'       => 'kt_number',
			'heading'    => __( 'Max item', 'maxstoreplus-toolkit' ),
			'param_name' => 'per_page',
			'value'      => 6,
			"dependency" => array( "element" => "target", "value" => array( 'best-selling', 'top-rated', 'recent-product', 'product-category', 'featured_products', 'product_attribute', 'on_sale' ) ),
			'group'      => esc_html__( 'Products options', 'maxstoreplus-toolkit' ),
		),
		array(
			'type'        => 'autocomplete',
			'heading'     => __( 'Products', 'maxstoreplus-toolkit' ),
			'param_name'  => 'ids',
			'settings'    => array(
				'multiple'      => true,
				'sortable'      => true,
				'unique_values' => true,
			),
			'save_always' => true,
			'description' => __( 'Enter List of Products', 'maxstoreplus-toolkit' ),
			"dependency"  => array( "element" => "target", "value" => array( 'products' ) ),
			'group'       => esc_html__( 'Products options', 'maxstoreplus-toolkit' ),
		),
		/* OWL Settings */
		array(
			'type'        => 'dropdown',
			'value'       => array(
				__( '1 Row', 'maxstoreplus-toolkit' )  => '1',
				__( '2 Rows', 'maxstoreplus-toolkit' ) => '2',
				__( '3 Rows', 'maxstoreplus-toolkit' ) => '3',
				__( '4 Rows', 'maxstoreplus-toolkit' ) => '4',
				__( '5 Rows', 'maxstoreplus-toolkit' ) => '5',
			),
			'std'         => '1',
			'heading'     => __( 'The number of rows which are shown on block', 'maxstoreplus-toolkit' ),
			'param_name'  => 'owl_number_row',
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
			"dependency"  => array(
				"element" => "productsliststyle", "value" => array( 'owl' ),
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => __( 'Rows space', 'maxstoreplus-toolkit' ),
			'param_name' => 'owl_rows_space',
			'value'      => array(
				__( 'Default', 'maxstoreplus-toolkit' ) => 'rows-space-0',
				__( '10px', 'maxstoreplus-toolkit' )    => 'rows-space-10',
				__( '20px', 'maxstoreplus-toolkit' )    => 'rows-space-20',
				__( '30px', 'maxstoreplus-toolkit' )    => 'rows-space-30',
				__( '40px', 'maxstoreplus-toolkit' )    => 'rows-space-40',
				__( '50px', 'maxstoreplus-toolkit' )    => 'rows-space-50',
				__( '60px', 'maxstoreplus-toolkit' )    => 'rows-space-60',
				__( '70px', 'maxstoreplus-toolkit' )    => 'rows-space-70',
				__( '80px', 'maxstoreplus-toolkit' )    => 'rows-space-80',
				__( '90px', 'maxstoreplus-toolkit' )    => 'rows-space-90',
				__( '100px', 'maxstoreplus-toolkit' )   => 'rows-space-100',
			),
			'std'        => 'rows-space-0',
			'group'      => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			"dependency" => array( "element" => "owl_number_row", "value" => array( '2', '3', '4', '5' ) ),
		),
		array(
			'type'        => 'dropdown',
			'value'       => array(
				__( 'Yes', 'maxstoreplus-toolkit' ) => 'true',
				__( 'No', 'maxstoreplus-toolkit' )  => 'false',
			),
			'std'         => 'false',
			'heading'     => __( 'AutoPlay', 'maxstoreplus-toolkit' ),
			'param_name'  => 'owl_autoplay',
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
			"dependency"  => array(
				"element" => "productsliststyle", "value" => array( 'owl' ),
			),
		),
		array(
			'type'        => 'dropdown',
			'value'       => array(
				__( 'No', 'maxstoreplus-toolkit' )  => 'false',
				__( 'Yes', 'maxstoreplus-toolkit' ) => 'true',
			),
			'std'         => false,
			'heading'     => __( 'Navigation', 'maxstoreplus-toolkit' ),
			'param_name'  => 'owl_navigation',
			'description' => __( "Show buton 'next' and 'prev' buttons.", 'maxstoreplus-toolkit' ),
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			"dependency"  => array(
				"element" => "productsliststyle", "value" => array( 'owl' ),
			),
			'admin_label' => false,
		),
		array(
			'type'        => 'dropdown',
			'value'       => array(
				__( 'Style 01', 'maxstoreplus-toolkit' ) => 'nav-style-1',
				__( 'Style 02', 'maxstoreplus-toolkit' ) => 'nav-style-2',
			),
			'std'         => 'nav-style-1',
			'heading'     => __( 'Nav Style', 'maxstoreplus-toolkit' ),
			'param_name'  => 'nav_style',
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
			"dependency"  => array(
				"element" => "owl_navigation", "value" => array( 'true' ),
			),
		),
		array(
			'type'        => 'dropdown',
			'value'       => array(
				__( 'No', 'maxstoreplus-toolkit' )  => 'false',
				__( 'Yes', 'maxstoreplus-toolkit' ) => 'true',
			),
			'std'         => false,
			'heading'     => __( 'Dots', 'maxstoreplus-toolkit' ),
			'param_name'  => 'owl_dots',
			'description' => __( "Show dots.", 'maxstoreplus-toolkit' ),
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			"dependency"  => array(
				"element" => "productsliststyle", "value" => array( 'owl' ),
			),
			'admin_label' => false,
		),
		array(
			'type'        => 'dropdown',
			'value'       => array(
				__( 'Yes', 'maxstoreplus-toolkit' ) => 'true',
				__( 'No', 'maxstoreplus-toolkit' )  => 'false',
			),
			'std'         => false,
			'heading'     => __( 'Loop', 'maxstoreplus-toolkit' ),
			'param_name'  => 'owl_loop',
			'description' => __( "Inifnity loop. Duplicate last and first items to get loop illusion.", 'maxstoreplus-toolkit' ),
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
			"dependency"  => array(
				"element" => "productsliststyle", "value" => array( 'owl' ),
			),
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "Slide Speed", 'maxstoreplus-toolkit' ),
			"param_name"  => "owl_slidespeed",
			"value"       => "200",
			"suffix"      => __( "milliseconds", 'maxstoreplus-toolkit' ),
			"description" => __( 'Slide speed in milliseconds', 'maxstoreplus-toolkit' ),
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
			"dependency"  => array(
				"element" => "productsliststyle", "value" => array( 'owl' ),
			),
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "Margin", 'maxstoreplus-toolkit' ),
			"param_name"  => "owl_margin",
			"value"       => "0",
			"description" => __( 'Distance( or space) between 2 item', 'maxstoreplus-toolkit' ),
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
			"dependency"  => array(
				"element" => "productsliststyle", "value" => array( 'owl' ),
			),
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "The items on desktop (Screen resolution of device >= 1400px )", 'maxstoreplus-toolkit' ),
			"param_name"  => "owl_bg_items",
			"value"       => "4",
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
			"dependency"  => array(
				"element" => "productsliststyle", "value" => array( 'owl' ),
			),
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "The items on desktop (Screen resolution of device >= 1200px )", 'maxstoreplus-toolkit' ),
			"param_name"  => "owl_lg_items",
			"value"       => "4",
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
			"dependency"  => array(
				"element" => "productsliststyle", "value" => array( 'owl' ),
			),
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "The items on desktop (Screen resolution of device >= 992px < 1200px )", 'maxstoreplus-toolkit' ),
			"param_name"  => "owl_md_items",
			"value"       => "3",
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
			"dependency"  => array(
				"element" => "productsliststyle", "value" => array( 'owl' ),
			),
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "The items on tablet (Screen resolution of device >=768px and < 992px )", 'maxstoreplus-toolkit' ),
			"param_name"  => "owl_sm_items",
			"value"       => "3",
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
			"dependency"  => array(
				"element" => "productsliststyle", "value" => array( 'owl' ),
			),
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "The items on mobile landscape(Screen resolution of device >=480px and < 768px)", 'maxstoreplus-toolkit' ),
			"param_name"  => "owl_xs_items",
			"value"       => "2",
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
			"dependency"  => array(
				"element" => "productsliststyle", "value" => array( 'owl' ),
			),
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "The items on mobile (Screen resolution of device < 480px)", 'maxstoreplus-toolkit' ),
			"param_name"  => "owl_ts_items",
			"value"       => "1",
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
			"dependency"  => array(
				"element" => "productsliststyle", "value" => array( 'owl' ),
			),
		),
		/* Bostrap setting */
		array(
			'type'       => 'dropdown',
			'heading'    => __( 'Rows space', 'maxstoreplus-toolkit' ),
			'param_name' => 'boostrap_rows_space',
			'value'      => array(
				__( 'Default', 'maxstoreplus-toolkit' ) => 'rows-space-0',
				__( '10px', 'maxstoreplus-toolkit' )    => 'rows-space-10',
				__( '20px', 'maxstoreplus-toolkit' )    => 'rows-space-20',
				__( '30px', 'maxstoreplus-toolkit' )    => 'rows-space-30',
				__( '40px', 'maxstoreplus-toolkit' )    => 'rows-space-40',
				__( '50px', 'maxstoreplus-toolkit' )    => 'rows-space-50',
				__( '60px', 'maxstoreplus-toolkit' )    => 'rows-space-60',
				__( '70px', 'maxstoreplus-toolkit' )    => 'rows-space-70',
				__( '80px', 'maxstoreplus-toolkit' )    => 'rows-space-80',
				__( '90px', 'maxstoreplus-toolkit' )    => 'rows-space-90',
				__( '100px', 'maxstoreplus-toolkit' )   => 'rows-space-100',
			),
			'std'        => 'rows-space-0',
			'group'      => __( 'Boostrap settings', 'maxstoreplus-toolkit' ),
			"dependency" => array(
				"element" => "productsliststyle", "value" => array( 'grid' ),
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => __( 'Items per row on Desktop', 'maxstoreplus-toolkit' ),
			'param_name'  => 'boostrap_lg_items',
			'value'       => array(
				__( '1 item', 'maxstoreplus-toolkit' )  => '12',
				__( '2 items', 'maxstoreplus-toolkit' ) => '6',
				__( '3 items', 'maxstoreplus-toolkit' ) => '4',
				__( '4 items', 'maxstoreplus-toolkit' ) => '3',
				__( '5 items', 'maxstoreplus-toolkit' ) => '15',
				__( '6 items', 'maxstoreplus-toolkit' ) => '2',
			),
			'description' => __( '(Item per row on screen resolution of device >= 1200px )', 'maxstoreplus-toolkit' ),
			'group'       => __( 'Boostrap settings', 'maxstoreplus-toolkit' ),
			'std'         => '15',
			"dependency"  => array(
				"element" => "productsliststyle", "value" => array( 'grid' ),
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => __( 'Items per row on landscape tablet', 'maxstoreplus-toolkit' ),
			'param_name'  => 'boostrap_md_items',
			'value'       => array(
				__( '1 item', 'maxstoreplus-toolkit' )  => '12',
				__( '2 items', 'maxstoreplus-toolkit' ) => '6',
				__( '3 items', 'maxstoreplus-toolkit' ) => '4',
				__( '4 items', 'maxstoreplus-toolkit' ) => '3',
				__( '5 items', 'maxstoreplus-toolkit' ) => '15',
				__( '6 items', 'maxstoreplus-toolkit' ) => '2',
			),
			'description' => __( '(Item per row on screen resolution of device >=992px and < 1200px )', 'maxstoreplus-toolkit' ),
			'group'       => __( 'Boostrap settings', 'maxstoreplus-toolkit' ),
			'std'         => '3',
			"dependency"  => array(
				"element" => "productsliststyle", "value" => array( 'grid' ),
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => __( 'Items per row on portrait tablet', 'maxstoreplus-toolkit' ),
			'param_name'  => 'boostrap_sm_items',
			'value'       => array(
				__( '1 item', 'maxstoreplus-toolkit' )  => '12',
				__( '2 items', 'maxstoreplus-toolkit' ) => '6',
				__( '3 items', 'maxstoreplus-toolkit' ) => '4',
				__( '4 items', 'maxstoreplus-toolkit' ) => '3',
				__( '5 items', 'maxstoreplus-toolkit' ) => '15',
				__( '6 items', 'maxstoreplus-toolkit' ) => '2',
			),
			'description' => __( '(Item per row on screen resolution of device >=768px and < 992px )', 'maxstoreplus-toolkit' ),
			'group'       => __( 'Boostrap settings', 'maxstoreplus-toolkit' ),
			'std'         => '4',
			"dependency"  => array(
				"element" => "productsliststyle", "value" => array( 'grid' ),
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => __( 'Items per row on Mobile', 'maxstoreplus-toolkit' ),
			'param_name'  => 'boostrap_xs_items',
			'value'       => array(
				__( '1 item', 'maxstoreplus-toolkit' )  => '12',
				__( '2 items', 'maxstoreplus-toolkit' ) => '6',
				__( '3 items', 'maxstoreplus-toolkit' ) => '4',
				__( '4 items', 'maxstoreplus-toolkit' ) => '3',
				__( '5 items', 'maxstoreplus-toolkit' ) => '15',
				__( '6 items', 'maxstoreplus-toolkit' ) => '2',
			),
			'description' => __( '(Item per row on screen resolution of device >=480  add < 768px )', 'maxstoreplus-toolkit' ),
			'group'       => __( 'Boostrap settings', 'maxstoreplus-toolkit' ),
			'std'         => '6',
			"dependency"  => array(
				"element" => "productsliststyle", "value" => array( 'grid' ),
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => __( 'Items per row on Mobile', 'maxstoreplus-toolkit' ),
			'param_name'  => 'boostrap_ts_items',
			'value'       => array(
				__( '1 item', 'maxstoreplus-toolkit' )  => '12',
				__( '2 items', 'maxstoreplus-toolkit' ) => '6',
				__( '3 items', 'maxstoreplus-toolkit' ) => '4',
				__( '4 items', 'maxstoreplus-toolkit' ) => '3',
				__( '5 items', 'maxstoreplus-toolkit' ) => '15',
				__( '6 items', 'maxstoreplus-toolkit' ) => '2',
			),
			'description' => __( '(Item per row on screen resolution of device < 480px)', 'maxstoreplus-toolkit' ),
			'group'       => __( 'Boostrap settings', 'maxstoreplus-toolkit' ),
			'std'         => '12',
			"dependency"  => array(
				"element" => "productsliststyle", "value" => array( 'grid' ),
			),
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "Extra class name", "corporatepro" ),
			"param_name"  => "el_class",
			"description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "corporatepro" ),
		),
		array(
			'type'       => 'css_editor',
			'heading'    => esc_html__( 'Css', 'maxstoreplus-toolkit' ),
			'param_name' => 'css',
			'group'      => esc_html__( 'Design options', 'maxstoreplus-toolkit' ),
		),
	);
	$map_settings = array(
		'name'        => esc_html__( 'Maxstore: Products', 'maxstoreplus-toolkit' ),
		'base'        => 'maxstore_products', // shortcode
		'class'       => '',
		'category'    => esc_html__( 'Maxstore Plus', 'maxstoreplus-toolkit' ),
		'description' => __( 'Display a product list.', 'maxstoreplus-toolkit' ),
		'params'      => $params,
	);
	vc_map( $map_settings );
}

function maxstore_products( $atts )
{
	$atts         = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'maxstore_products', $atts ) : $atts;
	$atts         = apply_filters( 'maxstore_atts_maxstore_woocommerce_products', $atts );
	$default_atts = array(
		'layout'                      => 'default',
		'title_style'                 => '',
		'style_product'               => 'content-product-style-1',
		'product_image_size'          => '',
		'product_custom_thumb_width'  => '',
		'product_custom_thumb_height' => '',
		'productsliststyle'           => 'grid',
		'product_style'               => 1,
		'nav_style'                   => '',
		'owl_number_row'              => 1,
		'owl_rows_space'              => 'rows-space-0',
		'owl_autoplay'                => false,
		'owl_navigation'              => false,
		'owl_dots'                    => false,
		'owl_loop'                    => false,
		'owl_slidespeed'              => 200,
		'owl_margin'                  => 0,
		'owl_bg_items'                => 4,
		'owl_lg_items'                => 4,
		'owl_md_items'                => 3,
		'owl_sm_items'                => 3,
		'owl_xs_items'                => 2,
		'owl_ts_items'                => 1,
		'boostrap_rows_space'         => 'rows-space-0',
		'boostrap_lg_items'           => 15,
		'boostrap_md_items'           => 3,
		'boostrap_sm_items'           => 4,
		'boostrap_xs_items'           => 6,
		'boostrap_ts_items'           => 12,
		'taxonomy'                    => '',
		'target'                      => 'recent-product',
		'attribute'                   => '',
		'orderby'                     => 'date',
		'order'                       => 'DESC',
		'per_page'                    => 6,
		'ids'                         => '',
		'title'                       => '',
		'subtitle'                    => '',
		'loadmore'                    => 'viewall',
		'main_title'                  => '',
		'time'                        => '',
		'css'                         => '',
		'el_class'                    => '',
	);
	$default_atts = apply_filters( 'maxstore_default_atts_maxstore_woocommerce_products', $default_atts );
	extract( shortcode_atts( $default_atts, $atts ) );
	$css_class = $el_class . ' ms-woocommerce-products ' . $layout . ' ms-content-product ' . $title_style . '';
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;
	/* Product Size */
	if ( $product_image_size ) {
		if ( $product_image_size == 'custom' ) {
			$thumb_width  = $product_custom_thumb_width;
			$thumb_height = $product_custom_thumb_height;
		} else {
			$product_image_size = explode( "x", $product_image_size );
			$thumb_width        = $product_image_size[0];
			$thumb_height       = $product_image_size[1];
		}
		if ( $thumb_width > 0 ) {
			add_filter( 'maxstoreolus_shop_pruduct_thumb_width', function () use ( $thumb_width ) { return $thumb_width; } );
		}
		if ( $thumb_height > 0 ) {
			add_filter( 'maxstoreolus_shop_pruduct_thumb_height', function () use ( $thumb_height ) { return $thumb_height; } );
		}
	}
	$products  = maxstore_getProducts( $atts );
	$new_class = '';
	if ( $style_product == 'content-product-style-5' || $style_product == 'content-product-style-6' ) {
		$new_class = 'content-product-style-3';
	}
	$product_item_class = array( 'product-item product', $style_product, $new_class );
	$product_list_class = array();
	$owl_settings       = '';
	if ( $productsliststyle == 'grid' ) {
		$product_list_class[] = 'product-list-grid row auto-clear';
		$product_item_class[] = $boostrap_rows_space;
		$product_item_class[] = 'col-lg-' . $boostrap_lg_items;
		$product_item_class[] = 'col-md-' . $boostrap_md_items;
		$product_item_class[] = 'col-sm-' . $boostrap_sm_items;
		$product_item_class[] = 'col-xs-' . $boostrap_xs_items;
		$product_item_class[] = 'col-ts-' . $boostrap_ts_items;
	}
	if ( $productsliststyle == 'owl' ) {
		$product_list_class[] = 'product-list-owl owl-carousel ' . $nav_style . '';
		$product_item_class[] = $owl_rows_space;
		$owl_settings         = maxstore_generate_carousel_data_attributes( 'owl_', $atts );
	}
	static $id = 168;
	$id++;
	$template_args = array(
		'id'             => $id,
		'atts'           => $atts,
		'css_class'      => $css_class,
		'products'       => $products,
		'owl_carousel'   => $owl_settings,
		'grid_bootstrap' => $product_item_class,
		'list_class'     => implode( " ", $product_list_class ),
		'thumb_width'    => $thumb_width,
		'thumb_height'   => $thumb_height,
	);
	ob_start();
	maxstoreplus_get_template_part( 'shortcodes/products/temp', $layout, $template_args );
	wp_reset_postdata();

	return ob_get_clean();
}

add_shortcode( 'maxstore_products', 'maxstore_products' );

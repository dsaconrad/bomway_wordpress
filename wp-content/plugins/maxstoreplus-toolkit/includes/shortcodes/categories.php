<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'vc_before_init', 'maxstoreplus_categories_settings' );
function maxstoreplus_categories_settings()
{
	$params       = array(
		array(
			'type'        => 'kt_select_preview',
			'heading'     => __( 'Layout', 'maxstoreplus-toolkit' ),
			'value'       => array(
				'default' => array(
					'alt' => 'Default',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'categories/default.jpg',
				),
				'layout1' => array(
					'alt' => 'layout1',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'categories/layout1.jpg',
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
			"type"        => "param_group",
			"heading"     => __( "Items", "corporatepro" ),
			"admin_label" => false,
			"param_name"  => "items",
			'dependency'  => array(
				'element' => 'layout',
				'value'   => 'layout1',
			),
			"params"      => array(
				array(
					"type"        => "kt_taxonomy",
					"taxonomy"    => "product_cat",
					"class"       => "",
					"heading"     => __( "Category", 'maxstoreplus-toolkit' ),
					"param_name"  => "category",
					"value"       => '',
					'parent'      => '',
					'multiple'    => false,
					'hide_empty'  => false,
					'placeholder' => __( 'Choose category', 'maxstoreplus-toolkit' ),
					"description" => __( "Note: If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'maxstoreplus-toolkit' ),
					'std'         => '',
					"admin_label" => true,
				),
				array(
					"type"        => "attach_image",
					"heading"     => __( "image icon", "maxstoreplus" ),
					"param_name"  => "bg_icon",
					"admin_label" => false,
				),
			),
		),
		array(
			"type"        => "kt_taxonomy",
			"taxonomy"    => "product_cat",
			"class"       => "",
			"heading"     => __( "Category", 'maxstoreplus-toolkit' ),
			"param_name"  => "category_slug",
			"value"       => '',
			'parent'      => '',
			'multiple'    => false,
			'hide_empty'  => false,
			'placeholder' => __( 'Choose category', 'maxstoreplus-toolkit' ),
			"description" => __( "Note: If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'maxstoreplus-toolkit' ),
			'std'         => '',
			"admin_label" => true,
			'dependency'  => array(
				'element' => 'layout',
				'value'   => 'default',
			),
		),
		array(
			"type"        => "attach_image",
			"heading"     => __( "Background", "maxstoreplus" ),
			"param_name"  => "bg_cat",
			"admin_label" => false,
			'dependency'  => array(
				'element' => 'layout',
				'value'   => 'default',
			),
		),
		array(
			'type'        => 'dropdown',
			'value'       => array(
				__( 'Up', 'maxstoreplus-toolkit' )   => 'up',
				__( 'Down', 'maxstoreplus-toolkit' ) => 'down',
			),
			'std'         => 'up',
			'heading'     => __( 'Style Show', 'maxstoreplus-toolkit' ),
			'param_name'  => 'style_show',
			'admin_label' => true,
			'dependency'  => array(
				'element' => 'layout',
				'value'   => 'default',
			),
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "Extra class name", 'maxstoreplus-toolkit' ),
			"param_name"  => "el_class",
			"description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'maxstoreplus-toolkit' ),
		),
		array(
			'type'       => 'css_editor',
			'heading'    => esc_html__( 'Css', 'maxstoreplus-toolkit' ),
			'param_name' => 'css',
			'group'      => esc_html__( 'Design options', 'maxstoreplus-toolkit' ),
		),
	);
	$map_settings = array(
		'name'        => esc_html__( 'Maxstore: categories', 'maxstoreplus-toolkit' ),
		'base'        => 'maxstoreplus_categories', // shortcode
		'class'       => '',
		'category'    => esc_html__( 'Maxstore Plus', 'maxstoreplus-toolkit' ),
		'description' => __( 'Display a categories with text.', 'maxstoreplus-toolkit' ),
		'params'      => $params,
	);
	vc_map( $map_settings );
}

function maxstoreplus_categories( $atts )
{
	$atts         = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'maxstoreplus_categories', $atts ) : $atts;
	$default_atts = array(
		'layout'        => 'default',
		'items'         => '',
		'style_show'    => '',
		'category_slug' => '',
		'title'         => '',
		'bg_cat'        => '',
		'css'           => '',
		'el_class'      => '',
	);
	extract( shortcode_atts( $default_atts, $atts ) );
	$css_class = $el_class . ' ' . $layout . '';
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;
	$template_args = array(
		'atts'      => $atts,
		'css_class' => $css_class,
	);
	ob_start();
	maxstoreplus_get_template_part( 'shortcodes/categories/temp', $layout, $template_args );

	return ob_get_clean();
}

add_shortcode( 'maxstoreplus_categories', 'maxstoreplus_categories' );

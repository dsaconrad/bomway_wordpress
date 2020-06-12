<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'vc_before_init', 'maxstoreplus_title_settings' );
function maxstoreplus_title_settings()
{
	$params       = array(
		array(
			'type'        => 'kt_select_preview',
			'heading'     => __( 'Layout', 'maxstoreplus-toolkit' ),
			'value'       => array(
				'default' => array(
					'alt' => 'Default',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'title/default.jpg',
				),
				'layout1' => array(
					'alt' => 'Layout1',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'title/layout1.jpg',
				),
				'layout2' => array(
					'alt' => 'Layout2',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'title/layout2.jpg',
				),
				'layout3' => array(
					'alt' => 'Layout3',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'title/layout3.jpg',
				),
				'layout4' => array(
					'alt' => 'Layout4',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'title/layout4.jpg',
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
			'heading'     => __( 'Description', 'maxstoreplus-toolkit' ),
			'param_name'  => 'des',
			'description' => __( 'The Description of shortcode', 'maxstoreplus-toolkit' ),
			'std'         => '',
			"dependency"  => array(
				"element" => "layout",
				"value"   => array( 'layout1', 'layout2', 'layout3', 'layout4' ),
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => __( 'Text Align', 'maxstoreplus-toolkit' ),
			'value'       => array(
				__( 'Left', 'maxstoreplus-toolkit' )   => 'left',
				__( 'Right', 'maxstoreplus-toolkit' )  => 'right',
				__( 'Center', 'maxstoreplus-toolkit' ) => 'center',
			),
			'admin_label' => true,
			'param_name'  => 'text_align',
		),
		array(
			'type'       => 'dropdown',
			'heading'    => __( 'Element tag', 'maxstoreplus-toolkit' ),
			'value'      => array(
				__( 'H1', 'maxstoreplus-toolkit' ) => 'h1',
				__( 'H2', 'maxstoreplus-toolkit' ) => 'h2',
				__( 'H3', 'maxstoreplus-toolkit' ) => 'h3',
				__( 'H4', 'maxstoreplus-toolkit' ) => 'h4',
				__( 'H5', 'maxstoreplus-toolkit' ) => 'h5',
			),
			'param_name' => 'element',
			"dependency" => array(
				"element" => "layout",
				"value"   => array( 'default' ),
			),
		),
		array(
			"type"        => "colorpicker",
			"class"       => "",
			"heading"     => __( "Color", 'maxstoreplus-toolkit' ),
			"param_name"  => "color",
			"value"       => '#333333', //Default Red color
			"description" => __( "Choose color", 'maxstoreplus-toolkit' ),
			"dependency"  => array(
				"element" => "layout",
				"value"   => array( 'default' ),
			),
		),
		array(
			'type'        => 'vc_link',
			'heading'     => __( 'URL (Link)', 'maxstoreplus-toolkit' ),
			'param_name'  => 'link',
			'description' => __( 'Add link.', 'maxstoreplus-toolkit' ),
			"dependency"  => array(
				"element" => "layout",
				"value"   => array( 'layout1', 'layout4' ),
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
		'name'        => esc_html__( 'Maxstore: title', 'maxstoreplus-toolkit' ),
		'base'        => 'maxstoreplus_title', // shortcode
		'class'       => '',
		'category'    => esc_html__( 'Maxstore Plus', 'maxstoreplus-toolkit' ),
		'description' => __( 'Display a title.', 'maxstoreplus-toolkit' ),
		'params'      => $params,
	);
	vc_map( $map_settings );
}

function maxstoreplus_title( $atts )
{
	$atts         = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'maxstoreplus_title', $atts ) : $atts;
	$default_atts = array(
		'layout'     => 'default',
		'link'       => '',
		'title'      => '',
		'text_align' => '',
		'des'        => '',
		'element'    => '',
		'color'      => '',
		'css'        => '',
		'el_class'   => '',
	);
	extract( shortcode_atts( $default_atts, $atts ) );
	$css_class = $el_class . ' ' . $layout . ' ' . $text_align . '';
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;
	$args          = array(
		'a'      => array(
			'href'  => array(),
			'title' => array(),
		),
		'br'     => array(),
		'em'     => array(),
		'strong' => array(),
	);
	$des           = wp_kses( $des, $args );
	$template_args = array(
		'atts'      => $atts,
		'css_class' => $css_class,
		'des'       => $des,
	);
	ob_start();
	maxstoreplus_get_template_part( 'shortcodes/title/temp', $layout, $template_args );

	return ob_get_clean();
}

add_shortcode( 'maxstoreplus_title', 'maxstoreplus_title' );

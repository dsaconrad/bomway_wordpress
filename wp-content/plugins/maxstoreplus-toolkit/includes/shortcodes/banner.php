<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'vc_before_init', 'maxstoreplus_banner_settings' );
function maxstoreplus_banner_settings()
{
	$params       = array(
		array(
			'type'        => 'kt_select_preview',
			'heading'     => __( 'Layout', 'maxstoreplus-toolkit' ),
			'value'       => array(
				'default'  => array(
					'alt' => 'Default',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'banner/default.jpg',
				),
				'layout1'  => array(
					'alt' => 'Layout1',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'banner/layout1.jpg',
				),
				'layout2'  => array(
					'alt' => 'Layout2',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'banner/layout2.jpg',
				),
				'layout3'  => array(
					'alt' => 'Layout3',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'banner/layout3.jpg',
				),
				'layout4'  => array(
					'alt' => 'Layout4',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'banner/layout4.jpg',
				),
				'layout5'  => array(
					'alt' => 'Layout5',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'banner/layout5.jpg',
				),
				'layout6'  => array(
					'alt' => 'Layout6',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'banner/layout6.jpg',
				),
				'layout7'  => array(
					'alt' => 'Layout7',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'banner/layout7.jpg',
				),
				'layout8'  => array(
					'alt' => 'Layout8',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'banner/layout8.jpg',
				),
				'layout9'  => array(
					'alt' => 'Layout9',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'banner/layout9.jpg',
				),
				'layout10' => array(
					'alt' => 'Layout10',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'banner/layout10.jpg',
				),
				'layout11' => array(
					'alt' => 'Layout11',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'banner/layout11.jpg',
				),
				'layout12' => array(
					'alt' => 'Layout12',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'banner/layout12.jpg',
				),
				'layout13' => array(
					'alt' => 'Layout13',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'banner/layout13.jpg',
				),
			),
			'default'     => 'default',
			'admin_label' => true,
			'param_name'  => 'layout',
			'description' => __( 'Select a layout.', 'maxstoreplus-toolkit' ),
		),
		array(
			'type'        => 'textarea',
			'heading'     => __( 'Text 01', 'maxstoreplus-toolkit' ),
			'param_name'  => 'des_top',
			'description' => __( 'The Description of shortcode', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
			'std'         => '',
			'dependency'  => array(
				'element' => 'layout',
				'value'   => array( 'layout4', 'layout7', 'layout8', 'layout9', 'layout13' ),
			),
		),
		array(
			'type'        => 'textarea',
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
			'admin_label' => false,
			'std'         => '',
		),
		array(
			'type'        => 'textfield',
			'heading'     => __( 'Price', 'maxstoreplus-toolkit' ),
			'param_name'  => 'price',
			'admin_label' => false,
			'std'         => '',
			'dependency'  => array(
				'element' => 'layout',
				'value'   => array( 'layout8' ),
			),
		),
		array(
			'type'        => 'dropdown',
			'value'       => array(
				__( 'Left', 'maxstoreplus-toolkit' )   => 'left',
				__( 'Right', 'maxstoreplus-toolkit' )  => 'right',
				__( 'Center', 'maxstoreplus-toolkit' ) => 'center',
			),
			'std'         => false,
			'heading'     => __( 'Content Align', 'maxstoreplus-toolkit' ),
			'param_name'  => 'content_align',
			'admin_label' => false,
			'dependency'  => array(
				'element' => 'layout',
				'value'   => array( 'layout3' ),
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => __( 'Feature', 'maxstoreplus-toolkit' ),
			'param_name'  => 'feature',
			'description' => __( 'The title of shortcode', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
			'std'         => '',
			'dependency'  => array(
				'element' => 'layout',
				'value'   => array( 'layout2' ),
			),
		),
		array(
			"type"        => "attach_image",
			"heading"     => __( "Background", 'maxstoreplus-toolkit' ),
			"param_name"  => "bg_banner",
			"admin_label" => false,
		),
		array(
			"type"       => "kt_number",
			"heading"    => __( "Width", 'maxstoreplus-toolkit' ),
			"param_name" => "width",
			"value"      => '',
			"suffix"     => __( "px", 'maxstoreplus-toolkit' ),
			'dependency' => array(
				'element' => 'layout',
				'value'   => array( 'default', 'layout1', 'layout2', 'layout3', 'layout5', 'layout6', 'layout9', 'layout10', 'layout11', 'layout12', 'layout13' ),
			),
		),
		array(
			"type"       => "kt_number",
			"heading"    => __( "Height", 'maxstoreplus-toolkit' ),
			"param_name" => "height",
			"value"      => '',
			"suffix"     => __( "px", 'maxstoreplus-toolkit' ),
			'dependency' => array(
				'element' => 'layout',
				'value'   => array( 'default', 'layout1', 'layout2', 'layout3', 'layout5', 'layout6', 'layout9', 'layout10', 'layout11', 'layout12', 'layout13' ),
			),
		),
		array(
			'type'        => 'vc_link',
			'heading'     => __( 'URL (Link)', 'maxstoreplus-toolkit' ),
			'param_name'  => 'link',
			'description' => __( 'Add link.', 'maxstoreplus-toolkit' ),
		),
		array(
			'type'        => 'dropdown',
			'value'       => array(
				__( 'Default', 'maxstoreplus-toolkit' )          => 'default-effect',
				__( 'Plus Zoom', 'maxstoreplus-toolkit' )        => 'plus-zoom',
				__( 'Corners Zoom', 'maxstoreplus-toolkit' )     => 'corner-zoom',
				__( 'Underline Center', 'maxstoreplus-toolkit' ) => 'underline-center',
				__( 'Rectangle In', 'maxstoreplus-toolkit' )     => 'rectangle-in',
				__( 'Collision', 'maxstoreplus-toolkit' )        => 'collision',
				__( 'Shine Swipe', 'maxstoreplus-toolkit' )      => 'shine-swipe',
				__( 'Smoosh', 'maxstoreplus-toolkit' )           => 'smoosh',
				__( 'Diagonal Close', 'maxstoreplus-toolkit' )   => 'diagonal-close',
				__( 'Swipe', 'maxstoreplus-toolkit' )            => 'swipe',
				__( 'Diagonal Swipe', 'maxstoreplus-toolkit' )   => 'diagonal-swipe',
			),
			'std'         => 'default-effect',
			'heading'     => __( 'Hover Style', 'maxstoreplus-toolkit' ),
			'param_name'  => 'hove_style',
			'admin_label' => true,
			'dependency'  => array(
				'element' => 'layout',
				'value'   => array( 'default', 'layout1', 'layout2', 'layout3', 'layout4', 'layout5', 'layout6', 'layout9', 'layout10', 'layout11', 'layout12' ),
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
		'name'        => esc_html__( 'Maxstore: Banner', 'maxstoreplus-toolkit' ),
		'base'        => 'maxstoreplus_banner', // shortcode
		'category'    => esc_html__( 'Maxstore Plus', 'maxstoreplus-toolkit' ),
		'description' => __( 'Display a banner.', 'maxstoreplus-toolkit' ),
		'params'      => $params,
	);
	vc_map( $map_settings );
}

function maxstoreplus_banner( $atts )
{
	$atts         = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'maxstoreplus_banner', $atts ) : $atts;
	$default_atts = array(
		'layout'        => 'default',
		'hove_style'    => 'default',
		'price'         => '',
		'des_top'       => '',
		'content_align' => '',
		'bg_banner'     => '',
		'feature'       => '',
		'width'         => '',
		'height'        => '',
		'title'         => '',
		'des'           => '',
		'link'          => '',
		'css'           => '',
		'el_class'      => '',
	);
	extract( shortcode_atts( $default_atts, $atts ) );
	$css_class = $el_class . ' ' . $layout . ' ' . $content_align . ' ' . $hove_style;
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
	$title         = wp_kses( $title, $args );
	$template_args = array(
		'atts'      => $atts,
		'css_class' => $css_class,
		'des'       => $des,
		'title'     => $title,
	);
	ob_start();
	maxstoreplus_get_template_part( 'shortcodes/banner/temp', $layout, $template_args );

	return ob_get_clean();
}

add_shortcode( 'maxstoreplus_banner', 'maxstoreplus_banner' );

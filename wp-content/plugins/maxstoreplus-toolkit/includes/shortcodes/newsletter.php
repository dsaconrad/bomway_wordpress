<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'vc_before_init', 'maxstoreplus_newsletter_settings' );
function maxstoreplus_newsletter_settings()
{
	$params = array(
		'layout' => array(
			'type'        => 'kt_select_preview',
			'heading'     => __( 'Layout', 'maxstoreplus-toolkit' ),
			'value'       => array(
				'default' => array(
					'alt' => 'Default',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'newsletter/default.jpg',
				),
				'layout1' => array(
					'alt' => 'layout1',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'newsletter/layout1.jpg',
				),
				'layout2' => array(
					'alt' => 'layout2',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'newsletter/layout2.jpg',
				),
				'layout3' => array(
					'alt' => 'layout3',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'newsletter/layout3.jpg',
				),
				'layout4' => array(
					'alt' => 'layout4',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'newsletter/layout4.jpg',
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
			'std'         => 'SIGN UP NOW',
		),
		array(
			'type'        => 'textarea',
			'heading'     => __( 'Description', 'maxstoreplus-toolkit' ),
			'param_name'  => 'description',
			'description' => __( 'The description of shortcode', 'maxstoreplus-toolkit' ),
			'admin_label' => true,
			'std'         => 'Get 25% off on your first purchase and get more news & promotions from us.',
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "Placeholder text", 'maxstoreplus-toolkit' ),
			"param_name"  => "placeholder_text",
			"admin_label" => false,
			'std'         => 'Email address here',
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "Button text", 'maxstoreplus-toolkit' ),
			"param_name"  => "button_text",
			"admin_label" => false,
			'std'         => 'Submit',
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
		'name'        => esc_html__( 'Maxstore: Newsletter', 'maxstoreplus-toolkit' ),
		'base'        => 'maxstoreplus_newsletter', // shortcode
		'class'       => '',
		'category'    => esc_html__( 'Maxstore Plus', 'maxstoreplus-toolkit' ),
		'description' => __( 'Display a newsletter form.', 'maxstoreplus-toolkit' ),
		'params'      => $params,
	);
	vc_map( $map_settings );
}

function maxstoreplus_newsletter( $atts )
{
	$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'maxstoreplus_newsletter', $atts ) : $atts;
	$default_atts = array(
		'layout'           => 'default',
		'placeholder_text' => 'Email address here',
		'placeholder_name' => '',
		'button_text'      => 'Submit',
		'title'            => '',
		'bg_newsletter'    => '',
		'email_des'        => '',
		'description'      => '',
		'css'              => '',
		'el_class'         => '',
	);
	extract( shortcode_atts( $default_atts, $atts ) );
	$css_class = $el_class . ' maxstoreplus-newsletter ' . $layout;
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;
	$args        = array(
		'a'      => array(
			'href'  => array(),
			'title' => array(),
		),
		'br'     => array(),
		'em'     => array(),
		'strong' => array(),
	);
	$description = wp_kses( $description, $args );
	$template_args = array(
		'atts'        => $atts,
		'css_class'   => $css_class,
		'description' => $description,
	);
	ob_start();
	maxstoreplus_get_template_part( 'shortcodes/newsletter/temp', $layout, $template_args );

	return ob_get_clean();
}

add_shortcode( 'maxstoreplus_newsletter', 'maxstoreplus_newsletter' );

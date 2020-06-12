<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'vc_before_init', 'maxstore_social_settings' );
function maxstore_social_settings()
{
	$socials     = array();
	$all_socials = maxstore_get_all_social();
	if ( $all_socials ) {
		foreach ( $all_socials as $key => $social )
			$socials[$social['name']] = $key;
	}
	$params       = array(
		array(
			'type'        => 'kt_select_preview',
			'heading'     => __( 'Layout', 'maxstoreplus-toolkit' ),
			'value'       => array(
				'default' => array(
					'alt' => 'Default',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'socials/default.jpg',
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
			'type'       => 'checkbox',
			'heading'    => __( 'Display on', 'maxstoreplus-toolkit' ),
			'param_name' => 'use_socials',
			'class'      => 'checkbox-display-block',
			'value'      => $socials,
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "Extra class name", "trueshop" ),
			"param_name"  => "el_class",
			"description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "trueshop" ),
		),
		array(
			'type'       => 'css_editor',
			'heading'    => esc_html__( 'Css', 'maxstoreplus-toolkit' ),
			'param_name' => 'css',
			'group'      => esc_html__( 'Design options', 'maxstoreplus-toolkit' ),
		),
	);
	$map_settings = array(
		'name'        => esc_html__( 'Maxstore: Socials', 'maxstoreplus-toolkit' ),
		'base'        => 'maxstore_social', // shortcode
		'class'       => '',
		'category'    => esc_html__( 'Maxstore Plus', 'maxstoreplus-toolkit' ),
		'description' => __( 'Display a social list.', 'maxstoreplus-toolkit' ),
		'params'      => $params,
	);
	vc_map( $map_settings );
}

function maxstore_social( $atts )
{
	$atts         = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'maxstore_social', $atts ) : $atts;
	$default_atts = array(
		'layout'      => 'default',
		'use_socials' => '',
		'title'       => '',
		'css'         => '',
		'el_class'    => '',
	);
	extract( shortcode_atts( $default_atts, $atts ) );
	$css_class = $el_class . ' socials ' . $layout . '';
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;
	$socials       = explode( ',', $use_socials );
	$template_args = array(
		'atts'      => $atts,
		'css_class' => $css_class,
		'socials'   => $socials,
	);
	ob_start();
	maxstoreplus_get_template_part( 'shortcodes/socials/temp', $layout, $template_args );

	return ob_get_clean();
}

add_shortcode( 'maxstore_social', 'maxstore_social' );

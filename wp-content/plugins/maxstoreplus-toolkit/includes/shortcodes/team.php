<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'vc_before_init', 'maxstoreplus_team_settings' );
function maxstoreplus_team_settings()
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
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'team/default.jpg',
				),
				'layout1' => array(
					'alt' => 'Layout1',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'team/layout1.jpg',
				),
			),
			'default'     => 'default',
			'admin_label' => true,
			'param_name'  => 'layout',
			'description' => __( 'Select a layout.', 'maxstoreplus-toolkit' ),
		),
		array(
			"type"        => "param_group",
			"heading"     => __( "Items Slide", "maxstoreplus" ),
			"admin_label" => false,
			"param_name"  => "items_layout1",
			'dependency'  => array(
				'element' => 'layout',
				'value'   => array( 'layout1' ),
			),
			"params"      => array(
				array(
					"type"        => "attach_image",
					"heading"     => __( "Image", "maxstoreplus" ),
					"param_name"  => "bg_img",
					"admin_label" => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => __( 'Name', 'maxstoreplus-toolkit' ),
					'param_name'  => 'name',
					'admin_label' => true,
					'std'         => '',
				),
				array(
					'type'        => 'textfield',
					'heading'     => __( 'Position', 'maxstoreplus-toolkit' ),
					'param_name'  => 'position',
					'admin_label' => true,
					'std'         => '',
				),
				array(
					'type'        => 'textarea',
					'heading'     => __( 'Description', 'maxstoreplus-toolkit' ),
					'param_name'  => 'des',
					'admin_label' => false,
					'std'         => '',
				),
				array(
					'type'        => 'vc_link',
					'heading'     => __( 'URL (Link)', 'maxstoreplus-toolkit' ),
					'param_name'  => 'link',
					'description' => __( 'Add link.', 'maxstoreplus-toolkit' ),
				),
			),
		),
		array(
			"type"        => "param_group",
			"heading"     => __( "Items Slide", "maxstoreplus" ),
			"admin_label" => false,
			"param_name"  => "items",
			'dependency'  => array(
				'element' => 'layout',
				'value'   => array( 'default' ),
			),
			"params"      => array(
				array(
					"type"        => "attach_image",
					"heading"     => __( "Image", "maxstoreplus" ),
					"param_name"  => "bg_img",
					"admin_label" => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => __( 'Name', 'maxstoreplus-toolkit' ),
					'param_name'  => 'name',
					'admin_label' => true,
					'std'         => '',
				),
				array(
					'type'        => 'textfield',
					'heading'     => __( 'Position', 'maxstoreplus-toolkit' ),
					'param_name'  => 'position',
					'admin_label' => true,
					'std'         => '',
				),
				array(
					'type'        => 'vc_link',
					'heading'     => __( 'URL (Link)', 'maxstoreplus-toolkit' ),
					'param_name'  => 'link',
					'description' => __( 'Add link.', 'maxstoreplus-toolkit' ),
				),
				array(
					'type'       => 'checkbox',
					'heading'    => __( 'Display on', 'maxstoreplus-toolkit' ),
					'param_name' => 'use_socials',
					'class'      => 'checkbox-display-block',
					'value'      => $socials,
				),
			),
		),
		/* OWL Settings */
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
			'admin_label' => false,
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
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "Slide Speed", 'maxstoreplus-toolkit' ),
			"param_name"  => "owl_slidespeed",
			"value"       => "1000",
			"suffix"      => __( "milliseconds", 'maxstoreplus-toolkit' ),
			"description" => __( 'Slide speed in milliseconds', 'maxstoreplus-toolkit' ),
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "Margin", 'maxstoreplus-toolkit' ),
			"param_name"  => "owl_margin",
			"value"       => "0",
			"description" => __( 'Distance( or space) between 2 item', 'maxstoreplus-toolkit' ),
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "The items on desktop (Screen resolution of device >= 1200px )", 'maxstoreplus-toolkit' ),
			"param_name"  => "owl_lg_items",
			"value"       => "4",
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "The items on desktop (Screen resolution of device >= 992px < 1200px )", 'maxstoreplus-toolkit' ),
			"param_name"  => "owl_md_items",
			"value"       => "3",
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "The items on tablet (Screen resolution of device >=768px and < 992px )", 'maxstoreplus-toolkit' ),
			"param_name"  => "owl_sm_items",
			"value"       => "3",
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "The items on mobile landscape(Screen resolution of device >=480px and < 768px)", 'maxstoreplus-toolkit' ),
			"param_name"  => "owl_xs_items",
			"value"       => "2",
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "The items on mobile (Screen resolution of device < 480px)", 'maxstoreplus-toolkit' ),
			"param_name"  => "owl_ts_items",
			"value"       => "1",
			'group'       => __( 'Carousel settings', 'maxstoreplus-toolkit' ),
			'admin_label' => false,
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
		'name'        => esc_html__( 'Maxstore: team', 'maxstoreplus-toolkit' ),
		'base'        => 'maxstoreplus_team', // shortcode
		'class'       => '',
		'category'    => esc_html__( 'Maxstore Plus', 'maxstoreplus-toolkit' ),
		'description' => __( 'Display Team.', 'maxstoreplus-toolkit' ),
		'params'      => $params,
	);
	vc_map( $map_settings );
}

function maxstoreplus_team( $atts )
{
	$atts         = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'maxstoreplus_team', $atts ) : $atts;
	$default_atts = array(
		'layout'          => '',
		'items_layout1'   => '',
		'items'           => '',
		'list_text_align' => '',
		'list_margin'     => '',
		'owl_autoplay'    => false,
		'owl_navigation'  => false,
		'owl_dots'        => false,
		'owl_loop'        => false,
		'owl_slidespeed'  => 1000,
		'owl_margin'      => 30,
		'owl_lg_items'    => 4,
		'owl_md_items'    => 3,
		'owl_sm_items'    => 3,
		'owl_xs_items'    => 2,
		'owl_ts_items'    => 1,
		'css'             => '',
		'el_class'        => '',
	);
	extract( shortcode_atts( $default_atts, $atts ) );
	$css_class = $el_class . ' ' . $layout . '';
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;
	$owl_settings  = maxstore_generate_carousel_data_attributes( 'owl_', $atts );
	$template_args = array(
		'atts'         => $atts,
		'css_class'    => $css_class,
		'owl_carousel' => $owl_settings,
	);
	ob_start();
	maxstoreplus_get_template_part( 'shortcodes/team/temp', $layout, $template_args );

	return ob_get_clean();
}

add_shortcode( 'maxstoreplus_team', 'maxstoreplus_team' );

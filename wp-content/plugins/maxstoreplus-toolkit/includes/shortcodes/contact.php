<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'vc_before_init', 'maxstoreplus_contact_settings' );
function maxstoreplus_contact_settings()
{
	$params       = array(
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
			'admin_label' => true,
			'std'         => '',
		),
		array(
			"type"        => "checkbox",
			"heading"     => __( "Is Mail? ", 'maxstoreplus-toolkit' ),
			"param_name"  => "check_mail",
			"admin_label" => true,
		),
		array(
			'type'        => 'dropdown',
			'heading'     => __( 'Icon library', 'maxstoreplus-toolkit' ),
			'value'       => array(
				__( 'Font Awesome', 'maxstoreplus-toolkit' ) => 'fontawesome',
				__( 'Other', 'maxstoreplus-toolkit' )        => 'mscustomfonts',
			),
			'admin_label' => true,
			'param_name'  => 'icon_lib',
			'description' => __( 'Select icon library.', 'maxstoreplus-toolkit' ),
		),
		array(
			'param_name'  => 'icon_mscustomfonts',
			'heading'     => esc_html__( 'Icon', 'maxstoreplus-toolkit' ),
			'description' => esc_html__( 'Select icon library.', 'maxstoreplus-toolkit' ),
			'type'        => 'iconpicker',
			'value'       => 'flaticon-heart1',
			'settings'    => array(
				'emptyIcon' => false,
				'type'      => 'mscustomfonts',
			),
			'dependency'  => array(
				'element' => 'icon_lib',
				'value'   => 'mscustomfonts',
			),
		),
		array(
			'type'        => 'iconpicker',
			'heading'     => __( 'Icon', 'maxstoreplus-toolkit' ),
			'param_name'  => 'icon_fontawesome',
			'value'       => 'fa fa-adjust', // default value to backend editor admin_label
			'settings'    => array(
				'emptyIcon'    => false,
				'iconsPerPage' => 4000,
			),
			'dependency'  => array(
				'element' => 'icon_lib',
				'value'   => 'fontawesome',
			),
			'description' => __( 'Select icon.', 'maxstoreplus-toolkit' ),
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
		'name'        => esc_html__( 'Maxstore: Contact', 'maxstoreplus-toolkit' ),
		'base'        => 'maxstoreplus_contact', // shortcode
		'class'       => '',
		'category'    => esc_html__( 'Maxstore Plus', 'maxstoreplus-toolkit' ),
		'description' => __( 'Display a title.', 'maxstoreplus-toolkit' ),
		'params'      => $params,
	);
	vc_map( $map_settings );
}

function maxstoreplus_contact( $atts )
{
	$atts         = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'maxstoreplus_contact', $atts ) : $atts;
	$default_atts = array(
		'icon_lib'           => '',
		'check_mail'         => '',
		'icon_mscustomfonts' => '',
		'icon_fontawesome'   => '',
		'title'              => '',
		'des'                => '',
		'css'                => '',
		'el_class'           => '',
	);
	extract( shortcode_atts( $default_atts, $atts ) );
	$css_class = $el_class . '';
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;
	$icon = '';
	if ( $icon_lib == 'fontawesome' ) {
		$icon = $icon_fontawesome;
	} elseif ( $icon_lib == 'mscustomfonts' ) {
		$icon = $icon_mscustomfonts;
	}
	ob_start();
	?>
    <div class="contact-info <?php echo esc_attr( $css_class ) ?>">
        <i class="<?php echo esc_attr( $icon ) ?>"></i>
        <h3 class="title"><?php echo esc_html( $title ) ?></h3>
		<?php if ( $check_mail == true ) : ?>
            <a href="mailto:<?php echo esc_attr( $des ) ?>">
                <p class="description"><?php echo esc_html( $des ) ?></p>
            </a>
		<?php else: ?>
            <p class="description"><?php echo esc_html( $des ) ?></p>
		<?php endif; ?>
    </div>
	<?php
	return ob_get_clean();
}

add_shortcode( 'maxstoreplus_contact', 'maxstoreplus_contact' );

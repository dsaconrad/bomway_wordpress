<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'vc_before_init', 'maxstoreplus_icon_settings' );
function maxstoreplus_icon_settings()
{
	$params       = array(
		array(
			'type'        => 'kt_select_preview',
			'heading'     => __( 'Layout', 'maxstoreplus-toolkit' ),
			'value'       => array(
				'default' => array(
					'alt' => 'Default',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'icon/default.jpg',
				),
				'layout1' => array(
					'alt' => 'layout1',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'icon/layout1.jpg',
				),
				'layout2' => array(
					'alt' => 'layout2',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'icon/layout2.jpg',
				),
				'layout3' => array(
					'alt' => 'layout3',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'icon/layout3.jpg',
				),
				'layout4' => array(
					'alt' => 'layout4',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'icon/layout4.jpg',
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
			'dependency'  => array(
				'element' => 'layout',
				'value'   => array( 'default', 'layout1', 'layout2', 'layout4' ),
			),
		),
		array(
			'type'        => 'textarea',
			'heading'     => __( 'Description', 'maxstoreplus-toolkit' ),
			'param_name'  => 'des',
			'description' => __( 'The Description of shortcode', 'maxstoreplus-toolkit' ),
			'std'         => '',
			'dependency'  => array(
				'element' => 'layout',
				'value'   => array( 'default', 'layout1', 'layout2', 'layout4' ),
			),
		),
		array(
			"type"        => "param_group",
			"heading"     => __( "Items icon", "corporatepro" ),
			"admin_label" => false,
			"param_name"  => "items",
			'dependency'  => array(
				'element' => 'layout',
				'value'   => array( 'layout3' ),
			),
			"params"      => array(
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
				),
				array(
					'type'        => 'dropdown',
					'heading'     => __( 'Icon library', 'maxstoreplus-toolkit' ),
					'value'       => array(
						__( 'Font Awesome', 'maxstoreplus-toolkit' ) => 'fontawesome',
						__( 'Other', 'maxstoreplus-toolkit' )        => 'mscustomfonts',
						__( 'image icon', 'maxstoreplus-toolkit' )   => 'img_icon',
					),
					'admin_label' => true,
					'param_name'  => 'icon_lib',
					'description' => __( 'Select icon library.', 'maxstoreplus-toolkit' ),
				),
				array(
					"type"        => "attach_image",
					"heading"     => __( "icon", "maxstoreplus" ),
					"param_name"  => "bg_icon",
					"admin_label" => false,
					'dependency'  => array(
						'element' => 'icon_lib',
						'value'   => array( 'img_icon' ),
					),
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
					'type'        => 'vc_link',
					'heading'     => __( 'URL (Link)', 'maxstoreplus-toolkit' ),
					'param_name'  => 'link',
					'description' => __( 'Add link.', 'maxstoreplus-toolkit' ),
				),
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => __( 'Icon library', 'maxstoreplus-toolkit' ),
			'value'       => array(
				__( 'Font Awesome', 'maxstoreplus-toolkit' ) => 'fontawesome',
				__( 'Other', 'maxstoreplus-toolkit' )        => 'mscustomfonts',
				__( 'image icon', 'maxstoreplus-toolkit' )   => 'img_icon',
			),
			'admin_label' => true,
			'param_name'  => 'icon_lib',
			'description' => __( 'Select icon library.', 'maxstoreplus-toolkit' ),
			'dependency'  => array(
				'element' => 'layout',
				'value'   => array( 'default', 'layout1', 'layout2', 'layout4' ),
			),
		),
		array(
			"type"        => "attach_image",
			"heading"     => __( "icon", "maxstoreplus" ),
			"param_name"  => "bg_icon",
			"admin_label" => false,
			'dependency'  => array(
				'element' => 'icon_lib',
				'value'   => array( 'img_icon' ),
			),
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
			'type'        => 'vc_link',
			'heading'     => __( 'URL (Link)', 'maxstoreplus-toolkit' ),
			'param_name'  => 'link',
			'description' => __( 'Add link.', 'maxstoreplus-toolkit' ),
			'dependency'  => array(
				'element' => 'layout',
				'value'   => array( 'default', 'layout1', 'layout2', 'layout4' ),
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
		'name'        => esc_html__( 'Maxstore: Icon', 'maxstoreplus-toolkit' ),
		'base'        => 'maxstoreplus_icon', // shortcode
		'class'       => '',
		'category'    => esc_html__( 'Maxstore Plus', 'maxstoreplus-toolkit' ),
		'description' => __( 'Display a icon with text.', 'maxstoreplus-toolkit' ),
		'params'      => $params,
	);
	vc_map( $map_settings );
}

function maxstoreplus_icon( $atts )
{
	$atts         = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'maxstoreplus_icon', $atts ) : $atts;
	$default_atts = array(
		'layout'             => 'default',
		'items'              => '',
		'bg_icon'            => '',
		'link'               => '',
		'icon_lib'           => '',
		'title'              => '',
		'icon_fontawesome'   => '',
		'icon_mscustomfonts' => '',
		'des'                => '',
		'css'                => '',
		'el_class'           => '',
	);
	extract( shortcode_atts( $default_atts, $atts ) );
	$css_class = $el_class . ' ' . $layout . '';
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;
	if ( $link ) {
		$link = vc_build_link( $link );
	} else {
		$link = array( 'url' => '', 'title' => '', 'target' => '_self', 'rel' => '' );
	}
	$args = array(
		'a'      => array(
			'href'  => array(),
			'title' => array(),
		),
		'br'     => array(),
		'em'     => array(),
		'strong' => array(),
	);
	$des  = wp_kses( $des, $args );
	$icon = '';
	if ( $icon_lib == 'fontawesome' ) {
		$icon = $icon_fontawesome;
	} elseif ( $icon_lib == 'mscustomfonts' ) {
		$icon = $icon_mscustomfonts;
	}
	$items       = vc_param_group_parse_atts( $items );
	$link_url    = $link['url'];
	$link_title  = $link['title'];
	$link_target = $link['target'];
	ob_start();
	if ( $layout == 'layout3' ) : ?>
        <div class="contain-icon-group <?php echo esc_attr( $css_class ); ?>">
			<?php foreach ( $items as $item ): ?>
				<?php
				if ( !empty( $item['link'] ) ) {
					$link = vc_build_link( $item['link'] );
				} else {
					$link = array( 'url' => '#', 'title' => '', 'target' => '_self', 'rel' => '' );
				}
				$icon_list = '';
				if ( $item['icon_lib'] == 'fontawesome' ) {
					$icon_list = $item['icon_fontawesome'];
				} elseif ( $item['icon_lib'] == 'mscustomfonts' ) {
					$icon_list = $item['icon_mscustomfonts'];
				}
				$args = array(
					'a'      => array(
						'href'  => array(),
						'title' => array(),
					),
					'br'     => array(),
					'em'     => array(),
					'strong' => array(),
				);
				$des  = wp_kses( $item['des'], $args );
				?>
                <div class="block-icon layout2">
                    <a href="<?php echo esc_url( $link['url'] ) ?>" target="<?php echo esc_attr( $link['target'] ) ?>">
						<?php if ( $item['icon_lib'] == 'img_icon' ) : ?>
							<?php $image_thumb = maxstoreplus_resize_image( $item['bg_icon'], null, 80, 80, true, true, false ); ?>
                            <img class="img-responsive" src="<?php echo esc_attr( $image_thumb['url'] ); ?>"
                                 width="<?php echo intval( $image_thumb['width'] ) ?>"
                                 height="<?php echo intval( $image_thumb['height'] ) ?>" alt="<?php the_title() ?>">
						<?php else : ?>
                            <span class="<?php echo esc_attr( $icon_list ) ?>"></span>
						<?php endif; ?>
                    </a>
                    <div class="icon-text">
						<?php if ( $item['title'] ) : ?>
                            <a href="<?php echo esc_url( $link['url'] ) ?>"
                               target="<?php echo esc_attr( $link['target'] ) ?>">
                                <h2 class="title"><?php echo esc_html( $item['title'] ) ?></h2>
                            </a>
						<?php endif; ?>
						<?php if ( $des ) : ?>
                            <p class="des"><?php echo $des ?></p>
						<?php endif; ?>
                    </div>
                </div>
			<?php endforeach; ?>
        </div>
	<?php else : ?>
        <div class="block-icon <?php echo esc_attr( $css_class ); ?>">
            <a href="<?php echo esc_url( $link_url ) ?>" target="<?php echo esc_attr( $link_target ) ?>">
				<?php if ( $icon_lib == 'img_icon' ) : ?>
					<?php $image_thumb = maxstoreplus_resize_image( $bg_icon, null, 80, 80, true, true, false ); ?>
                    <img class="img-responsive" src="<?php echo esc_attr( $image_thumb['url'] ); ?>"
                         width="<?php echo intval( $image_thumb['width'] ) ?>"
                         height="<?php echo intval( $image_thumb['height'] ) ?>" alt="<?php the_title() ?>">
				<?php else : ?>
                    <span class="<?php echo esc_attr( $icon ) ?>"></span>
				<?php endif; ?>
            </a>
            <div class="icon-text">
				<?php if ( $title ) : ?>
                    <a href="<?php echo esc_url( $link_url ) ?>" target="<?php echo esc_attr( $link_target ) ?>">
                        <h2 class="title"><?php echo esc_html( $title ) ?></h2>
                    </a>
				<?php endif; ?>
				<?php if ( $des ) : ?>
                    <p class="des"><?php echo $des ?></p>
				<?php endif; ?>
            </div>
        </div>
	<?php endif;

	return ob_get_clean();
}

add_shortcode( 'maxstoreplus_icon', 'maxstoreplus_icon' );

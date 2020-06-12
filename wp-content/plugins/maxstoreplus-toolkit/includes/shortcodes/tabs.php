<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
add_action( 'vc_before_init', 'corporatepro_tabs_settings' );
function corporatepro_tabs_settings()
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
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'tabs/default.jpg',
				),
				'layout1' => array(
					'alt' => 'Layout1',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'tabs/layout1.jpg',
				),
			),
			'default'     => 'default',
			'admin_label' => true,
			'param_name'  => 'layout',
			'description' => __( 'Select a layout.', 'maxstoreplus-toolkit' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => __( 'Title', 'js_composer' ),
			'param_name'  => 'title',
			'description' => __( 'title of shortcode.', 'js_composer' ),
		),
		array(
			'type'       => 'dropdown',
			'value'      => array(
				__( 'Left', 'maxstoreplus-toolkit' )   => 'left',
				__( 'Right', 'maxstoreplus-toolkit' )  => 'right',
				__( 'Center', 'maxstoreplus-toolkit' ) => 'center',
			),
			'std'        => false,
			'heading'    => __( 'Tabs Align', 'maxstoreplus-toolkit' ),
			'param_name' => 'tabs_align',
		),
		array(
			'type'       => 'dropdown',
			'value'      => array(
				__( 'Yes', 'maxstoreplus-toolkit' ) => 'yes',
				__( 'No', 'maxstoreplus-toolkit' )  => 'no',
			),
			'std'        => false,
			'heading'    => __( 'Tabs Ajax', 'maxstoreplus-toolkit' ),
			'param_name' => 'tabs_ajax',
		),
		vc_map_add_css_animation(),
		array(
			'type'        => 'textfield',
			'heading'     => __( 'Extra class name', 'js_composer' ),
			'param_name'  => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
		),
		array(
			'type'       => 'css_editor',
			'heading'    => __( 'CSS box', 'js_composer' ),
			'param_name' => 'css',
			'group'      => __( 'Design Options', 'js_composer' ),
		),
	);
	$map_settings = array(
		'name'                    => __( 'Maxstore: Tabs', 'js_composer' ),
		'base'                    => 'corporatepro_tabs',
		'icon'                    => 'icon-wpb-ui-tab-content',
		'is_container'            => true,
		'show_settings_on_create' => false,
		'as_parent'               => array(
			'only' => 'vc_tta_section',
		),
		'category'                => __( 'Maxstore Plus', 'js_composer' ),
		'description'             => __( 'Tabbed content', 'js_composer' ),
		'params'                  => $params,
		'js_view'                 => 'VcBackendTtaTabsView',
		'custom_markup'           => '
        <div class="vc_tta-container" data-vc-action="collapse">
            <div class="vc_general vc_tta vc_tta-tabs vc_tta-color-backend-tabs-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-spacing-1 vc_tta-tabs-position-top vc_tta-controls-align-left">
                <div class="vc_tta-tabs-container">'
			. '<ul class="vc_tta-tabs-list">'
			. '<li class="vc_tta-tab" data-vc-tab data-vc-target-model-id="{{ model_id }}" data-element_type="vc_tta_section"><a href="javascript:;" data-vc-tabs data-vc-container=".vc_tta" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-target-model-id="{{ model_id }}"><span class="vc_tta-title-text">{{ section_title }}</span></a></li>'
			. '</ul>
                </div>
                <div class="vc_tta-panels vc_clearfix {{container-class}}">
                  {{ content }}
                </div>
            </div>
        </div>',
		'default_content'         => '
        [vc_tta_section title="' . sprintf( '%s %d', __( 'Tab', 'js_composer' ), 1 ) . '"][/vc_tta_section]
        [vc_tta_section title="' . sprintf( '%s %d', __( 'Tab', 'js_composer' ), 2 ) . '"][/vc_tta_section]
        ',
		'admin_enqueue_js'        => array(
			vc_asset_url( 'lib/vc_tabs/vc-tabs.js' ),
		),
	);
	vc_map( $map_settings );
}

VcShortcodeAutoloader::getInstance()->includeClass( 'WPBakeryShortCode_VC_Tta_Accordion' );

class WPBakeryShortCode_corporatepro_tabs extends WPBakeryShortCode_VC_Tta_Accordion
{
	protected function content( $atts, $content = null )
	{
		$atts         = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'corporatepro_tabs', $atts ) : $atts;
		$default_atts = array(
			'layout'        => 'default',
			'title'         => '',
			'tabs_align'    => '',
			'css_animation' => '',
			'tabs_ajax'     => '',
			'css'           => '',
			'el_class'      => '',
		);
		extract( shortcode_atts( $default_atts, $atts ) );
		$css_class = 'ms-tabs ' . $el_class . ' ' . $layout . ' ' . $tabs_align . '';
		if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
			$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
		endif;
		// Get all url link
		$sections = maxstore_get_all_attributes( 'vc_tta_section', $content );
		ob_start();
		?>
        <div class="tab-style-2 <?php echo esc_attr( $css_class ); ?>">
			<?php if ( $sections && is_array( $sections ) && count( $sections ) > 0 ): ?>
                <ul class="tabs-link">
					<?php $i = 0; ?>
					<?php foreach ( $sections as $section ): ?>
						<?php $i++; ?>
                        <li class="<?php if ( $i == 1 ): ?>active<?php endif; ?>">
                            <a data-animate="<?php echo esc_attr( $css_animation ); ?>"
								<?php if ( $tabs_ajax == 'yes' ) : ?>
                                    data-ajax="1"
								<?php endif; ?>
                               data-section="<?php echo esc_attr( $section['tab_id'] ); ?>"
                               data-id='<?php echo get_the_ID(); ?>'
                               href="#<?php echo esc_attr( $section['tab_id'] ); ?>">
								<?php echo esc_html( $section['title'] ); ?>
                            </a>
                        </li>
					<?php endforeach; ?>
                </ul>
				<?php if ( $title ) : ?>
                    <p class="tabs-title"><?php echo esc_html( $title ) ?></p>
				<?php endif; ?>
                <div class="tab-container">
					<?php $i = 0; ?>
					<?php foreach ( $sections as $section ): ?>
						<?php $i++; ?>
                        <div id="<?php echo esc_attr( $section['tab_id'] ); ?>"
                             class="tab-panel <?php if ( $i == 1 ): ?>active<?php endif; ?>">
							<?php
							if ( $tabs_ajax == 'yes' ) {
								if ( $i == 1 ) {
									echo do_shortcode( $section['content'] );
								}
							} else {
								echo do_shortcode( $section['content'] );
							}
							?>
                        </div>
					<?php endforeach; ?>
                </div>
			<?php endif; ?>
        </div>
		<?php
		return ob_get_clean();
	}
}

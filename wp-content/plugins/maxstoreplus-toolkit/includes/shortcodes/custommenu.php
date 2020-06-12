<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'vc_before_init', 'maxstoreplus_custommenu_settings' );
function maxstoreplus_custommenu_settings()
{
	$all_menu = array();
	$menus    = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
	if ( !empty( $menus ) ) {
		foreach ( $menus as $m ) {
			$all_menu[$m->name] = $m->slug;
		}
	}
	$params       = array(
		array(
			'type'        => 'kt_select_preview',
			'heading'     => __( 'Layout', 'maxstoreplus-toolkit' ),
			'value'       => array(
				'default' => array(
					'alt' => 'Default',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'custommenu/default.jpg',
				),
				'layout1' => array(
					'alt' => 'Layout1',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'custommenu/layout1.jpg',
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
			'type'        => 'dropdown',
			'heading'     => __( 'Menu', 'maxstoreplus-toolkit' ),
			'param_name'  => 'menu',
			'value'       => $all_menu,
			'admin_label' => true,
			'description' => __( 'Select menu to display.', 'maxstoreplus-toolkit' ),
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
		'name'        => esc_html__( 'Maxstore: Custom menu', 'maxstoreplus-toolkit' ),
		'base'        => 'maxstoreplus_custommenu', // shortcode
		'class'       => '',
		'category'    => esc_html__( 'Maxstore Plus', 'maxstoreplus-toolkit' ),
		'description' => __( 'Display a menu.', 'maxstoreplus-toolkit' ),
		'params'      => $params,
	);
	vc_map( $map_settings );
}

function maxstoreplus_custommenu( $atts )
{
	$atts         = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'maxstoreplus_custommenu', $atts ) : $atts;
	$default_atts = array(
		'layout'   => 'default',
		'title'    => '',
		'menu'     => '',
		'css'      => '',
		'el_class' => '',
	);
	extract( shortcode_atts( $default_atts, $atts ) );
	$css_class = $el_class . ' maxstoreplus_custommenu ' . $layout . '';
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;
	$nav_menu = get_term_by( 'slug', $menu, 'nav_menu' );
	ob_start();
	if ( $layout == 'default' ): ?>
        <div class="<?php echo esc_attr( $css_class ); ?>">
			<?php
			$instance = array();
			if ( is_object( $nav_menu ) && !empty( $nav_menu ) ) {
				if ( $title ) {
					$instance['title'] = $title;
				}
				if ( $nav_menu->term_id ) {
					$instance['nav_menu'] = $nav_menu->term_id;
				}
				the_widget( 'WP_Nav_Menu_Widget', $instance );
			}
			?>
        </div>
	<?php endif;
	if ( $layout == 'layout1' ): ?>
        <div class="<?php echo esc_attr( $css_class ); ?>">
            <div class="widget widget_nav_menu">
				<?php if ( $title ): ?>
                    <h2 class="widgettitle"><?php echo esc_html( $title ); ?></h2>
				<?php endif ?>
				<?php if ( is_object( $nav_menu ) && !empty( $nav_menu ) ): ?>
                    <div class="menu-<?php echo $nav_menu->slug ?>-container">
						<?php
						wp_nav_menu( array(
								'menu'            => $nav_menu->term_id,
								'theme_location'  => $nav_menu->term_id,
								'container'       => '',
								'container_class' => '',
								'container_id'    => '',
								'menu_class'      => 'menu',
								'fallback_cb'     => 'maxstoreplus_bootstrap_navwalker::fallback',
								'walker'          => new maxstoreplus_bootstrap_navwalker(),
							)
						);
						?>
                    </div>
				<?php endif ?>
            </div>
        </div>
	<?php endif;

	return ob_get_clean();
}

add_shortcode( 'maxstoreplus_custommenu', 'maxstoreplus_custommenu' );

<?php
/**
 * Custom nav in wp-admin
 *
 * @author      KuteThemes
 * @package     Kite/Template
 * @since       1.0.0
 * @link        http://kutethemes.com
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'Kutetheme_ovic_Megamenu' ) ) {
	/**
	 * Class Kutetheme_ovic_Megamenu
	 * @since 1.0
	 */
	class Kutetheme_ovic_Megamenu
	{

		public $custom_fields;

		/**
		 * Initializes the plugin by setting localization, filters, and administration functions.
		 */
		function __construct()
		{
			$this->custom_fields = array( 'img_icon', 'do_shortcode', 'font_icon', 'item_icon_type', 'mega_menu_width', 'mega_menu_url', 'img_icon_hover', 'img_note', 'enable_login_logout', 'enable_minicart', 'enable_currency_switcher', 'hiden_title' );
			// add custom menu fields to menu
			add_filter( 'wp_setup_nav_menu_item', array( $this, 'add_custom_nav_fields' ) );

			// save menu custom fields
			add_action( 'wp_update_nav_menu_item', array( $this, 'update_custom_nav_fields' ), 10, 3 );

			// edit menu walker
			add_filter( 'wp_edit_nav_menu_walker', array( $this, 'edit_walker' ), 10, 2 );

			// add enqueue scripts
			add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts' ) );

		} // end constructor

		/**
		 * Add custom fields to $item nav object
		 * in order to be used in custom Walker
		 *
		 * @access      public
		 * @since       1.0
		 * @return      void
		 */
		function add_custom_nav_fields( $menu_item )
		{
			foreach ( $this->custom_fields as $key ) {
				$menu_item->$key = get_post_meta( $menu_item->ID, '_menu_item_megamenu_' . $key, true );
			}

			return $menu_item;

		}

		/**
		 * Save menu custom fields
		 *
		 * @access      public
		 * @since       1.0
		 * @return      void
		 */
		function update_custom_nav_fields( $menu_id, $menu_item_db_id, $args )
		{

			foreach ( $this->custom_fields as $key ) {
				if ( !isset( $_REQUEST[ 'menu-item-megamenu-' . $key ][ $menu_item_db_id ] ) ) {
					$_REQUEST[ 'menu-item-megamenu-' . $key ][ $menu_item_db_id ] = '';
				}

				$value = $_REQUEST[ 'menu-item-megamenu-' . $key ][ $menu_item_db_id ];

				update_post_meta( $menu_item_db_id, '_menu_item_megamenu_' . $key, $value );
			}

		}

		/**
		 * Define new Walker edit
		 *
		 * @access      public
		 * @since       1.0
		 * @return      void
		 */
		function edit_walker( $walker, $menu_id )
		{
			return 'Walker_Nav_Menu_Edit_Custom';
		}

		/**
		 * Register megamenu javascript assets
		 *
		 * @return void
		 *
		 * @since  1.0
		 */
		function register_scripts( $hook )
		{
			if ( 'nav-menus.php' != $hook ) return;
			wp_enqueue_style( 'kt-style-mega-menu', get_template_directory_uri() . '/includes/nav/css/megamenu.css' );
			wp_enqueue_style( 'kt-style-magnific', get_template_directory_uri() . '/includes/nav/css/magnific-popup.css' );
			wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/includes/nav/css/font-awesome.min.css' );
			wp_enqueue_media();
			wp_enqueue_script( 'kt-script-mega-menu', get_template_directory_uri() . '/includes/nav/js/megamenu.js', array( 'jquery' ), '1.0.0', true );
			wp_enqueue_script( 'kt-script-magnific', get_template_directory_uri() . '/includes/nav/js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.0.0', true );
		}

	} // end kt_MegaMenu() class

	// instantiate plugin's class
	new Kutetheme_ovic_Megamenu();

}

require_once( trailingslashit( get_template_directory() ) . 'includes/nav/nav_menu_custom_fields.php' );
require_once( trailingslashit( get_template_directory() ) . 'includes/nav/nav_edit_custom_walker.php' );
require_once( trailingslashit( get_template_directory() ) . 'includes/nav/kt_bootstrap_navwalker.php' );


add_action( 'wp_ajax_corporatepro_ajax_load_font_icon', 'corporatepro_ajax_load_font_icon' );

function corporatepro_ajax_load_font_icon()
{
	$id        = $_POST[ 'id' ];
	$list_font = include( trailingslashit( get_template_directory() ) . 'includes/nav/list-font-icons.php' );
	?>
    <div class="icons-popup">
        <div class="inner">
			<?php foreach ( $list_font as $item ): ?>
                <h3 class="title"><?php echo esc_html( $item[ 'title' ] ); ?></h3>
                <ul class="list-font">
					<?php foreach ( $item[ 'fonts' ] as $font ): ?>
                        <li class="font-item" data-id="<?php echo esc_attr( $id ); ?>"
                            data-icon="<?php echo esc_attr( $font ); ?>">
                            <span class="item-icon <?php echo esc_attr( $font ); ?>"></span>
                            <!-- <span class="text"><?php echo esc_html( $font ); ?></span> -->
                        </li>
					<?php endforeach; ?>
                </ul>
			<?php endforeach; ?>
        </div>
    </div>
	<?php
	die(); // this is required to return a proper result
}


if ( !function_exists( 'maxstoreplus_addShortcodesCustomCss_megamenu' ) ) {
	function maxstoreplus_addShortcodesCustomCss_megamenu()
	{
		$args        = array(
			'posts_per_page' => -1,
			'post_type'      => 'megamenu',
			'post_status'    => 'publish',
		);
		$posts_array = get_posts( $args );

		if ( $posts_array ) {
			$shortcodes_custom_css = '';
			foreach ( $posts_array as $post ) {
				$shortcodes_custom_css .= get_post_meta( $post->ID, '_wpb_shortcodes_custom_css', true );
			}

			if ( !empty( $shortcodes_custom_css ) ) {
				wp_add_inline_style( 'maxstoreplus_style', $shortcodes_custom_css );
			}
		}
	}
}
add_action( 'wp_enqueue_scripts', 'maxstoreplus_addShortcodesCustomCss_megamenu', 99 );

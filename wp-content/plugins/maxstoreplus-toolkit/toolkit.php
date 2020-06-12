<?php
/**
 * Plugin Name: MaxstorePlus Toolkit
 * Plugin URI: https://kutethemes.com
 * Description: This Toolkit is used for themes that are developed by Kutethemes.
 * Version: 1.0.9
 * Author: Kutethemes
 * Author URI: https://kutethemes.com
 * Text Domain: maxstoreplus-toolkit
 */
// don't load directly
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
// Include function plugins if not include.
if ( !function_exists( 'is_plugin_active' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}
if ( !class_exists( 'Maxstore_Toolkit' ) ) {
	class Maxstore_Toolkit
	{
		/**
		 * The single instance of the class.
		 *
		 * @var Maxstore_Toolkit
		 * @since 1.0
		 */
		protected static $_instance = null;

		public static function instance()
		{
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Maxstore_Toolkit Constructor.
		 */
		public function __construct()
		{
			$this->plugin_uri = trailingslashit( plugin_dir_url( __FILE__ ) );
			$this->define_constants();
			$this->includes();
			$this->load_textdomain();
		}

		/**
		 * Define Maxstore_Toolkit Constants.
		 */
		private function define_constants()
		{
			$this->define( 'MAXSTOREPLUS_VERSION', '1.0.9' );
			$this->define( 'MAXSTOREPLUS_BASE_URL', trailingslashit( plugins_url( 'maxstoreplus-toolkit' ) ) );
			$this->define( 'MAXSTOREPLUS_DIR_PATH', plugin_dir_path( __FILE__ ) );
			$this->define( 'MAXSTOREPLUS_LIBS', MAXSTOREPLUS_DIR_PATH . '/libs/' );
			$this->define( 'MAXSTOREPLUS_LIBS_URL', MAXSTOREPLUS_BASE_URL . '/libs/' );
			$this->define( 'MAXSTOREPLUS_CORE', MAXSTOREPLUS_DIR_PATH . '/core/' );
			$this->define( 'MAXSTOREPLUS_CSS_URL', MAXSTOREPLUS_BASE_URL . 'assets/css/' );
			$this->define( 'MAXSTOREPLUS_JS', MAXSTOREPLUS_BASE_URL . 'assets/js/' );
			$this->define( 'MAXSTOREPLUS_VENDORS_URL', MAXSTOREPLUS_BASE_URL . 'assets/vendors/' );
			$this->define( 'MAXSTOREPLUS_IMG_URL', MAXSTOREPLUS_BASE_URL . 'assets/images/' );
			$this->define( 'MAXSTOREPLUS_INCLUDES', MAXSTOREPLUS_DIR_PATH . 'includes/' );
			$this->define( 'MAXSTOREPLUS_SHORTCODE_IMG_URL', MAXSTOREPLUS_BASE_URL . 'assets/layout-images/' );
			$this->define( 'MAXSTOREPLUS_TEMPLATES_PATH', 'templates/' );
		}

		/**
		 * Define constant if not already set.
		 *
		 * @param string      $name
		 * @param string|bool $value
		 */
		private function define( $name, $value )
		{
			if ( !defined( $name ) ) {
				define( $name, $value );
			}
		}

		function load_textdomain()
		{
			load_plugin_textdomain( 'maxstoreplus-toolkit', false, MAXSTOREPLUS_DIR_PATH . 'languages' );
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 */
		public function includes()
		{
			if ( !is_plugin_active( 'redux-framework/redux-framework.php' ) ) {
				include_once( 'includes/vendor/ReduxCore/framework.php' );
			}
			include_once( 'includes/vendor/CMB/init.php' );
			include_once( 'includes/post-types.php' );
			include_once( 'includes/wellcome.php' );
			/*MAILCHIP*/
			include_once( 'includes/classes/MCAPI/MCAPI.class.php' );
			include_once( 'includes/classes/MCAPI/mailchimp-settings.php' );
			include_once( 'includes/classes/MCAPI/mailchimp.php' );
			/* SHORTCODE */
			if ( class_exists( 'Vc_Manager' ) ) {
				include_once( MAXSTOREPLUS_INCLUDES . 'shortcodes.php' );
				include_once( MAXSTOREPLUS_INCLUDES . 'shortcodes/custommenu.php' );
				include_once( MAXSTOREPLUS_INCLUDES . 'shortcodes/socials.php' );
				include_once( MAXSTOREPLUS_INCLUDES . 'shortcodes/tabs.php' );
				include_once( MAXSTOREPLUS_INCLUDES . 'shortcodes/simple_slide.php' );
				include_once( MAXSTOREPLUS_INCLUDES . 'shortcodes/newsletter.php' );
				include_once( MAXSTOREPLUS_INCLUDES . 'shortcodes/blogs.php' );
				include_once( MAXSTOREPLUS_INCLUDES . 'shortcodes/title.php' );
				include_once( MAXSTOREPLUS_INCLUDES . 'shortcodes/banner.php' );
				include_once( MAXSTOREPLUS_INCLUDES . 'shortcodes/icon.php' );
				include_once( MAXSTOREPLUS_INCLUDES . 'shortcodes/categories.php' );
				include_once( MAXSTOREPLUS_INCLUDES . 'shortcodes/maps.php' );
				include_once( MAXSTOREPLUS_INCLUDES . 'shortcodes/contact.php' );
				include_once( MAXSTOREPLUS_INCLUDES . 'shortcodes/team.php' );
				if ( class_exists( 'WooCommerce' ) ) {
					include_once( MAXSTOREPLUS_INCLUDES . 'templates.php' );
					include_once( MAXSTOREPLUS_INCLUDES . 'shortcodes/products.php' );
				}
			}
		}
	}
}
/**
 * Main instance of Maxstore_Toolkit.
 *
 * Returns the main instance of WC to prevent the need to use globals.
 *
 * @return Maxstore_Toolkit
 * @since  1.0.0
 */
if ( !function_exists( 'Maxstore_Toolkit' ) ) {
	function Maxstore_Toolkit()
	{
		return Maxstore_Toolkit::instance();
	}
}
add_action( 'plugins_loaded', 'Maxstore_Toolkit', 9999 );
// Global for backwards compatibility.
// $GLOBALS['coporate_toolkit'] = Maxstore_Toolkit();

<?php
if ( !class_exists( 'maxstoreplus_PluginLoad' ) ) {
	class maxstoreplus_PluginLoad
	{
		public $plugins = array();
		public $config  = array();

		public function __construct()
		{
			$this->plugins();
			$this->config();
			if ( function_exists( 'tgmpa' ) ) {
				tgmpa( $this->plugins, $this->config );
			}
		}

		public function plugins()
		{
			$this->plugins = array(
				array(
					'name'               => 'Maxstoreplus Toolkit',
					'slug'               => 'maxstoreplus-toolkit',
					'source'             => 'https://plugins.kutethemes.net/maxstoreplus-toolkit.zip',
					'required'           => true,
					'version'            => '1.0.9',
					'force_activation'   => false,
					'force_deactivation' => false,
					'external_url'       => '',
					'image'              => get_template_directory_uri() . '/images/maxstore.jpg',
				),
				array(
					'name'               => 'Revolution Slider',
					'slug'               => 'revslider',
					'source'             => 'https://plugins.kutethemes.net/revslider.zip',
					'required'           => true,
					'version'            => '6.2.2',
					'force_activation'   => false,
					'force_deactivation' => false,
					'external_url'       => '',
					'image'              => get_template_directory_uri() . '/images/slider-revolution.jpg',
				),
				array(
					'name'               => 'WPBakery Visual Composer',
					'slug'               => 'js_composer',
					'source'             => 'https://plugins.kutethemes.net/js_composer.zip',
					'required'           => true,
					'version'            => '6.1',
					'force_activation'   => false,
					'force_deactivation' => false,
					'external_url'       => '',
					'image'              => get_template_directory_uri() . '/images/visual-composer.png',
				),
				array(
					'name'     => 'Ovic Import Demo',
					'slug'     => 'ovic-import-demo',
					'required' => true,
				),
				array(
					'name'     => 'WooCommerce',
					'slug'     => 'woocommerce',
					'required' => false,
					'image'    => get_template_directory_uri() . '/images/woocommerce.png',
				),
				array(
					'name'     => 'YITH WooCommerce Compare',
					'slug'     => 'yith-woocommerce-compare',
					'required' => false,
					'image'    => get_template_directory_uri() . '/images/compare.jpg',
				),
				array(
					'name'     => 'YITH WooCommerce Wishlist',
					'slug'     => 'yith-woocommerce-wishlist',
					'required' => false,
					'image'    => get_template_directory_uri() . '/images/wishlist.jpg',
				),
				array(
					'name'     => 'YITH WooCommerce Quick View',
					'slug'     => 'yith-woocommerce-quick-view',
					'required' => false,
					'image'    => get_template_directory_uri() . '/images/quickview.jpg',
				),
				array(
					'name'     => 'Contact Form 7',
					'slug'     => 'contact-form-7',
					'required' => false,
					'image'    => get_template_directory_uri() . '/images/contactform7.png',
				),
			);
		}

		public function config()
		{
			$this->config = array(
				'id'           => 'maxstoreplus',                 // Unique ID for hashing notices for multiple instances of TGMPA.
				'default_path' => '',                      // Default absolute path to bundled plugins.
				'menu'         => 'maxstoreplus-install-plugins', // Menu slug.
				'parent_slug'  => 'themes.php',            // Parent menu slug.
				'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
				'has_notices'  => true,                    // Show admin notices or not.
				'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
				'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
				'is_automatic' => true,                   // Automatically activate plugins after installation or not.
				'message'      => '',                      // Message to output right before the plugins table.
			);
		}
	}
}
if ( !function_exists( 'maxstoreplus_PluginLoad' ) ) {
	function maxstoreplus_PluginLoad()
	{
		new  maxstoreplus_PluginLoad();
	}
}
add_action( 'tgmpa_register', 'maxstoreplus_PluginLoad' );
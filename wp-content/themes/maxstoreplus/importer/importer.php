<?php
// Prevent direct access to this file
defined( 'ABSPATH' ) || die( 'Direct access to this file is not allowed.' );
/**
 * Core class.
 *
 * @package  Ovic
 * @since    1.0
 */
if ( !class_exists( 'Ovic_Import_Demo_Content' ) ) {
	class Ovic_Import_Demo_Content
	{
		/**
		 * Define theme version.
		 *
		 * @var  string
		 */
		const VERSION = '1.0.0';

		public function __construct()
		{
			add_action( 'ovic_after_content_import', array( $this, 'after_content_import' ) );
			add_filter( 'ovic_import_config', array( $this, 'import_config' ) );
			add_filter( 'ovic_import_wooCommerce_attributes', array( $this, 'woocommerce_attributes' ) );
		}

		function woocommerce_attributes()
		{
			return array(
				array(
					'attribute_name'    => 'color',
					'attribute_label'   => 'color',
					'attribute_type'    => 'box_style',
					'attribute_orderby' => 'menu_order',
					'attribute_public'  => '0',
				),
				array(
					'attribute_name'    => 'image',
					'attribute_label'   => 'image',
					'attribute_type'    => 'box_style',
					'attribute_orderby' => 'menu_order',
					'attribute_public'  => '0',
				),
				array(
					'attribute_name'    => 'size',
					'attribute_label'   => 'size',
					'attribute_type'    => 'select',
					'attribute_orderby' => 'menu_order',
					'attribute_public'  => '0',
				),
			);
		}

		function import_config( $data_filter )
		{
			$registed_menu                = array(
				'primary'            => 'Primary Menu',
				'primary-left-menu'  => 'Main menu left',
				'primary-right-menu' => 'Main menu right',
				'menu-categories'    => 'Menu Categories - Products',
			);
			$menu_location                = array(
				'primary'            => 'Primary Menu',
				'primary-left-menu'  => 'Main menu left',
				'primary-right-menu' => 'Main menu right',
				'menu-categories'    => 'Menu Categories - Products',
			);
			$data_filter['data_advanced'] = array(
				'att' => 'Demo Attachments',
				'wid' => 'Import Widget',
				'rev' => 'Slider Revolution',
			);
			$data_filter['data_import']   = array(
				'main_demo'      => "https://maxstore.kutethemes.net",
				'theme_option'   => get_template_directory() . '/importer/data/theme-options.json',
				'content_path'   => get_template_directory() . '/importer/data/content.xml',
				'widget_path'    => get_template_directory() . '/importer/data/widgets.wie',
				'revslider_path' => get_template_directory() . '/importer/revsliders/',
			);
			$data_filter['data_demos']    = array();
			$data_filter['default_demo']  = array(
				'slug'           => 'home-01',
				'menus'          => $registed_menu,
				'homepage'       => 'Home 01',
				'blogpage'       => 'Blog',
				'menu_locations' => $menu_location,
				'option_key'     => 'maxstoreplus',
			);
			$data_filter['woo_single']    = '600';
			$data_filter['woo_catalog']   = '300';
			$data_filter['woo_ratio']     = '270:320';

			return $data_filter;
		}

		public function after_content_import()
		{
			$menus    = get_terms(
				'nav_menu',
				array(
					'hide_empty' => true,
				)
			);
			$home_url = get_home_url();
			if ( !empty( $menus ) ) {
				foreach ( $menus as $menu ) {
					$items = wp_get_nav_menu_items( $menu->term_id );
					if ( !empty( $items ) ) {
						foreach ( $items as $item ) {
							$_menu_item_url = get_post_meta( $item->ID, '_menu_item_url', true );
							if ( !empty( $_menu_item_url ) ) {
								$_menu_item_url = str_replace( "https://maxstore.kutethemes.net", $home_url, $_menu_item_url );
								$_menu_item_url = str_replace( "http://maxstore.kutethemes.net", $home_url, $_menu_item_url );
								update_post_meta( $item->ID, '_menu_item_url', $_menu_item_url );
							}
						}
					}
				}
			}
		}
	}

	new Ovic_Import_Demo_Content();
}
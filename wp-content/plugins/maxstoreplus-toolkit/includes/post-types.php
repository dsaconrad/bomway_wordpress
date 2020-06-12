<?php

if ( !defined( 'ABSPATH' ) ) exit;

function register_post_type_init()
{
	/* portfolio */
	$labels = array(
		'name'               => _x( 'portfolios', 'boutique' ),
		'singular_name'      => _x( 'portfolio', 'boutique' ),
		'add_new'            => __( 'Add New', 'boutique' ),
		'all_items'          => __( 'All portfolios', 'boutique' ),
		'add_new_item'       => __( 'Add New portfolio', 'boutique' ),
		'edit_item'          => __( 'Edit portfolio', 'boutique' ),
		'new_item'           => __( 'New portfolio', 'boutique' ),
		'view_item'          => __( 'View portfolio', 'boutique' ),
		'search_items'       => __( 'Search portfolio', 'boutique' ),
		'not_found'          => __( 'No portfolio found', 'boutique' ),
		'not_found_in_trash' => __( 'No portfolio found in Trash', 'boutique' ),
		'parent_item_colon'  => __( 'Parent portfolio', 'boutique' ),
		'menu_name'          => __( 'portfolios', 'boutique' ),
	);
	$args   = array(
		'labels'              => $labels,
		'description'         => 'Post type portfolio',
		'supports'            => array(
			'title',
			'editor',
			'excerpt',
			'author',
			'thumbnail',
			'comments',
			'revisions',
			'custom-fields',
		),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'menu_icon'           => 'dashicons-admin-site',
	);

	register_post_type( 'portfolio', $args );

	// Taxonomy portfolio
	$labels = array(
		'name'                  => _x( 'Categories', 'category portfolios', 'boutique' ),
		'singular_name'         => _x( 'Category', 'category portfolio', 'boutique' ),
		'menu_name'             => __( 'Categories', 'boutique' ),
		'all_items'             => __( 'All Categories', 'boutique' ),
		'parent_item'           => '',
		'parent_item_colon'     => '',
		'new_item_name'         => __( 'New Category', 'boutique' ),
		'add_new_item'          => __( 'Add New Category', 'boutique' ),
		'edit_item'             => __( 'Edit Category', 'boutique' ),
		'update_item'           => __( 'Update Category', 'boutique' ),
		'search_items'          => __( 'Search Category', 'boutique' ),
		'add_or_remove_items'   => __( 'Add New or Delete Category', 'boutique' ),
		'choose_from_most_used' => __( 'Choose from most used', 'boutique' ),
		'not_found'             => __( 'Category not found', 'boutique' ),
	);
	$args   = array(
		'labels'                => $labels,
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'show_in_nav_menus'     => true,
		'show_tagcloud'         => false,
		'update_count_callback' => '_update_post_term_count'
	);
	register_taxonomy( 'category_portfolio', array( 'portfolio' ), $args );

	$labels = array(
		'name'               => __( 'Mega Menu', 'boutique' ),
		'singular_name'      => __( 'Mega Menu Item', 'boutique' ),
		'add_new'            => __( 'Add New', 'boutique' ),
		'add_new_item'       => __( 'Add New Menu Item', 'boutique' ),
		'edit_item'          => __( 'Edit Menu Item', 'boutique' ),
		'new_item'           => __( 'New Menu Item', 'boutique' ),
		'view_item'          => __( 'View Menu Item', 'boutique' ),
		'search_items'       => __( 'Search Menu Items', 'boutique' ),
		'not_found'          => __( 'No Menu Items found', 'boutique' ),
		'not_found_in_trash' => __( 'No Menu Items found in Trash', 'boutique' ),
		'parent_item_colon'  => __( 'Parent Menu Item:', 'boutique' ),
		'menu_name'          => __( 'Menu Builder', 'boutique' ),
	);

	$args = array(
		'labels'              => $labels,
		'hierarchical'        => false,
		'description'         => __( 'Mega Menus.', 'boutique' ),
		'supports'            => array( 'title', 'editor' ),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => 'maxstoreplus',
		'menu_position'       => 40,
		'show_in_nav_menus'   => true,
		'publicly_queryable'  => false,
		'exclude_from_search' => true,
		'has_archive'         => false,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => false,
		'capability_type'     => 'page',
		'menu_icon'           => 'dashicons-welcome-widgets-menus',
	);

	register_post_type( 'megamenu', $args );

	$labels = array(
		'name'               => __( 'Footer', 'boutique' ),
		'singular_name'      => __( 'Footer Footer', 'boutique' ),
		'add_new'            => __( 'Add New', 'boutique' ),
		'add_new_item'       => __( 'Add New Footer Item', 'boutique' ),
		'edit_item'          => __( 'Edit Footer Item', 'boutique' ),
		'new_item'           => __( 'New Footer Item', 'boutique' ),
		'view_item'          => __( 'View Footer Item', 'boutique' ),
		'search_items'       => __( 'Search Footer Items', 'boutique' ),
		'not_found'          => __( 'No Footer Items found', 'boutique' ),
		'not_found_in_trash' => __( 'No Footer Items found in Trash', 'boutique' ),
		'parent_item_colon'  => __( 'Parent Footer Item:', 'boutique' ),
		'menu_name'          => __( 'Footer Builder', 'boutique' ),
	);

	$args = array(
		'labels'              => $labels,
		'hierarchical'        => true,
		'description'         => __( 'To Build Template Footer.', 'boutique' ),
		'supports'            => array( 'title', 'editor' ),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => 'maxstoreplus',
		'menu_position'       => 40,
		'show_in_nav_menus'   => false,
		'publicly_queryable'  => false,
		'exclude_from_search' => true,
		'has_archive'         => false,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => false,
		'capability_type'     => 'page',
		'menu_icon'           => 'dashicons-welcome-widgets-menus',
	);

	register_post_type( 'footer', $args );

	flush_rewrite_rules();
}

add_action( 'init', 'register_post_type_init' );
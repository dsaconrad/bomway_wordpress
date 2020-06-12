<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'vc_before_init', 'maxstoreplus_blogs_settings' );
function maxstoreplus_blogs_settings()
{
	/* CATEGORY DRROPDOW */
	$categories_array = array(
		__( 'All', 'maxstoreplus-toolkit' ) => '',
	);
	$args             = array(
		'taxonomy' => 'category',
	);
	$categories       = get_categories( $args );
	foreach ( $categories as $category ) {
		$categories_array[$category->name] = $category->slug;
	}
	$params       = array(
		array(
			'type'        => 'kt_select_preview',
			'heading'     => __( 'Layout', 'maxstoreplus-toolkit' ),
			'value'       => array(
				'content-fomat-2' => array(
					'alt' => 'Default',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'blogs/default.jpg',
				),
				'content-fomat-4' => array(
					'alt' => 'layout1',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'blogs/layout1.jpg',
				),
				'content-fomat-5' => array(
					'alt' => 'layout2',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'blogs/layout2.jpg',
				),
				'content-fomat-6' => array(
					'alt' => 'layout3',
					'img' => MAXSTOREPLUS_SHORTCODE_IMG_URL . 'blogs/layout3.jpg',
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
			'value'       => array(
				__( 'Left', 'maxstoreplus-toolkit' )   => 'left',
				__( 'Right', 'maxstoreplus-toolkit' )  => 'right',
				__( 'Center', 'maxstoreplus-toolkit' ) => 'center',
			),
			'std'         => false,
			'heading'     => __( 'Content Align', 'maxstoreplus-toolkit' ),
			'param_name'  => 'content_align',
			'admin_label' => false,
		),
		/* group posts */
		array(
			'param_name'  => 'category_slug',
			'type'        => 'dropdown',
			'value'       => $categories_array,
			'heading'     => __( 'Category filter:', 'maxstoreplus-toolkit' ),
			"admin_label" => false,
			'dependency'  => array(
				'element' => 'target',
				'value'   => array( 'muti' ),
			),
			'group'       => __( 'Blogs settings', 'maxstoreplus-toolkit' ),
		),
		array(
			"type"        => "dropdown",
			"heading"     => __( "Order by", 'maxstoreplus-toolkit' ),
			"param_name"  => "orderby",
			"value"       => array(
				__( 'None', 'maxstoreplus-toolkit' )     => 'none',
				__( 'ID', 'maxstoreplus-toolkit' )       => 'ID',
				__( 'Author', 'maxstoreplus-toolkit' )   => 'author',
				__( 'Name', 'maxstoreplus-toolkit' )     => 'name',
				__( 'Date', 'maxstoreplus-toolkit' )     => 'date',
				__( 'Modified', 'maxstoreplus-toolkit' ) => 'modified',
				__( 'Rand', 'maxstoreplus-toolkit' )     => 'rand',
			),
			'std'         => 'date',
			"description" => __( "Select how to sort retrieved posts.", 'maxstoreplus-toolkit' ),
			'dependency'  => array(
				'element' => 'target',
				'value'   => array( 'muti' ),
			),
			'group'       => __( 'Blogs settings', 'maxstoreplus-toolkit' ),
		),
		array(
			"type"        => "dropdown",
			"heading"     => __( "Order", 'maxstoreplus-toolkit' ),
			"param_name"  => "order",
			"value"       => array(
				__( 'ASC', 'maxstoreplus-toolkit' )  => 'ASC',
				__( 'DESC', 'maxstoreplus-toolkit' ) => 'DESC',
			),
			'std'         => 'DESC',
			"description" => __( "Designates the ascending or descending order.", 'maxstoreplus-toolkit' ),
			'dependency'  => array(
				'element' => 'target',
				'value'   => array( 'muti' ),
			),
			'group'       => __( 'Blogs settings', 'maxstoreplus-toolkit' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => __( 'Number Post', 'maxstoreplus-toolkit' ),
			'param_name'  => 'per_page',
			'std'         => 3,
			'admin_label' => false,
			'description' => __( 'Number post in a slide', 'maxstoreplus-toolkit' ),
			'dependency'  => array(
				'element' => 'target',
				'value'   => array( 'muti' ),
			),
			'group'       => __( 'Blogs settings', 'maxstoreplus-toolkit' ),
		),
		// responsive ---------------------------------------------------
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
			"value"       => "200",
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
		// responsive ---------------------------------------------------
		array(
			"type"        => "dropdown",
			"heading"     => __( "Target", 'maxstoreplus-toolkit' ),
			"param_name"  => "target",
			"value"       => array(
				__( 'Muti Blog', 'maxstoreplus-toolkit' )   => 'muti',
				__( 'Single Blog', 'maxstoreplus-toolkit' ) => 'single',
			),
			'std'         => 'muti',
			"description" => __( "Select how to get posts.", 'maxstoreplus-toolkit' ),
			'group'       => __( 'Blogs settings', 'maxstoreplus-toolkit' ),
		),
		array(
			'type'        => 'autocomplete',
			'class'       => '',
			'heading'     => esc_html__( 'Post Name', 'maxstoreplus-toolkit' ),
			'param_name'  => 'ids_post',
			'settings'    => array(
				'multiple'      => true,
				'sortable'      => true,
				'unique_values' => true,
				'values'        => maxstore_get_posts_data(),
			),
			'description' => __( 'Enter List of post name', 'maxstoreplus-toolkit' ),
			'dependency'  => array(
				'element' => 'target',
				'value'   => array( 'single' ),
			),
			'group'       => __( 'Blogs settings', 'maxstoreplus-toolkit' ),
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
		'name'        => esc_html__( 'Maxstore: Blogs', 'maxstoreplus-toolkit' ),
		'base'        => 'maxstoreplus_blogs', // shortcode
		'class'       => '',
		'category'    => esc_html__( 'Maxstore Plus', 'maxstoreplus-toolkit' ),
		'description' => __( 'Display a Posts.', 'maxstoreplus-toolkit' ),
		'params'      => $params,
	);
	vc_map( $map_settings );
}

function maxstoreplus_blogs( $atts )
{
	$atts         = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'maxstoreplus_blogs', $atts ) : $atts;
	$default_atts = array(
		'layout'         => 'content-fomat-1',
		'content_align'  => '',
		'ids_post'       => '',
		'title'          => '',
		'target'         => '',
		'category_slug'  => '',
		'per_page'       => 10,
		'orderby'        => 'date',
		'order'          => 'desc',
		'status'         => '',
		'css'            => '',
		'items'          => '',
		'el_class'       => '',
		'owl_autoplay'   => false,
		'owl_navigation' => true,
		'owl_dots'       => false,
		'owl_loop'       => false,
		'owl_slidespeed' => 200,
		'owl_margin'     => 0,
		'owl_lg_items'   => 4,
		'owl_md_items'   => 3,
		'owl_sm_items'   => 3,
		'owl_xs_items'   => 2,
		'owl_ts_items'   => 1,
	);
	extract( shortcode_atts( $default_atts, $atts ) );
	$css_class = $el_class . ' ' . $layout . ' ' . $status . ' ' . $content_align . '';
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;
	$owl_carousel = maxstore_generate_carousel_data_attributes( 'owl_', $atts );
	$args         = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'posts_per_page'      => $per_page,
		'suppress_filter'     => true,
		'orderby'             => $orderby,
		'order'               => $order,
	);
	if ( !empty( $ids_post ) ) {
		$args['p'] = $ids_post;
	}
	if ( $category_slug ) {
		$idObj = get_category_by_slug( $category_slug );
		if ( is_object( $idObj ) ) {
			$args['cat'] = $idObj->term_id;
		}
	}
	$loop_posts = new WP_Query( apply_filters( 'maxstore_shortcode_posts_query', $args, $atts ) );
	ob_start();
	if ( $layout != 'content-fomat-6' ) : ?>
		<?php if ( $loop_posts->have_posts() ) : ?>
            <div class="blog-content">
                <div class="owl-carousel blog-style5 nav-style-1 <?php echo esc_attr( $css_class ) ?>" <?php echo $owl_carousel; ?>>
					<?php while ( $loop_posts->have_posts() ) : $loop_posts->the_post() ?>
						<?php get_template_part( 'templates/blogs/fomat/' . $layout . '' ); ?>
					<?php endwhile; ?>
                </div>
            </div>
		<?php endif; ?>
	<?php else : ?>
		<?php if ( $loop_posts->have_posts() ) : ?>
            <div class="blog-content <?php echo esc_attr( $css_class ) ?>">
                <h2 class="title"><?php echo esc_html( $title ) ?></h2>
                <div class="blog-style5">
					<?php while ( $loop_posts->have_posts() ) : $loop_posts->the_post() ?>
						<?php get_template_part( 'templates/blogs/fomat/' . $layout . '' ); ?>
					<?php endwhile; ?>
                </div>
            </div>
		<?php endif; ?>
	<?php endif;
	wp_reset_query();

	return ob_get_clean();
}

add_shortcode( 'maxstoreplus_blogs', 'maxstoreplus_blogs' );

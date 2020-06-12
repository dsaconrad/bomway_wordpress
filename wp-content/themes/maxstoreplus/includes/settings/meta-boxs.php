<?php

add_filter( 'cmb2_init', 'corporatepro_post_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @return array
 */
if( !function_exists('corporatepro_post_metaboxes')){
	function corporatepro_post_metaboxes() {
		// Start with an underscore to hide fields from custom fields list
		$prefix = '_corporatepro_';


		/* Testimonial */
		$meta_boxes = new_cmb2_box(
			array(
				'title'        => __( 'Video link', 'maxstoreplus' ),
				'id'           => 'corporatepro_video',
				'object_types' => array( 'product' ), // Post type
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true, // Show field names on the left
			)
		);

		$field_args = array(
			array(
				'name'         => 'URL video',
				'desc'         => '',
				'id'           => $prefix . 'url_video',
				'type'         => 'text_url',
			),
		);

		foreach ( $field_args as $field ):

			$meta_boxes->add_field( $field );

		endforeach;

		/* FOOTER */
		$meta_boxes = new_cmb2_box(
			array(
				'title'        => __( 'Footer Options', 'maxstoreplus' ),
				'id'           => 'corporatepro_footer_metas',
				'object_types' => array( 'footer' ), // Post type
				// 'show_on_cb' => 'lena_core_show_if_front_page', // function should return a bool value
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true, // Show field names on the left
				// 'cmb_styles' => false, // false to disable the CMB stylesheet
				// 'closed'     => true, // true to keep the metabox closed by default
			)
		);
		$layoutDir = get_template_directory().'/templates/footers/';
		$footer_style_options = array(
		    'default'   =>  __('Default', 'maxstoreplus'),
		);
		if(is_dir($layoutDir)){
		    $files = scandir($layoutDir);
		    if($files && is_array($files)){
		        $option = '';
		        foreach ($files as $file){
		            if ($file != '.' && $file != '..'){
		                $fileInfo = pathinfo($file);
		                if($fileInfo['extension'] == 'php'){
		                    $file_data = get_file_data( $layoutDir.$file, array('Name'=>'Name') );
		                    $file_name = str_replace('footer-', '', $fileInfo['filename']);
		                    $footer_style_options[$file_name] = array(
		                        'label' => $file_data['Name'],
		                        'attr'  => get_template_directory_uri(). '/templates/footers/footer-'.$file_name.'.jpg',
		                    );
		                }
		            }
		        }
		    }
		}
		$field_args = array(
			array(
                'name'             => __( 'Footer style', 'maxstoreplus' ),
                'desc'             => __( 'Select an option', 'maxstoreplus' ),
                'id'               => $prefix.'template_style',
                'type'             => 'select',
                'show_option_none' => false,
                'options'          => $footer_style_options,
            )
		);

		foreach ( $field_args as $field ):

			$meta_boxes->add_field( $field );

		endforeach;

		/* PAGES*/
        $meta_boxes = new_cmb2_box(
            array(
                'title'        => __( 'Page Options', 'maxstoreplus' ),
                'id'           => 'corporatepro_page_metas',
                'object_types' => array( 'page' ), // Post type
                // 'show_on_cb' => 'lena_core_show_if_front_page', // function should return a bool value
                'context'      => 'normal',
                'priority'     => 'high',
                'show_names'   => true, // Show field names on the left
                // 'cmb_styles' => false, // false to disable the CMB stylesheet
                // 'closed'     => true, // true to keep the metabox closed by default
            )
        );
        $field_args = array(
            array(
                'name' => __( 'Page header backgound', 'maxstoreplus' ),
                'desc'    => __( 'Setting your page banner', 'maxstoreplus' ),
                'id'   =>  $prefix.'page_header_background',
                'type' => 'file'
            ),
            array(
                'name' => __( 'Page heading height', 'maxstoreplus' ),
                'id'   => $prefix.'page_heading_height',
                'type' => 'text',
                'desc'    => __( 'Unit PX', 'maxstoreplus' ),
            ),
            array(
                'name'             => __('Page layout','maxstoreplus'),
                'id'               => $prefix.'page_layout',
                'type'             => 'radio_image',
                'default'          => 'left',
                'options'          => array(
                    'left'  => get_template_directory_uri()  .'/images/2cl.png',
                    'right' => get_template_directory_uri()  .'/images/2cr.png',
                    'full'  => get_template_directory_uri()  .'/images/1column.png',
                ),
            ),
            array(
                'name'    => __( 'Sidebar', 'maxstoreplus' ),
                'id'      => $prefix.'page_used_sidebar',
                'type'    => 'sidebar_select',
                'default' => 'widget-area',
                'desc'    => __( 'Setting sidebar in the area sidebar', 'maxstoreplus' ),
                'dependency' => array(
                    'id'    => $prefix.'page_layout',
                    'value' => array( 'left', 'right' )
                )
            ),
            array(
                'name' => __( 'Extra page class', 'maxstoreplus' ),
                'desc' => __( 'If you wish to add extra classes to the body class of the page (for custom css use), then please add the class(es) here.', 'maxstoreplus' ),
                'id'   => $prefix.'page_extra_class',
                'type' => 'text',
            ),
        );

        foreach ( $field_args as $field ):

            $meta_boxes->add_field( $field );

        endforeach;

	}
}

<?php
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( !class_exists( 'maxstore_shortcode' ) ) {
	class  maxstore_shortcode
	{
		public function __construct()
		{
			add_action( 'after_setup_theme', array( &$this, 'checkVersionVC' ), 1 );
			add_action( 'vc_after_mapping', array( &$this, '__load' ) );
			/* Custom font Icon*/
			add_filter( 'vc_iconpicker-type-mscustomfonts', array( &$this, 'iconpicker_type_mscustomfonts' ) );
		}

		/**
		 * Check version visualcomposer
		 * @author ngocthang.ict
		 * @since 1.0
		 **/
		public function checkVersionVC()
		{
			if ( !defined( 'WPB_VC_VERSION' ) ) {
				return;
			}
			if ( version_compare( WPB_VC_VERSION, '4.2', '<' ) ) {
				add_action( 'init', array( &$this, 'params' ), 100 );
			} else {
				add_action( 'vc_after_mapping', array( &$this, 'params' ) );
			}
		}

		/**
		 * Custom param for visual composer
		 * @author ngocthang.ict
		 * @since 1.0
		 **/
		public function params()
		{
			//vc_shortcodes_theme_templates_dir( get_stylesheet_directory() . '/vc_templates/' );
			global $vc_setting_row, $vc_setting_col, $vc_setting_column_inner, $vc_setting_icon_shortcode;
			vc_add_params( 'vc_icon', $vc_setting_icon_shortcode );
			vc_add_params( 'vc_column', $vc_setting_col );
			vc_add_params( 'vc_column_inner', $vc_setting_column_inner );
			if ( function_exists( 'vc_add_shortcode_param' ) ) {
				vc_add_shortcode_param( 'kt_select_preview', array( &$this, 'select_preview_field' ) );
				vc_add_shortcode_param( 'kt_select_image', array( &$this, 'images_field' ) );
				vc_add_shortcode_param( 'kt_select_preview', array( &$this, 'select_preview_field' ) );
				vc_add_shortcode_param( 'kt_uniqid', array( &$this, 'kt_uniqid_field' ) );
				vc_add_shortcode_param( 'kt_number', array( &$this, 'number_field' ) );
				vc_add_shortcode_param( 'kt_inputtext_raw_html', array( &$this, 'kt_inputtext_raw_html_field' ) );
				vc_add_shortcode_param( 'kt_categories', array( &$this, 'categories_field' ) );
				vc_add_shortcode_param( 'kt_nav_menu', array( &$this, 'nav_menu_field' ) );
				vc_add_shortcode_param( 'kt_taxonomy', array( &$this, 'taxonomy_field' ) );
				vc_add_shortcode_param( 'kt_taxonomy_project', array( &$this, 'taxonomy_field_project' ) );
				vc_add_shortcode_param( 'kt_product_attributes', array( &$this, 'product_attributes' ) );
				vc_add_shortcode_param( 'kt_datetimepicker', array( &$this, 'datetimepicker_field' ) );
				vc_add_shortcode_param( 'kt_posts', array( &$this, 'post_type_field' ) );
				vc_add_shortcode_param( 'kt_animate', array( &$this, 'animate_field' ) );
			} else {
				vc_add_shortcode_param( 'kt_select_preview', array( &$this, 'select_preview_field' ) );
				vc_add_shortcode_param( 'kt_select_image', array( &$this, 'images_field' ) );
				vc_add_shortcode_param( 'kt_select_preview', array( &$this, 'select_preview_field' ) );
				vc_add_shortcode_param( 'kt_uniqid', array( &$this, 'kt_uniqid_field' ) );
				vc_add_shortcode_param( 'kt_number', array( &$this, 'number_field' ) );
				vc_add_shortcode_param( 'kt_inputtext_raw_html', array( &$this, 'kt_inputtext_raw_html_field' ) );
				vc_add_shortcode_param( 'kt_categories', array( &$this, 'categories_field' ) );
				vc_add_shortcode_param( 'kt_taxonomy_project', array( &$this, 'taxonomy_field_project' ) );
				vc_add_shortcode_param( 'kt_nav_menu', array( &$this, 'nav_menu_field' ) );
				vc_add_shortcode_param( 'kt_taxonomy', array( &$this, 'taxonomy_field' ) );
				vc_add_shortcode_param( 'kt_product_attributes', array( &$this, 'product_attributes' ) );
				vc_add_shortcode_param( 'kt_datetimepicker', array( &$this, 'datetimepicker_field' ) );
				vc_add_shortcode_param( 'kt_posts', array( &$this, 'post_type_field' ) );
				vc_add_shortcode_param( 'kt_animate', array( &$this, 'animate_field' ) );
			}
		}

		public function select_preview_field( $settings, $value )
		{
			ob_start();
			// Get menus list
			$options = $settings['value'];
			$default = $settings['default'];
			if ( is_array( $options ) && count( $options ) > 0 ) {
				$uniqeID = uniqid();
				$i       = 0;
				?>
                <div class="container-select_preview">
                    <select id="kt_select_preview-<?php echo $uniqeID ?>" name="<?php echo $settings['param_name'] ?>"
                            class="vc_select_image wpb_vc_param_value wpb-input wpb-select <?php $settings['param_name'] ?> <?php echo $settings['type'] ?>_field">
						<?php foreach ( $options as $k => $option ): ?>
							<?php
							if ( $i == 0 ) {
								$first_value = $k;
							}
							$i++;
							?>
							<?php $selected = ( $k == $value ) ? ' selected="selected"' : ''; ?>
                            <option data-img="<?php echo esc_url( $option['img'] ); ?>"
                                    value='<?php echo esc_attr( $k ) ?>' <?php echo esc_attr( $selected ) ?>><?php echo esc_attr( $option['alt'] ) ?></option>
						<?php endforeach; ?>
                    </select>
                    <div class="image-preview">
						<?php if ( isset( $options[$value] ) && $options[$value] && ( isset( $options[$value]['img'] ) ) ): ?>
                            <img style="margin-top: 10px; max-width: 100%;height: auto;"
                                 src="<?php echo esc_url( $options[$value]['img'] ); ?>" alt="">
						<?php else: ?>
                            <img style="margin-top: 10px; max-width: 100%;height: auto;"
                                 src="<?php echo esc_url( $options[$default]['img'] ); ?>" alt="">
						<?php endif; ?>
                    </div>
                </div>
                <script type="text/javascript">
                    (function ($) {
                        "use strict";
                        $(document).on('change', '#kt_select_preview-<?php echo $uniqeID ?>', function () {
                            var url = $(this).find(':selected').data('img');
                            $(this).closest('.container-select_preview').find('.image-preview img').attr('src', url);
                        });
                    })(jQuery);
                </script>
				<?php
			}

			return ob_get_clean();
		}

		public function taxonomy_field_project( $settings, $value )
		{
			$dependency = '';
			$value_arr  = $value;
			if ( !is_array( $value_arr ) ) {
				$value_arr = array_map( 'trim', explode( ',', $value_arr ) );
			}
			$output = '';
			if ( isset( $settings['hide_empty'] ) && $settings['hide_empty'] ) {
				$settings['hide_empty'] = 1;
			} else {
				$settings['hide_empty'] = 0;
			}
			if ( !empty( $settings['taxonomy'] ) ) {
				$terms_fields = array();
				if ( isset( $settings['placeholder'] ) && $settings['placeholder'] ) {
					$terms_fields[] = "<option value=''>" . $settings['placeholder'] . "</option>";
				}
				$terms = get_terms( $settings['taxonomy'], array( 'hide_empty' => false, 'parent' => $settings['parent'], 'hide_empty' => $settings['hide_empty'] ) );
				if ( $terms && !is_wp_error( $terms ) ) {
					foreach ( $terms as $term ) {
						$selected       = ( in_array( $term->slug, $value_arr ) ) ? ' selected="selected"' : '';
						$terms_fields[] = "<option value='{$term->slug}' {$selected}>{$term->name}</option>";
					}
				}
				$size     = ( !empty( $settings['size'] ) ) ? 'size="' . $settings['size'] . '"' : '';
				$multiple = ( !empty( $settings['multiple'] ) ) ? 'multiple="multiple"' : '';
				$uniqeID  = uniqid();
				$output   = '<select style="width:100%;" id="kt_taxonomy-' . $uniqeID . '" ' . $multiple . ' ' . $size . ' name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '_field" ' . $dependency . '>'
					. implode( $terms_fields )
					. '</select>';
				$output   .= '<script type="text/javascript">jQuery("#kt_taxonomy-' . $uniqeID . '").chosen();</script>';
			}

			return $output;
		}

		public function kt_inputtext_raw_html_field( $settings, $value )
		{
			$dependency = '';
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type       = isset( $settings['type '] ) ? $settings['type'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			if ( !$value && isset( $settings['std'] ) ) {
				$value = $settings['std'];
			}
			$output = '<input type="text" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . htmlentities( rawurldecode( base64_decode( $value ) ), ENT_COMPAT, 'UTF-8' ) . '" ' . $dependency . ' />';

			return $output;
		}

		public function images_field( $settings, $value )
		{
			ob_start(); ?>
            <div class="container-kt-select-image">
				<?php foreach ( $settings['value'] as $k => $v ): ?>
                    <label class="kt-image-select kt-image-select " for="kt-select-image-<?php echo esc_attr( $v ) ?>">
                        <input name="kt-select-image-<?php echo esc_attr( $settings['param_name'] ); ?>"
                               value="<?php echo esc_attr( $v ) ?>" <?php checked( $v, $value, 1 ) ?>
                               id="kt-select-image-<?php echo esc_attr( $v ) ?>" style="display: none;" type="radio"
                               class="wpb_vc_param_value"/>
                        <img src="<?php echo esc_attr( $k ) ?>" alt="<?php echo esc_attr( $v ) ?>"/>
                    </label>
				<?php endforeach; ?>
                <img/>
            </div>
			<?php
			return ob_get_clean();
		}

		public function kt_uniqid_field( $settings, $value )
		{
			if ( !$value ) {
				$value = uniqid( hash( 'crc32', $settings['param_name'] ) . '-' );
			}
			$output = '<input type="text" class="wpb_vc_param_value textfield" name="' . $settings['param_name'] . '" value="' . esc_attr( $value ) . '" />';

			return $output;
		}

		public function number_field( $settings, $value )
		{
			$dependency = '';
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type       = isset( $settings['type '] ) ? $settings['type'] : '';
			$min        = isset( $settings['min'] ) ? $settings['min'] : '';
			$max        = isset( $settings['max'] ) ? $settings['max'] : '';
			$suffix     = isset( $settings['suffix'] ) ? $settings['suffix'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			if ( !$value && isset( $settings['std'] ) ) {
				$value = $settings['std'];
			}
			$output = '<input type="number" min="' . esc_attr( $min ) . '" max="' . esc_attr( $max ) . '" class="wpb_vc_param_value textfield ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . esc_attr( $value ) . '" ' . $dependency . ' style="max-width:100px; margin-right: 10px;" />' . $suffix;

			return $output;
		}

		public function categories_field( $settings, $value )
		{
			$args = array(
				'id'           => $settings['param_name'],
				'name'         => $settings['param_name'],
				'class'        => 'select-category wpb_vc_param_value',
				'hide_empty'   => 1,
				'orderby'      => 'name',
				'order'        => "desc",
				'tab_index'    => true,
				'hierarchical' => true,
				'echo'         => 0,
				'selected'     => $value,
			);
			if ( kt_is_wc() ) {
				$args['taxonomy'] = 'product_cat';
			}

			return wp_dropdown_categories( $args );
		}

		public function nav_menu_field( $settings, $value )
		{
			// Get menus list
			$value_arr = $value;
			if ( !is_array( $value_arr ) ) {
				$value_arr = array_map( 'trim', explode( ',', $value_arr ) );
			}
			ob_start();
			$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
			if ( $menus && !is_wp_error( $menus ) ) : $uniqeID = uniqid(); ?>
                <select id="kt_nav-<?php echo $uniqeID ?>" multiple="multiple"
                        name="<?php echo $settings['param_name'] ?>"
                        class="wpb_vc_param_value wpb-input wpb-select <?php $settings['param_name'] ?> <?php echo $settings['type'] ?>_field">
					<?php foreach ( $menus as $menu ): $selected = ( in_array( $menu->slug, $value_arr ) ) ? ' selected="selected"' : ''; ?>
                        <option value='<?php echo esc_attr( $menu->slug ) ?>' <?php echo esc_attr( $selected ) ?>><?php echo esc_attr( $menu->name ) ?></option>
					<?php endforeach; ?>
                </select>
                <script type="text/javascript">jQuery("#kt_nav-<?php echo esc_attr( $uniqeID )  ?>").chosen();</script>
			<?php endif;

			return ob_get_clean();
		}

		public function product_attributes( $settings, $value )
		{
			// Get attributes list
			$value_arr = $value;
			if ( !is_array( $value_arr ) ) {
				$value_arr = array_map( 'trim', explode( ',', $value_arr ) );
			}
			ob_start();
			$multiple             = ( !empty( $settings['multiple'] ) ) ? 'multiple="multiple"' : '';
			$attribute_taxonomies = wc_get_attribute_taxonomies();
			if ( $attribute_taxonomies && !is_wp_error( $attribute_taxonomies ) ) : $uniqeID = uniqid(); ?>
                <select id="kt_nav-<?php echo $uniqeID ?>" <?php echo $multiple; ?>
                        name="<?php echo $settings['param_name'] ?>"
                        class="wpb_vc_param_value wpb-input wpb-select <?php $settings['param_name'] ?> <?php echo $settings['type'] ?>_field">
					<?php foreach ( $attribute_taxonomies as $attr ):
						$selected = ( in_array( $attr->attribute_name, $value_arr ) ) ? ' selected="selected"' : '';
						?>
                        <option value='<?php echo esc_attr( $attr->attribute_name ) ?>' <?php echo esc_attr( $selected ) ?> ><?php echo esc_attr( $attr->attribute_label ) ?></option>
					<?php endforeach; ?>
                </select>
                <script type="text/javascript">jQuery("#kt_nav-<?php echo esc_attr( $uniqeID )  ?>").chosen();</script>
			<?php endif;

			return ob_get_clean();
		}

		public function taxonomy_field( $settings, $value )
		{
			$dependency = '';
			$value_arr  = $value;
			if ( !is_array( $value_arr ) ) {
				$value_arr = array_map( 'trim', explode( ',', $value_arr ) );
			}
			$output = '';
			if ( isset( $settings['hide_empty'] ) && $settings['hide_empty'] ) {
				$settings['hide_empty'] = 1;
			} else {
				$settings['hide_empty'] = 0;
			}
			if ( !empty( $settings['taxonomy'] ) ) {
				$terms_fields = array();
				if ( isset( $settings['placeholder'] ) && $settings['placeholder'] ) {
					$terms_fields[] = "<option value=''>" . $settings['placeholder'] . "</option>";
				}
				$terms = get_terms( $settings['taxonomy'], array( 'hide_empty' => false, 'parent' => $settings['parent'], 'hide_empty' => $settings['hide_empty'] ) );
				if ( $terms && !is_wp_error( $terms ) ) {
					foreach ( $terms as $term ) {
						$selected       = ( in_array( $term->slug, $value_arr ) ) ? ' selected="selected"' : '';
						$terms_fields[] = "<option value='{$term->slug}' {$selected}>{$term->name}</option>";
					}
				}
				$size     = ( !empty( $settings['size'] ) ) ? 'size="' . $settings['size'] . '"' : '';
				$multiple = ( !empty( $settings['multiple'] ) ) ? 'multiple="multiple"' : '';
				$uniqeID  = uniqid();
				$output   = '<select style="width:100%;" id="kt_taxonomy-' . $uniqeID . '" ' . $multiple . ' ' . $size . ' name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '_field" ' . $dependency . '>'
					. implode( $terms_fields )
					. '</select>';
				$output   .= '<script type="text/javascript">jQuery("#kt_taxonomy-' . $uniqeID . '").chosen();</script>';
			}

			return $output;
		}

		public function datetimepicker_field( $settings, $value )
		{
			if ( !wp_script_is( 'jquery-ui-datepicker' ) ) {
				wp_enqueue_script( 'jquery-ui-datepicker' );
			}
			$dependency = '';
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type       = isset( $settings['type'] ) ? $settings['type'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			$uni        = uniqid();
			$output     = '<div class="kt-datetime"><input id="kt-date-time' . $uni . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" style="width:258px;" value="' . $value . '" ' . $dependency . '/><div class="add-on" >  <i data-time-icon="Defaults-time" data-date-icon="Defaults-time"></i></div></div>';
			$output     .= '<script type="text/javascript">
        		jQuery(document).ready(function(){
        			jQuery("#kt-date-time' . $uni . '").datepicker({ dateFormat: "yy/mm/dd 12:00:00" });
        		})
        		</script>';

			return $output;
		}

		public function post_type_field( $settings, $value )
		{
			$dependency = '';
			$value_arr  = $value;
			if ( !is_array( $value_arr ) ) {
				$value_arr = array_map( 'trim', explode( ',', $value_arr ) );
			}
			$output = '';
			if ( isset( $settings['hide_empty'] ) && $settings['hide_empty'] ) {
				$settings['hide_empty'] = 1;
			} else {
				$settings['hide_empty'] = 0;
			}
			$settings['post_type'] = $settings['post_type'] ? $settings['post_type'] : 'post';
			$terms_fields          = array();
			if ( isset( $settings['placeholder'] ) && $settings['placeholder'] ) {
				$terms_fields[] = "<option value=''>" . $settings['placeholder'] . "</option>";
			}
			$posts = get_posts( array( 'post_type' => 'template', 'posts_per_page' => -1 ) );
			if ( $posts && !is_wp_error( $posts ) ) {
				foreach ( $posts as $post ) {
					setup_postdata( $post );
					$selected       = ( in_array( $post->ID, $value_arr ) ) ? ' selected="selected"' : '';
					$posts_fields[] = "<option value='{$post->ID}' {$selected}>{$post->post_title}</option>";
				}
			}
			$size     = ( !empty( $settings['size'] ) ) ? 'size="' . $settings['size'] . '"' : '';
			$multiple = ( !empty( $settings['multiple'] ) ) ? 'multiple="multiple"' : '';
			$uniqeID  = uniqid();
			$output   = '<select id="kt_post_type-' . $uniqeID . '" ' . $multiple . ' ' . $size . ' name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '_field" ' . $dependency . '>'
				. implode( $posts_fields )
				. '</select>';
			$output   .= '<script type="text/javascript">jQuery("#kt_post_type-' . $uniqeID . '").chosen();</script>';

			return $output;
		}

		public function animate_field( $settings, $value )
		{
			// Animate list
			$animate_arr = array(
				'bounce',
				'flash',
				'pulse',
				'rubberBand',
				'shake',
				'headShake',
				'swing',
				'tada',
				'wobble',
				'jello',
				'bounceIn',
				'bounceInDown',
				'bounceInLeft',
				'bounceInRight',
				'bounceInUp',
				'bounceOut',
				'bounceOutDown',
				'bounceOutLeft',
				'bounceOutRight',
				'bounceOutUp',
				'fadeIn',
				'fadeInDown',
				'fadeInDownBig',
				'fadeInLeft',
				'fadeInLeftBig',
				'fadeInRight',
				'fadeInRightBig',
				'fadeInUp',
				'fadeInUpBig',
				'fadeOut',
				'fadeOutDown',
				'fadeOutDownBig',
				'fadeOutLeft',
				'fadeOutLeftBig',
				'fadeOutRight',
				'fadeOutRightBig',
				'fadeOutUp',
				'fadeOutUpBig',
				'flipInX',
				'flipInY',
				'flipOutX',
				'flipOutY',
				'lightSpeedIn',
				'lightSpeedOut',
				'rotateIn',
				'rotateInDownLeft',
				'rotateInDownRight',
				'rotateInUpLeft',
				'rotateInUpRight',
				'rotateOut',
				'rotateOutDownLeft',
				'rotateOutDownRight',
				'rotateOutUpLeft',
				'rotateOutUpRight',
				'hinge',
				'rollIn',
				'rollOut',
				'zoomIn',
				'zoomInDown',
				'zoomInLeft',
				'zoomInRight',
				'zoomInUp',
				'zoomOut',
				'zoomOutDown',
				'zoomOutLeft',
				'zoomOutRight',
				'zoomOutUp',
				'slideInDown',
				'slideInLeft',
				'slideInRight',
				'slideInUp',
				'slideOutDown',
				'slideOutLeft',
				'slideOutRight',
				'slideOutUp',
			);
			$uniqeID     = uniqid();
			ob_start();
			?>
            <select id="kt_animate-<?php echo $uniqeID ?>" name="<?php echo $settings['param_name'] ?>"
                    class="wpb_vc_param_value wpb-input wpb-select <?php echo $settings['param_name']; ?> <?php echo $settings['type'] ?>_field">
                <option value=""><?php esc_html_e( 'None', 'kute-toolkit' ) ?></option>
				<?php foreach ( $animate_arr as $animate ):
					$selected = ( $value == $animate ) ? ' selected="selected"' : '';
					?>
                    <option value='<?php echo esc_attr( $animate ) ?>' <?php echo esc_attr( $selected ) ?>><?php echo esc_attr( $animate ) ?></option>
				<?php endforeach; ?>
            </select>
			<?php
			return ob_get_clean();
		}

		public function scripts()
		{
		}

		/**
		 * load param autocomplete render
		 * */
		public function __load()
		{
			//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
			add_filter( 'vc_autocomplete_maxstore_products_ids_callback', array( &$this, 'productIdAutocompleteSuggester' ), 10, 1 ); // Get suggestion(find). Must return an array
			add_filter( 'vc_autocomplete_coporate_megacategories_ids_render', array( &$this, 'productIdAutocompleteRender' ), 10, 1 );  //Render exact product. Must return an array (label,value).
			add_filter( 'vc_autocomplete_coporate_mega_category_ids_callback', array( &$this, 'productIdAutocompleteSuggester' ), 10, 1 ); // Get suggestion(find). Must return an array
			add_filter( 'vc_autocomplete_coporate_mega_category_ids_render', array( &$this, 'productIdAutocompleteRender' ), 10, 1 );  //Render exact product. Must return an array (label,value).
			add_filter( 'vc_autocomplete_coporate_woocommerce_products_ids_callback', array( &$this, 'productIdAutocompleteSuggester' ), 10, 1 ); // Get suggestion(find). Must return an array
			add_filter( 'vc_autocomplete_coporate_woocommerce_products_ids_render', array( &$this, 'productIdAutocompleteRender' ), 10, 1 );  //Render exact product. Must return an array (label,value).
			add_action( 'wp_ajax_vc_woocommerce_get_attribute_terms', array(
					&$this,
					'getAttributeTermsAjax',
				)
			);
			//Filters For autocomplete param:
			//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
			add_filter( 'vc_autocomplete_kt_single_banner_id_callback', array(
				&$this,
				'productIdAutocompleteSuggester',
			), 10, 1
			); // Get suggestion(find). Must return an array
			add_filter( 'vc_autocomplete_kt_single_banner_id_render', array(
				&$this,
				'productIdAutocompleteRender',
			), 10, 1
			); // Render exact product. Must return an array (label,value)
			//For param: ID default value filter
			add_filter( 'vc_form_fields_render_field_kt_single_banner_id_param_value', array(
				&$this,
				'productIdDefaultValue',
			), 10, 4
			); // Defines default value for param if not provided. Takes from other param value.
			//Filters For autocomplete param:
			//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
			add_filter( 'vc_autocomplete_kt_banner_product_id_callback', array(
				&$this,
				'productIdAutocompleteSuggester',
			), 10, 1
			); // Get suggestion(find). Must return an array
			add_filter( 'vc_autocomplete_kt_banner_product_id_render', array(
				&$this,
				'productIdAutocompleteRender',
			), 10, 1
			);  //Render exact product. Must return an array (label,value).
			//Filters For autocomplete param:
			//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
			add_filter( 'vc_autocomplete_kt_deals_of_day_ids_callback', array(
				&$this,
				'productIdAutocompleteSuggester',
			), 10, 1
			); // Get suggestion(find). Must return an array
			add_filter( 'vc_autocomplete_kt_deals_of_day_ids_render', array(
				&$this,
				'productIdAutocompleteRender',
			), 10, 1
			);  //Render exact product. Must return an array (label,value).
			//Filters For autocomplete param:
			//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
			add_filter( 'vc_autocomplete_maxstoreplus_categories_taxonomy_callback', array(
				&$this,
				'productCategoryCategoryAutocompleteSuggesterBySlug',
			), 10, 1
			); // Get suggestion(find). Must return an array
			add_filter( 'vc_autocomplete_maxstoreplus_categories_taxonomy_render', array(
				&$this,
				'productCategoryCategoryRenderBySlugExact',
			), 10, 1
			); // Render exact category by Slug. Must return an array (label,value)
			//Filters For autocomplete param:
			//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
			add_filter( 'vc_autocomplete_kt_products_ids_callback', array(
				&$this,
				'productIdAutocompleteSuggester',
			), 10, 1
			); // Get suggestion(find). Must return an array
			add_filter( 'vc_autocomplete_kt_products_ids_render', array(
				&$this,
				'productIdAutocompleteRender',
			), 10, 1
			);  //Render exact product. Must return an array (label,value).
			//Filters For autocomplete param:
			//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
			add_filter( 'vc_autocomplete_kt_woocommerce_ids_callback', array(
				&$this,
				'productIdAutocompleteSuggester',
			), 10, 1
			); // Get suggestion(find). Must return an array
			add_filter( 'vc_autocomplete_kt_woocommerce_ids_render', array(
				&$this,
				'productIdAutocompleteRender',
			), 10, 1
			);  //Render exact product. Must return an array (label,value).
			//Filters For autocomplete param:
			//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
			add_filter( 'vc_autocomplete_kt_menu_product_ids_callback', array(
				&$this,
				'productIdAutocompleteSuggester',
			), 10, 1
			); // Get suggestion(find). Must return an array
			add_filter( 'vc_autocomplete_kt_menu_product_ids_render', array(
				&$this,
				'productIdAutocompleteRender',
			), 10, 1
			);  //Render exact product. Must return an array (label,value).
			//Filters For autocomplete param:
			//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
			add_filter( 'vc_autocomplete_kt_woocommerce_taxonomy_callback', array(
				&$this,
				'productCategoryCategoryAutocompleteSuggesterBySlug',
			), 10, 1
			); // Get suggestion(find). Must return an array
			add_filter( 'vc_autocomplete_kt_woocommerce_taxonomy_render', array(
				&$this,
				'productCategoryCategoryRenderBySlugExact',
			), 10, 1
			); // Render exact category by Slug. Must return an array (label,value)
			//Filters For autocomplete param:
			//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
			add_filter( 'vc_autocomplete_kt_products_taxonomy_callback', array(
				&$this,
				'productCategoryCategoryAutocompleteSuggesterBySlug',
			), 10, 1
			); // Get suggestion(find). Must return an array
			add_filter( 'vc_autocomplete_kt_products_taxonomy_render', array(
				&$this,
				'productCategoryCategoryRenderBySlugExact',
			), 10, 1
			); // Render exact category by Slug. Must return an array (label,value)
			//Filters For autocomplete param:
			//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
			add_filter( 'vc_autocomplete_kt_collection_taxonomy_callback', array(
				&$this,
				'productCategoryCategoryAutocompleteSuggesterBySlug',
			), 10, 1
			); // Get suggestion(find). Must return an array
			add_filter( 'vc_autocomplete_kt_collection_taxonomy_render', array(
				&$this,
				'productCategoryCategoryRenderBySlugExact',
			), 10, 1
			); // Render exact category by Slug. Must return an array (label,value)
			//For param: "filter" param value
			//vc_form_fields_render_field_{shortcode_name}_{param_name}_param
			add_filter( 'vc_form_fields_render_field_kt_woocommerce_filter_param', array(
				&$this,
				'productAttributeFilterParamValue',
			), 10, 4
			); // Defines default value for param if not provided. Takes from other param value.
			add_filter( 'vc_form_fields_render_field_kt_deals_of_day_filter_param', array(
				&$this,
				'productAttributeFilterParamValue',
			), 10, 4
			); // Defines default value for param if not provided. Takes from other param value.
			//add_filter( 'vc_font_container_get_allowed_tags', array(&$this,'koolshop_vc_font_container_get_allowed_tags'),1,1 );
		}

		/**
		 * Suggester for autocomplete by id/name/title/sku
		 *
		 * @param $query
		 *
		 * @return array - id's from products with title/sku.
		 * @author Kutethemes
		 * @since 1.0
		 *
		 */
		public function productIdAutocompleteSuggester( $query )
		{
			global $wpdb;
			$product_id      = (int)$query;
			$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.ID AS id, a.post_title AS title, b.meta_value AS sku
    					FROM {$wpdb->posts} AS a
    					LEFT JOIN ( SELECT meta_value, post_id  FROM {$wpdb->postmeta} WHERE `meta_key` = '_sku' ) AS b ON b.post_id = a.ID
    					WHERE a.post_type = 'product' AND ( a.ID = '%d' OR b.meta_value LIKE '%%%s%%' OR a.post_title LIKE '%%%s%%' )", $product_id > 0 ? $product_id : -1, stripslashes( $query ), stripslashes( $query )
			), ARRAY_A
			);
			$results         = array();
			if ( is_array( $post_meta_infos ) && !empty( $post_meta_infos ) ) {
				foreach ( $post_meta_infos as $value ) {
					$data          = array();
					$data['value'] = $value['id'];
					$data['label'] = __( 'Id', 'js_composer' ) . ': ' . $value['id'] . ( ( strlen( $value['title'] ) > 0 ) ? ' - ' . __( 'Title', 'js_composer' ) . ': ' . $value['title'] : '' ) . ( ( strlen( $value['sku'] ) > 0 ) ? ' - ' . __( 'Sku', 'js_composer' ) . ': ' . $value['sku'] : '' );
					$results[]     = $data;
				}
			}

			return $results;
		}

		/**
		 * Find product by id
		 *
		 * @param $query
		 *
		 * @return bool|array
		 * @author Angels.IT
		 *
		 * @since 1.0
		 *
		 */
		public function productIdAutocompleteRender( $query )
		{
			$query = trim( $query['value'] ); // get value from requested
			if ( !empty( $query ) ) {
				// get product
				$product_object = wc_get_product( (int)$query );
				if ( is_object( $product_object ) ) {
					$product_sku         = $product_object->get_sku();
					$product_title       = $product_object->get_title();
					$product_id          = $product_object->id;
					$product_sku_display = '';
					if ( !empty( $product_sku ) ) {
						$product_sku_display = ' - ' . __( 'Sku', 'js_composer' ) . ': ' . $product_sku;
					}
					$product_title_display = '';
					if ( !empty( $product_title ) ) {
						$product_title_display = ' - ' . __( 'Title', 'js_composer' ) . ': ' . $product_title;
					}
					$product_id_display = __( 'Id', 'js_composer' ) . ': ' . $product_id;
					$data               = array();
					$data['value']      = $product_id;
					$data['label']      = $product_id_display . $product_title_display . $product_sku_display;

					return !empty( $data ) ? $data : false;
				}

				return false;
			}

			return false;
		}

		/**
		 * Replace single product sku to id.
		 *
		 * @param $current_value
		 * @param $param_settings
		 * @param $map_settings
		 * @param $atts
		 *
		 * @return bool|string
		 * @author Angels.IT
		 * @since 1.0
		 *
		 */
		public function productIdDefaultValue( $current_value, $param_settings, $map_settings, $atts )
		{
			$value = trim( $current_value );
			if ( strlen( trim( $current_value ) ) === 0 && isset( $atts['sku'] ) && strlen( $atts['sku'] ) > 0 ) {
				$value = $this->productIdDefaultValueFromSkuToId( $atts['sku'] );
			}

			return $value;
		}

		/**
		 * Suggester for autocomplete to find product category by id/name/slug but return found product category SLUG
		 *
		 * @param $query
		 *
		 * @return array - slug of products categories.
		 * @author Angels.IT
		 * @since 1.0
		 *
		 */
		public function productCategoryCategoryAutocompleteSuggesterBySlug( $query )
		{
			$result = $this->productCategoryCategoryAutocompleteSuggester( $query, true );

			return $result;
		}

		/**
		 * Search product category by slug.
		 *
		 * @param $query
		 *
		 * @return bool|array
		 * @author Angels.IT
		 * @since 1.0
		 *
		 */
		public function productCategoryCategoryRenderBySlugExact( $query )
		{
			$query = $query['value'];
			$query = trim( $query );
			if ( is_numeric( $query ) ) {
				$term = get_term_by( 'ID', $query, 'product_cat' );
			} else {
				$term = get_term_by( 'slug', $query, 'product_cat' );
			}

			return $this->productCategoryTermOutput( $term );
		}

		/**
		 * Search product category by id
		 *
		 * @param $query
		 *
		 * @return bool|array
		 * @since 1.0
		 *
		 */
		public function productCategoryCategoryRenderByIdExact( $query )
		{
			$query  = $query['value'];
			$cat_id = (int)$query;
			$term   = get_term( $cat_id, 'product_cat' );

			return $this->productCategoryTermOutput( $term );
		}

		/**
		 * Defines default value for param if not provided. Takes from other param value.
		 *
		 * @param array $param_settings
		 * @param       $current_value
		 * @param       $map_settings
		 * @param       $atts
		 *
		 * @return array
		 * @author Angels.IT
		 * @since 1.0
		 *
		 */
		public function productAttributeFilterParamValue( $param_settings, $current_value, $map_settings, $atts )
		{
			if ( isset( $atts['attribute'] ) ) {
				$value = $this->getAttributeTerms( $atts['attribute'] );
				if ( is_array( $value ) && !empty( $value ) ) {
					$param_settings['value'] = $value;
				}
			}

			return $param_settings;
		}

		/**
		 * Get attribute terms hooks from ajax request
		 * @since 1.0
		 */
		public function getAttributeTermsAjax()
		{
			vc_user_access()
				->checkAdminNonce()
				->validateDie()
				->wpAny( 'edit_posts', 'edit_pages' )
				->validateDie();
			$attribute  = vc_post_param( 'attribute' );
			$values     = $this->getAttributeTerms( $attribute );
			$param      = array(
				'param_name' => 'filter',
				'type'       => 'checkbox',
			);
			$param_line = '';
			foreach ( $values as $label => $v ) {
				$param_line .= ' <label class="vc_checkbox-label"><input id="' . $param['param_name'] . '-' . $v . '" value="' . $v . '" class="wpb_vc_param_value ' . $param['param_name'] . ' ' . $param['type'] . '" type="checkbox" name="' . $param['param_name'] . '"' . '> ' . $label . '</label>';
			}
			die( json_encode( $param_line ) );
		}

		/**
		 * Return product category value|label array
		 *
		 * @param $term
		 *
		 * @return array|bool
		 * @author Angels.IT
		 * @since 1.0
		 *
		 */
		protected function productCategoryTermOutput( $term )
		{
			if ( !is_object( $term ) ) return false;
			$term_slug         = $term->slug;
			$term_title        = $term->name;
			$term_id           = $term->term_id;
			$term_slug_display = '';
			if ( !empty( $term_slug ) ) {
				$term_slug_display = ' - ' . __( 'Sku', 'js_composer' ) . ': ' . $term_slug;
			}
			$term_title_display = '';
			if ( !empty( $term_title ) ) {
				$term_title_display = ' - ' . __( 'Title', 'js_composer' ) . ': ' . $term_title;
			}
			$term_id_display = __( 'Id', 'js_composer' ) . ': ' . $term_id;
			$data            = array();
			$data['value']   = $term_id;
			$data['label']   = $term_id_display . $term_title_display . $term_slug_display;

			return !empty( $data ) ? $data : false;
		}

		/**
		 * Get attribute terms suggester
		 *
		 * @param $attribute
		 *
		 * @return array
		 * @author Angels.IT
		 * @since 1.0
		 *
		 */
		public function getAttributeTerms( $attribute )
		{
			$terms = get_terms( 'pa_' . $attribute ); // return array. take slug
			$data  = array();
			if ( !empty( $terms ) && empty( $terms->errors ) ) {
				foreach ( $terms as $term ) {
					$data[$term->name] = $term->slug;
				}
			}

			return $data;
		}

		/**
		 * Autocomplete suggester to search product category by name/slug or id.
		 *
		 * @param      $query
		 * @param bool $slug - determines what output is needed
		 *      default false - return id of product category
		 *      true - return slug of product category
		 *
		 * @return array
		 * @author Angels.IT
		 * @since 1.0
		 *
		 */
		public function productCategoryCategoryAutocompleteSuggester( $query, $slug = false )
		{
			global $wpdb;
			$cat_id          = (int)$query;
			$query           = trim( $query );
			$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
    						FROM {$wpdb->term_taxonomy} AS a
    						INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
    						WHERE a.taxonomy = 'product_cat' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )", $cat_id > 0 ? $cat_id : -1, stripslashes( $query ), stripslashes( $query )
			), ARRAY_A
			);
			$result          = array();
			if ( is_array( $post_meta_infos ) && !empty( $post_meta_infos ) ) {
				foreach ( $post_meta_infos as $value ) {
					$data          = array();
					$data['value'] = $slug ? $value['slug'] : $value['id'];
					$data['label'] = __( 'Id', 'js_composer' ) . ': ' . $value['id'] . ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . __( 'Name', 'js_composer' ) . ': ' . $value['name'] : '' ) . ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . __( 'Slug', 'js_composer' ) . ': ' . $value['slug'] : '' );
					$result[]      = $data;
				}
			}

			return $result;
		}

		/**
		 * Return ID of product by provided SKU of product.
		 *
		 * @param $query
		 *
		 * @return bool
		 * @author Angels.IT
		 * @since 1.0
		 *
		 */
		public function productIdDefaultValueFromSkuToId( $query )
		{
			$result = $this->productIdAutocompleteSuggesterExactSku( $query );

			return isset( $result['value'] ) ? $result['value'] : false;
		}

		/**
		 * Find product by SKU
		 *
		 * @param $query
		 *
		 * @return bool|array
		 * @author Angels.IT
		 * @since 1.0
		 *
		 */
		public function productIdAutocompleteSuggesterExactSku( $query )
		{
			global $wpdb;
			$query        = trim( $query );
			$product_id   = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", stripslashes( $query ) ) );
			$product_data = get_post( $product_id );
			if ( 'product' !== $product_data->post_type ) {
				return '';
			}
			$product_object = wc_get_product( $product_data );
			if ( is_object( $product_object ) ) {
				$product_sku         = $product_object->get_sku();
				$product_title       = $product_object->get_title();
				$product_id          = $product_object->id;
				$product_sku_display = '';
				if ( !empty( $product_sku ) ) {
					$product_sku_display = ' - ' . __( 'Sku', 'js_composer' ) . ': ' . $product_sku;
				}
				$product_title_display = '';
				if ( !empty( $product_title ) ) {
					$product_title_display = ' - ' . __( 'Title', 'js_composer' ) . ': ' . $product_title;
				}
				$product_id_display = __( 'Id', 'js_composer' ) . ': ' . $product_id;
				$data               = array();
				$data['value']      = $product_id;
				$data['label']      = $product_id_display . $product_title_display . $product_sku_display;

				return !empty( $data ) ? $data : false;
			}

			return false;
		}

		/* Custom Font icon*/
		function iconpicker_type_mscustomfonts( $icons )
		{
			$mscustomfonts_icons = array(
				array( 'flaticon-transport' => '1' ),
				array( 'flaticon-transport-1' => '2' ),
				array( 'flaticon-shield' => '3' ),
				array( 'flaticon-present' => '4' ),
				array( 'flaticon-028-present' => '5' ),
				array( 'flaticon-arrows' => '6' ),
				array( 'flaticon-support' => '7' ),
				array( 'flaticon-gift-card' => '8' ),
				array( 'flaticon-store-house' => '9' ),
			);

			return array_merge( $icons, $mscustomfonts_icons );
		}
	}
}
new maxstore_shortcode();
/* OWL SETTINGS */
if ( !function_exists( 'maxstore_generate_carousel_data_attributes' ) ) {
	function maxstore_generate_carousel_data_attributes( $prefix = '', $atts )
	{
		$result = '';
		if ( isset( $atts[$prefix . 'autoplay'] ) )
			$result .= 'data-autoplay="' . $atts[$prefix . 'autoplay'] . '" ';
		if ( isset( $atts[$prefix . 'navigation'] ) )
			$result .= 'data-nav="' . $atts[$prefix . 'navigation'] . '" ';
		if ( isset( $atts[$prefix . 'dots'] ) )
			$result .= 'data-dots="' . $atts[$prefix . 'dots'] . '" ';
		if ( isset( $atts[$prefix . 'loop'] ) )
			$result .= 'data-loop="' . $atts[$prefix . 'loop'] . '" ';
		if ( isset( $atts[$prefix . 'slidespeed'] ) )
			$result .= 'data-slidespeed="' . $atts[$prefix . 'slidespeed'] . '" ';
		if ( isset( $atts[$prefix . 'items'] ) )
			$result .= 'data-items="' . $atts[$prefix . 'items'] . '" ';
		if ( isset( $atts[$prefix . 'margin'] ) )
			$margin = $atts[$prefix . 'margin'];
		$result     .= 'data-margin="' . $margin . '" ';
		$responsive = '';
		if ( isset( $atts[$prefix . 'ts_items'] ) ) {
			$responsive .= '"0":{"items":' . $atts[$prefix . 'ts_items'] . ', ';
			if ( isset( $atts[$prefix . 'ts_margin'] ) )
				$responsive .= '"margin":' . $atts[$prefix . 'ts_margin'] . '}, ';
			else
				$responsive .= '"margin":' . $margin . '}, ';
		}
		if ( isset( $atts[$prefix . 'xs_items'] ) ) {
			$responsive .= '"480":{"items":' . $atts[$prefix . 'xs_items'] . ', ';
			if ( isset( $atts[$prefix . 'xs_margin'] ) )
				$responsive .= '"margin":' . $atts[$prefix . 'xs_margin'] . '}, ';
			else
				$responsive .= '"margin":' . $margin . '}, ';
		}
		if ( isset( $atts[$prefix . 'sm_items'] ) ) {
			$responsive .= '"768":{"items":' . $atts[$prefix . 'sm_items'] . ', ';
			if ( isset( $atts[$prefix . 'sm_margin'] ) )
				$responsive .= '"margin":' . $atts[$prefix . 'sm_margin'] . '}, ';
			else
				$responsive .= '"margin":' . $margin . '}, ';
		}
		if ( isset( $atts[$prefix . 'md_items'] ) ) {
			$responsive .= '"992":{"items":' . $atts[$prefix . 'md_items'] . ', ';
			if ( isset( $atts[$prefix . 'md_margin'] ) )
				$responsive .= '"margin":' . $atts[$prefix . 'md_margin'] . '}, ';
			else
				$responsive .= '"margin":' . $margin . '}, ';
		}
		if ( isset( $atts[$prefix . 'lg_items'] ) ) {
			$responsive .= '"1200":{"items":' . $atts[$prefix . 'lg_items'] . ', ';
			if ( isset( $atts[$prefix . 'lg_margin'] ) )
				$responsive .= '"margin":' . $atts[$prefix . 'lg_margin'] . '}, ';
			else
				$responsive .= '"margin":' . $margin . '}, ';
		}
		if ( isset( $atts[$prefix . 'bg_items'] ) ) {
			$responsive .= '"1400":{"items":' . $atts[$prefix . 'bg_items'] . ', ';
			if ( isset( $atts[$prefix . 'bg_margin'] ) )
				$responsive .= '"margin":' . $atts[$prefix . 'bg_margin'] . '}, ';
			else
				$responsive .= '"margin":' . $margin . '}, ';
		}
		if ( $responsive ) {
			$responsive = substr( $responsive, 0, strlen( $responsive ) - 2 );
			$result     .= ' data-responsive = \'{' . $responsive . '}\'';
		}

		return $result;
	}
}
/**
 * extract arguement from content shortcode
 *
 * @param $tag string shortcode tag
 * @param $text string content shortcode is needed extract param
 *
 * @author AngelsIT
 * @since 1.0
 */
if ( !function_exists( 'maxstore_get_all_attributes' ) ) {
	function maxstore_get_all_attributes( $tag, $text )
	{
		preg_match_all( '/' . get_shortcode_regex() . '/s', $text, $matches );
		$out               = array();
		$shortcode_content = array();
		if ( isset( $matches[5] ) ) {
			$shortcode_content = $matches[5];
		}
		if ( isset( $matches[2] ) ) {
			$i = 0;
			foreach ( (array)$matches[2] as $key => $value ) {
				if ( $tag === $value ) {
					$out[$i]            = shortcode_parse_atts( $matches[3][$key] );
					$out[$i]['content'] = $matches[5][$key];
				}
				$i++;
			}
		}

		return $out;
	}
}
if ( !function_exists( 'maxstore_getProducts' ) ) {
	function maxstore_getProducts( $atts, $args = array(), $ignore_sticky_posts = 1 )
	{
		extract( $atts );
		$target             = isset( $target ) ? $target : 'recent-product';
		$meta_query         = WC()->query->get_meta_query();
		$args['meta_query'] = $meta_query;
		$args['post_type']  = 'product';
		if ( isset( $atts['taxonomy'] ) && $atts['taxonomy'] != '' ) {
			$args['tax_query'] =
				array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => array_map( 'sanitize_title', explode( ',', $atts['taxonomy'] )
						),
					),
				);
		}
		$args['post_status']         = 'publish';
		$args['ignore_sticky_posts'] = $ignore_sticky_posts;
		$args['suppress_filter']     = true;
		if ( isset( $atts['per_page'] ) && $atts['per_page'] ) {
			$args['posts_per_page'] = $atts['per_page'];
		}
		if ( !isset( $orderby ) ) {
			$ordering_args = WC()->query->get_catalog_ordering_args();
			$orderby       = $ordering_args['orderby'];
			$order         = $ordering_args['order'];
		}
		switch ( $target ):
			case 'best-selling' :
				$args['meta_key'] = 'total_sales';
				$args['orderby']  = 'meta_value_num';
				break;
			case 'top-rated' :
				$args['orderby'] = $orderby;
				$args['order']   = $order;
				break;
			case 'product-category' :
				$ordering_args   = WC()->query->get_catalog_ordering_args( $atts['orderby'], $atts['order'] );
				$args['orderby'] = $ordering_args['orderby'];
				$args['order']   = $ordering_args['order'];
				break;
			case 'products' :
				$args['posts_per_page'] = -1;
				if ( !empty( $ids ) ) {
					$args['post__in'] = array_map( 'trim', explode( ',', $ids ) );
					$args['orderby']  = 'post__in';
				}
				if ( !empty( $skus ) ) {
					$args['meta_query'][] = array(
						'key'     => '_sku',
						'value'   => array_map( 'trim', explode( ',', $skus ) ),
						'compare' => 'IN',
					);
				}
				break;
			case 'featured_products' :
				$meta_query         = WC()->query->get_meta_query();
				$tax_query          = WC()->query->get_tax_query();
				$tax_query[]        = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'featured',
					'operator' => 'IN',
				);
				$args['tax_query']  = $tax_query;
				$args['meta_query'] = $meta_query;
				break;
			case 'product_attribute' :
				//'recent-product'
				$args['tax_query'] = array(
					array(
						'taxonomy' => strstr( $atts['attribute'], 'pa_' ) ? sanitize_title( $atts['attribute'] ) : 'pa_' . sanitize_title( $atts['attribute'] ),
						'terms'    => array_map( 'sanitize_title', explode( ',', $atts['filter'] ) ),
						'field'    => 'slug',
					),
				);
				break;
			case 'on_sale' :
				$product_ids_on_sale = wc_get_product_ids_on_sale();
				$args['post__in']    = array_merge( array( 0 ), $product_ids_on_sale );
				if ( $orderby == '_sale_price' ) {
					$orderby = 'date';
					$order   = 'DESC';
				}
				$args['orderby'] = $orderby;
				$args['order']   = $order;
				break;
			case 'filter' :
				if ( $atts['order'] ) {
					$order = $atts['order'];
				} else {
					$order = '';
				}
				$ordering_args   = $this->get_catalog_ordering_args( $atts['orderby'], $order );
				$args['orderby'] = $ordering_args['orderby'];
				$args['order']   = $ordering_args['order'];
				if ( isset( $ordering_args['meta_key'] ) ) {
					$args['meta_key'] = $ordering_args['meta_key'];
				}
				if ( $atts['filter_by_price'] && $atts['price_max'] && $atts['price_min'] ) {
					$args['meta_query'][] = array(
						'key'     => '_price',
						'value'   => array( intval( $atts['price_min'] ), intval( $atts['price_max'] ) ),
						'compare' => 'BETWEEN',
						'type'    => 'NUMERIC',
					);
				}
				if ( $atts['attributes'] ) {
					foreach ( $atts['attributes'] as $attr ) {
						if ( trim( $attr['terms'] ) != "" ) {
							$attr_terms = explode( ',', $attr['terms'] );
							if ( !empty( $attr_terms ) ) {
								$args['tax_query'][] = array(
									'taxonomy' => $attr['taxonomy'],
									'terms'    => $attr_terms,
									'field'    => 'slug',
									'operator' => 'IN',
								);
							}
						}
					}
				}
				/*tags*/
				if ( trim( $atts['tags'] ) != "" ) {
					$tags = explode( ',', $atts['tags'] );
					if ( !empty( $tags ) ) {
						$args['tax_query'][] = array(
							'taxonomy' => 'product_tag',
							'terms'    => $tags,
							'field'    => 'slug',
							'operator' => 'IN',
						);
					}
				}
				break;
			default :
				//'recent-product'
				$args['orderby'] = $orderby;
				$args['order']   = $order;
				if ( isset( $ordering_args['meta_key'] ) ) {
					$args['meta_key'] = $ordering_args['meta_key'];
				}
				// Remove ordering query arguments
				WC()->query->remove_ordering_args();
				break;
		endswitch;

		return $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );
	}
}
/**
 * Get template part (for templates like the shop-loop).
 *
 * WC_TEMPLATE_DEBUG_MODE will prevent overrides in themes from taking priority.
 *
 * @access public
 *
 * @param mixed  $slug
 * @param string $name (default: '')
 */
if ( !function_exists( 'maxstoreplus_get_template_part' ) ) {
	function maxstoreplus_get_template_part( $slug, $name = '', $args = array() )
	{
		$template = '';
		if ( is_array( $args ) && isset( $args ) ) :
			extract( $args );
		endif;
		// Look in yourtheme/slug-name.php and yourtheme/tempalates/slug-name.php
		if ( $name ) {
			$template = locate_template( array( "{$slug}-{$name}.php", MAXSTOREPLUS_TEMPLATES_PATH . "{$slug}-{$name}.php" ) );
		}
		// Get default slug-name.php
		if ( $template == "" && $name && file_exists( MAXSTOREPLUS_DIR_PATH . "templates/{$slug}-{$name}.php" ) ) {
			$template = MAXSTOREPLUS_DIR_PATH . "templates/{$slug}-{$name}.php";
		}
		// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/templates/slug.php
		if ( !$template ) {
			$template = locate_template( array( "{$slug}.php", MAXSTOREPLUS_TEMPLATES_PATH . "{$slug}.php" ) );
		}
		// Allow 3rd party plugins to filter template file from their plugin.
		$template = apply_filters( 'maxstoreplus_get_template_part', $template, $slug, $name );
		if ( $template ) {
			//load_template($template, false, true);
			include $template;
		} else {
			esc_html_e( 'File does not exist', 'maxstoreplus-toolkit' );
		}
	}
}
if ( !function_exists( 'maxstore_get_all_social' ) ) {
	function maxstore_get_all_social()
	{
		$socials = array(
			'opt_twitter_link'     => array(
				'name'  => 'Twitter',
				'class' => 'twitter',
				'id'    => 'opt_twitter_link',
				'icon'  => '<i class="fa fa-twitter"></i>',
			),
			'opt_fb_link'          => array(
				'name'  => 'Facebook',
				'class' => 'facebook',
				'id'    => 'opt_fb_link',
				'icon'  => '<i class="fa fa-facebook"></i>',
			),
			'opt_google_plus_link' => array(
				'name'  => 'Google plus',
				'class' => 'google',
				'id'    => 'opt_google_plus_link',
				'icon'  => '<i class="fa fa-google-plus" aria-hidden="true"></i>',
			),
			'opt_dribbble_link'    => array(
				'name'  => 'Dribbble',
				'class' => 'dribbble',
				'id'    => 'opt_dribbble_link',
				'icon'  => '<i class="fa fa-dribbble" aria-hidden="true"></i>',
			),
			'opt_behance_link'     => array(
				'name'  => 'Behance',
				'class' => 'behance',
				'id'    => 'opt_behance_link',
				'icon'  => '<i class="fa fa-behance" aria-hidden="true"></i>',
			),
			'opt_tumblr_link'      => array(
				'name'  => 'Tumblr',
				'class' => 'tumblr',
				'id'    => 'opt_tumblr_link',
				'icon'  => '<i class="fa fa-tumblr" aria-hidden="true"></i>',
			),
			'opt_instagram_link'   => array(
				'name'  => 'Instagram',
				'class' => 'instagram',
				'id'    => 'opt_instagram_link',
				'icon'  => '<i class="fa fa-instagram" aria-hidden="true"></i>',
			),
			'opt_pinterest_link'   => array(
				'name'  => 'Pinterest',
				'class' => 'pinterest',
				'id'    => 'opt_pinterest_link',
				'icon'  => '<i class="fa fa-pinterest" aria-hidden="true"></i>',
			),
			'opt_youtube_link'     => array(
				'name'  => 'Youtube',
				'class' => 'youtube',
				'id'    => 'opt_youtube_link',
				'icon'  => '<i class="fa fa-youtube" aria-hidden="true"></i>',
			),
			'opt_vimeo_link'       => array(
				'name'  => 'Vimeo',
				'class' => 'vimeo',
				'id'    => 'opt_vimeo_link',
				'icon'  => '<i class="fa fa-vimeo" aria-hidden="true"></i>',
			),
			'opt_linkedin_link'    => array(
				'name'  => 'Linkedin',
				'class' => 'linkedin',
				'id'    => 'opt_linkedin_link',
				'icon'  => '<i class="fa fa-linkedin" aria-hidden="true"></i>',
			),
			'opt_rss_link'         => array(
				'name'  => 'RSS',
				'class' => 'rss',
				'id'    => 'opt_rss_link',
				'icon'  => '<i class="fa fa-rss" aria-hidden="true"></i>',
			),
		);

		return $socials;
	}
}
if ( !function_exists( 'maxstoreplus_social' ) ) {
	function maxstoreplus_social( $social = '' )
	{
		$all_social   = maxstore_get_all_social();
		$social_link  = maxstoreplus_get_option( $social, '' );
		$social_icon  = $all_social[$social]['icon'];
		$social_name  = $all_social[$social]['name'];
		$social_class = $all_social[$social]['class'];
		echo balanceTags( '<a class="' . $social_class . '" target="_blank" href="' . esc_url( $social_link ) . '" title ="' . esc_attr( $social_name ) . '" >' . $social_icon . '<span class="text">' . $social_name . '</span></a>' );
	}
}
if ( !function_exists( 'maxstore_get_posts_data' ) ) {
	function maxstore_get_posts_data( $post_type = 'post' )
	{
		$posts  = get_posts( array(
				'posts_per_page' => -1,
				'post_type'      => $post_type,
			)
		);
		$result = array();
		foreach ( $posts as $post ) {
			$result[] = array(
				'value' => $post->ID,
				'label' => $post->post_title,
			);
		}

		return $result;
	}

	add_action( 'vc_before_init', 'maxstore_get_posts_data' );
}
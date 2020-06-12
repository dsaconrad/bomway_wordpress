<?php
/* Session Start*/
if ( !function_exists( 'maxstoreplus_StartSession' ) ) {
	function maxstoreplus_StartSession()
	{
		if ( !session_id() ) {
			session_start();
		}
	}
}
add_action( 'init', 'maxstoreplus_StartSession', 1 );
function maxstoreplus_init()
{
	define( 'MAXSTOREPLUS_THEME_VERSION', '1.0' );
	global $maxstoreplus;
	if ( isset( $maxstoreplus['opt_enable_dev_mode'] ) && $maxstoreplus['opt_enable_dev_mode'] == 1 ) {
		define( 'MAXSTOREPLUS_DEV_MODE', true );
	} else {
		define( 'MAXSTOREPLUS_DEV_MODE', false );
	}
}

add_action( 'init', 'maxstoreplus_init' );
//GET DEMO OPTIONS
add_action( 'wp', 'maxstoreplus_get_theme_options_json', 20 );
if ( !function_exists( 'maxstoreplus_get_theme_options_json' ) ) {
	function maxstoreplus_get_theme_options_json()
	{
		global $maxstoreplus;
		if ( !is_front_page() && defined( 'MAXSTOREPLUS_DEV_MODE' ) && MAXSTOREPLUS_DEV_MODE == true ) {
			$page_slug = get_post_field( 'post_name', get_post() );
			if ( is_page( $page_slug ) ) {
				$option_files    = get_template_directory() . '/includes/settings/theme-options/' . $page_slug . '.json';
				$option_file_url = get_template_directory_uri() . '/includes/settings/theme-options/' . $page_slug . '.json';
				if ( file_exists( $option_files ) ) {
					$option_content = wp_remote_get( $option_file_url );
					$option_content = $option_content['body'];
					if ( !empty( $option_content ) ) {
						$options_configs = json_decode( $option_content, true );
						if ( is_array( $options_configs ) && !empty( $options_configs ) ) {
							$maxstoreplus = $options_configs;
						}
					}
				}
			}
		}
	}
}
/* Get Option */
if ( !function_exists( 'maxstoreplus_get_option' ) ) {
	function maxstoreplus_get_option( $option = false, $default = false )
	{
		global $maxstoreplus;
		if ( isset( $_GET[$option] ) ) {
			return $_GET[$option];
		}
		if ( isset( $maxstoreplus[$option] ) && $maxstoreplus[$option] != '' ) {
			return $maxstoreplus[$option];
		} else {
			return $default;
		}
	}
}
if ( !function_exists( 'maxstoreplus_resize_image' ) ) {
	/**
	 * @param int    $attach_id
	 * @param string $img_url
	 * @param int    $width
	 * @param int    $height
	 * @param bool   $crop
	 * @param bool   $use_lazy
	 *
	 * @return array
	 * @since 1.0
	 */
	function maxstoreplus_resize_image( $attach_id, $img_url, $width, $height, $crop = false, $use_lazy = false )
	{
		$img_lazy = "data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20viewBox%3D%270%200%20" . $width . "%20" . $height . "%27%2F%3E";
		/*If is singular and has post thumbnail and $attach_id is null, so we get post thumbnail id automatic*/
		if ( is_singular() && !$attach_id ) {
			if ( has_post_thumbnail() && !post_password_required() ) {
				$attach_id = get_post_thumbnail_id();
			}
		}
		/*this is an attachment, so we have the ID*/
		$image_src = array();
		if ( $attach_id ) {
			$image_src        = wp_get_attachment_image_src( $attach_id, 'full' );
			$actual_file_path = get_attached_file( $attach_id );
			/*this is not an attachment, let's use the image url*/
		} else if ( $img_url ) {
			$file_path        = str_replace( get_site_url(), get_home_path(), $img_url );
			$actual_file_path = rtrim( $file_path, '/' );
			if ( !file_exists( $actual_file_path ) ) {
				$file_path        = parse_url( $img_url );
				$actual_file_path = rtrim( ABSPATH, '/' ) . $file_path['path'];
			}
			if ( file_exists( $actual_file_path ) ) {
				$orig_size    = getimagesize( $actual_file_path );
				$image_src[0] = $img_url;
				$image_src[1] = $orig_size[0];
				$image_src[2] = $orig_size[1];
			} else {
				$image_src[0] = '';
				$image_src[1] = 0;
				$image_src[2] = 0;
			}
		}
		if ( !empty( $actual_file_path ) && file_exists( $actual_file_path ) ) {
			$file_info = pathinfo( $actual_file_path );
			$extension = '.' . $file_info['extension'];
			/*the image path without the extension*/
			$no_ext_path      = $file_info['dirname'] . '/' . $file_info['filename'];
			$cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;
			/*checking if the file size is larger than the target size*/
			/*if it is smaller or the same size, stop right here and return*/
			if ( $image_src[1] > $width || $image_src[2] > $height ) {
				/*the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)*/
				if ( file_exists( $cropped_img_path ) ) {
					$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
					$vt_image        = array(
						'url'    => $cropped_img_url,
						'width'  => $width,
						'height' => $height,
						'img'    => '<img src="' . esc_url( $cropped_img_url ) . '" width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" alt="">',
					);
					if ( $use_lazy == true ) {
						$vt_image['img'] = '<img class="lazy" src="' . esc_attr( $img_lazy ) . '" data-src="' . esc_url( $cropped_img_url ) . '" width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" alt="">';
					}

					return $vt_image;
				}
				if ( $crop == false ) {
					/*calculate the size proportionaly*/
					$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
					$resized_img_path  = $no_ext_path . '-' . $proportional_size[0] . 'x' . $proportional_size[1] . $extension;
					/*checking if the file already exists*/
					if ( file_exists( $resized_img_path ) ) {
						$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );
						$vt_image        = array(
							'url'    => $resized_img_url,
							'width'  => $proportional_size[0],
							'height' => $proportional_size[1],
							'img'    => '<img src="' . esc_url( $resized_img_url ) . '" width="' . esc_attr( $proportional_size[0] ) . '" height="' . esc_attr( $proportional_size[1] ) . '" alt="">',
						);
						if ( $use_lazy == true ) {
							$vt_image['img'] = '<img class="lazy" src="' . esc_attr( $img_lazy ) . '" data-src="' . esc_url( $resized_img_url ) . '" width="' . esc_attr( $proportional_size[0] ) . '" height="' . esc_attr( $proportional_size[1] ) . '" alt="">';
						}

						return $vt_image;
					}
				}
				/*no cache files - let's finally resize it*/
				$img_editor = wp_get_image_editor( $actual_file_path );
				if ( is_wp_error( $img_editor ) || is_wp_error( $img_editor->resize( $width, $height, $crop ) ) ) {
					return array(
						'url'    => '',
						'width'  => '',
						'height' => '',
						'img'    => '',
					);
				}
				$new_img_path = $img_editor->generate_filename();
				if ( is_wp_error( $img_editor->save( $new_img_path ) ) ) {
					return array(
						'url'    => '',
						'width'  => '',
						'height' => '',
						'img'    => '',
					);
				}
				if ( !is_string( $new_img_path ) ) {
					return array(
						'url'    => '',
						'width'  => '',
						'height' => '',
						'img'    => '',
					);
				}
				$new_img_size = getimagesize( $new_img_path );
				$new_img      = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );
				/*resized output*/
				$vt_image = array(
					'url'    => $new_img,
					'width'  => $new_img_size[0],
					'height' => $new_img_size[1],
					'img'    => '<img src="' . esc_url( $new_img ) . '" width="' . esc_attr( $new_img_size[0] ) . '" height="' . esc_attr( $new_img_size[1] ) . '" alt="">',
				);
				if ( $use_lazy == true ) {
					$vt_image['img'] = '<img class="lazy" src="' . esc_attr( $img_lazy ) . '" data-src="' . esc_url( $new_img ) . '" width="' . esc_attr( $new_img_size[0] ) . '" height="' . esc_attr( $new_img_size[1] ) . '" alt="">';
				}

				return $vt_image;
			}
			/*default output - without resizing*/
			$vt_image = array(
				'url'    => $image_src[0],
				'width'  => $image_src[1],
				'height' => $image_src[2],
				'img'    => '<img src="' . esc_url( $image_src[0] ) . '" width="' . esc_attr( $image_src[1] ) . '" height="' . esc_attr( $image_src[2] ) . '" alt="">',
			);
			if ( $use_lazy == true ) {
				$vt_image['img'] = '<img class="lazy" src="' . esc_attr( $img_lazy ) . '" data-src="' . esc_url( $image_src[0] ) . '" width="' . esc_attr( $image_src[1] ) . '" height="' . esc_attr( $image_src[2] ) . '" alt="">';
			}

			return $vt_image;
		} else {
			$width    = intval( $width );
			$height   = intval( $height );
			$vt_image = array(
				'url'    => 'https://via.placeholder.com/' . $width . 'x' . $height,
				'width'  => $width,
				'height' => $height,
				'img'    => '<img src="' . esc_url( 'https://via.placeholder.com/' . $width . 'x' . $height ) . '" width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" alt="">',
			);

			return $vt_image;
		}

		return false;
	}
}
/* Get Header */
if ( !function_exists( 'maxstoreplus_get_header' ) ) {
	function maxstoreplus_get_header()
	{
		$opt_header_layout = maxstoreplus_get_option( 'opt_header_layout', 'style-01' );
		ob_start();
		get_template_part( 'templates/headers/header', $opt_header_layout );
		$html = ob_get_clean();
		echo $html;
	}
}
/* Get Logo*/
if ( !function_exists( 'corporatepro_get_logo' ) ) {
	function corporatepro_get_logo()
	{
		$opt_general_logo = maxstoreplus_get_option( "opt_general_logo", array() );
		if ( is_array( $opt_general_logo ) ) {
			if ( isset( $opt_general_logo['url'] ) && $opt_general_logo['url'] != "" ) {
				$html = '<a href="' . esc_url( home_url( '/' ) ) . '"><img alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" src="' . esc_url( $opt_general_logo['url'] ) . '" class="_rw" /></a>';
			} else {
				$html = '<a href="' . esc_url( home_url( '/' ) ) . '"><img alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" src="' . esc_url( get_template_directory_uri() . '/images/logo.png' ) . '" class="_rw" /></a>';
			}
		}
		echo apply_filters( 'corporatepro_site_logo', $html );
	}
}
/* Get search form */
if ( !function_exists( 'corporatepro_get_search_form' ) ) {
	function corporatepro_get_search_form()
	{
		get_template_part( 'template-parts/search', 'form' );
	}
}
if ( !function_exists( 'maxstoreplus_paging_nav' ) ) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 * @since Boutique 1.0
	 *
	 * @global WP_Query   $wp_query WordPress Query object.
	 * @global WP_Rewrite $wp_rewrite WordPress Rewrite object.
	 */
	function maxstoreplus_paging_nav()
	{
		global $wp_query, $wp_rewrite;
		$opt_blog_loadmore = maxstoreplus_get_option( 'opt_blog_loadmore', '0' );
		$opt_style_post    = maxstoreplus_get_option( 'opt_blog_list_style' );
		if ( $opt_blog_loadmore == '1' ) {
			?>
			<?php if ( $opt_style_post == 'masonry' || $opt_style_post == 'masonry2' ) : ?>
                <div id="pj-loadmore" class="pj-loadmore">
                    <div id="loadmore-posts-result"></div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
                            <a id="cp-loadmore-masonry-posts" href="#"
                               class="cp-button button-block button-larger button-loadmore"><?php esc_html_e( 'Load more item', 'maxstoreplus' ); ?></a>
                        </div>
                    </div>
                </div>
			<?php else : ?>
                <div id="pj-loadmore" class="pj-loadmore">
                    <div id="loadmore-posts-result"></div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
                            <a id="cp-button-loadmore-posts" href="#"
                               class="cp-button button-block button-larger button-loadmore"><?php esc_html_e( 'Load more item', 'maxstoreplus' ); ?></a>
                        </div>
                    </div>
                </div>
			<?php endif; ?>
			<?php
		} else {
			// Don't print empty markup if there's only one page.
			if ( $wp_query->max_num_pages < 2 ) {
				return;
			}
			echo get_the_posts_pagination( array(
					'screen_reader_text' => '&nbsp;',
					'before_page_number' => '',
				)
			);
		}
	}
endif;
add_filter( 'navigation_markup_template', 'maxstoreplus_navigation_markup_template', 2, 99 );
if ( !function_exists( 'maxstoreplus_navigation_markup_template' ) ) {
	function maxstoreplus_navigation_markup_template( $template, $class )
	{
		$template = '
        <div class="cp-pagination text-left" role="navigation">
            %3$s
        </div>';

		return $template;
	}
}
/*Comment Layout*/
if ( !function_exists( 'maxstoreplus_custom_comment' ) ) {
	/**
	 * Display comment teplate.
	 *
	 * @since Linda 1.0
	 * @author RedApple
	 */
	function maxstoreplus_custom_comment( $comment, $args, $depth )
	{
		if ( 'div' === $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li ';
			$add_below = 'div-comment';
		}
		?>
        <<?php echo $tag ?><?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
        <div class="avatar">
			<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
        </div>
        <div class="comment-content">
            <div class="head">
                <span class="author"><?php echo get_comment_author(); ?></span>
                <div class="comment-meta commentmetadata"><a
                            href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
						<?php
						/* translators: 1: date, 2: time */
						printf( esc_html__( '%1$s', 'maxstoreplus' ), get_comment_date() ); ?></a><?php edit_comment_link( esc_html__( '(Edit)', 'maxstoreplus' ), '  ', '' );
					?>
                </div>
            </div>
            <div class="coment-text">
				<?php if ( $comment->comment_approved == '0' ) : ?>
                    <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'maxstoreplus' ); ?></em>
                    <br/>
				<?php endif; ?>
				<?php comment_text(); ?>
            </div>
            <div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                <i class="fa fa-share" aria-hidden="true"></i>
            </div>
        </div>
		<?php if ( 'div' != $args['style'] ) : ?>
        </div>
	<?php endif; ?>
		<?php
	}
}
if ( !function_exists( 'corporatepro_full_size_gallery' ) ) {
	function corporatepro_full_size_gallery( $out )
	{
		$out['size'] = 'full';  // Edit this to your needs! (thumbnail, medium, large, ...)

		return $out;
	}
}
if ( !function_exists( 'maxstoreplus_get_footer' ) ) {
	function maxstoreplus_get_footer()
	{
		$opt_footer_style   = maxstoreplus_get_option( 'opt_footer_style', '' );
		$opt_template_style = corporatepro_get_post_meta( $opt_footer_style, '_corporatepro_template_style', '' );
		ob_start();
		$query = new WP_Query( array( 'p' => $opt_footer_style, 'post_type' => 'footer', 'posts_per_page' => 1 ) );
		if ( $query->have_posts() ):
			while ( $query->have_posts() ): $query->the_post(); ?>
				<?php if ( $opt_template_style == 'default' ): ?>
                    <footer class="footer footer-style1">
                        <div class="container">
							<?php the_content(); ?>
                        </div>
                    </footer>
				<?php else: ?>
					<?php get_template_part( 'templates/footers/footer', $opt_template_style ); ?>
				<?php endif; ?>
			<?php endwhile;
		endif;
		wp_reset_postdata();
		echo ob_get_clean();
	}
}
if ( !function_exists( 'corporatepro_get_post_meta' ) ) {
	/**
	 * Function get post meta
	 *
	 * @since corporatepro 1.0
	 * @author Kutethemes
	 */
	function corporatepro_get_post_meta( $post_id, $key, $default = "" )
	{
		$meta = get_post_meta( $post_id, $key, true );
		if ( $meta ) {
			return $meta;
		}

		return $default;
	}
}
if ( !function_exists( 'maxstoreplus_get_all_social' ) ) {
	function maxstoreplus_get_all_social()
	{
		$socials = array(
			'opt_twitter_link'     => array(
				'name' => 'Twitter',
				'id'   => 'opt_twitter_link',
				'icon' => '<i class="fa fa-twitter"></i>',
			),
			'opt_fb_link'          => array(
				'name' => 'Facebook',
				'id'   => 'opt_fb_link',
				'icon' => '<i class="fa fa-facebook"></i>',
			),
			'opt_google_plus_link' => array(
				'name' => 'Google plus',
				'id'   => 'opt_google_plus_link',
				'icon' => '<i class="fa fa-google-plus" aria-hidden="true"></i>',
			),
			'opt_dribbble_link'    => array(
				'name' => 'Dribbble',
				'id'   => 'opt_dribbble_link',
				'icon' => '<i class="fa fa-dribbble" aria-hidden="true"></i>',
			),
			'opt_behance_link'     => array(
				'name' => 'Behance',
				'id'   => 'opt_behance_link',
				'icon' => '<i class="fa fa-behance" aria-hidden="true"></i>',
			),
			'opt_tumblr_link'      => array(
				'name' => 'Tumblr',
				'id'   => 'opt_tumblr_link',
				'icon' => '<i class="fa fa-tumblr" aria-hidden="true"></i>',
			),
			'opt_instagram_link'   => array(
				'name' => 'Instagram',
				'id'   => 'opt_instagram_link',
				'icon' => '<i class="fa fa-instagram" aria-hidden="true"></i>',
			),
			'opt_pinterest_link'   => array(
				'name' => 'Pinterest',
				'id'   => 'opt_pinterest_link',
				'icon' => '<i class="fa fa-pinterest" aria-hidden="true"></i>',
			),
			'opt_youtube_link'     => array(
				'name' => 'Youtube',
				'id'   => 'opt_youtube_link',
				'icon' => '<i class="fa fa-youtube" aria-hidden="true"></i>',
			),
			'opt_vimeo_link'       => array(
				'name' => 'Vimeo',
				'id'   => 'opt_vimeo_link',
				'icon' => '<i class="fa fa-vimeo" aria-hidden="true"></i>',
			),
			'opt_linkedin_link'    => array(
				'name' => 'Linkedin',
				'id'   => 'opt_linkedin_link',
				'icon' => '<i class="fa fa-linkedin" aria-hidden="true"></i>',
			),
			'opt_rss_link'         => array(
				'name' => 'RSS',
				'id'   => 'opt_rss_link',
				'icon' => '<i class="fa fa-rss" aria-hidden="true"></i>',
			),
		);

		return $socials;
	}
}
if ( !function_exists( 'maxstoreplus_social' ) ) {
	function maxstoreplus_social( $social = '' )
	{
		$all_social  = maxstoreplus_get_all_social();
		$social_link = maxstoreplus_get_option( $social, '' );
		$social_icon = $all_social[$social]['icon'];
		$social_name = $all_social[$social]['name'];
		echo balanceTags( '<a class="' . $social_name . '" target="_blank" href="' . esc_url( $social_link ) . '" title ="' . esc_attr( $social_name ) . '" >' . $social_icon . '<span class="text">' . $social_name . '</span></a>' );
	}
}
if ( !function_exists( 'maxstoreplus_rev_slide_options_for_redux' ) ) {
	function maxstoreplus_rev_slide_options_for_redux()
	{
		$maxstoreplus_rev_slide_options_for_redux = array( '' => esc_html__( '--- Choose Revolution Slider ---', 'maxstoreplus' ) );
		if ( class_exists( 'RevSlider' ) ) {
			global $wpdb;
			if ( shortcode_exists( 'rev_slider' ) ) {
				$rev_sql  = $wpdb->prepare(
					"SELECT *
                FROM {$wpdb->prefix}revslider_sliders
                WHERE %d", 1
				);
				$rev_rows = $wpdb->get_results( $rev_sql );
				if ( count( $rev_rows ) > 0 ) {
					foreach ( $rev_rows as $rev_row ):
						$maxstoreplus_rev_slide_options_for_redux[$rev_row->alias] = $rev_row->title;
					endforeach;
				}
			}
		}

		return $maxstoreplus_rev_slide_options_for_redux;
	}
}
if ( !function_exists( 'maxstoreplus_coming_soon_redirect' ) ) {
	function maxstoreplus_coming_soon_redirect()
	{
		$is_coming_soon_mode                  = ( maxstoreplus_get_option( 'enable_coming_soon', '' ) ) ? maxstoreplus_get_option( 'enable_coming_soon', '' ) == '1' : false;
		$disable_if_date_smaller_than_current = ( maxstoreplus_get_option( 'opt_disable_coming_soon_when_date_small', '' ) ) ? maxstoreplus_get_option( 'opt_disable_coming_soon_when_date_small', '' ) == '1' : false;
		$coming_date                          = ( maxstoreplus_get_option( 'coming_soon_date', '' ) ) ? maxstoreplus_get_option( 'coming_soon_date', '' ) : '';
		$today                                = date( 'm/d/Y' );
		if ( trim( $coming_date ) == '' || strtotime( $coming_date ) <= strtotime( $today ) ) {
			if ( $disable_if_date_smaller_than_current ) {
				$is_coming_soon_mode = false;
			}
		}
		// Dont't show coming soon page if is user logged in or is not coming soon mode on
		if ( is_user_logged_in() || !$is_coming_soon_mode ) {
			return;
		}
		maxstoreplus_coming_soon_html(); // Locate in theme_coming_soon_template.php
		exit();
	}

	add_action( 'template_redirect', 'maxstoreplus_coming_soon_redirect' );
}
if ( !function_exists( 'maxstoreplus_coming_soon_mode_admin_toolbar' ) ) {
	// Add Toolbar Menus
	function maxstoreplus_coming_soon_mode_admin_toolbar()
	{
		global $wp_admin_bar;
		$is_coming_soon_mode                  = ( maxstoreplus_get_option( 'enable_coming_soon', '' ) ) ? maxstoreplus_get_option( 'enable_coming_soon', '' ) == '1' : false;
		$disable_if_date_smaller_than_current = ( maxstoreplus_get_option( 'opt_disable_coming_soon_when_date_small', '' ) ) ? maxstoreplus_get_option( 'opt_disable_coming_soon_when_date_small', '' ) == '1' : false;
		$coming_date                          = ( maxstoreplus_get_option( 'coming_soon_date', '' ) ) ? maxstoreplus_get_option( 'coming_soon_date', '' ) : '';
		$today                                = date( 'm/d/Y' );
		if ( trim( $coming_date ) == '' || strtotime( $coming_date ) <= strtotime( $today ) ) {
			if ( $disable_if_date_smaller_than_current && $is_coming_soon_mode ) {
				$is_coming_soon_mode = false;
				$menu_item_class     = 'maxstoreplus_coming_soon_expired';
				if ( current_user_can( 'administrator' ) ) { // Coming soon expired
					$date = ( maxstoreplus_get_option( 'coming_soon_date', '' ) ) ? maxstoreplus_get_option( 'coming_soon_date', '' ) : date();
					$args = array(
						'id'     => 'maxstoreplus_coming_soon',
						'parent' => 'top-secondary',
						'title'  => esc_html__( 'Coming Soon Mode Expired', 'maxstoreplus' ),
						'href'   => esc_url( admin_url( 'admin.php?page=maxstore_options' ) ),
						'meta'   => array(
							'class' => 'maxstoreplus_coming_soon_expired',
							'title' => esc_html__( 'Coming soon mode is actived but expired', 'maxstoreplus' ),
						),
					);
					$wp_admin_bar->add_menu( $args );
				}
			}
		}
		if ( current_user_can( 'administrator' ) && $is_coming_soon_mode ) {
			$date = ( maxstoreplus_get_option( 'coming_soon_date', '' ) ) ? maxstoreplus_get_option( 'coming_soon_date', '' ) : date();
			$args = array(
				'id'     => 'maxstoreplus_coming_soon',
				'parent' => 'top-secondary',
				'title'  => esc_html__( 'Coming Soon Mode', 'maxstoreplus' ),
				'href'   => esc_url( admin_url( 'admin.php?page=maxstore_options' ) ),
				'meta'   => array(
					'class' => 'maxstoreplus_coming_soon maxstoreplus-countdown-wrap countdown-admin-menu maxstoreplus-cms-date_' . esc_attr( $date ),
					'title' => esc_html__( 'Coming soon mode is actived', 'maxstoreplus' ),
				),
			);
			$wp_admin_bar->add_menu( $args );
		}
	}

	add_action( 'wp_before_admin_bar_render', 'maxstoreplus_coming_soon_mode_admin_toolbar', 999 );
}
if ( !function_exists( 'maxstoreplus_wp_title' ) ) {
	/*
	 * WP title
	*/
	function maxstoreplus_wp_title( $title, $separator )
	{
		if ( is_feed() ) {
			return $title;
		}
		$is_coming_soon_mode = ( maxstoreplus_get_option( 'enable_coming_soon', '' ) ) ? maxstoreplus_get_option( 'enable_coming_soon', '' ) == '1' : false;
		if ( !current_user_can( 'administrator' ) && $is_coming_soon_mode ) {
			$title = ( maxstoreplus_get_option( 'coming_soon_title', '' ) ) ? maxstoreplus_get_option( 'coming_soon_title', '' ) : $title;
		} else {
			return $title;
		}

		return $title;
	}

	add_filter( 'wp_title', 'maxstoreplus_wp_title', 10, 2 );
}

class Team_Post_Type_Metaboxes
{
	public function init()
	{
		add_action( 'add_meta_boxes', array( $this, 'ratio_img_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_meta_boxes' ), 10, 2 );
	}

	/**
	 * Register the metaboxes to be used for the team post type
	 *
	 * @since 0.1.0
	 */
	public function ratio_img_meta_boxes()
	{
		add_meta_box( "ratio_image_fields", "Select Image Ratio", array( $this, 'render_meta_boxes' ), "post", "side", "high", null );
		add_meta_box( "ratio_image_fields", "Select Image Ratio", array( $this, 'render_meta_boxes' ), "portfolio", "side", "high", null );
	}

	/**
	 * The HTML for the fields
	 *
	 * @since 0.1.0
	 */
	function render_meta_boxes( $post )
	{
		$meta     = get_post_custom( $post->ID );
		$selected = isset( $meta['image_ratio_post_select'] ) ? esc_attr( $meta['image_ratio_post_select'][0] ) : 'img1x1';
		wp_nonce_field( basename( __FILE__ ), 'ratio_image_fields' ); ?>

        <p>
            <label
                    for="image_ratio_post_select"><?php echo esc_html__( 'Select size image.', 'maxstoreplus' ); ?></label>
            <br>
            <select name="image_ratio_post_select" id="image_ratio_post_select">
                <option
                        value="img1x1" <?php selected( $selected, 'img1x1' ); ?>><?php echo esc_html__( 'Default', 'maxstoreplus' ); ?></option>
                <option
                        value="img1x1" <?php selected( $selected, 'img1x1' ); ?>><?php echo esc_html__( 'Ratio 1:1', 'maxstoreplus' ); ?></option>
                <option
                        value="img1x2" <?php selected( $selected, 'img1x2' ); ?>><?php echo esc_html__( 'Ratio 1:2', 'maxstoreplus' ); ?></option>
                <option
                        value="img2x2" <?php selected( $selected, 'img2x2' ); ?>><?php echo esc_html__( 'Ratio 2:2', 'maxstoreplus' ); ?></option>
            </select>
        </p>
	<?php }

	/**
	 * Save metaboxes
	 *
	 * @since 0.1.0
	 */
	function save_meta_boxes( $post_id )
	{
		global $post;
		// Verify nonce
		if ( !isset( $_POST['ratio_image_fields'] ) || !wp_verify_nonce( $_POST['ratio_image_fields'], basename( __FILE__ ) ) ) {
			return $post_id;
		}
		// Check Autosave
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || isset( $_REQUEST['bulk_edit'] ) ) {
			return $post_id;
		}
		// Don't save if only a revision
		if ( isset( $post->post_type ) && $post->post_type == 'revision' ) {
			return $post_id;
		}
		// Check permissions
		if ( !current_user_can( 'edit_post', $post->ID ) ) {
			return $post_id;
		}
		$meta['image_ratio_post_select'] = ( isset( $_POST['image_ratio_post_select'] ) ? esc_textarea( $_POST['image_ratio_post_select'] ) : '' );
		foreach ( $meta as $key => $value ) {
			update_post_meta( $post->ID, $key, $value );
		}
	}
}

// Initialize metaboxes
$post_type_metaboxes = new Team_Post_Type_Metaboxes;
$post_type_metaboxes->init();
if ( class_exists( 'Vc_Manager' ) ) {
	function change_vc_row()
	{
		$args = array(
			array(
				"type"       => "checkbox",
				"group"      => "Additions",
				"class"      => "",
				"heading"    => esc_html__( 'Using 50% background?: ', 'maxstoreplus' ),
				"param_name" => "half_background",
				"value"      => array(
					esc_html__( 'Yes', 'maxstoreplus' ) => "half-background",
				),
			),
			array(
				"type"       => "checkbox",
				"group"      => "Additions",
				"class"      => "",
				"heading"    => esc_html__( 'Using Parallax?: ', 'maxstoreplus' ),
				"param_name" => "parallax_theme",
				"value"      => array(
					esc_html__( 'Yes', 'maxstoreplus' ) => "bg-parallax",
				),
			),
			array(
				"type"       => "checkbox",
				"group"      => "Additions",
				"class"      => "",
				"heading"    => esc_html__( 'Disable Overflow: ', 'maxstoreplus' ),
				"param_name" => "disable_overflow",
				"value"      => array(
					esc_html__( 'Yes', 'maxstoreplus' ) => "1",
				),
			),
			array(
				"type"       => "checkbox",
				"group"      => "Additions",
				"class"      => "",
				"heading"    => esc_html__( 'Using Overlay? ', 'maxstoreplus' ),
				"param_name" => "overlay",
				"value"      => array(
					esc_html__( 'Yes', 'maxstoreplus' ) => "cp-overlay",
				),
			),
			array(
				'type'        => 'colorpicker',
				"group"       => "Additions",
				"class"       => "",
				'heading'     => esc_html__( 'Color Overlay: ', 'maxstoreplus' ),
				'param_name'  => 'color_overlay',
				'value'       => 'rgba(0,49,67,0.5)',
				'dependency'  => array(
					'element' => 'overlay',
					'value'   => array( 'cp-overlay' ),
				),
				'description' => esc_html__( 'Select Overlay color.', 'maxstoreplus' ),
			),
		);
		foreach ( $args as $value ) {
			vc_add_param( "vc_row", $value );
			vc_add_param( "vc_section", $value );
		}
	}

	change_vc_row();
	get_template_part( 'vc_templates/vc_row.php' );
	get_template_part( 'vc_templates/vc_section.php' );
}
function maxstoreplus_detect_shortcode( $id, $tab_id )
{
	$post              = get_post( $id );
	$content           = preg_replace( '/\s+/', ' ', $post->post_content );
	$shortcode_section = '';
	preg_match_all( '/\[vc_tta_section(.*?)vc_tta_section\]/', $content, $matches );
	if ( $matches[0] && is_array( $matches[0] ) && count( $matches[0] ) > 0 ) {
		foreach ( $matches[0] as $key => $value ) {
			preg_match_all( '/tab_id="([^"]+)"/', $matches[0][$key], $matches_ids );
			foreach ( $matches_ids[1] as $matches_id ) {
				if ( $tab_id == $matches_id ) {
					$shortcode_section = $value;
				}
			}
		}
	}

	return $shortcode_section;
}

/* AJAX TABS */
if ( !function_exists( ( 'maxstoreplus_ajax_tabs' ) ) ) {
	function maxstoreplus_ajax_tabs()
	{
		$response   = array(
			'html'    => '',
			'message' => '',
			'success' => 'no',
		);
		$section_id = isset( $_POST['section_id'] ) ? $_POST['section_id'] : '';
		$id         = isset( $_POST['id'] ) ? $_POST['id'] : '';
		$shortcode  = maxstoreplus_detect_shortcode( $id, $section_id );
		WPBMap::addAllMappedShortcodes();
		$response['html']    = wpb_js_remove_wpautop( $shortcode );
		$response['success'] = 'ok';
		wp_send_json( $response );
		wp_die();
	}

	// TABS ajaxify update
	add_action( 'wp_ajax_maxstoreplus_ajax_tabs', 'maxstoreplus_ajax_tabs' );
	add_action( 'wp_ajax_nopriv_maxstoreplus_ajax_tabs', 'maxstoreplus_ajax_tabs' );
}

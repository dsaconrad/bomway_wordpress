<?php
if ( ! isset( $content_width ) ) {
	$content_width = 900;
};
if ( ! class_exists( 'maxstoreplus_Functions' ) ) {
	class maxstoreplus_Functions
	{
		/**
		 * Instance of the class.
		 *
		 * @since   1.0.0
		 *
		 * @var   object
		 */
		protected static $instance = null;

		/**
		 * Initialize the plugin by setting localization and loading public scripts
		 * and styles.
		 *
		 * @since    1.0.0
		 */
		public function __construct()
		{
			add_action( 'after_setup_theme', array( $this, 'theme_setup' ) );
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );
			add_action( 'init', array( $this, 'add_multi_widgets' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
			add_filter( 'body_class', array( $this, 'body_class' ) );
			add_filter( 'get_default_comment_status', array( $this, 'open_default_comments_for_page' ), 10, 3 );
			add_filter( 'comment_form_fields', array( $this, 'wpb_move_comment_field_to_bottom' ), 10, 3 );
			$this->includes();
			add_action( 'wp_ajax_check_search', array( $this, 'check_search' ) );
			add_action( 'wp_ajax_nopriv_check_search', array( $this, 'check_search' ) );
		}

		/**
		 * Return an instance of this class.
		 *
		 * @return  object  A single instance of the class.
		 * @since    1.0.0
		 *
		 */
		public static function get_instance()
		{
			// If the single instance hasn't been set yet, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		function theme_setup()
		{
			load_theme_textdomain( 'maxstoreplus', get_template_directory() . '/languages' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support( 'post-thumbnails' );
			// This theme uses wp_nav_menu() in two locations.
			register_nav_menus(
				array(
					'primary'            => esc_html__( 'Primary Menu', 'maxstoreplus' ),
					'primary-left-menu'  => esc_html__( 'Primary Left Menu', 'maxstoreplus' ),
					'primary-right-menu' => esc_html__( 'Primary Right Menu', 'maxstoreplus' ),
					'menu-categories'    => esc_html__( 'Menu Categories', 'maxstoreplus' ),
				)
			);
			add_theme_support( 'html5', array(
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
				)
			);
			add_theme_support( 'post-formats', array(
					'image',
					'video',
					'gallery',
					'audio',
				)
			);
			// Support WooCommerce
			add_theme_support( 'woocommerce' );
			// Add support for Block Styles.
			add_theme_support( 'wp-block-styles' );
			// Add support for full and wide align images.
			add_theme_support( 'align-wide' );
			// Add support for editor styles.
			add_theme_support( 'editor-styles' );
			// Add support for responsive embedded content.
			add_theme_support( 'responsive-embeds' );
			// Add theme support for selective refresh for widgets.
			add_theme_support( 'customize-selective-refresh-widgets' );
		}

		function add_multi_widgets()
		{
			$opt_multi_slidebars = maxstoreplus_get_option( 'opt_multi_slidebars', '' );
			if ( is_array( $opt_multi_slidebars ) && count( $opt_multi_slidebars ) > 0 ) {
				foreach ( $opt_multi_slidebars as $value ) {
					if ( $value && $value != '' ) {
						register_sidebar( array(
								'name'          => $value,
								'id'            => 'kt-custom-sidebar-' . sanitize_key( $value ),
								'before_widget' => '<div id="%1$s" class="widget block-sidebar %2$s">',
								'after_widget'  => '</div>',
								'before_title'  => '<div class="title-widget widgettitle"><strong>',
								'after_title'   => '</strong></div>',
							)
						);
					}
				}
			}
		}

		/**
		 * Register widget area.
		 *
		 * @since corporatepro 1.0
		 *
		 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
		 */
		function widgets_init()
		{
			register_sidebar( array(
					'name'          => esc_html__( 'Widget Area', 'maxstoreplus' ),
					'id'            => 'widget-area',
					'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'maxstoreplus' ),
					'before_widget' => '<div id="%1$s" class="widget block-sidebar %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<div class="title-widget widgettitle"><strong>',
					'after_title'   => '</strong></div>',
				)
			);
			register_sidebar( array(
					'name'          => esc_html__( 'Shop Widget Area', 'maxstoreplus' ),
					'id'            => 'shop-widget-area',
					'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'maxstoreplus' ),
					'before_widget' => '<div id="%1$s" class="widget block-sidebar %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<div class="title-widget widgettitle"><strong>',
					'after_title'   => '</strong></div>',
				)
			);
			register_sidebar( array(
					'name'          => esc_html__( 'Shop Single Widget Area', 'maxstoreplus' ),
					'id'            => 'shop-single-widget-area',
					'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'maxstoreplus' ),
					'before_widget' => '<div id="%1$s" class="widget block-sidebar %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<div class="title-widget widgettitle"><strong>',
					'after_title'   => '</strong></div>',
				)
			);
		}

		/**
		 * Register custom fonts.
		 */
		function maxstoreplus_fonts_url()
		{
			$fonts_url = '';
			/**
			 * Translators: If there are characters in your language that are not
			 * supported by Montserrat, translate this to 'off'. Do not translate
			 * into your own language.
			 */
			$montserrat = esc_html_x( 'on', 'Montserrat font: on or off', 'maxstoreplus' );
			if ( 'off' !== $montserrat ) {
				$font_families   = array();
				$font_families[] = 'Raleway:300,300i,400,400i,500,500i,600,600i,700,700i,800';
				$font_families[] = 'Montserrat:400,400i,500,500i,600,600i,700';
				$font_families[] = 'Playfair Display:400,400i,700,700i,900,900i';
				$query_args      = array(
					'family' => urlencode( implode( '|', $font_families ) ),
					'subset' => urlencode( 'latin,latin-ext' ),
				);
				$fonts_url       = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
			}

			return esc_url_raw( $fonts_url );
		}

		/**
		 * Enqueue scripts and styles.
		 *
		 * @since Maxstoreplus 1.0
		 */
		function scripts()
		{
			// Add custom fonts, used in the main stylesheet.
			wp_enqueue_style( 'maxstoreplus-fonts', self::maxstoreplus_fonts_url(), array(), null );
			wp_enqueue_style( 'bootstrap', get_theme_file_uri( 'css/bootstrap.min.css' ), array(), false );
			wp_enqueue_style( 'bxslider', get_theme_file_uri( 'css/bxslider.min.css' ), array(), false );
			wp_enqueue_style( 'chosen', get_theme_file_uri( 'css/chosen.min.css' ), array(), false );
			wp_enqueue_style( 'font-awesome', get_theme_file_uri( 'css/font-awesome.min.css' ), array(), false );
			wp_enqueue_style( 'owl-carousel', get_theme_file_uri( 'css/owl.carousel.min.css' ), array(), false );
			wp_enqueue_style( 'flaticon', get_theme_file_uri( 'fonts/flaticon/font/flaticon.css' ), array(), '1.0' );
			wp_enqueue_style( 'maxstoreplus_woocommerce', get_theme_file_uri( 'css/woocommerce.min.css' ), array(), false );
			wp_enqueue_style( 'maxstoreplus_style', get_theme_file_uri( 'css/style.min.css' ), array(), false );
			/*Load our main stylesheet.*/
			wp_enqueue_style( 'maxstoreplus-main-style', get_stylesheet_uri() );
			/*Load js */
			global $wp_query;
			$posts        = $wp_query->posts;
			$gmap_api_key = maxstoreplus_get_option( 'google_key', '' );
			foreach ( $posts as $post ) {
				if ( is_a( $post, 'WP_Post' ) && ! has_shortcode( $post->post_content, 'contact-form-7' ) ) {
					wp_dequeue_script( 'contact-form-7' );
				}
				if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'maxstoreplus_maps' ) ) {
					if ( $gmap_api_key ) {
						wp_enqueue_script( 'maxstoreplus-api-map', esc_url( '//maps.googleapis.com/maps/api/js?key=' . trim( $gmap_api_key ) ), array(), false, true );
					} else {
						wp_enqueue_script( 'maxstoreplus-api-sensor', esc_url( '//maps.google.com/maps/api/js?sensor=true' ), array(), false, true );
					}
				}
			}
			wp_enqueue_script( 'jquery-ui-accordion' );
			wp_enqueue_script( 'bootstrap', get_theme_file_uri( 'js/bootstrap.min.js' ), array( 'jquery' ), '3.3.7', true );
			wp_enqueue_script( 'lazy-load', get_theme_file_uri( 'js/lazyload.min.js' ), array( 'jquery' ), '1.9.7', true );
			wp_enqueue_script( 'chosen', get_theme_file_uri( 'js/chosen.min.js' ), array( 'jquery' ), '1.6.5', true );
			wp_enqueue_script( 'bxslider', get_theme_file_uri( 'js/bxslider.min.js' ), array( 'jquery' ), '4.2.10', true );
			wp_enqueue_script( 'froogaloop2', get_theme_file_uri( 'js/froogaloop2.min.js' ), array( 'jquery' ), '4.2.10', true );
			wp_enqueue_script( 'html5lightbox', get_theme_file_uri( 'js/html5lightbox.min.js' ), array( 'jquery' ), '4.2.10', true );
			wp_enqueue_script( 'owl-carousel', get_theme_file_uri( 'js/owl.carousel.min.js' ), array( 'jquery' ), '1.0', true );
			wp_enqueue_script( 'parallax', get_theme_file_uri( 'js/parallax-1.1.3.js' ), array( 'jquery' ), '1.0', true );
			wp_enqueue_script( 'countdown', get_theme_file_uri( 'js/countdown.min.js' ), array( 'jquery' ), '1.0', true );
			wp_enqueue_script( 'final_countdown', get_theme_file_uri( 'js/final-countdown.min.js' ), array( 'jquery' ), '1.0', true );
			wp_enqueue_script( 'maxstoreplus-scripts', get_theme_file_uri( 'js/functions.min.js' ), array( 'jquery' ), '1.0' );
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
			/* REGISTER SCRIPT */
			wp_register_script( 'isotope', get_theme_file_uri( 'js/isotope.pkgd.min.js' ), array( 'jquery' ), '1.0', true );
			wp_register_script( 'masonry', get_theme_file_uri( 'js/masonry.pkgd.min.js' ), array( 'jquery' ), '1.0', true );
			wp_register_script( 'packery_mode', get_theme_file_uri( 'js/packery-mode.pkgd.min.js' ), array( 'jquery' ), '1.0', true );
			wp_register_script( 'maxstoreplus-isotope', get_theme_file_uri( 'js/isotope-scripts.js' ), array(
				'jquery',
				'isotope',
				'masonry',
				'packery_mode',
				'imagesloaded'
			), '1.0', true );
			/* GLOBAL SCRIPT */
			wp_localize_script( 'maxstoreplus-scripts', 'maxstoreplus_ajax_frontend', array(
					'ajaxurl'  => admin_url( 'admin-ajax.php' ),
					'security' => wp_create_nonce( 'maxstoreplus_ajax_frontend' ),
				)
			);
			global $wp_query;
			$opt_style_header                  = maxstoreplus_get_option( 'opt_header_layout', '' );
			$opt_enable_main_menu_sticky       = maxstoreplus_get_option( 'opt_enable_main_menu_sticky', 1 );
			$kt_enable_popup_newsletter        = maxstoreplus_get_option( 'kt_enable_popup_newsletter', '0' );
			$kt_popup_delay_time               = maxstoreplus_get_option( 'kt_popup_delay_time', 0 );
			$kt_enable_popup_newsletter_mobile = maxstoreplus_get_option( 'kt_enable_popup_newsletter_mobile', '1' );
			wp_localize_script( 'maxstoreplus-scripts', 'maxstoreplus_global', array(
					'opt_enable_main_menu_sticky'       => $opt_enable_main_menu_sticky,
					'opt_style_header'                  => $opt_style_header,
					'kt_popup_delay_time'               => $kt_popup_delay_time,
					'kt_enable_popup_newsletter'        => $kt_enable_popup_newsletter,
					'kt_enable_popup_newsletter_mobile' => $kt_enable_popup_newsletter_mobile,
					'query'                             => $wp_query->query,
				)
			);
		}

		function admin_scripts()
		{
			wp_enqueue_style( 'admin-flasticon', get_theme_file_uri( 'fonts/flaticon/font/flaticon.css' ), array(), false );
			wp_enqueue_style( 'chosen', get_theme_file_uri( 'css/chosen.min.css' ), array(), '1.6.5' );
			wp_enqueue_script( 'chosen', get_theme_file_uri( 'js/chosen.min.js' ), array( 'jquery' ), '1.6.5', true );
		}

		public function body_class( $classes )
		{
			$my_theme  = wp_get_theme();
			$classes[] = strtolower( $my_theme->get( 'Name' ) ) . "-" . $my_theme->get( 'Version' );

			return $classes;
		}

		/**
		 * Filter whether comments are open for a given post type.
		 *
		 * @param  string  $status  Default status for the given post type,
		 *                             either 'open' or 'closed'.
		 * @param  string  $post_type  Post type. Default is `post`.
		 * @param  string  $comment_type  Type of comment. Default is `comment`.
		 *
		 * @return string (Maybe) filtered default status for the given post type.
		 */
		public function open_default_comments_for_page( $status, $post_type, $comment_type )
		{
			if ( 'page' == $post_type ) {
				return 'open';
			}

			return $status;
		}

		public function wpb_move_comment_field_to_bottom( $fields )
		{
			$comment_field = $fields['comment'];
			unset( $fields['comment'] );
			$fields['comment'] = $comment_field;

			return $fields;
		}

		public function includes()
		{
			require_once( trailingslashit( get_template_directory() ) . 'includes/class/class-tgm-plugin-activation.php' );
			require_once( trailingslashit( get_template_directory() ) . 'includes/class/breadcrumbs.php' );
			require_once( trailingslashit( get_template_directory() ) . 'includes/class/maxstoreplus-breadcrumbs.php' );
			require_once( trailingslashit( get_template_directory() ) . 'includes/class/coming-soon.php' );
			require_once( trailingslashit( get_template_directory() ) . 'includes/nav/nav.php' );
			require_once( trailingslashit( get_template_directory() ) . 'includes/theme-functions.php' );
			require_once( trailingslashit( get_template_directory() ) . 'includes/custom-css.php' );
			require_once( trailingslashit( get_template_directory() ) . 'includes/settings/theme-options.php' );
			require_once( trailingslashit( get_template_directory() ) . 'includes/settings/meta-boxs.php' );
			require_once( trailingslashit( get_template_directory() ) . 'includes/settings/post-like.php' );
			require_once( trailingslashit( get_template_directory() ) . 'includes/settings/plugins_load.php' );
			if ( class_exists( 'WooCommerce' ) ) {
				require_once get_template_directory() . '/includes/woo-functions.php';
				require_once( trailingslashit( get_template_directory() ) . 'includes/attributes-swatches/product-attribute-meta.php' );
				require_once( trailingslashit( get_template_directory() ) . 'includes/widgets/widgets_product_categories.php' );
				require_once( trailingslashit( get_template_directory() ) . 'includes/widgets/widget-woo-layered-nav.php' );
			}
		}

		/* INSTANT SEARCH */
		function check_search()
		{
			$response = array(
				'array'   => '',
				'message' => '',
				'success' => 'no',
			);
			$args     = array(
				'post_type'      => 'product',
				'posts_per_page' => - 1,
				'post_status'    => 'publish',
			);
			$posts    = new WP_Query( $args );
			if ( $posts->have_posts() ) {
				while ( $posts->have_posts() ) { ?>
					<?php
					$posts->the_post();
					global $product;
					ob_start(); ?>
                    <div <?php post_class( 'blog-item col-lg-3 col-md-3 col-sm-4 col-xs-6' ); ?>>
                        <div class="post-thumb">
                            <a href="<?php the_permalink() ?>">
								<?php
								$image_thumb = maxstoreplus_resize_image( get_post_thumbnail_id(), null, 250, 190, true, false );
								echo htmlspecialchars_decode( $image_thumb['img'] );
								?>
                            </a>
                        </div>
                        <h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<?php if ( $price_html = $product->get_price_html() ) : ?>
                            <span class="price pj-price">
                                <?php echo esc_html__( 'Price:', 'maxstoreplus' ); ?>
                                <?php echo $price_html; ?>
                            </span>
						<?php endif; ?>
                    </div>
					<?php
					$post_html   = ob_get_clean();
					$post_data[] = array(
						'post_title' => esc_html( get_the_title() ),
						'post_link'  => esc_url( get_permalink() ),
						'thumb'      => $image_thumb,
						'post_html'  => $post_html,
					);
					?>
				<?php }
			}
			wp_reset_postdata();
			$response['array']   = $post_data;
			$response['success'] = 'ok';
			wp_send_json( $response );
			die();
		}
	}

	new maxstoreplus_Functions();
}
/* LOADMORE PRODUCTS */
add_action( 'wp_ajax_maxstoreplus_loadmore_product', 'maxstoreplus_loadmore_product' );
add_action( 'wp_ajax_nopriv_maxstoreplus_loadmore_product', 'maxstoreplus_loadmore_product' );
if ( ! function_exists( 'maxstoreplus_loadmore_product' ) ) {
	function maxstoreplus_loadmore_product()
	{
		$response        = array(
			'html'    => '',
			'message' => '',
			'success' => 'no',
		);
		$except_post_ids = isset( $_POST['except_post_ids'] ) ? $_POST['except_post_ids'] : '';
		$style_product   = isset( $_POST['style_product'] ) ? $_POST['style_product'] : '';
		$number_product  = isset( $_POST['number_product'] ) ? $_POST['number_product'] : '';
		$class_product   = isset( $_POST['class_product'] ) ? $_POST['class_product'] : '';
		$thumb_width     = isset( $_POST['width'] ) ? $_POST['width'] : '';
		$thumb_height    = isset( $_POST['height'] ) ? $_POST['height'] : '';
		$cat             = isset( $_POST['cat'] ) ? $_POST['cat'] : '';
		add_filter( 'maxstoreolus_shop_pruduct_thumb_width', function () use ( $thumb_width ) {
			return $thumb_width;
		} );
		add_filter( 'maxstoreolus_shop_pruduct_thumb_height', function () use ( $thumb_height ) {
			return $thumb_height;
		} );
		$args = array(
			'post_type'    => 'product',
			'showposts'    => $number_product,
			'post__not_in' => $except_post_ids,
			'post_status'  => 'publish',
		);
		if ( $cat != '' ) {
			$category_slug = array();
			if ( $cat ) {
				$category_slug = explode( ',', $cat );
			}
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => $category_slug,
				),
			);
		}
		$loop = new wp_query( $args );
		ob_start();
		while ( $loop->have_posts() ) : $loop->the_post();
			?>
            <div data-cat="<?php echo esc_attr( $cat ) ?>"
                 data-id="post-<?php echo get_the_ID() ?>"
                 class="<?php echo esc_attr( $class_product ) ?>"
                 data-style="<?php echo esc_attr( $style_product ) ?>"
                 data-number="<?php echo esc_attr( $number_product ) ?>"
                 data-width="<?php echo esc_attr( $thumb_width ) ?>"
                 data-height="<?php echo esc_attr( $thumb_height ) ?>">
				<?php wc_get_template_part( 'product-styles/content-product-style', $style_product ); ?>
            </div>
		<?php
		endwhile;
		wp_reset_query();
		$response['html']    = ob_get_clean();
		$response['success'] = 'ok';
		wp_send_json( $response );
		die();
	}
}
if ( ! function_exists( 'maxstoreplus_set_post_views' ) ) {
	function maxstoreplus_set_post_views( $postID )
	{
		$count_key = 'maxstoreplus_post_views_count';
		$count     = get_post_meta( $postID, $count_key, true );
		if ( $count == '' ) {
			$count = 0;
			delete_post_meta( $postID, $count_key );
			add_post_meta( $postID, $count_key, '0' );
		} else {
			$count ++;
			update_post_meta( $postID, $count_key, $count );
		}
	}
}
if ( ! function_exists( 'maxstoreplus_get_post_views' ) ) {
	function maxstoreplus_get_post_views( $postID )
	{
		$count_key = 'maxstoreplus_post_views_count';
		$count     = get_post_meta( $postID, $count_key, true );
		if ( $count == '' ) {
			delete_post_meta( $postID, $count_key );
			add_post_meta( $postID, $count_key, '0' );

			return "0 View";
		}

		return $count;
	}
}
if ( ! function_exists( 'maxstoreplus_time_ago' ) ) {
	function maxstoreplus_time_ago( $type = 'post' )
	{
		$d = 'comment' == $type ? 'get_comment_time' : 'get_post_time';

		return human_time_diff( $d( 'U' ), current_time( 'timestamp' ) ) . " " . esc_html__( 'ago', 'maxstoreplus' );
	}
}

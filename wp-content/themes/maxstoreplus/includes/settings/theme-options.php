<?php
/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
 * */
if ( !class_exists( 'MaxStore_Redux_Framework_config' ) ) {
	class MaxStore_Redux_Framework_config
	{
		public $args           = array();
		public $sections       = array();
		public $theme;
		public $ReduxFramework;
		public $sidebars       = array();
		public $header_options = array();

		public function __construct()
		{
			if ( !class_exists( 'ReduxFramework' ) ) {
				return;
			}
			/* install options */
			$this->get_sidebars();
			$this->get_header_options();
			$this->initSettings();
			/* add new field */
			add_filter( 'redux/maxstoreplus/field/class/select_preview', array( $this, 'overload_select_preview_field_path' ) );
		}

		public function overload_select_preview_field_path( $field )
		{
			return dirname( __FILE__ ) . '/redux-fields/select_preview/field_select_preview.php';
		}

		public function get_sidebars()
		{
			global $wp_registered_sidebars;
			foreach ( $wp_registered_sidebars as $sidebar ) {
				$sidebars[$sidebar['id']] = $sidebar['name'];
			}
			$this->sidebars = $sidebars;
		}

		public function get_header_options()
		{
			$layoutDir      = get_template_directory() . '/templates/headers/';
			$header_options = array();

			if ( is_dir( $layoutDir ) ) {
				$files = scandir( $layoutDir );
				if ( $files && is_array( $files ) ) {
					$option = '';
					foreach ( $files as $file ) {
						if ( $file != '.' && $file != '..' ) {
							$fileInfo = pathinfo( $file );
							if ( $fileInfo['extension'] == 'php' ) {
								$file_data                  = get_file_data( $layoutDir . $file, array( 'Name' => 'Name' ) );
								$file_name                  = str_replace( 'header-', '', $fileInfo['filename'] );
								$header_options[$file_name] = array(
									'title'   => $file_data['Name'],
									'preview' => get_template_directory_uri() . '/templates/headers/header-' . $file_name . '.jpg',
								);
							}
						}
					}
				}
			}
			$this->header_options = $header_options;
		}

		public function initSettings()
		{
			// Just for demo purposes. Not needed per say.
			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();

			// Set a few help tabs so you can see how it's done
			$this->setHelpTabs();

			// Create the sections and fields
			$this->setSections();

			if ( !isset( $this->args['opt_name'] ) ) { // No errors please
				return;
			}

			// If Redux is running as a plugin, this will remove the demo notice and links
			//add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

			// Function to test the compiler hook and demo CSS output.
			//add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
			// Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
			// Change the arguments after they've been declared, but before the panel is created
			//add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
			// Change the default value of a field after it's been set, but before it's been useds
			//add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
			// Dynamically add a section. Can be also used to modify sections/fields
			add_filter( 'redux/options/' . $this->args['opt_name'] . '/sections', array( $this, 'dynamic_section' ) );

			$sections = array_values( apply_filters( 'corporatepro_all_theme_option_sections', $this->sections ) );

			$this->ReduxFramework = new ReduxFramework( $sections, $this->args );
		}

		/**
		 *
		 * This is a test function that will let you see when the compiler hook occurs.
		 * It only runs if a field   set with compiler=>true is changed.
		 * */
		function compiler_action( $options, $css )
		{
		}

		function ts_redux_update_options_user_can_register( $options, $css )
		{
			global $maxstoreplus;
			$users_can_register = isset( $maxstoreplus['opt-users-can-register'] ) ? $maxstoreplus['opt-users-can-register'] : 0;
			update_option( 'users_can_register', $users_can_register );
		}

		/**
		 *
		 * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
		 * Simply include this function in the child themes functions.php file.
		 *
		 * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
		 * so you must use get_template_directory_uri() if you want to use any of the built in icons
		 * */
		function dynamic_section( $sections )
		{
			//$sections = array();
			$sections[] = array(
				'title'  => esc_html__( 'Section via hook', 'maxstoreplus' ),
				'desc'   => wp_kses( __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'maxstoreplus' ), array( 'p' => array( 'class' => array() ) ) ),
				'icon'   => 'el-icon-paper-clip',
				// Leave this as a blank section, no options just some intro text set above.
				'fields' => array(),
			);

			return $sections;
		}

		/**
		 *
		 * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
		 * */
		function change_arguments( $args )
		{
			//$args['dev_mode'] = true;

			return $args;
		}

		/**
		 *
		 * Filter hook for filtering the default value of any given field. Very useful in development mode.
		 * */
		function change_defaults( $defaults )
		{
			$defaults['str_replace'] = "Testing filter hook!";

			return $defaults;
		}

		// Remove the demo link and the notice of integrated demo from the redux-framework plugin
		function remove_demo()
		{
			// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
			if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
				remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::instance(), 'plugin_metalinks' ), null, 2 );

				// Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
				remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
			}
		}

		public function setSections()
		{
			/**
			 * Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
			 * */
			// Background Patterns Reader
			$sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
			$sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
			$sample_patterns      = array();

			ob_start();

			$ct          = wp_get_theme();
			$this->theme = $ct;
			$item_name   = $this->theme->get( 'Name' );
			$tags        = $this->theme->Tags;
			$screenshot  = $this->theme->get_screenshot();
			$class       = $screenshot ? 'has-screenshot' : '';

			$customize_title = sprintf( __( 'Customize &#8220;%s&#8221;', 'maxstoreplus' ), $this->theme->display( 'Name' ) );
			?>
            <div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
				<?php if ( $screenshot ) : ?>
					<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize"
                           title="<?php echo esc_attr( $customize_title ); ?>">
                            <img src="<?php echo esc_url( $screenshot ); ?>"
                                 alt="<?php esc_attr_e( 'Current theme preview', 'maxstoreplus' ); ?>"/>
                        </a>
					<?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>"
                         alt="<?php esc_attr_e( 'Current theme preview', 'maxstoreplus' ); ?>"/>
				<?php endif; ?>

                <h4>
					<?php echo sanitize_text_field( $this->theme->display( 'Name' ) ); ?>
                </h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf( __( 'By %s', 'maxstoreplus' ), $this->theme->display( 'Author' ) ); ?></li>
                        <li><?php printf( __( 'Version %s', 'maxstoreplus' ), $this->theme->display( 'Version' ) ); ?></li>
                        <li><?php echo '<strong>' . esc_html__( 'Tags', 'maxstoreplus' ) . ':</strong> '; ?><?php printf( $this->theme->display( 'Tags' ) ); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo esc_attr( $this->theme->display( 'Description' ) ); ?></p>
					<?php
					if ( $this->theme->parent() ) {
						printf(
							' <p class="howto">' . wp_kses( __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'maxstoreplus' ), array( 'a' => array( 'href' => array() ) ) ) . '</p>', esc_html__( 'http://codex.wordpress.org/Child_Themes', 'maxstoreplus' ), $this->theme->parent()
						);
					}
					?>

                </div>

            </div>

			<?php
			$item_info = ob_get_contents();

			ob_end_clean();

			/*--General Settings--*/
			$this->sections[] = array(
				'title'            => esc_html__( 'General', 'maxstoreplus' ),
				'id'               => 'general',
				'desc'             => esc_html__( 'This General Setings', 'maxstoreplus' ),
				'customizer_width' => '400px',
				'icon'             => 'el-icon-wordpress',
				'fields'           => array(
					array(
						'id'      => 'opt_enable_dev_mode',
						'type'    => 'switch',
						'title'   => esc_html__( 'Dev Mode', 'maxstoreplus' ),
						'default' => '1',
						'on'      => esc_html__( 'Enable', 'maxstoreplus' ),
						'off'     => esc_html__( 'Disable', 'maxstoreplus' ),
					),
					array(
						'id'       => 'kt_enable_lazy',
						'type'     => 'switch',
						'title'    => esc_html__( 'Enable lazy load', 'maxstoreplus' ),
						'subtitle' => esc_html__( 'Enable lazy load image in products', 'maxstoreplus' ),
						'default'  => '0',
						'on'       => esc_html__( 'Enable', 'maxstoreplus' ),
						'off'      => esc_html__( 'Disable', 'maxstoreplus' ),
					),
				),
			);

			/* Logo */
			$this->sections[] = array(
				'title'            => esc_html__( 'Logo', 'maxstoreplus' ),
				'id'               => 'logo',
				'subsection'       => true,
				'customizer_width' => '450px',
				'desc'             => esc_html__( 'Setting logo of site', 'maxstoreplus' ),
				'fields'           => array(
					array(
						'id'       => 'opt_general_logo',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Logo', 'maxstoreplus' ),
						'compiler' => 'true',
						//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
						'desc'     => esc_html__( 'Basic media uploader with disabled URL input field.', 'maxstoreplus' ),
						'subtitle' => esc_html__( 'Upload any media using the WordPress native uploader', 'maxstoreplus' ),
						'default'  => array( 'url' => get_template_directory_uri() . '/images/logo.png' ),
						//'hint'      => array(
						//    'title'     => 'Hint Title',
						//    'content'   => 'This is a <b>hint</b> for the media field with a Title.',
						//)
					),
				),
			);
			/* Color */
			$this->sections[] = array(
				'title'      => esc_html__( 'Color', 'maxstoreplus' ),
				'desc'       => esc_html__( 'Setting Color of site ', 'maxstoreplus' ),
				'id'         => 'site-color',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'       => 'opt_general_accent_color',
						'type'     => 'color_rgba',
						'title'    => esc_html__( 'Main Color', 'maxstoreplus' ),
						'subtitle' => esc_html__( 'Gives you the RGBA color.', 'maxstoreplus' ),
						'default'  => array(
							'color' => '#ff4949',
							'alpha' => '1',
						),
						//'output'   => array( 'body' ),
						'mode'     => 'background',
						//'validate' => 'colorrgba',
					),
				),
			);

			/* Coming soon */
			$this->sections[] = array(
				'title'      => esc_html__( 'Coming Soon !', 'maxstoreplus' ),
				'id'         => 'coming_soon',
				'subsection' => true,
				'fields'     => array(
					array(
						'title'   => esc_html__( 'Enable Coming Soon !', 'maxstoreplus' ),
						'id'      => 'enable_coming_soon',
						'type'    => 'switch',
						'default' => '0',
						'on'      => esc_html__( 'Enable', 'maxstoreplus' ),
						'off'     => esc_html__( 'Disable', 'maxstoreplus' ),
					),
					array(
						'title'    => esc_html__( 'Coming Soon Logo', 'maxstoreplus' ),
						'id'       => 'logo_coming_soon',
						'type'     => 'media',
						'default'  => array(
							'url' => get_template_directory_uri() . 'images/logo-3.png',
						),
						'required' => array( 'enable_coming_soon', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Coming Soon Background', 'maxstoreplus' ),
						'id'       => 'coming_soon_background',
						'type'     => 'media',
						'default'  => array(
							'url' => get_template_directory_uri() . 'images/bg_coming_soon.jpg',
						),
						'required' => array( 'enable_coming_soon', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Title', 'maxstoreplus' ),
						'id'       => 'coming_soon_title',
						'type'     => 'text',
						'default'  => "we're Coming Soon!",
						'required' => array( 'enable_coming_soon', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Description', 'maxstoreplus' ),
						'id'       => 'coming_soon_des',
						'type'     => 'editor',
						'args'     => array(
							'teeny'         => true,
							'textarea_rows' => 10,
						),
						'default'  => "We are currently closed setting up our online store. Please, hold on and soon you will get an opportunity to browse
our captivating shop. Shopping here will be in pleasure!",
						'required' => array( 'enable_coming_soon', '=', array( '1' ) ),
					),
					array(
						'id'          => 'coming_soon_date',
						'type'        => 'date',
						'title'       => esc_html__( 'Date Option', 'maxstoreplus' ),
						'placeholder' => 'Click to enter a date',
						'required'    => array( 'enable_coming_soon', '=', array( '1' ) ),
					),
					array(
						'id'       => 'coming_soon_footer',
						'type'     => 'editor',
						'title'    => esc_html__( 'Footer Coming Soon', 'maxstoreplus' ),
						'default'  => esc_html__( '© 2017 Maxstore Kutethemes. All rights reserved', 'maxstoreplus' ),
						'args'     => array(
							'teeny'         => true,
							'textarea_rows' => 10,
						),
						'required' => array( 'enable_coming_soon', '=', array( '1' ) ),
					),
					array(
						'id'       => 'opt_disable_coming_soon_when_date_small',
						'type'     => 'switch',
						'title'    => esc_html__( 'Coming soon when count down date expired', 'maxstoreplus' ),
						'default'  => 1,
						'on'       => esc_html__( 'Disable coming soon', 'maxstoreplus' ),
						'off'      => esc_html__( "Don't disable coming soon", 'maxstoreplus' ),
						'required' => array( 'enable_coming_soon', '=', array( '1' ) ),
					),
				),
			);

			/* Popup Newsletter */
			$this->sections[] = array(
				'title'      => esc_html__( 'Popup Newsletter', 'maxstoreplus' ),
				'id'         => 'popupnewsletter',
				'subsection' => true,
				'fields'     => array(
					array(
						'title'    => esc_html__( 'Enable Popup Newsletter', 'maxstoreplus' ),
						'id'       => 'kt_enable_popup_newsletter',
						'type'     => 'switch',
						'default'  => '0',
						'on'       => esc_html__( 'Enable', 'maxstoreplus' ),
						'off'      => esc_html__( 'Disable', 'maxstoreplus' ),
						'subtitle' => esc_html__( 'Use only for Home page', 'maxstoreplus' ),
					),
					array(
						'title'    => esc_html__( 'Popup Title', 'maxstoreplus' ),
						'id'       => 'kt_popup_title',
						'type'     => 'text',
						'default'  => 'SIGN UP NEWSLETTER',
						'required' => array( 'kt_enable_popup_newsletter', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Popup content', 'maxstoreplus' ),
						'id'       => 'kt_popup_content',
						'type'     => 'textarea',
						'default'  => 'Sign up our Newsletter & Get 25% Off at your first Purchase!',
						'required' => array( 'kt_enable_popup_newsletter', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Input placeholder text', 'maxstoreplus' ),
						'id'       => 'kt_popup_placeholder_text',
						'type'     => 'text',
						'default'  => 'Your Email...',
						'required' => array( 'kt_enable_popup_newsletter', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Form button text', 'maxstoreplus' ),
						'id'       => 'kt_popup_button_text',
						'type'     => 'text',
						'default'  => 'Subscribe',
						'required' => array( 'kt_enable_popup_newsletter', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Popup Background', 'maxstoreplus' ),
						'id'       => 'kt_popup_background',
						'type'     => 'media',
						'default'  => array(
							'url' => get_template_directory_uri() . 'images/bg_newsletter.jpg',
						),
						'required' => array( 'kt_enable_popup_newsletter', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Delay time', 'maxstoreplus' ),
						'id'       => 'kt_popup_delay_time',
						'type'     => 'text',
						'default'  => '0',
						'required' => array( 'kt_enable_popup_newsletter', '=', array( '1' ) ),
						'subtitle' => esc_html__( 'Unit milliseconds', 'maxstoreplus' ),
					),
					array(
						'title'    => 'Mobile Popup Newsletter',
						'id'       => 'kt_enable_popup_newsletter_mobile',
						'type'     => 'switch',
						'default'  => '1',
						'on'       => esc_html__( 'Enable', 'maxstoreplus' ),
						'off'      => esc_html__( 'Disable', 'maxstoreplus' ),
						'required' => array( 'kt_enable_popup_newsletter', '=', array( '1' ) ),
					),
				),
			);
			$this->sections[] = array(
				'title'      => esc_html__( 'Slidebar', 'maxstoreplus' ),
				'id'         => 'slidebar',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'       => 'opt_multi_slidebars',
						'type'     => 'multi_text',
						'title'    => esc_html__( 'Sidebars', 'maxstoreplus' ),
						'subtitle' => esc_html__( 'Add custom sidebars.', 'maxstoreplus' ),
						'desc'     => esc_html__( 'This is the description field, again good for additional info.', 'maxstoreplus' ),
					),
				),
			);
			/* Google Maps */
			$this->sections[] = array(
				'title'      => esc_html__( 'Google Maps', 'maxstoreplus' ),
				'id'         => 'google_map',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'      => 'google_key',
						'type'    => 'text',
						'title'   => esc_html__( 'Google Keys', 'maxstoreplus' ),
						'default' => '',
						'desc'    => wp_kses( __( 'Get api_key in <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">Google</a>', 'maxstoreplus' ), array( 'a' => array( 'href' => array() ) ) ),
					),
				),
			);

			/* Custom css, js */
			$this->sections[] = array(
				'title'      => esc_html__( 'Custom CSS/JS', 'maxstoreplus' ),
				'desc'       => esc_html__( 'Custom css,js your site ', 'maxstoreplus' ),
				'id'         => 'custom-css-js',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'       => 'opt_general_css_code',
						'type'     => 'ace_editor',
						'title'    => esc_html__( 'Custom CSS', 'maxstoreplus' ),
						'subtitle' => esc_html__( 'Paste your custom CSS code here.', 'maxstoreplus' ),
						'mode'     => 'css',
						'theme'    => 'monokai',
						'desc'     => 'Custom css code.',
						'default'  => "",
					),
					array(
						'id'       => 'opt_general_js_code',
						'type'     => 'ace_editor',
						'title'    => esc_html__( 'Custom JS ', 'maxstoreplus' ),
						'subtitle' => esc_html__( 'Paste your custom JS code here.', 'maxstoreplus' ),
						'mode'     => 'javascript',
						'theme'    => 'chrome',
						'desc'     => 'Custom javascript code',
						//'default' => "jQuery(document).ready(function(){\n\n});"
					),
				),
			);
			/*--Typograply Options--*/
			$this->sections[] = array(
				'icon'   => 'el-icon-font',
				'title'  => esc_html__( 'Typography Options', 'maxstoreplus' ),
				'fields' => array(
					array(
						'id'       => 'opt_typography_body_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Body Font Setting', 'maxstoreplus' ),
						'subtitle' => esc_html__( 'Specify the body font properties.', 'maxstoreplus' ),
						'google'   => true,
						'output'   => 'body',
					),
					array(
						'id'       => 'opt_typography_h1_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Heading 1(H1) Font Setting', 'maxstoreplus' ),
						'subtitle' => esc_html__( 'Specify the H1 tag font properties.', 'maxstoreplus' ),
						'google'   => true,
						'output'   => 'h1',
					),
					array(
						'id'       => 'opt_typography_h2_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Heading 2(H2) Font Setting', 'maxstoreplus' ),
						'subtitle' => esc_html__( 'Specify the H2 tag font properties.', 'maxstoreplus' ),
						'google'   => true,
						'output'   => 'h2',
					),
					array(
						'id'       => 'opt_typography_h3_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Heading 3(H3) Font Setting', 'maxstoreplus' ),
						'subtitle' => esc_html__( 'Specify the H3 tag font properties.', 'maxstoreplus' ),
						'google'   => true,
						'output'   => 'h3',
					),
					array(
						'id'       => 'opt_typography_h4_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Heading 4(H4) Font Setting', 'maxstoreplus' ),
						'subtitle' => esc_html__( 'Specify the H4 tag font properties.', 'maxstoreplus' ),
						'google'   => true,
						'output'   => 'h4',
					),
					array(
						'id'       => 'opt_typography_h5_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Heading 5(H5) Font Setting', 'maxstoreplus' ),
						'subtitle' => esc_html__( 'Specify the H5 tag font properties.', 'maxstoreplus' ),
						'google'   => true,
						'output'   => 'h5',
					),
					array(
						'id'       => 'opt_typography_h6_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Heading 6(H6) Font Setting', 'maxstoreplus' ),
						'subtitle' => esc_html__( 'Specify the H6 tag font properties.', 'maxstoreplus' ),
						'google'   => true,
						'output'   => 'h6',
					),
				),
			);
			// -> Header Settings
			$this->sections[] = array(
				'title'            => esc_html__( 'Header', 'maxstoreplus' ),
				'id'               => 'header',
				'desc'             => esc_html__( 'Header Setings', 'maxstoreplus' ),
				'customizer_width' => '400px',
				'icon'             => 'el el-folder-open',
				'fields'           => array(
					array(
						'id'       => 'opt_header_layout',
						'type'     => 'select_preview',
						'title'    => esc_html__( 'Header Layout', 'maxstoreplus' ),
						'subtitle' => esc_html__( 'Select header layout style.', 'maxstoreplus' ),
						'options'  => $this->header_options,
						'default'  => 'style-01',
					),
					array(
						'id'       => 'opt_header_phone_number',
						'type'     => 'text',
						'title'    => esc_html__( 'Phone Number', 'maxstoreplus' ),
						'default'  => '(+100) 123 456 7890',
						'required' => array( 'opt_header_layout', '=', array( 'style-01', 'style-09', 'style-12' ) ),
					),
					array(
						'id'       => 'opt_header_text_right',
						'type'     => 'text',
						'title'    => esc_html__( 'Text Header', 'maxstoreplus' ),
						'default'  => 'Free worldwide shipping - On order over $100',
						'required' => array( 'opt_header_layout', '=', array( 'style-01', 'style-09', 'style-12' ) ),
					),
					array(
						'id'       => 'opt_header_text_left',
						'type'     => 'text',
						'title'    => esc_html__( 'Text Header', 'maxstoreplus' ),
						'default'  => 'Welcome to our sport store!',
						'required' => array( 'opt_header_layout', '=', array( 'style-07' ) ),
					),
					array(
						'id'      => 'opt_enable_main_menu_sticky',
						'type'    => 'switch',
						'title'   => esc_html__( 'Main Menu Sticky', 'maxstoreplus' ),
						'default' => '1',
						'on'      => esc_html__( 'Enable', 'maxstoreplus' ),
						'off'     => esc_html__( 'Disable', 'maxstoreplus' ),
					),
				),
			);

			// -> Footer Settings
			$this->sections[] = array(
				'title'  => esc_html__( 'Footer Settings', 'maxstoreplus' ),
				'desc'   => esc_html__( 'Footer Settings', 'maxstoreplus' ),
				'icon'   => 'el el-folder-open',
				'fields' => array(
					array(
						'id'    => 'opt_footer_style',
						'type'  => 'select',
						'data'  => 'posts',
						'args'  => array( 'post_type' => array( 'footer' ), 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ),
						'title' => esc_html__( 'Footer Display', 'maxstoreplus' ),
					),
				),
			);

			// -> Blog Settings
			$this->sections[] = array(
				'title'            => esc_html__( 'Blog Settings', 'maxstoreplus' ),
				'id'               => 'blog',
				'desc'             => esc_html__( 'This Blog Setings', 'maxstoreplus' ),
				'customizer_width' => '400px',
				'icon'             => 'el-icon-podcast',
				'fields'           => array(
					array(
						'id'       => 'opt_blog_layout',
						'type'     => 'image_select',
						'compiler' => true,
						'title'    => esc_html__( 'Blog Layout', 'maxstoreplus' ),
						'subtitle' => esc_html__( 'Select a layout.', 'maxstoreplus' ),
						'options'  => array(
							'left'  => array( 'alt' => 'Left Sidebar', 'img' => get_template_directory_uri() . '/images/2cl.png' ),
							'right' => array( 'alt' => 'Right Sidebar', 'img' => get_template_directory_uri() . '/images/2cr.png' ),
							'full'  => array( 'alt' => 'Full Width', 'img' => get_template_directory_uri() . '/images/1column.png' ),
						),
						'default'  => 'left',
					),
					array(
						'id'       => 'opt_blog_used_sidebar',
						'type'     => 'select',
						'multi'    => false,
						'title'    => esc_html__( 'Blog Sidebar', 'maxstoreplus' ),
						'options'  => $this->sidebars,
						'default'  => 'widget-area',
						'required' => array( 'opt_blog_layout', '=', array( 'left', 'right' ) ),
					),
					array(
						'id'      => 'opt_blog_list_style',
						'type'    => 'select',
						'multi'   => false,
						'title'   => esc_html__( 'Blog Layout Style', 'maxstoreplus' ),
						'options' => array(
							'standard' => esc_html__( 'Standard', 'maxstoreplus' ),
							'masonry'  => esc_html__( 'Grid masonry', 'maxstoreplus' ),
						),
						'default' => 'standard',
					),

					/* Masory columns*/
					array(
						'id'       => 'opt_blog_masonry_columns',
						'type'     => 'text',
						'title'    => esc_html__( 'Colmuns', 'maxstoreplus' ),
						'default'  => 3,
						'validate' => 'numeric',
						'required' => array( 'opt_blog_list_style', '=', array( 'masonry' ) ),
					),
				),
			);

			/* Single blog settings */
			$this->sections[] = array(
				'title'            => esc_html__( 'Single post', 'maxstoreplus' ),
				'id'               => 'blog-single',
				'desc'             => esc_html__( 'This Single post Setings', 'maxstoreplus' ),
				'icon'             => 'el el-cogs',
				'customizer_width' => '400px',
				'subsection'       => true,
				'fields'           => array(
					array(
						'id'       => 'opt_single_blog_layout',
						'type'     => 'image_select',
						'compiler' => true,
						'title'    => esc_html__( 'Layout', 'maxstoreplus' ),
						'subtitle' => esc_html__( 'Select a layout.', 'maxstoreplus' ),
						'options'  => array(
							'left'  => array( 'alt' => 'Left Sidebar', 'img' => get_template_directory_uri() . '/images/2cl.png' ),
							'right' => array( 'alt' => 'Right Sidebar', 'img' => get_template_directory_uri() . '/images/2cr.png' ),
							'full'  => array( 'alt' => 'Full Width', 'img' => get_template_directory_uri() . '/images/1column.png' ),
						),
						'default'  => 'left',
					),
					array(
						'id'       => 'opt_single_blog_used_sidebar',
						'type'     => 'select',
						'multi'    => false,
						'title'    => esc_html__( 'Sidebar', 'maxstoreplus' ),
						'options'  => $this->sidebars,
						'default'  => 'widget-area',
						'required' => array( 'opt_single_blog_layout', '=', array( 'left', 'right' ) ),
					),
					array(
						'id'      => 'opt_blog_about_author', // For blog standard in excerpt mode only
						'type'    => 'switch',
						'title'   => esc_html__( 'About Author', 'maxstoreplus' ),
						'default' => '0',
						'on'      => esc_html__( 'On', 'maxstoreplus' ),
						'off'     => esc_html__( 'Off', 'maxstoreplus' ),
					),
					array(
						'id'      => 'opt_blog_related_post', // For blog standard in excerpt mode only
						'type'    => 'switch',
						'title'   => esc_html__( 'Related Post', 'maxstoreplus' ),
						'default' => '0',
						'on'      => esc_html__( 'On', 'maxstoreplus' ),
						'off'     => esc_html__( 'Off', 'maxstoreplus' ),
					),
					array(
						'id'       => 'opt_related_posts_per_page',
						'type'     => 'text',
						'title'    => esc_html__( 'Related per page', 'maxstoreplus' ),
						'default'  => 5,
						'validate' => 'numeric',
						'required' => array( 'opt_blog_related_post', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Items per row on Desktop', 'maxstoreplus' ),
						'subtitle' => esc_html__( '(Screen resolution of device >= 1200px )', 'maxstoreplus' ),
						'id'       => 'opt_blog_related_lg_items',
						'type'     => 'select',
						'default'  => '3',
						'options'  => array(
							'1' => '1 item',
							'2' => '2 items',
							'3' => '3 items',
							'4' => '4 items',
							'5' => '5 items',
							'6' => '6 items',
						),
						'required' => array( 'opt_blog_related_post', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Items per row on landscape tablet', 'maxstoreplus' ),
						'subtitle' => esc_html__( '(Screen resolution of device >=992px and < 1200px )', 'maxstoreplus' ),
						'id'       => 'opt_blog_related_md_items',
						'type'     => 'select',
						'default'  => '3',
						'options'  => array(
							'1' => '1 item',
							'2' => '2 items',
							'3' => '3 items',
							'4' => '4 items',
							'5' => '5 items',
							'6' => '6 items',
						),
						'required' => array( 'opt_blog_related_post', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Items per row on portrait tablet', 'maxstoreplus' ),
						'subtitle' => esc_html__( '(Screen resolution of device >=768px and < 992px )', 'maxstoreplus' ),
						'id'       => 'opt_blog_related_sm_items',
						'type'     => 'select',
						'default'  => '2',
						'options'  => array(
							'1' => '1 item',
							'2' => '2 items',
							'3' => '3 items',
							'4' => '4 items',
							'5' => '5 items',
							'6' => '6 items',
						),
						'required' => array( 'opt_blog_related_post', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Items per row on Mobile', 'maxstoreplus' ),
						'subtitle' => esc_html__( '(Screen resolution of device >=480  add < 768px)', 'maxstoreplus' ),
						'id'       => 'opt_blog_related_xs_items',
						'type'     => 'select',
						'default'  => '2',
						'options'  => array(
							'1' => '1 item',
							'2' => '2 items',
							'3' => '3 items',
							'4' => '4 items',
							'5' => '5 items',
							'6' => '6 items',
						),
						'required' => array( 'opt_blog_related_post', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Items per row on Mobile', 'maxstoreplus' ),
						'subtitle' => esc_html__( '(Screen resolution of device < 480px)', 'maxstoreplus' ),
						'id'       => 'opt_blog_related_ts_items',
						'type'     => 'select',
						'default'  => '1',
						'options'  => array(
							'1' => '1 item',
							'2' => '2 items',
							'3' => '3 items',
							'4' => '4 items',
							'5' => '5 items',
							'6' => '6 items',
						),
						'required' => array( 'opt_blog_related_post', '=', array( '1' ) ),
					),
				),
			);

			// -> Portfolio Settings
			$this->sections[] = array(
				'title'            => esc_html__( 'Portfolio Settings', 'maxstoreplus' ),
				'id'               => 'portfolio',
				'desc'             => esc_html__( 'This Portfolio Setings', 'maxstoreplus' ),
				'customizer_width' => '400px',
				'icon'             => 'el-icon-globe-alt',
				'fields'           => array(
					array(
						'id'       => 'opt_portfolio_layout',
						'type'     => 'image_select',
						'compiler' => true,
						'title'    => esc_html__( 'Portfolio Layout', 'maxstoreplus' ),
						'subtitle' => esc_html__( 'Select a layout.', 'maxstoreplus' ),
						'options'  => array(
							'left'  => array( 'alt' => 'Left Sidebar', 'img' => get_template_directory_uri() . '/images/2cl.png' ),
							'right' => array( 'alt' => 'Right Sidebar', 'img' => get_template_directory_uri() . '/images/2cr.png' ),
							'full'  => array( 'alt' => 'Full Width', 'img' => get_template_directory_uri() . '/images/1column.png' ),
						),
						'default'  => 'left',
					),
					array(
						'id'       => 'opt_portfolio_used_sidebar',
						'type'     => 'select',
						'multi'    => false,
						'title'    => esc_html__( 'Portfolio Sidebar', 'maxstoreplus' ),
						'options'  => $this->sidebars,
						'default'  => 'widget-area',
						'required' => array( 'opt_portfolio_layout', '=', array( 'left', 'right' ) ),
					),
					array(
						'id'      => 'opt_portfolio_list_style',
						'type'    => 'select',
						'multi'   => false,
						'title'   => esc_html__( 'Portfolio Layout Style', 'maxstoreplus' ),
						'options' => array(
							'standard'  => esc_html__( 'Standard', 'maxstoreplus' ),
							'portfolio' => esc_html__( 'Grid Portfolio', 'maxstoreplus' ),
						),
						'default' => 'standard',
					),
				),
			);

			/* Single Portfolio settings */
			$this->sections[] = array(
				'title'            => esc_html__( 'Single Portfolio', 'maxstoreplus' ),
				'id'               => 'portfolio-single',
				'desc'             => esc_html__( 'This Single post Setings', 'maxstoreplus' ),
				'icon'             => 'el el-hand-right',
				'customizer_width' => '400px',
				'subsection'       => true,
				'fields'           => array(
					array(
						'id'       => 'opt_single_portfolio_layout',
						'type'     => 'image_select',
						'compiler' => true,
						'title'    => esc_html__( 'Layout', 'maxstoreplus' ),
						'subtitle' => esc_html__( 'Select a layout.', 'maxstoreplus' ),
						'options'  => array(
							'left'  => array( 'alt' => 'Left Sidebar', 'img' => get_template_directory_uri() . '/images/2cl.png' ),
							'right' => array( 'alt' => 'Right Sidebar', 'img' => get_template_directory_uri() . '/images/2cr.png' ),
							'full'  => array( 'alt' => 'Full Width', 'img' => get_template_directory_uri() . '/images/1column.png' ),
						),
						'default'  => 'left',
					),
					array(
						'id'       => 'opt_single_portfolio_used_sidebar',
						'type'     => 'select',
						'multi'    => false,
						'title'    => esc_html__( 'Sidebar', 'maxstoreplus' ),
						'options'  => $this->sidebars,
						'default'  => 'widget-area',
						'required' => array( 'opt_single_portfolio_layout', '=', array( 'left', 'right' ) ),
					),
					array(
						'id'      => 'opt_portfolio_about_author', // For portfolio standard in excerpt mode only
						'type'    => 'switch',
						'title'   => esc_html__( 'About Author', 'maxstoreplus' ),
						'default' => '0',
						'on'      => esc_html__( 'On', 'maxstoreplus' ),
						'off'     => esc_html__( 'Off', 'maxstoreplus' ),
					),
					array(
						'id'      => 'opt_portfolio_related_post', // For portfolio standard in excerpt mode only
						'type'    => 'switch',
						'title'   => esc_html__( 'Related Post', 'maxstoreplus' ),
						'default' => '0',
						'on'      => esc_html__( 'On', 'maxstoreplus' ),
						'off'     => esc_html__( 'Off', 'maxstoreplus' ),
					),
					array(
						'id'       => 'portfolio_related_posts_per_page',
						'type'     => 'text',
						'title'    => esc_html__( 'Related per page', 'maxstoreplus' ),
						'default'  => 5,
						'validate' => 'numeric',
						'required' => array( 'opt_portfolio_related_post', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Items per row on Desktop', 'maxstoreplus' ),
						'subtitle' => esc_html__( '(Screen resolution of device >= 1200px )', 'maxstoreplus' ),
						'id'       => 'opt_portfolio_related_lg_items',
						'type'     => 'select',
						'default'  => '3',
						'options'  => array(
							'1' => '1 item',
							'2' => '2 items',
							'3' => '3 items',
							'4' => '4 items',
							'5' => '5 items',
							'6' => '6 items',
						),
						'required' => array( 'opt_portfolio_related_post', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Items per row on landscape tablet', 'maxstoreplus' ),
						'subtitle' => esc_html__( '(Screen resolution of device >=992px and < 1200px )', 'maxstoreplus' ),
						'id'       => 'opt_portfolio_related_md_items',
						'type'     => 'select',
						'default'  => '3',
						'options'  => array(
							'1' => '1 item',
							'2' => '2 items',
							'3' => '3 items',
							'4' => '4 items',
							'5' => '5 items',
							'6' => '6 items',
						),
						'required' => array( 'opt_portfolio_related_post', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Items per row on portrait tablet', 'maxstoreplus' ),
						'subtitle' => esc_html__( '(Screen resolution of device >=768px and < 992px )', 'maxstoreplus' ),
						'id'       => 'opt_portfolio_related_sm_items',
						'type'     => 'select',
						'default'  => '2',
						'options'  => array(
							'1' => '1 item',
							'2' => '2 items',
							'3' => '3 items',
							'4' => '4 items',
							'5' => '5 items',
							'6' => '6 items',
						),
						'required' => array( 'opt_portfolio_related_post', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Items per row on Mobile', 'maxstoreplus' ),
						'subtitle' => esc_html__( '(Screen resolution of device >=480  add < 768px)', 'maxstoreplus' ),
						'id'       => 'opt_portfolio_related_xs_items',
						'type'     => 'select',
						'default'  => '2',
						'options'  => array(
							'1' => '1 item',
							'2' => '2 items',
							'3' => '3 items',
							'4' => '4 items',
							'5' => '5 items',
							'6' => '6 items',
						),
						'required' => array( 'opt_portfolio_related_post', '=', array( '1' ) ),
					),
					array(
						'title'    => esc_html__( 'Items per row on Mobile', 'maxstoreplus' ),
						'subtitle' => esc_html__( '(Screen resolution of device < 480px)', 'maxstoreplus' ),
						'id'       => 'opt_portfolio_related_ts_items',
						'type'     => 'select',
						'default'  => '1',
						'options'  => array(
							'1' => '1 item',
							'2' => '2 items',
							'3' => '3 items',
							'4' => '4 items',
							'5' => '5 items',
							'6' => '6 items',
						),
						'required' => array( 'opt_portfolio_related_post', '=', array( '1' ) ),
					),
				),
			);

			if ( class_exists( 'WooCommerce' ) ) {
				// -> Woo Settings
				$this->sections[] = array(
					'title'  => esc_html__( 'WooCommerce', 'maxstoreplus' ),
					'desc'   => esc_html__( 'WooCommerce Settings', 'maxstoreplus' ),
					'icon'   => 'el-icon-shopping-cart',
					'fields' => array(
						array(
							'title'    => esc_html__( 'Products perpage', 'maxstoreplus' ),
							'id'       => 'woo_products_perpage',
							'type'     => 'text',
							'default'  => '12',
							'validate' => 'numeric',
							'subtitle' => esc_html__( 'Number of products on shop page', 'maxstoreplus' ),
						),
						array(
							'id'       => 'woo_shop_layout',
							'type'     => 'image_select',
							'compiler' => true,
							'title'    => esc_html__( 'Sidebar Position', 'maxstoreplus' ),
							'subtitle' => esc_html__( 'Select sidebar position on shop, product archive page.', 'maxstoreplus' ),
							'options'  => array(
								'left'  => array( 'alt' => '1 Column Left', 'img' => get_template_directory_uri() . '/images/2cl.png' ),
								'right' => array( 'alt' => '2 Column Right', 'img' => get_template_directory_uri() . '/images/2cr.png' ),
								'full'  => array( 'alt' => 'Full Width', 'img' => get_template_directory_uri() . '/images/1column.png' ),
							),
							'default'  => 'left',
						),
						array(
							'id'       => 'woo_shop_used_sidebar',
							'type'     => 'select',
							'multi'    => false,
							'title'    => esc_html__( 'Sidebar', 'maxstoreplus' ),
							'options'  => $this->sidebars,
							'default'  => 'widget-area',
							'required' => array( 'woo_shop_layout', '=', array( 'left', 'right' ) ),
						),
						array(
							'id'       => 'woo_shop_list_style',
							'type'     => 'image_select',
							'compiler' => true,
							'title'    => esc_html__( 'Shop Default Layout', 'maxstoreplus' ),
							'subtitle' => esc_html__( 'Select default layout for shop, product category archive.', 'maxstoreplus' ),
							'options'  => array(
								'grid' => array( 'alt' => 'Layout Grid', 'img' => get_template_directory_uri() . '/images/grid-display.png' ),
								'list' => array( 'alt' => 'Layout List', 'img' => get_template_directory_uri() . '/images/list-display.png' ),
							),
							'default'  => 'grid',
						),
						array(
							'id'       => 'woo_style_hover',
							'type'     => 'switch',
							'title'    => esc_html__( 'Enable two image', 'maxstoreplus' ),
							'subtitle' => esc_html__( 'Enable two image in products', 'maxstoreplus' ),
							'default'  => '1',
							'on'       => esc_html__( 'Enable', 'maxstoreplus' ),
							'off'      => esc_html__( 'Disable', 'maxstoreplus' ),
						),
						array(
							'id'       => 'woo_shop_banner',
							'type'     => 'switch',
							'title'    => esc_html__( 'Display banner in shop page', 'maxstoreplus' ),
							'subtitle' => esc_html__( 'Display image in shop page', 'maxstoreplus' ),
							'default'  => '1',
							'on'       => esc_html__( 'On', 'maxstoreplus' ),
							'off'      => esc_html__( 'Off', 'maxstoreplus' ),
						),
						array(
							'id'       => 'woo_shop_slider',
							'type'     => 'select',
							'title'    => esc_html__( 'Banner Slide', 'maxstoreplus' ),
							'subtitle' => esc_html__( 'Select banner Slide style.', 'maxstoreplus' ),
							'options'  => maxstoreplus_rev_slide_options_for_redux(),
							'required' => array( 'woo_shop_banner', '=', 1 ),
						),
						array(
							'title'    => esc_html__( 'Items per row on Desktop( For grid mode )', 'maxstoreplus' ),
							'subtitle' => esc_html__( '(Screen resolution of device >= 1200px )', 'maxstoreplus' ),
							'id'       => 'woo_shop_lg_items',
							'type'     => 'select',
							'default'  => '4',
							'options'  => array(
								'12' => '1 item',
								'6'  => '2 items',
								'4'  => '3 items',
								'3'  => '4 items',
								'15' => '5 items',
								'2'  => '6 items',
							),

						),
						array(
							'title'    => esc_html__( 'Items per row on landscape tablet( For grid mode )', 'maxstoreplus' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=992px and < 1200px )', 'maxstoreplus' ),
							'id'       => 'woo_shop_md_items',
							'type'     => 'select',
							'default'  => '4',
							'options'  => array(
								'12' => '1 item',
								'6'  => '2 items',
								'4'  => '3 items',
								'3'  => '4 items',
								'15' => '5 items',
								'2'  => '6 items',
							),

						),
						array(
							'title'    => esc_html__( 'Items per row on portrait tablet( For grid mode )', 'maxstoreplus' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=768px and < 992px )', 'maxstoreplus' ),
							'id'       => 'woo_shop_sm_items',
							'type'     => 'select',
							'default'  => '4',
							'options'  => array(
								'12' => '1 item',
								'6'  => '2 items',
								'4'  => '3 items',
								'3'  => '4 items',
								'15' => '5 items',
								'2'  => '6 items',
							),

						),
						array(
							'title'    => esc_html__( 'Items per row on Mobile( For grid mode )', 'maxstoreplus' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=480  add < 768px)', 'maxstoreplus' ),
							'id'       => 'woo_shop_xs_items',
							'type'     => 'select',
							'default'  => '6',
							'options'  => array(
								'12' => '1 item',
								'6'  => '2 items',
								'4'  => '3 items',
								'3'  => '4 items',
								'15' => '5 items',
								'2'  => '6 items',
							),

						),
						array(
							'title'    => esc_html__( 'Items per row on Mobile( For grid mode )', 'maxstoreplus' ),
							'subtitle' => esc_html__( '(Screen resolution of device < 480px)', 'maxstoreplus' ),
							'id'       => 'woo_shop_ts_items',
							'type'     => 'select',
							'default'  => '12',
							'options'  => array(
								'12' => '1 item',
								'6'  => '2 items',
								'4'  => '3 items',
								'3'  => '4 items',
								'15' => '5 items',
								'2'  => '6 items',
							),

						),
					),
				);
				/** Single Product **/
				$this->sections[] = array(
					'title'      => esc_html__( 'Single product', 'maxstoreplus' ),
					'desc'       => esc_html__( 'Single product settings', 'maxstoreplus' ),
					'subsection' => true,
					'fields'     => array(
						array(
							'id'       => 'woo_single_product_layout',
							'type'     => 'image_select',
							'title'    => esc_html__( 'Single Product Sidebar Position', 'maxstoreplus' ),
							'subtitle' => esc_html__( 'Select sidebar position on single product page.', 'maxstoreplus' ),
							'options'  => array(
								'left'  => array( 'alt' => '1 Column Left', 'img' => get_template_directory_uri() . '/images/2cl.png' ),
								'right' => array( 'alt' => '2 Column Right', 'img' => get_template_directory_uri() . '/images/2cr.png' ),
								'full'  => array( 'alt' => 'Full Width', 'img' => get_template_directory_uri() . '/images/1column.png' ),
							),
							'default'  => 'left',
						),
						array(
							'id'       => 'woo_single_used_sidebar',
							'type'     => 'select',
							'multi'    => false,
							'title'    => esc_html__( 'Sidebar', 'maxstoreplus' ),
							'options'  => $this->sidebars,
							'default'  => 'widget-area',
							'required' => array( 'woo_single_product_layout', '=', array( 'left', 'right' ) ),
						),
					),

				);
				/** Cross sell products **/
				$this->sections['woocommerce-cross-sell'] = array(
					'title'      => esc_html__( 'Cross sell', 'maxstoreplus' ),
					'desc'       => esc_html__( 'Cross sell settings', 'maxstoreplus' ),
					'subsection' => true,
					'fields'     => array(
						array(
							'title'    => esc_html__( 'Cross sell title', 'maxstoreplus' ),
							'id'       => 'woo_cross_sell_products_title',
							'type'     => 'text',
							'default'  => 'You may be interested in...',
							'subtitle' => esc_html__( 'Cross sell title', 'maxstoreplus' ),
						),

						array(
							'title'    => esc_html__( 'Cross sell items per row on Desktop', 'maxstoreplus' ),
							'subtitle' => esc_html__( '(Screen resolution of device >= 1200px )', 'maxstoreplus' ),
							'id'       => 'woo_cross_sell_lg_items',
							'type'     => 'select',
							'default'  => '3',
							'options'  => array(
								'1' => '1 item',
								'2' => '2 items',
								'3' => '3 items',
								'4' => '4 items',
								'5' => '5 items',
								'6' => '6 items',
							),
						),
						array(
							'title'    => esc_html__( 'Cross sell items per row on landscape tablet', 'maxstoreplus' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=992px and < 1200px )', 'maxstoreplus' ),
							'id'       => 'woo_cross_sell_md_items',
							'type'     => 'select',
							'default'  => '3',
							'options'  => array(
								'1' => '1 item',
								'2' => '2 items',
								'3' => '3 items',
								'4' => '4 items',
								'5' => '5 items',
								'6' => '6 items',
							),
						),
						array(
							'title'    => esc_html__( 'Cross sell items per row on portrait tablet', 'maxstoreplus' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=768px and < 992px )', 'maxstoreplus' ),
							'id'       => 'woo_cross_sell_sm_items',
							'type'     => 'select',
							'default'  => '2',
							'options'  => array(
								'1' => '1 item',
								'2' => '2 items',
								'3' => '3 items',
								'4' => '4 items',
								'5' => '5 items',
								'6' => '6 items',
							),
						),
						array(
							'title'    => esc_html__( 'Cross sell items per row on Mobile', 'maxstoreplus' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=480  add < 768px)', 'maxstoreplus' ),
							'id'       => 'woo_cross_sell_xs_items',
							'type'     => 'select',
							'default'  => '2',
							'options'  => array(
								'1' => '1 item',
								'2' => '2 items',
								'3' => '3 items',
								'4' => '4 items',
								'5' => '5 items',
								'6' => '6 items',
							),
						),
						array(
							'title'    => esc_html__( 'Cross sell items per row on Mobile', 'maxstoreplus' ),
							'subtitle' => esc_html__( '(Screen resolution of device < 480px)', 'maxstoreplus' ),
							'id'       => 'woo_cross_sell_ts_items',
							'type'     => 'select',
							'default'  => '1',
							'options'  => array(
								'1' => '1 item',
								'2' => '2 items',
								'3' => '3 items',
								'4' => '4 items',
								'5' => '5 items',
								'6' => '6 items',
							),
						),
					),
				);

				/*-- RELATED PRODUCTS --*/
				$this->sections['woocommerce-related'] = array(
					'title'      => esc_html__( 'Related products', 'maxstoreplus' ),
					'desc'       => esc_html__( 'Related products settings', 'maxstoreplus' ),
					'subsection' => true,
					'fields'     => array(
						array(
							'title'    => esc_html__( 'Related products title', 'maxstoreplus' ),
							'id'       => 'woo_related_product_products_title',
							'type'     => 'text',
							'default'  => 'Related Products',
							'subtitle' => esc_html__( 'Related products title', 'maxstoreplus' ),
						),

						array(
							'title'    => esc_html__( 'Limit number of products', 'maxstoreplus' ),
							'id'       => 'woo_related_products_limit_num_of_products',
							'type'     => 'text',
							'default'  => '8',
							'validate' => 'numeric',
							'subtitle' => esc_html__( 'Number of products on shop page', 'maxstoreplus' ),
						),

						array(
							'title'    => esc_html__( 'Related products items per row on Desktop', 'maxstoreplus' ),
							'subtitle' => esc_html__( '(Screen resolution of device >= 1200px )', 'maxstoreplus' ),
							'id'       => 'woo_related_product_lg_items',
							'type'     => 'select',
							'default'  => '3',
							'options'  => array(
								'1' => '1 item',
								'2' => '2 items',
								'3' => '3 items',
								'4' => '4 items',
								'5' => '5 items',
								'6' => '6 items',
							),
						),
						array(
							'title'    => esc_html__( 'Related products items per row on landscape tablet', 'maxstoreplus' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=992px and < 1200px )', 'maxstoreplus' ),
							'id'       => 'woo_related_product_md_items',
							'type'     => 'select',
							'default'  => '3',
							'options'  => array(
								'1' => '1 item',
								'2' => '2 items',
								'3' => '3 items',
								'4' => '4 items',
								'5' => '5 items',
								'6' => '6 items',
							),
						),
						array(
							'title'    => esc_html__( 'Related product items per row on portrait tablet', 'maxstoreplus' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=768px and < 992px )', 'maxstoreplus' ),
							'id'       => 'woo_related_product_sm_items',
							'type'     => 'select',
							'default'  => '2',
							'options'  => array(
								'1' => '1 item',
								'2' => '2 items',
								'3' => '3 items',
								'4' => '4 items',
								'5' => '5 items',
								'6' => '6 items',
							),
						),
						array(
							'title'    => esc_html__( 'Related products items per row on Mobile', 'maxstoreplus' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=480  add < 768px)', 'maxstoreplus' ),
							'id'       => 'woo_related_product_xs_items',
							'type'     => 'select',
							'default'  => '2',
							'options'  => array(
								'1' => '1 item',
								'2' => '2 items',
								'3' => '3 items',
								'4' => '4 items',
								'5' => '5 items',
								'6' => '6 items',
							),
						),
						array(
							'title'    => esc_html__( 'Related products items per row on Mobile', 'maxstoreplus' ),
							'subtitle' => esc_html__( '(Screen resolution of device < 480px)', 'maxstoreplus' ),
							'id'       => 'woo_related_product_ts_items',
							'type'     => 'select',
							'default'  => '1',
							'options'  => array(
								'1' => '1 item',
								'2' => '2 items',
								'3' => '3 items',
								'4' => '4 items',
								'5' => '5 items',
								'6' => '6 items',
							),
						),
					),
				);

				/*-- UP SELL PRODUCTS --*/
				$this->sections['woocommerce-up-sells'] = array(
					'title'      => esc_html__( 'Up sells products', 'maxstoreplus' ),
					'desc'       => esc_html__( 'Up sells products settings', 'maxstoreplus' ),
					'subsection' => true,
					'fields'     => array(
						array(
							'title'    => esc_html__( 'Up sells title', 'maxstoreplus' ),
							'id'       => 'woo_up_sells_products_title',
							'type'     => 'text',
							'default'  => 'You may also like&hellip;',
							'subtitle' => esc_html__( 'Up sells products title', 'maxstoreplus' ),
						),

						array(
							'title'    => esc_html__( 'Up sells items per row on Desktop', 'maxstoreplus' ),
							'subtitle' => esc_html__( '(Screen resolution of device >= 1200px )', 'maxstoreplus' ),
							'id'       => 'woo_up_sells_lg_items',
							'type'     => 'select',
							'default'  => '3',
							'options'  => array(
								'1' => '1 item',
								'2' => '2 items',
								'3' => '3 items',
								'4' => '4 items',
								'5' => '5 items',
								'6' => '6 items',
							),
						),
						array(
							'title'    => esc_html__( 'Up sells items per row on landscape tablet', 'maxstoreplus' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=992px and < 1200px )', 'maxstoreplus' ),
							'id'       => 'woo_up_sells_md_items',
							'type'     => 'select',
							'default'  => '3',
							'options'  => array(
								'1' => '1 item',
								'2' => '2 items',
								'3' => '3 items',
								'4' => '4 items',
								'5' => '5 items',
								'6' => '6 items',
							),
						),
						array(
							'title'    => esc_html__( 'Up sells items per row on portrait tablet', 'maxstoreplus' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=768px and < 992px )', 'maxstoreplus' ),
							'id'       => 'woo_up_sells_sm_items',
							'type'     => 'select',
							'default'  => '2',
							'options'  => array(
								'1' => '1 item',
								'2' => '2 items',
								'3' => '3 items',
								'4' => '4 items',
								'5' => '5 items',
								'6' => '6 items',
							),
						),
						array(
							'title'    => esc_html__( 'Up sells items per row on Mobile', 'maxstoreplus' ),
							'subtitle' => esc_html__( '(Screen resolution of device >=480  add < 768px)', 'maxstoreplus' ),
							'id'       => 'woo_up_sells_xs_items',
							'type'     => 'select',
							'default'  => '2',
							'options'  => array(
								'1' => '1 item',
								'2' => '2 items',
								'3' => '3 items',
								'4' => '4 items',
								'5' => '5 items',
								'6' => '6 items',
							),
						),
						array(
							'title'    => esc_html__( 'Up sells items per row on Mobile', 'maxstoreplus' ),
							'subtitle' => esc_html__( '(Screen resolution of device < 480px)', 'maxstoreplus' ),
							'id'       => 'woo_up_sells_ts_items',
							'type'     => 'select',
							'default'  => '1',
							'options'  => array(
								'1' => '1 item',
								'2' => '2 items',
								'3' => '3 items',
								'4' => '4 items',
								'5' => '5 items',
								'6' => '6 items',
							),
						),
					),
				);
			}

			/*--Social Settings--*/
			$this->sections[] = array(
				'title'  => esc_html__( 'Social Settings', 'maxstoreplus' ),
				'icon'   => 'el-icon-group',
				'fields' => array(
					array(
						'id'       => 'opt_twitter_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Twitter', 'maxstoreplus' ),
						'default'  => 'https://twitter.com',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_fb_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Facebook', 'maxstoreplus' ),
						'default'  => 'https://facebook.com',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_google_plus_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Google Plus', 'maxstoreplus' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_dribbble_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Dribbble', 'maxstoreplus' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_behance_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Behance', 'maxstoreplus' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_tumblr_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Tumblr', 'maxstoreplus' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_instagram_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Instagram', 'maxstoreplus' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_pinterest_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Pinterest', 'maxstoreplus' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_youtube_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Youtube', 'maxstoreplus' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_vimeo_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Vimeo', 'maxstoreplus' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_linkedin_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Linkedin', 'maxstoreplus' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_rss_link',
						'type'     => 'text',
						'title'    => esc_html__( 'RSS', 'maxstoreplus' ),
						'default'  => '',
						'validate' => 'url',
					),
				),
			);
		}

		public function setHelpTabs()
		{
			// Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
			$this->args['help_tabs'][] = array(
				'id'      => 'redux-opts-1',
				'title'   => esc_html__( 'Theme Information 1', 'maxstoreplus' ),
				'content' => wp_kses( __( '<p>This is the tab content, HTML is allowed.</p>', 'maxstoreplus' ), array( 'p' ) ),
			);

			$this->args['help_tabs'][] = array(
				'id'      => 'redux-opts-2',
				'title'   => esc_html__( 'Theme Information 2', 'maxstoreplus' ),
				'content' => wp_kses( __( '<p>This is the tab content, HTML is allowed.</p>', 'maxstoreplus' ), array( 'p' ) ),
			);

			// Set the help sidebar
			$this->args['help_sidebar'] = wp_kses( __( '<p>This is the tab content, HTML is allowed.</p>', 'maxstoreplus' ), array( 'p' ) );
		}

		/**
		 *
		 * All the possible arguments for Redux.
		 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
		 * */
		public function setArguments()
		{
			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(
				// TYPICAL -> Change these values as you need/desire
				'opt_name'           => 'maxstoreplus', // This is where your data is stored in the database and also becomes your global variable name.
				'display_name'       => '<span class="ts-theme-name">' . sanitize_text_field( $theme->get( 'Name' ) ) . '</span>', // Name that appears at the top of your panel
				'display_version'    => $theme->get( 'Version' ), // Version that appears at the top of your panel
				'menu_type'          => 'submenu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu'     => false, // Show the sections below the admin menu item or not
				'menu_title'         => esc_html__( 'Theme Options', 'maxstoreplus' ),
				'page_title'         => esc_html__( 'Theme Options', 'maxstoreplus' ),
				// You will need to generate a Google API key to use this feature.
				// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
				'google_api_key'     => '', // Must be defined to add google fonts to the typography module
				//'async_typography'    => true, // Use a asynchronous font on the front end or font string
				//'admin_bar'           => false, // Show the panel pages on the admin bar
				'global_variable'    => 'maxstoreplus', // Set a different name for your global variable other than the opt_name
				'dev_mode'           => false, // Show the time the page took to load, etc
				'customizer'         => true, // Enable basic customizer support
				// OPTIONAL -> Give you extra features
				'page_priority'      => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
				'page_parent'        => 'maxstoreplus', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
				'page_permissions'   => 'manage_options', // Permissions needed to access the options panel.
				'menu_icon'          => '', // Specify a custom URL to an icon
				'last_tab'           => '', // Force your panel to always open to a specific tab (by id)
				'page_icon'          => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
				'page_slug'          => 'maxstore_options', // Page slug used to denote the panel
				'save_defaults'      => true, // On load save the defaults to DB before user clicks save or not
				'default_show'       => false, // If true, shows the default value next to each field that is not the default value.
				'default_mark'       => '', // What to print by the field's title if the value shown is default. Suggested: *
				// CAREFUL -> These options are for advanced use only
				'transient_time'     => 60 * MINUTE_IN_SECONDS,
				'output'             => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
				'output_tag'         => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
				//'domain'              => 'maxstoreplus', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
				'footer_credit'      => esc_html__( 'Kute Themes WordPress Team', 'maxstoreplus' ), // Disable the footer credit of Redux. Please leave if you can help it.
				// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
				'database'           => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
				'show_import_export' => true, // REMOVE
				'system_info'        => false, // REMOVE
				'help_tabs'          => array(),
				'help_sidebar'       => '', // esc_html__( '', $this->args['domain'] );
				'hints'              => array(
					'icon'          => 'icon-question-sign',
					'icon_position' => 'right',
					'icon_color'    => 'lightgray',
					'icon_size'     => 'normal',

					'tip_style'    => array(
						'color'   => 'light',
						'shadow'  => true,
						'rounded' => false,
						'style'   => '',
					),
					'tip_position' => array(
						'my' => 'top left',
						'at' => 'bottom right',
					),
					'tip_effect'   => array(
						'show' => array(
							'effect'   => 'slide',
							'duration' => '500',
							'event'    => 'mouseover',
						),
						'hide' => array(
							'effect'   => 'slide',
							'duration' => '500',
							'event'    => 'click mouseleave',
						),
					),
				),
			);

			$this->args['share_icons'][] = array(
				'url'   => 'https://facebook.com/',
				'title' => 'Like us on Facebook',
				'icon'  => 'el-icon-facebook',
			);
			$this->args['share_icons'][] = array(
				'url'   => 'http://twitter.com/',
				'title' => 'Follow us on Twitter',
				'icon'  => 'el-icon-twitter',
			);

			// Panel Intro text -> before the form
			if ( !isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
				if ( !empty( $this->args['global_variable'] ) ) {
					$v = $this->args['global_variable'];
				} else {
					$v = str_replace( "-", "_", $this->args['opt_name'] );
				}
			}
		}
	}
}
if ( !function_exists( 'MaxStore_Redux_Framework_config' ) ) {
	function MaxStore_Redux_Framework_config()
	{
		new MaxStore_Redux_Framework_config();
	}
}
add_action( 'init', 'MaxStore_Redux_Framework_config', 1 );

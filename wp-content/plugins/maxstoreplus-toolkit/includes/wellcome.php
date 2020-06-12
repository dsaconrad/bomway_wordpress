<?php
if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {
	if ( !class_exists( 'Maxstoreplus_Wellcome' ) ) {
		class Maxstoreplus_Wellcome
		{

			public $tabs = array();

			public function __construct()
			{
				$this->set_tabs();
				// Add action to enqueue scripts.
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
				add_action( 'admin_menu', array( $this, 'admin_menu' ), 9 );
			}

			public function admin_menu()
			{
				if ( current_user_can( 'edit_theme_options' ) ) {
					add_menu_page( 'maxstoreplus', 'Maxstore - Plus', 'manage_options', 'maxstoreplus', array( &$this, 'wellcome' ), MAXSTOREPLUS_IMG_URL . 'menu-icon.png', 2 );
					add_submenu_page( 'maxstoreplus', 'maxstoreplus Dashboard', 'Dashboard', 'manage_options', 'maxstoreplus', array( $this, 'wellcome' ) );
				}
			}

			public function enqueue_scripts()
			{
				wp_enqueue_style( 'jquery-ui-datepicker' );
				wp_enqueue_script( 'jquery-ui-datepicker' );
				wp_enqueue_style( 'kt-backend', MAXSTOREPLUS_BASE_URL . 'assets/css/style.css', array(), false );
				wp_enqueue_style( 'kt-jquery-ui', MAXSTOREPLUS_BASE_URL . 'assets/css/jquery-ui.min.css', array(), false );
				wp_enqueue_style( 'cmb2-style', MAXSTOREPLUS_BASE_URL . 'includes/vendor/CMB/css/style.css', array(), false );
				wp_enqueue_script( 'kt-theme-option-js', MAXSTOREPLUS_BASE_URL . 'includes/vendor/CMB/js/custom.js', array( 'jquery' ), '1.0', true );
				wp_enqueue_script( 'chosen', MAXSTOREPLUS_BASE_URL . 'assets/js/chosen.jquery.min.js', array( 'jquery' ), '1.0', true );
				wp_enqueue_script( 'functions-js', MAXSTOREPLUS_BASE_URL . 'assets/js/functions.js', array( 'jquery' ), '1.5.0', true );
			}

			public function set_tabs()
			{
				$this->tabs = array(
					'plugins' => esc_html__( 'Plugins', 'maxstoreplus' ),
					'support' => esc_html__( 'Support', 'maxstoreplus' )
				);

			}

			public function active_plugin()
			{
				if ( empty( $_GET[ 'magic_token' ] ) || wp_verify_nonce( $_GET[ 'magic_token' ], 'panel-plugins' ) === false ) {
					esc_html_e( 'Permission denied', 'maxstoreplus' );
					die;
				}

				if ( isset( $_GET[ 'plugin_slug' ] ) && $_GET[ 'plugin_slug' ] != "" ) {
					$plugin_slug = $_GET[ 'plugin_slug' ];
					$plugins     = TGM_Plugin_Activation::$instance->plugins;
					foreach ( $plugins as $plugin ) {
						if ( $plugin[ 'slug' ] == $plugin_slug ) {
							activate_plugins( $plugin[ 'file_path' ] );
							?>
                            <script type="text/javascript">
                                window.location = "admin.php?page=maxstoreplus&tab=plugins";
                            </script>
							<?php
							break;
						}
					}
				}

			}

			public function deactivate_plugin()
			{
				if ( empty( $_GET[ 'magic_token' ] ) || wp_verify_nonce( $_GET[ 'magic_token' ], 'panel-plugins' ) === false ) {
					esc_html_e( 'Permission denied', 'maxstoreplus' );
					die;
				}

				if ( isset( $_GET[ 'plugin_slug' ] ) && $_GET[ 'plugin_slug' ] != "" ) {
					$plugin_slug = $_GET[ 'plugin_slug' ];
					$plugins     = TGM_Plugin_Activation::$instance->plugins;
					foreach ( $plugins as $plugin ) {
						if ( $plugin[ 'slug' ] == $plugin_slug ) {
							deactivate_plugins( $plugin[ 'file_path' ] );
							?>
                            <script type="text/javascript">
                                window.location = "admin.php?page=maxstoreplus&tab=plugins";
                            </script>
							<?php
							break;
						}
					}
				}

			}

			public function intall_plugin()
			{

			}

			/**
			 * Maxstore_Toolkit cpanel page.
			 */
			public function wellcome()
			{

				/* deactivate_plugin */
				if ( isset( $_GET[ 'action' ] ) && $_GET[ 'action' ] == 'deactivate_plugin' ) {
					$this->deactivate_plugin();
				}
				/* deactivate_plugin */
				if ( isset( $_GET[ 'action' ] ) && $_GET[ 'action' ] == 'active_plugin' ) {
					$this->active_plugin();
				}

				$tab = 'plugins';
				if ( isset( $_GET[ 'tab' ] ) ) {
					$tab = $_GET[ 'tab' ];
				}
				?>
                <div class="wrap redapple-wrap">
                    <div class="welcome-panel">
                        <div class="welcome-panel-content">
                            <h2><?php esc_html_e( 'Welcome to MaxstorePlus!', 'maxstoreplus' ); ?></h2>
                            <p class="about-description"><?php esc_html_e( 'We\'ve assembled some links to get you started', 'maxstoreplus' ); ?></p>
                            <div class="welcome-panel-column-container">
                                <div class="welcome-panel-column">
                                    <h3><?php esc_html_e( 'Get Started', 'maxstoreplus' ) ?></h3>
                                    <a href="http://kutethemes.net/wordpress/maxstore/" target="_blank"
                                       class="button button-primary button-hero trigger-tab"><?php esc_html_e( 'View demos', 'maxstoreplus' ); ?></a>
                                    <p class="small-text">or, <a
                                                href="http://localhost/wp-test/wp-admin/customize.php"><?php echo esc_html_e( 'Customize your site', 'maxstoreplus' ); ?></a>
                                    </p>
                                </div>
                                <div class="welcome-panel-column">
                                    <h3><?php echo esc_html_e( 'Next Steps', 'maxstoreplus' ); ?></h3>
                                    <ul>
                                        <li><a target="_blank" href="#"
                                               class="welcome-icon dashicons-media-document"><?php esc_html_e( 'Read Documentation', 'maxstoreplus' ) ?></a>
                                        </li>
                                        <li><a target="_blank" href="http://support.ovicsoft.com/support-system"
                                               class="welcome-icon dashicons-editor-help"><?php esc_html_e( 'Request Support', 'maxstoreplus' ); ?></a>
                                        </li>
                                        <li><a target="_blank"
                                               href="http://kutethemes.net/wordpress/maxstore/changelog.txt"
                                               class="welcome-icon dashicons-backup"><?php esc_html_e( 'View Changelog Details', 'corporatepro' ); ?></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="welcome-panel-column">
                                    <h3><?php esc_html_e( 'Keep in Touch', 'maxstoreplus' ); ?></h3>
                                    <ul>
                                        <li><a target="_blank" href="#"
                                               class="welcome-icon dashicons-email-alt"><?php esc_html_e( 'Newsletter', 'maxstoreplus' ); ?></a>
                                        </li>
                                        <li><a target="_blank" href="#"
                                               class="welcome-icon dashicons-twitter"><?php esc_html_e( 'Twitter', 'maxstoreplus' ); ?></a>
                                        </li>
                                        <li><a target="_blank" href="#"
                                               class="welcome-icon dashicons-facebook"><?php esc_html_e( 'Facebook', 'maxstoreplus' ); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- .welcome-panel-content -->
                    </div>
                    <div id="tabs-container" role="tabpanel">
                        <div class="nav-tab-wrapper">
							<?php foreach ( $this->tabs as $key => $value ): ?>
                                <a class="nav-tab maxstoreplus-nav <?php if ( $tab == $key ): ?> active<?php endif; ?>"
                                   href="admin.php?page=maxstoreplus&tab=<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></a>
							<?php endforeach; ?>
                        </div>
                        <div class="tab-content">
							<?php $this->$tab(); ?>
                        </div>
                    </div>
                </div>
				<?php
			}

			public static function plugins()
			{
				$maxstoreplus_tgm_theme_plugins = TGM_Plugin_Activation::$instance->plugins;
				$tgm                            = TGM_Plugin_Activation::$instance;

				$status_class = "";
				?>
                <div class="plugins rp-row">
					<?php
					$wp_plugin_list = get_plugins();
					foreach ( $maxstoreplus_tgm_theme_plugins as $maxstoreplus_tgm_theme_plugin ) {
						if ( $tgm->is_plugin_active( $maxstoreplus_tgm_theme_plugin[ 'slug' ] ) ) {
							$status_class = 'is-active';
							if ( $tgm->does_plugin_have_update( $maxstoreplus_tgm_theme_plugin[ 'slug' ] ) ) {
								$status_class = 'plugin-update';
							}
						} else if ( isset( $wp_plugin_list[ $maxstoreplus_tgm_theme_plugin[ 'file_path' ] ] ) ) {
							$status_class = 'plugin-inactive';
						} else {
							$status_class = 'no-intall';
						}
						?>
                        <div class="rp-col">
                            <div class="plugin <?php echo esc_attr( $status_class ); ?>">
                                <div class="preview">
									<?php if ( isset( $maxstoreplus_tgm_theme_plugin[ 'image' ] ) && $maxstoreplus_tgm_theme_plugin[ 'image' ] != "" ): ?>
                                        <img src="<?php echo esc_url( $maxstoreplus_tgm_theme_plugin[ 'image' ] ); ?>"
                                             alt="">
									<?php else: ?>
                                        <img src="<?php echo esc_url( get_template_directory_uri() . '/images/no-image.jpg' ); ?>"
                                             alt="">
									<?php endif; ?>
                                </div>
                                <div class="plugin-name">
                                    <h3 class="theme-name"><?php echo $maxstoreplus_tgm_theme_plugin[ 'name' ] ?></h3>
                                </div>
                                <div class="actions">
                                    <a class="button button-primary button-install-plugin" href="<?php
									echo esc_url( wp_nonce_url(
										add_query_arg(
											array(
												'page'          => urlencode( TGM_Plugin_Activation::$instance->menu ),
												'plugin'        => urlencode( $maxstoreplus_tgm_theme_plugin[ 'slug' ] ),
												'tgmpa-install' => 'install-plugin',
											),
											admin_url( 'themes.php' )
										),
										'tgmpa-install',
										'tgmpa-nonce'
									)
									);
									?>"><?php esc_html_e( 'Install', 'maxstoreplus' ); ?></a>

                                    <a class="button button-primary button-update-plugin" href="<?php
									echo esc_url( wp_nonce_url(
										add_query_arg(
											array(
												'page'         => urlencode( TGM_Plugin_Activation::$instance->menu ),
												'plugin'       => urlencode( $maxstoreplus_tgm_theme_plugin[ 'slug' ] ),
												'tgmpa-update' => 'update-plugin',
											),
											admin_url( 'themes.php' )
										),
										'tgmpa-install',
										'tgmpa-nonce'
									)
									);
									?>"><?php esc_html_e( 'Update', 'maxstoreplus' ); ?></a>

                                    <a class="button button-primary button-activate-plugin" href="<?php
									echo esc_url(
										add_query_arg(
											array(
												'page'        => urlencode( 'maxstoreplus' ),
												'plugin_slug' => urlencode( $maxstoreplus_tgm_theme_plugin[ 'slug' ] ),
												'action'      => 'active_plugin',
												'magic_token' => wp_create_nonce( 'panel-plugins' )
											),
											admin_url( 'admin.php' )
										)
									);
									?>""><?php esc_html_e( 'Activate', 'maxstoreplus' ); ?></a>
                                    <a class="button button-secondary button-uninstall-plugin" href="<?php
									echo esc_url(
										add_query_arg(
											array(
												'page'        => urlencode( 'maxstoreplus' ),
												'plugin_slug' => urlencode( $maxstoreplus_tgm_theme_plugin[ 'slug' ] ),
												'action'      => 'deactivate_plugin',
												'magic_token' => wp_create_nonce( 'panel-plugins' )
											),
											admin_url( 'admin.php' )
										)
									);
									?>""><?php esc_html_e( 'Deactivate', 'maxstoreplus' ); ?></a>
                                </div>
                            </div>
                        </div>
						<?php
					}
					?>
                </div>
				<?php
			}

			public static function support()
			{
				?>
                <div class="rp-row">
                    <div class="rp-col">
                        <div class="suport-item">
                            <h3><?php esc_html_e( 'Documentation', 'maxstoreplus' ); ?></h3>
                            <p><?php esc_html_e( 'Here is our user guide for maxstoreplus, including basic setup steps, as well as Linda features and elements for your reference.', 'maxstoreplus' ); ?></p>
                            <a target="_blank" href="#"
                               class="button button-primary"><?php esc_html_e( 'Read Documentation', 'maxstoreplus' ); ?></a>
                        </div>
                    </div>
                    <div class="rp-col closed">
                        <div class="suport-item">
                            <h3><?php esc_html_e( 'Video Tutorials', 'maxstoreplus' ); ?></h3>
                            <p class="coming-soon"><?php esc_html_e( 'Video tutorials is the great way to show you how to setup Linda theme, make sure that the feature works as it\'s designed.', 'maxstoreplus' ); ?></p>
                            <a href="#"
                               class="button button-primary disabled"><?php esc_html_e( 'See Video', 'maxstoreplus' ); ?></a>
                        </div>
                    </div>
                    <div class="rp-col">
                        <div class="suport-item">
                            <h3><?php esc_html_e( 'Forum', 'maxstoreplus' ); ?></h3>
                            <p><?php esc_html_e( 'Can\'t find the solution on documentation? We\'re here to help, even on weekend. Just click here to start 1on1 chatting with us!', 'maxstoreplus' ); ?></p>
                            <a target="_blank" href="http://support.ovicsoft.com/support-system"
                               class="button button-primary"><?php esc_html_e( 'Request Support', 'maxstoreplus' ); ?></a>
                        </div>
                    </div>
                </div>
				<?php
			}
		}

		new Maxstoreplus_Wellcome();
	}
}

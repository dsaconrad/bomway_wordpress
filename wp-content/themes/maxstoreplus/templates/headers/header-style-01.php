<?php
/*
Name:	Header style 01
*/
$opt_header_phone_number = maxstoreplus_get_option( 'opt_header_phone_number', '(+100) 123 456 7890' );
$opt_header_text_right   = maxstoreplus_get_option( 'opt_header_text_right', 'Free worldwide shipping - On order over $100' );
?>
<!-- Header -->
<header id="header" class="header header-style-1">
    <div id="header-primary">
        <div class="header-top">
            <div class="row">
                <div class="col-md-4">
                    <ul class="header-bar-menu left">
                        <li class="menu-item phone-number">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <p><?php echo esc_html__( 'call us toll free: ', 'maxstoreplus' ) ?><?php echo esc_html( $opt_header_phone_number ) ?></p>
                        </li>
                    </ul>
                </div>
                <div class="col-md-8">
                    <ul class="header-bar-menu right">
                        <li class="menu-item notification-bar">
                            <p><?php echo esc_html( $opt_header_text_right ) ?></p>
                        </li>
						<?php get_template_part( 'template-parts/header', 'currency' ); ?>
						<?php get_template_part( 'template-parts/header', 'language' ); ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="main-header">
            <div class="row">
                <div class="col-md-4">
                    <ul class="header-bar-menu left">
                        <li class="search-bar">
                            <!-- Search form -->
							<?php corporatepro_get_search_form(); ?>
                            <!-- ./Search form -->
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <div class="header-center">
                        <div class="logo logo-header">
							<?php corporatepro_get_logo(); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="header-bar-menu right">
                        <li class="menu-item navigation-bar">
							<?php get_template_part( 'template-parts/header', 'userlink' ); ?>
                        </li>
                        <li class="menu-item wishlist-switch">
                            <a href="<?php echo get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) ); ?>"
                               class="wishlist-icon">
                                <i class="flaticon-heart1"></i>
                            </a>
                        </li>
                        <li class="menu-item shopcart-switch">
                            <!-- block mini cart -->
							<?php if ( class_exists( 'WooCommerce' ) ) {
								woocommerce_mini_cart();
							} ?>
                            <!-- block mini cart -->
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="header-menu ms-main-menu main-menu-wapper">
            <nav class="navigation main-menu">
				<?php
				wp_nav_menu( array(
					'menu'            => 'primary',
					'theme_location'  => 'primary',
					'container'       => '',
					'container_class' => '',
					'container_id'    => '',
					'menu_class'      => 'primary-menu',
					'fallback_cb'     => 'maxstoreplus_bootstrap_navwalker::fallback',
					'walker'          => new maxstoreplus_bootstrap_navwalker(),
				)
				);
				?>
            </nav>
        </div>
    </div>
</header>
<!-- /Header -->
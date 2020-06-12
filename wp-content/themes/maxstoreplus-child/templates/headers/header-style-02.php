<?php
/*
Name:	Header style 02
*/
?>
<!-- Header -->
<header id="header" class="header header-style-2">
    <div id="header-primary">
        <div class="main-header">
            <div class="row">
                <div class="col-md-5">
                    <div class="header-left">
                        <a href="#" id="toggle-menu-style-2" class="menu-button style1"><span class="flaticon-bars1"></span></a>
                        <div class="search-bar">
                            <!-- Search form -->
                            <?php corporatepro_get_search_form();?>
                            <!-- ./Search form -->
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="header-center">
                        <div class="logo logo-header">
                            <?php corporatepro_get_logo();?>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <ul class="header-bar-menu right">
                        <li class="menu-item navigation-bar">
                            <?php get_template_part( 'template-parts/header','userlink');?>
                        </li>
                        <li class="menu-item wishlist-switch">
                            <a href="<?php echo get_permalink(get_option('yith_wcwl_wishlist_page_id')); ?>" class="wishlist-icon">
                                <i class="flaticon-heart1"></i>
                            </a>
                        </li>
                        <li class="menu-item shopcart-switch">
                            <!-- block mini cart -->
                            <?php if (class_exists('WooCommerce')) {woocommerce_mini_cart();} ?>
                            <!-- block mini cart -->
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="drop-menu-style-2" class="header-menu main-menu-wapper">
            <a href="#" class="close-menu"><span class="flaticon-close1"></span></a>
            <nav class="navigation main-menu">
                <?php
                wp_nav_menu( array(
                    'menu'            => 'primary',
                    'theme_location'  => 'primary',
                    'container'       => '',
                    'container_class' => '',
                    'container_id'    => '',
                    'menu_class'      => 'scrollbar-rail primary-menu',
                    'fallback_cb'     => 'maxstoreplus_bootstrap_navwalker::fallback',
                    'walker'          => new maxstoreplus_bootstrap_navwalker()
                ));
                ?>
            </nav>
        </div>
    </div>
</header>
<!-- /Header -->
<?php
/*
Name:	Header style 05
*/
?>
<!-- Header -->
<header id="header" class="header header-style-5 main-menu-wapper">
    <div id="header-primary">
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <ul class="header-bar-menu left">
                            <?php get_template_part( 'template-parts/header','control');?>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="header-bar-menu right currency-bar-list">
                            <?php  get_template_part( 'template-parts/header','currency');?>
                            <?php  get_template_part( 'template-parts/header','language');?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="main-header">
                <div class="row">
                    <div class="col-md-4">
                        <div class="header-left">
                            <div class="search-bar">
                                <!-- Search form -->
                                <?php corporatepro_get_search_form();?>
                                <!-- ./Search form -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="header-center">
                            <div class="logo logo-header">
                                <?php corporatepro_get_logo();?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <ul class="header-bar-menu right">
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
            <div class="header-menu ms-main-menu">
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
                        'walker'          => new maxstoreplus_bootstrap_navwalker()
                    ));
                    ?>
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- /Header -->

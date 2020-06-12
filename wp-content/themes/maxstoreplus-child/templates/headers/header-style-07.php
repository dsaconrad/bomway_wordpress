<?php
/*
Name:	Header style 07
*/
$opt_header_text_left      = maxstoreplus_get_option('opt_header_text_left','Welcome to our sport store!');
?>
<!-- Header -->
<header id="header" class="header header-style-7 main-menu-wapper">
    <div id="header-primary">
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <ul class="header-bar-menu left">
                            <li class="menu-item notification-bar">
                                <p><?php echo esc_html($opt_header_text_left) ?></p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-9">
                        <ul class="header-bar-menu right">
                            <li class="menu-item">
                                <ul class="header-bar-menu left">
                                    <?php get_template_part( 'template-parts/header','control');?>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <ul class="header-bar-menu left currency-bar-list">
                                    <?php  get_template_part( 'template-parts/header','currency');?>
                                    <?php  get_template_part( 'template-parts/header','language');?>
                                </ul>
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
        </div>
        <div class="container">
            <div class="main-header">
                <div class="row">
                    <div class="col-md-3">
                        <div class="header-left">
                            <div class="logo logo-header">
                                <?php corporatepro_get_logo();?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 header-menu-fix">
                        <ul class="header-bar-menu right">
                            <li class="menu-item">
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
                            </li>
                            <li class="menu-item search-bar">
                                <!-- Search form -->
                                <?php corporatepro_get_search_form();?>
                                <!-- ./Search form -->
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- /Header -->

<?php
/*
Name:	Header style 03
*/
?>
<!-- Header -->
<header id="header" class="header header-style-3 main-menu-wapper">
    <div id="header-primary">
        <div class="header-top">
            <div class="row">
                <div class="col-md-6">
                    <ul class="header-bar-menu left">
                        <?php get_template_part( 'template-parts/header','control');?>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="header-bar-menu right">
                        <?php  get_template_part( 'template-parts/header','currency');?>
                        <?php  get_template_part( 'template-parts/header','language');?>
                        <li class="menu-item shopcart-switch">
                            <!-- block mini cart -->
                            <?php if (class_exists('WooCommerce')) {woocommerce_mini_cart();} ?>
                            <!-- block mini cart -->
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="main-header">
            <div class="row">
                <div class="col-md-12">
                    <div class="header-center">
                        <div class="logo logo-header">
                            <?php corporatepro_get_logo();?>
                        </div>
                    </div>
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
</header>
<!-- /Header -->

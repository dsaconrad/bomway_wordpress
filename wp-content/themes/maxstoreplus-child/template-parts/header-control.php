<?php
$header_layout = maxstoreplus_get_option('opt_header_layout');
?>
<li class="menu-item">
    <a href="<?php echo get_permalink( get_page_by_path( 'my-account' ) ) ?>">
        <?php echo esc_html__('my account','maxstoreplus')?>
    </a>
</li>
<li class="menu-item">
    <a href="<?php echo get_permalink( get_page_by_path( 'wishlist' ) ) ?>">
        <?php echo esc_html__('wishlist','maxstoreplus')?>
    </a>
</li>
<li class="menu-item navigation-bar">
    <?php get_template_part( 'template-parts/header','userlink');?>
</li>
<li class="menu-item">
    <a href="<?php echo get_permalink( get_page_by_path( 'checkout' ) ) ?>">
        <?php echo esc_html__('checkout','maxstoreplus')?>
    </a>
</li>
<?php if (($header_layout == 'style-03') ) : ?>
    <li class="menu-item search-bar">
        <!-- Search form -->
        <?php corporatepro_get_search_form();?>
        <!-- ./Search form -->
    </li>
<?php endif; ?>

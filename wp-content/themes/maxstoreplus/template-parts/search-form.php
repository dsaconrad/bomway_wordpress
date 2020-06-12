<?php
$header_layout = maxstoreplus_get_option('opt_header_layout');
$selected = '';
if (isset($_GET['product_cat']) && $_GET['product_cat']) {
    $selected = $_GET['product_cat'];
}
$args = array(
    'show_option_none'  => __('All Categories', 'maxstoreplus'),
    'taxonomy'          => 'product_cat',
    'class'             => 'categori-search-option',
    'hide_empty'        => 1,
    'orderby'           => 'name',
    'order'             => "asc",
    'tab_index'         => true,
    'hierarchical'      => true,
    'id'                => rand(),
    'name'              => 'product_cat',
    'value_field'       => 'slug',
    'selected'          => $selected,
    'option_none_value' => '0',
);
?>
<?php if (($header_layout == 'style-03')) : ?>
    <a class="search-button" href="#">
        <?php echo esc_html__('store search', 'maxstoreplus') ?>
    </a>
    <div class="search-content">
        <p class="title"><?php echo esc_html__('Search anything', 'maxstoreplus'); ?></p>
        <span class="close-touch"><i class="flaticon-close1"></i></span>
        <div class="container">
            <div class="content-wrap">
                <form method="get" action="<?php echo esc_url(home_url('/')) ?>" class="form-search">
                    <?php if (class_exists('WooCommerce')): ?>
                        <input type="hidden" name="post_type" value="product"/>
                    <?php endif; ?>
                    <input class="instant-search" name="s" placeholder="<?php esc_html_e('Search...', 'maxstoreplus'); ?>" type="search">
                    <span></span>
                </form>
                <div class="content-inner">
                    <div class="content-content">
                        <div class="row result-search style-search auto-clear"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php elseif ( ($header_layout == 'style-04') || ($header_layout == 'style-07') || ($header_layout == 'style-09') || ($header_layout == 'style-11') ) : ?>
    <a class="search-button" href="#">
        <i class="flaticon-search2"></i>
    </a>
    <div class="search-content">
        <p class="title"><?php echo esc_html__('Search anything', 'maxstoreplus'); ?></p>
        <span class="close-touch"><i class="flaticon-close1"></i></span>
        <div class="container">
            <div class="content-wrap">
                <form method="get" action="<?php echo esc_url(home_url('/')) ?>" class="form-search">
                    <?php if (class_exists('WooCommerce')): ?>
                        <input type="hidden" name="post_type" value="product"/>
                    <?php endif; ?>
                    <input class="instant-search" name="s" placeholder="<?php esc_html_e('Search...', 'maxstoreplus'); ?>" type="search">
                    <span></span>
                </form>
                <div class="content-inner">
                    <div class="content-content">
                        <div class="row result-search style-search auto-clear"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php elseif (($header_layout == 'style-06')) : ?>
    <!-- block search -->
    <form method="get" action="<?php echo esc_url(home_url('/')) ?>" class="block-search">
        <?php if (class_exists('WooCommerce')): ?>
            <input type="hidden" name="post_type" value="product"/>
            <input type="hidden" name="taxonomy" value="product_cat">
        <?php endif; ?>
        <div class="block-content">
            <?php if (class_exists('WooCommerce')): ?>
                <div class="categori-search">
                    <?php wp_dropdown_categories($args); ?>
                </div>
            <?php endif; ?>
            <input type="text" class="form-control" name="s" value="<?php echo esc_attr(get_search_query()); ?>"
                   placeholder="<?php esc_html_e('Search here...', 'maxstoreplus'); ?>">
            <button class="button btn-search" type="submit">
                <span><?php esc_html_e('search', 'maxstoreplus'); ?></span>
            </button>
        </div>
    </form><!-- block search -->
<?php else : ?>
    <form method="get" action="<?php echo esc_url(home_url('/')) ?>" class="search-bar-form">
		<?php if (class_exists('WooCommerce')): ?>
            <input type="hidden" name="post_type" value="product"/>
		<?php endif; ?>
        <span>
            <button class="search-submit" type="submit">
                <i class="flaticon-search3"></i>
            </button>
        </span>
        <input name="s" placeholder="<?php esc_html_e('Search entire store here', 'maxstoreplus'); ?>" type="search">
    </form>
<?php endif; ?>
<?php
if( isset($atts) ){
    extract ( $atts );
}

$taxonomys      = 'product_cat';
$orderby        = 'name';
$show_count     = 0;      // 1 for yes, 0 for no
$pad_counts     = 0;      // 1 for yes, 0 for no
$hierarchical   = 1;      // 1 for yes, 0 for no
$title          = '';
$empty          = 0;
$slug           = $category_slug;

$args = array(
    'taxonomy'     => $taxonomys,
    'orderby'      => $orderby,
    'show_count'   => $show_count,
    'pad_counts'   => $pad_counts,
    'hierarchical' => $hierarchical,
    'title_li'     => $title,
    'hide_empty'   => $empty,
    'slug'         => $slug
);
$all_categories = get_categories( $args );
?>
<div class="block-cat <?php echo esc_attr( $css_class )?> <?php echo esc_attr($style_show)?>">
    <div class="thumb">
        <figure>
			<?php
			$kt_lazy_image = maxstoreplus_get_option( 'kt_enable_lazy', '' ) == 0 ? false : true;
			$image_thumb   = maxstoreplus_resize_image( $bg_cat, null, 255, 335, true, $kt_lazy_image );
			echo htmlspecialchars_decode( $image_thumb[ 'img' ] );
			?>
        </figure>
        <?php foreach ($all_categories as $category) : ?>
        <a href="<?php echo get_term_link($category->term_id,'product_cat' ) ?>" class="content-cat">
            <h3 class="title title_cat"><?php echo esc_html($category->name)?></h3>
            <span class="count count_cat">
                <?php echo '( '.$category->count.' items )';?>
            </span>
        </a>
    </div>
    <a href="<?php echo get_term_link($category->term_id,'product_cat' ) ?>" class="button button_cat">
        <?php echo esc_html__('shop category','maxstoreplus')?>
    </a>
    <?php endforeach; ?>
</div>

<?php
if( isset($atts) ){
    extract ( $atts );
}
$items = vc_param_group_parse_atts( $items );
?>
<div class="block-cat <?php echo esc_attr( $css_class )?>">
    <?php foreach( $items as $item):?>
        <div class="content-cat">
            <?php
            $taxonomys      = 'product_cat';
            $orderby        = 'name';
            $show_count     = 0;      // 1 for yes, 0 for no
            $pad_counts     = 0;      // 1 for yes, 0 for no
            $hierarchical   = 1;      // 1 for yes, 0 for no
            $title          = '';
            $empty          = 0;
            $slug           = $item['category'];

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
            $all_category = get_categories( $args );
            ?>
            <figure>
				<?php
				$kt_lazy_image = maxstoreplus_get_option( 'kt_enable_lazy', '' ) == 0 ? false : true;
				$image_thumb   = maxstoreplus_resize_image( $item['bg_icon'], null, 60, 60, true, $kt_lazy_image );
				echo htmlspecialchars_decode( $image_thumb[ 'img' ] );
				?>
            </figure>
            <?php foreach ($all_category as $category) : ?>
                <a href="<?php echo get_term_link($category->term_id,'product_cat' ) ?>" class="sub-cat">
                    <h3 class="title title_cat"><?php echo esc_html($category->name)?></h3>
                    <span class="count count_cat">
                <?php echo ' ('.$category->count.')';?>
            </span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endforeach;?>
</div>

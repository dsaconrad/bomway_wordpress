<?php
if ($atts) {
    extract($atts);
}
$items = vc_param_group_parse_atts($items_layout1);
?>
<div class="team-slide owl-carousel <?php echo esc_attr($css_class); ?>" <?php echo $owl_carousel ?>>
    <?php foreach ($items as $item): ?>
        <?php
        if (!empty($item['link'])) {
            $link = vc_build_link($item['link']);
        } else {
            $link = array('url' => '#', 'title' => '', 'target' => '_self', 'rel' => '');
        }
        $args = array(
            'br' => array(),
            'em' => array(),
            'strong' => array(),
        );
        $description    = wp_kses($item['des'], $args);
        ?>
        <div class="item-team">
            <a href="<?php echo esc_url($link['url']) ?>" target="<?php echo esc_attr($link['target']) ?>">
				<?php
				$kt_lazy_image = maxstoreplus_get_option( 'kt_enable_lazy', '' ) == 0 ? false : true;
				$image_thumb   = maxstoreplus_resize_image( $item['bg_img'], null, 85, 85, true, $kt_lazy_image );
				echo htmlspecialchars_decode( $image_thumb[ 'img' ] );
				?>
            </a>
            <div class="content-team">
                <?php if ($item['des']) : ?>
                    <p class="des">
                        <?php echo $description; ?>
                    </p>
                <?php endif; ?>
                <?php if ($item['name']) : ?>
                    <a href="<?php echo esc_url($link['url']) ?>" target="<?php echo esc_attr($link['target']) ?>">
                        <h3 class="title"><?php echo esc_html($item['name']) ?></h3>
                    </a>
                <?php endif; ?>
                <?php if ($item['position']) : ?>
                    <p class="position"><?php echo esc_html($item['position']) ?></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

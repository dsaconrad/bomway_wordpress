<?php
if ($atts) {
    extract($atts);
}
$items = vc_param_group_parse_atts($items);
?>
<div class="team-slide owl-carousel <?php echo esc_attr($css_class); ?>" <?php echo $owl_carousel ?>>
    <?php foreach ($items as $item): ?>
        <?php
        if (!empty($item['link'])) {
            $link = vc_build_link($item['link']);
        } else {
            $link = array('url' => '#', 'title' => '', 'target' => '_self', 'rel' => '');
        }
        $socials = explode(',', $item['use_socials']);
        ?>
        <div class="item-team">
            <a href="<?php echo esc_url($link['url']) ?>" target="<?php echo esc_attr($link['target']) ?>">
				<?php
				$kt_lazy_image = maxstoreplus_get_option( 'kt_enable_lazy', '' ) == 0 ? false : true;
				$image_thumb   = maxstoreplus_resize_image( $item['bg_img'], null, 370, 363, true, $kt_lazy_image );
				echo htmlspecialchars_decode( $image_thumb[ 'img' ] );
				?>
            </a>
            <?php if ($item['name']) : ?>
                <h3 class="title">
                    <a href="<?php echo esc_url($link['url']) ?>" target="<?php echo esc_attr($link['target']) ?>"><?php echo esc_html($item['name']) ?></a>
                </h3>
            <?php endif; ?>
            <?php if ($item['position']) : ?>
                <p class="position"><?php echo esc_html($item['position']) ?></p>
            <?php endif; ?>
            <?php if( $socials && is_array($socials) && count( $socials ) > 0 ):?>
                <ul class="social-f">
                    <?php foreach ($socials as $social):?>
                        <li><?php maxstoreplus_social($social);?></li>
                    <?php endforeach;?>
                </ul>
            <?php endif;?>
        </div>
    <?php endforeach; ?>
</div>

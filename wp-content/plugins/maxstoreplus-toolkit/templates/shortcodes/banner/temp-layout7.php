<?php
if( isset($atts) ){
    extract ( $atts );
}
if( $link ){
    $link = vc_build_link( $link );
}else{
    $link = array('url'=>'', 'title'=>'', 'target'=>'_self', 'rel'=>'') ;
}
$css = 'background: url('.esc_url(wp_get_attachment_url($bg_banner)).')';
?>
<div class="block-banner <?php echo esc_attr( $css_class );?>" style="<?php echo esc_attr($css) ?>">
    <span class="effect"></span>
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-7">
                <div class="content-banner">
                    <?php if ( $des_top ) : ?>
                        <p class="des-banner-top"><?php echo $des_top ?></p>
                    <?php endif; ?>
                    <?php if ( $title ) : ?>
                        <h2 class="title title-banner"><?php echo $title ?></h2>
                    <?php endif; ?>
                    <?php if ( $des ) : ?>
                        <h3 class="description des-banner"><?php echo $des ?></h3>
                    <?php endif; ?>
                    <?php if ( $link['url'] != '' ) : ?>
                        <a href="<?php echo esc_url($link['url']) ?>" target="<?php echo esc_html($link['target']) ?>" class="button button-banner">
                            <?php echo esc_html($link['title']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if( $atts ){
    extract ( $atts );
}

if( $link ){
    $link = vc_build_link( $link );
}else{
    $link = array('url'=>'', 'title'=>'', 'target'=>'_self', 'rel'=>'') ;
}
?>
<div class="block-title <?php echo esc_attr( $css_class ) ?>">
    <?php if ( $title ) : ?>
        <h1 class="title title-banner"><?php echo esc_html($title) ?></h1>
    <?php endif; ?>
    <?php if ( $des ) : ?>
        <p class="description"><?php echo $des ?></p>
    <?php endif; ?>
    <?php if ( $link['url'] != '' ) : ?>
        <a href="<?php echo esc_url($link['url']) ?>" target="<?php echo esc_html($link['target']) ?>" class="button">
            <?php echo esc_html($link['title']); ?>
        </a>
    <?php endif; ?>
</div>

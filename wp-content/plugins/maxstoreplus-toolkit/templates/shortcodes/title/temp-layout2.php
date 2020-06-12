<?php
if( $atts ){
    extract ( $atts );
}
?>
<div class="block-title <?php echo esc_attr( $css_class ) ?>">
    <?php if ( $title ) : ?>
        <h1 class="title title-banner"><?php echo esc_html($title) ?></h1>
    <?php endif; ?>
    <?php if ( $des ) : ?>
        <p class="description"><?php echo $des ?></p>
    <?php endif; ?>
</div>

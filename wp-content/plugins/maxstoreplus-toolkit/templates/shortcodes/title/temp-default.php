<?php
if( isset($atts) ){
    extract ( $atts );
}

?>
<div class="block-title">
    <?php
        echo '<'.$element.' class="super-title '.esc_attr( $css_class ).'" style="color: '.esc_attr($color).'">'.esc_html($title).'</'.$element.'>';
    ?>
</div>

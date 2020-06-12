<?php
if( isset($atts) ){
    extract ( $atts );
}
?>
<div class="newsletter-form-wrap widget widget-newsletter layout1 <?php echo esc_attr( $css_class );?>">
    <div class="block-newsletter left">
        <?php if( $title ): ?>
            <h3 class="title-newletter title">
                <?php echo esc_html($title);?>
            </h3>
        <?php endif; ?>
    </div>
    <div class="form-newsletter">
        <input name="emailaddress" class="email" type="email"  placeholder="<?php echo esc_attr($placeholder_text);?>"/>
        <span><input class="submit-newsletter" type="submit" value="<?php echo balanceTags($button_text);?>"></span>
    </div>
</div>
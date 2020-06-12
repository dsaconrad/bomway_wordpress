<?php
if( isset($atts) ){
    extract ( $atts );
}
?>
<div class="newsletter-form-wrap widget widget-newsletter <?php echo esc_attr( $css_class );?>">
    <?php if( $title ): ?>
        <h3 class="title-newletter title">
            <?php echo esc_html($title);?>
            <span><?php echo esc_html__('yahoo!!','maxstoreplus')?></span>
        </h3>
    <?php endif; ?>
    <?php if ( $description ): ?>
        <p><?php echo esc_html($description) ?></p>
    <?php endif; ?>
    <div class="form-newsletter">
        <input name="emailaddress" class="email" type="email"  placeholder="<?php echo esc_attr($placeholder_text);?>"/>
        <span><input class="submit-newsletter" type="submit" value="<?php echo balanceTags($button_text);?>"></span>
    </div>
</div>
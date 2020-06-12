<?php
$kt_popup_title            = maxstoreplus_get_option( 'kt_popup_title', 'SIGN UP NEWSLETTER' );
$kt_popup_content          = maxstoreplus_get_option( 'kt_popup_content', 'Sign up our Newsletter & Get 25% Off at your first Purchase!' );
$kt_popup_placeholder_text = maxstoreplus_get_option( 'kt_popup_placeholder_text', 'Enter your email address' );
$kt_popup_button_text      = maxstoreplus_get_option( 'kt_popup_button_text', 'Subscribe' );
$kt_popup_background       = maxstoreplus_get_option( 'kt_popup_background', '' );
?>
<!--  Popup Newsletter-->
<div class="modal fade" id="popup-newsletter" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" <?php if ( $kt_popup_background ): ?>style="background-image: url(<?php echo $kt_popup_background[ 'url' ]; ?>)" <?php endif; ?>>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="flaticon-close1"></i>
            </button>
            <div class="block-inner">
                <div class="block-newletter">
					<?php if ( $kt_popup_title ): ?>
                        <h2 class="title-newsletter"><?php echo esc_html( $kt_popup_title ); ?></h2>
					<?php endif; ?>
                    <div class="block-content">
                        <p class="text-des"><?php echo esc_html( $kt_popup_content ); ?></p>
                        <div class="newsletter-form-wrap">
                            <div class="input-group">
                                <input type="email" name="emailaddress"
                                       placeholder="<?php echo esc_attr( $kt_popup_placeholder_text ); ?>"
                                       class="form-control">
                                <span class="input-group-btn">
                                <button type="button"
                                        class="btn btn-subcribe submit-newsletter"><span><?php echo esc_html( $kt_popup_button_text ); ?></span></button>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="checkbox btn-checkbox">
                    <label>
                        <input class="kt_disabled_popup_by_user"
                               type="checkbox"><span><?php echo esc_html__( 'Dont show this popup again', 'maxstoreplus' ); ?></span>
                    </label>
                </div>
            </div>

        </div>
    </div>
</div><!--  Popup Newsletter-->
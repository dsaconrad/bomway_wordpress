<?php
$woo_shop_banner    = maxstoreplus_get_option('woo_shop_banner','');
$slide_rv           = maxstoreplus_get_option('woo_shop_slider');

$banner_class = array('banner-shop banner-shop');
if ( $woo_shop_banner == 1 && !empty($slide_rv) ) : ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="<?php echo esc_attr( implode(' ', $banner_class) );?>">
                    <?php echo do_shortcode( '[rev_slider alias="'.$slide_rv.'"]' ); ?>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
    <?php return; ?>
<?php endif; ?>

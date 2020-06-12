<?php
$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
$myaccount_link = get_permalink( get_option('woocommerce_myaccount_page_id') );
$woocommerce_enable_myaccount_registration = get_option('woocommerce_enable_myaccount_registration');
$login_text = esc_html__('Login','maxstoreplus');
if( $woocommerce_enable_myaccount_registration == "yes" ){
    $login_text .= esc_html__('/Register','maxstoreplus');
}
$logout_url = "#";
if ( $myaccount_page_id ) {
    $logout_url = wp_logout_url( get_permalink( woocommerce_get_page_id( 'shop' ) ) );
    if ( get_option( 'woocommerce_force_ssl_checkout' ) == 'yes' ){
        $logout_url = str_replace( 'http:', 'https:', $logout_url );
    }
}
?>

<div class="block-header-link block-header-user">
    <a class="icon" href="<?php echo esc_url( $myaccount_link );?>"><span class="flaticon-shape"></span></a>
    <div class="block-content">
        <?php if( function_exists( 'wc_get_account_menu_items' )):?>
            <ul class="links">
                <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
                    <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                        <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif;?>
    </div>
</div>
<?php
$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
$myaccount_link = get_permalink( get_option('woocommerce_myaccount_page_id') );
$woocommerce_enable_myaccount_registration = get_option('woocommerce_enable_myaccount_registration');
$login_text = esc_html__('Login','maxstoreplus');
if( $woocommerce_enable_myaccount_registration == "yes" ){
	$login_text .= esc_html__('/Register','maxstoreplus');
}
$login_alt = "<i class='fa fa-user-o user'></i>";

$logout_url = "#";
 if ( $myaccount_page_id ) {
      $logout_url = wp_logout_url( get_permalink( get_page_by_title( 'shop' ) ) );
      if ( get_option( 'woocommerce_force_ssl_checkout' ) == 'yes' ){
        $logout_url = str_replace( 'http:', 'https:', $logout_url );
      }
}
?>
<?php if( is_user_logged_in()): ?>
<?php
$currentUser = wp_get_current_user();
?>

<a data-toggle="dropdown" class="admin-click" href="<?php echo esc_url( $myaccount_link );?>">
    <?php esc_html_e('Hi, ','maxstoreplus'); echo $currentUser->display_name; ?>
</a>
<?php if( function_exists( 'wc_get_account_menu_items' )):?>
    <ul class="navigation-item-menu submenu">
        <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
            <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?> ">
                <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif;?>

<?php else:?>
    <ul>
        <li><a href="<?php echo esc_url( $myaccount_link );?> loginbutton"><?php echo $login_alt;?></a></li>
    </ul>
<?php endif;?>
<?php
if ( class_exists( 'WOOCS_STORAGE' ) ) :
	?>
    <li class="menu-item currency-bar">
		<?php
		$default          = array(
			'EUR' => array(
				'name'        => 'euro',
				'rate'        => 1,
				'symbol'      => '&euro;',
				'position'    => 'right',
				'is_etalon'   => 1,
				'description' => 'Europian Euro',
				'hide_cents'  => 0,
				'flag'        => '',
			),
			'USD' => array(
				'name'        => 'dollar',
				'rate'        => 1,
				'symbol'      => '$',
				'position'    => 'right',
				'is_etalon'   => 1,
				'description' => 'USA Dollar',
				'hide_cents'  => 0,
				'flag'        => '',
			),
		);
		$current_currency = 'USD';
		$storage          = new WOOCS_STORAGE( get_option( 'woocs_storage', 'session' ) );
		if ( $storage->get_val( 'woocs_current_currency' ) != '' ) {
			$current_currency = $storage->get_val( 'woocs_current_currency' );
		}
		$currencies = get_option( 'woocs', $default );
		?>
		<?php foreach ( $currencies as $key => $currency ) : ?>
			<?php if ( $key == $current_currency ): ?>
                <a class="text currency-toggle" data-toggle="dropdown">
					<?php echo esc_html( $currency['description'] ); ?>
                </a>
			<?php endif; ?>
		<?php endforeach; ?>
        <ul class="currency-list submenu">
			<?php foreach ( $currencies as $key => $currency ) : ?>
                <li class="switcher-option <?php if ( $key == $current_currency ): ?> active <?php endif; ?>">
                    <a class="woocs_flag_view_item<?php if ( $key == $current_currency ): ?> woocs_flag_view_item_current<?php endif; ?>"
                       href="#" data-currency="<?php echo esc_attr( $key ) ?>">
                        <span class="symbol"><?php echo esc_html( $currency['symbol'] ); ?></span>
                        <span class="text"><?php echo esc_html( $currency['description'] ); ?></span>
                    </a>
                </li>
			<?php endforeach; ?>
        </ul>
    </li>
<?php
endif;
?>
<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}


if ( !function_exists( 'maxstoreplus_coming_soon_html' ) ) {

    function maxstoreplus_coming_soon_html() {

        $date   = maxstoreplus_get_option('coming_soon_date','') ? maxstoreplus_get_option('coming_soon_date','') : date();
        $title  = maxstoreplus_get_option('coming_soon_title','');
        $des    = maxstoreplus_get_option('coming_soon_des','');
        $logo   = maxstoreplus_get_option('logo_coming_soon','');
        $footer = maxstoreplus_get_option('coming_soon_footer','');
        $background   = maxstoreplus_get_option('coming_soon_background','');

        get_header( 'soon' );

        $html = '';
        $logo_html  = '';
        $title_html = '';
        $des_html   = '';
        $count_down_html = '';
        $footer_html     = '';

        if ( !empty($logo) ) {
            $logo_html = '<div class="logo-maintenance"><a href="'.esc_url( get_home_url() ).'"><img src="' . esc_url($logo['url']) . '" alt=""></a></div>';
        }
        if ( $title ) {
            $title_html = '<h1 class="title-coming-soon">'.esc_html($title).'</h1>';
        }
        if ( $footer ) {
            $footer_html = '<div class="footer-coming-soon">'.esc_html($footer).'</div>';
        }
        if ( $des ) {
            $des_html = '<p class="des-coming-soon des">'.esc_html($des).'</p>';
        }

        $count_down_html = '<div class="maxstore-countdown cp-countdown cp-pie-charts" data-time="' . esc_attr( $date ) . '">
                                <span class="day"></span>
                                <span class="hour"></span>
                                <span class="minute"></span>
                                <span class="second piechart-number"></span>
                            </div><!-- /.maxstore-countdown-wrap -->';
        $html .= '<div class="page-maintenance" style="background: url('.esc_url($background['url']).')">
                		<div class="container">
                			'.$logo_html.'
                			<div class="content-maintenance">
                				' . $title_html . '
                				' . $des_html . '
                                ' . $count_down_html . '
                			</div>
                			'.$footer_html.'
                		</div>
                	</div>';

        echo balanceTags( $html );
        get_footer( 'soon' );

    }


}
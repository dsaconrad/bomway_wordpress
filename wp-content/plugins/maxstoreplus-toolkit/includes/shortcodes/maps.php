<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'vc_before_init', 'maxstoreplus_maps_settings' );
function maxstoreplus_maps_settings()
{
	$params       = array(
		array(
			"type"        => "textfield",
			"heading"     => __( "Title", "maxstoreplus" ),
			"param_name"  => "title",
			'admin_label' => true,
			"description" => __( "title.", "maxstoreplus" ),
			'std'         => 'Kute themes',
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "Phone", "maxstoreplus" ),
			"param_name"  => "phone",
			'admin_label' => true,
			"description" => __( "phone.", "maxstoreplus" ),
			'std'         => '088-465 9965 02',
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "Email", "maxstoreplus" ),
			"param_name"  => "email",
			'admin_label' => true,
			"description" => __( "email.", "maxstoreplus" ),
			'std'         => 'kutethemes@gmail.com',
		),
		array(
			'type'       => 'dropdown',
			'heading'    => __( 'Maps type', 'maxstoreplus-toolkit' ),
			'param_name' => 'map_type',
			'value'      => array(
				__( 'ROADMAP', 'maxstoreplus-toolkit' )   => 'ROADMAP',
				__( 'SATELLITE', 'maxstoreplus-toolkit' ) => 'SATELLITE',
				__( 'HYBRID', 'maxstoreplus-toolkit' )    => 'HYBRID',
				__( 'TERRAIN', 'maxstoreplus-toolkit' )   => 'TERRAIN',
			),
			'std'        => 'ROADMAP',
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "Address", "maxstoreplus" ),
			"param_name"  => "address",
			'admin_label' => true,
			"description" => __( "address.", "maxstoreplus" ),
			'std'         => 'Z115 TP. Thai Nguyen',
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "Longitude", "maxstoreplus" ),
			"param_name"  => "longitude",
			'admin_label' => true,
			"description" => __( "longitude.", "maxstoreplus" ),
			'std'         => '105.800286',
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "Latitude", "maxstoreplus" ),
			"param_name"  => "latitude",
			'admin_label' => true,
			"description" => __( "latitude.", "maxstoreplus" ),
			'std'         => '21.587001',
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "Zoom", "maxstoreplus" ),
			"param_name"  => "zoom",
			'admin_label' => true,
			"description" => __( "zoom.", "maxstoreplus" ),
			'std'         => '14',
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "Height", "maxstoreplus" ),
			"param_name"  => "height",
			'admin_label' => true,
			"description" => __( "Style Height map.", "maxstoreplus" ),
			'std'         => '436',
		),
		array(
			"type"        => "textfield",
			"heading"     => __( "Extra class name", "maxstoreplus" ),
			"param_name"  => "el_class",
			"description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "maxstoreplus" ),
		),
		array(
			'type'       => 'css_editor',
			'heading'    => esc_html__( 'Css', 'maxstoreplus-toolkit' ),
			'param_name' => 'css',
			'group'      => esc_html__( 'Design options', 'maxstoreplus-toolkit' ),
		),
	);
	$map_settings = array(
		'name'        => esc_html__( 'Maxstore: Maps', 'maxstoreplus-toolkit' ),
		'base'        => 'maxstoreplus_maps', // shortcode
		'class'       => '',
		'category'    => esc_html__( 'Maxstore Plus', 'maxstoreplus-toolkit' ),
		'description' => __( 'Display a google maps.', 'maxstoreplus-toolkit' ),
		'params'      => $params,
	);
	vc_map( $map_settings );
}

function maxstoreplus_maps( $atts )
{
	$atts         = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'maxstoreplus_maps', $atts ) : $atts;
	$default_atts = array(
		'icon_lib'  => '',
		'map_type'  => '',
		'height'    => '436',
		'email'     => '',
		'title'     => '',
		'phone'     => '',
		'address'   => '',
		'longitude' => '',
		'latitude'  => '',
		'zoom'      => '',
		'css'       => '',
		'el_class'  => '',
	);
	extract( shortcode_atts( $default_atts, $atts ) );
	$css_class = $el_class . ' ms-google-maps';
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ):
		$css_class .= ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
	endif;
	ob_start();
	$id = uniqid();
	?>
    <div class="<?php echo esc_attr( $css_class ); ?>"
         id="az-google-maps-<?php echo esc_attr( $id ); ?>"
         style="height: <?php echo esc_attr( $atts['height'] ); ?>px;">
    </div>
    <script type="text/javascript">
        window.addEventListener('load',
            function (ev) {
                var $hue             = '',
                    $saturation      = '',
                    $modify_coloring = false,
                    $ovic_map        = {
                        lat: <?php echo esc_attr( $atts['latitude'] ); ?>,
                        lng: <?php echo esc_attr( $atts['longitude'] ) ?>
                    };
                if ( $modify_coloring === true ) {
                    var $styles = [
                        {
                            stylers: [
                                {hue: $hue},
                                {invert_lightness: false},
                                {saturation: $saturation},
                                {lightness: 1},
                                {
                                    featureType: "landscape.man_made",
                                    stylers: [ {
                                        visibility: "on"
                                    } ]
                                }
                            ]
                        }, {
                            featureType: 'water',
                            elementType: 'geometry',
                            stylers: [
                                {color: '#46bcec'}
                            ]
                        }
                    ];
                }
                var map = new google.maps.Map(document.getElementById("az-google-maps-<?php echo esc_attr( $id ); ?>"), {
                    zoom: <?php echo esc_attr( $atts['zoom'] ) ?>,
                    center: $ovic_map,
                    mapTypeId: google.maps.MapTypeId.<?php echo esc_attr( $atts['map_type'] ) ?>,
                    styles: $styles
                });

                var contentString = '<div style="background-color:#fff; padding: 30px 30px 10px 25px; width:290px;line-height: 22px" class="ovic-map-info">' +
                    '<h4 class="map-title"><?php echo esc_html( $atts['title'] ) ?></h4>' +
                    '<div class="map-field"><i class="fa fa-map-marker"></i><span>&nbsp;<?php echo esc_html( $atts['address'] ) ?></span></div>' +
                    '<div class="map-field"><i class="fa fa-phone"></i><span>&nbsp;<a href="tel:<?php echo esc_html( $atts['phone'] ) ?>"><?php echo esc_html( $atts['phone'] ) ?></a></span></div>' +
                    '<div class="map-field"><i class="fa fa-envelope"></i><span><a href="mailto:<?php echo esc_html( $atts['email'] ) ?>">&nbsp;<?php echo esc_html( $atts['email'] ) ?></a></span></div> ' +
                    '</div>';

                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });

                var marker = new google.maps.Marker({
                    position: $ovic_map,
                    map: map
                });
                marker.addListener('click', function () {
                    infowindow.open(map, marker);
                });
            }, false);
    </script>
	<?php
	return ob_get_clean();
}

add_shortcode( 'maxstoreplus_maps', 'maxstoreplus_maps' );

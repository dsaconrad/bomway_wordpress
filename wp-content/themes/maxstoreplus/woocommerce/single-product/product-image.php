<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.5.1
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $product;

$url_video = get_post_meta( $product->get_id(), '_corporatepro_url_video', true );
$skin      = get_theme_file_uri( 'js/skins/default/' );
?>
<div class="maxstore-product-zoom pr-gallery-vectical product-gallery">
	<?php if ( $url_video != '' ) : ?>
        <div class="video-box">
            <a href="<?php echo esc_url( $url_video ) ?>" class="html5lightbox"
               data-skinsfolder="<?php echo esc_attr( $skin ); ?>">
                <span></span>
                <i class="fa fa-play" aria-hidden="true"></i>
            </a>
        </div>
	<?php endif; ?>
	<?php
	$attachment_ids    = $product->get_gallery_image_ids();
	$post_thumbnail_id = $product->get_image_id();
	$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
	$thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array(
		$gallery_thumbnail['width'],
		$gallery_thumbnail['height']
	) );
	$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
	$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
			'woocommerce-product-gallery',
			'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
			'woocommerce-product-gallery--columns-' . absint( $columns ),
			'images',
		)
	);
	?>
    <div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>"
         style="opacity: 0; transition: opacity .25s ease-in-out;">
        <figure class="dots-custom main-slide thumbnails_carousel owl-carousel" data-items="1">
			<?php
			if ( $product->get_image_id() ) {
				$thumbnail_src = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail_size );
				$full_src      = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
				$alt_text      = trim( wp_strip_all_tags( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) ) );
				$image         = wp_get_attachment_image(
					$post_thumbnail_id,
					'woocommerce_single',
					false,
					array(
						'title'                   => _wp_specialchars( get_post_field( 'post_title', $post_thumbnail_id ), ENT_QUOTES, 'UTF-8', true ),
						'data-caption'            => _wp_specialchars( get_post_field( 'post_excerpt', $post_thumbnail_id ), ENT_QUOTES, 'UTF-8', true ),
						'data-src'                => esc_url( $full_src[0] ),
						'data-large_image'        => esc_url( $full_src[0] ),
						'data-large_image_width'  => esc_attr( $full_src[1] ),
						'data-large_image_height' => esc_attr( $full_src[2] ),
						'class'                   => 'wp-post-image',
					)
				);
				$html          = '<div data-thumb="' . esc_url( $thumbnail_src[0] ) . '" class="woocommerce-product-gallery__image">';
				$html          .= '<a class="html5lightbox" data-skinsfolder="' . esc_attr( $skin ) . '" data-group="mygroup" data-thumbnail="' . esc_url( $thumbnail_src[0] ) . '" href="' . esc_url( $full_src[0] ) . '">';
				$html          .= $image;
				$html          .= '</a></div>';
			} else {
				$html = '<div class="woocommerce-product-gallery__image--placeholder">';
				$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'maxstoreplus' ) );
				$html .= '</div>';
			}
			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );

			if ( $attachment_ids && has_post_thumbnail() ) {
				foreach ( $attachment_ids as $attachment_id ) {
					$thumbnail_src = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
					$full_src      = wp_get_attachment_image_src( $attachment_id, 'full' );
					$alt_text      = trim( wp_strip_all_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
					$image         = wp_get_attachment_image(
						$attachment_id,
						'woocommerce_single',
						false,
						array(
							'title'                   => _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
							'data-caption'            => _wp_specialchars( get_post_field( 'post_excerpt', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
							'data-src'                => esc_url( $full_src[0] ),
							'data-large_image'        => esc_url( $full_src[0] ),
							'data-large_image_width'  => esc_attr( $full_src[1] ),
							'data-large_image_height' => esc_attr( $full_src[2] ),
							'class'                   => '',
						)
					);
					$html          = '<div data-thumb="' . esc_url( $thumbnail_src[0] ) . '" class="woocommerce-product-gallery__image">';
					$html          .= '<a class="html5lightbox" data-skinsfolder="' . esc_attr( $skin ) . '" data-group="mygroup" data-thumbnail="' . esc_url( $thumbnail_src[0] ) . '" href="' . esc_url( $full_src[0] ) . '">';
					$html          .= $image;
					$html          .= '</a></div>';
					echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
				}
			}
			?>
        </figure>
        <div class="owl-dots cp-dots-custom">
			<?php
			if ( $product->get_image_id() ) {
				echo '<div class="owl-dot">' . wp_get_attachment_image( $post_thumbnail_id, 'shop_thumbnail' ) . '</div>';
			}
			if ( $attachment_ids && has_post_thumbnail() ) {
				foreach ( $attachment_ids as $attachment_id ) {
					echo '<div class="owl-dot">' . wp_get_attachment_image( $attachment_id, 'shop_thumbnail' ) . '</div>';
				}
			}
			?>
        </div>
    </div>
</div>
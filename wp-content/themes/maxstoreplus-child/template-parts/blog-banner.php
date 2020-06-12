<?php
$opt_blog_gallery = maxstoreplus_get_option('opt_blog_gallery','');
$banner_class = array('banner-page banner-blog1');
if( $opt_blog_gallery ){
	$banner_class[]='slide-banner';
}else{
	$banner_class[]='bg-parallax';
}
$opt_blog_gallery = explode(',',$opt_blog_gallery);
?>
<div class="<?php echo esc_attr( implode(' ', $banner_class) );?>">
	<?php if( count( $opt_blog_gallery ) > 0 ):?>
		<div class="owl-carousel dot-style4" data-dots="false" data-autoplay="true" data-items="1">
			<?php foreach( $opt_blog_gallery as $key => $value):?>
			<?php
			$image = wp_get_attachment_image_src( $value, 'full', false );
			?>
			<?php if( $image[0] && $image[0] !=''):?>
			<div class="banner-item" data-bg="<?php echo esc_url($image[0]);?>"></div>
			<?php endif;?>
			<?php endforeach;?>
		</div>
	<?php endif;?>	
	<div class="content-banner">
		<div class="container">
			<?php get_template_part('template-parts/part','breadcrumb');?>
		</div>
	</div>
</div>
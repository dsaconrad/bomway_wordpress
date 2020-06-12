<?php
$_corporatepro_page_header_background = corporatepro_get_post_meta(get_the_ID(),'_corporatepro_page_header_background','');
$_corporatepro_page_heading_height    = corporatepro_get_post_meta(get_the_ID(),'_corporatepro_page_heading_height','');
$css = '';

if( $_corporatepro_page_header_background && $_corporatepro_page_header_background!=""){
	$css .='background-image:url("'.$_corporatepro_page_header_background.'");';
}
if( $_corporatepro_page_heading_height && $_corporatepro_page_heading_height!=""){
	$css .='min-height:'.$_corporatepro_page_heading_height.'px;';
}

?>
<!-- Banner page -->
<div class="banner-page banner-blog1" style='<?php echo $css;?>'>
	<div class="content-banner">
		<div class="container">
			<?php get_template_part('template-parts/part','breadcrumb');?>
		</div>
	</div>
</div>
<!-- /Banner page -->
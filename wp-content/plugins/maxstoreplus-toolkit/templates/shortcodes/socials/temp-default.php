<?php
if( isset($atts) ){
	extract ( $atts );
}
?>

<div class="widget widget-connect <?php echo esc_attr( $css_class );?>">
	<?php if( $title != '' ):?>
	<h3 class="title-widget widgettitle"><?php echo esc_html( $title );?></h3>
	<?php endif;?>

	<?php if( $socials && is_array($socials) && count( $socials ) > 0 ):?>
	    <ul class="social-f">
	        <?php foreach ($socials as $social):?>
	        	<li><?php maxstoreplus_social($social);?></li>
	        <?php endforeach;?>
	    </ul>
	<?php endif;?>
</div>
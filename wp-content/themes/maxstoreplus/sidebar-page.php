<?php
$_corporatepro_page_used_sidebar = corporatepro_get_post_meta(get_the_ID(),'_corporatepro_page_used_sidebar','widget-area');
?>
<?php if ( is_active_sidebar( $_corporatepro_page_used_sidebar ) ) : ?>
    <div id="widget-area" class="widget-area">
        <?php dynamic_sidebar( $_corporatepro_page_used_sidebar ); ?>
    </div><!-- .widget-area -->
<?php endif; ?>

<?php maxstoreplus_get_footer();?>
<a href="#" class="backtotop" title="<?php echo esc_attr(esc_html__('Scroll to Top','maxstoreplus'));?>">
    <i class="fa fa-angle-up"></i>
</a>
<?php if ( is_front_page() ): ?>
	<?php get_template_part( 'templates/popup', 'content' ); ?>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
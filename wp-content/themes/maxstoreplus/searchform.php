<form method="get" class="searchform" action="<?php echo esc_url(home_url( '/' )); ?>">
    <p><input type="text" class="search-field" placeholder="<?php esc_html_e( 'Enter your keywords...', 'maxstoreplus' ); ?>" name="s" /></p>
    <button class="button-submit"><?php esc_html_e( 'Search', 'maxstoreplus' ); ?></button>
</form>
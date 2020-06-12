<?php get_header();?>
    <div class="main-container">
        <div class="container">
            <div class="text-center page-404">
                <figure>
                    <img src="<?php echo get_theme_file_uri('images/404.jpg')?>" alt="">
                </figure>
                <h1 class="title"><?php esc_html_e('Error 404 - page not found','maxstoreplus');?></h1>
                <p><?php esc_html_e('The page you request could not be found. Keep calm & return to the previous page!','maxstoreplus');?></p>
                <a class="button" href="<?php echo esc_url( get_home_url() );?>"><?php esc_html_e('Go to Home','maxstoreplus');?></a>
            </div>
        </div>
    </div>
<?php get_footer();?>
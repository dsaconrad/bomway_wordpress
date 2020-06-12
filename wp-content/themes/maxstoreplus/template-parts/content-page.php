<?php
if( have_posts()){
    while( have_posts()){
        the_post();
        ?>
        <div class="page-title">
            <h1><?php the_title();?></h1>
        </div>
        <div class="page-main-content">
            <?php
            the_content();
            wp_link_pages( array(
                'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'maxstoreplus' ) . '</span>',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
                'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'maxstoreplus' ) . ' </span>%',
                'separator'   => '<span class="screen-reader-text">, </span>',
            ) );
            ?>
        </div>
        <?php
    }
}
?>
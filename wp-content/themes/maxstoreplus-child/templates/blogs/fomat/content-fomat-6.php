<div class="blog-item">
    <div class="the-time">
        <span class="day"><?php echo get_the_time('j') ?></span>
        <span class="month"> <?php echo get_the_time('M') ?></span>
    </div>
    <div class="main-content-post">
        <a class="post-title" href="<?php the_permalink() ?>"><?php the_title();?></a>
        <div class="meta-post meta-style1">
            <ul class="meta-post meta-style1">
                <li class="author">
                    <span><?php echo esc_html__('By:', 'maxstoreplus') ?></span>
                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))) ?>">
                        <?php the_author() ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
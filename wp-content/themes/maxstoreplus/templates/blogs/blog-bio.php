<?php $description = get_the_author_meta('description');?>
<?php  if( $description != "" ):?>
<div class="about-me">
    <div class="top-info-author">
        <div class="comment-count">
            <?php comments_number(
                esc_html__('0 Comments', 'maxstoreplus'),
                esc_html__('1 Comments', 'maxstoreplus'),
                esc_html__('% Comments', 'maxstoreplus')
            );
            ?>
        </div>
        <div class="social-author">
            <?php if(get_the_author_meta('facebook')) : ?><a target="_blank" class="facebook" href="http://facebook.com/<?php echo the_author_meta('facebook'); ?>"><i class="fa fa-facebook"></i></a><?php endif; ?>
            <?php if(get_the_author_meta('twitter')) : ?><a target="_blank" class="twitter" href="http://twitter.com/<?php echo the_author_meta('twitter'); ?>"><i class="fa fa-twitter"></i></a><?php endif; ?>
            <?php if(get_the_author_meta('google')) : ?><a target="_blank" class="google-plus" href="http://plus.google.com/<?php echo the_author_meta('google'); ?>?rel=author"><i class="fa fa-google-plus"></i></a><?php endif; ?>
        </div>
    </div>
    <div class="main-info-author">
        <div class="avatar">
            <?php echo get_avatar( get_the_author_meta('email'), '150' ); ?>
        </div>
        <div class="about-text">
            <div class="author-info">
                <h3 class="author-name"><?php the_author(); ?></h3>
                <span class="author-company"><?php echo get_the_author_meta('company')?></span>
            </div>
            <div class="author-desc"><?php the_author_meta('description'); ?></div>
        </div>
    </div>
</div>
<?php endif;?>
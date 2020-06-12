<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package corporatepro
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$fields = array(
	'author' => '<div class="row"><div class="col-xs-12 col-sm-6"><input type="text" name="author" id="name" class="input-form" placeholder="' . esc_html__( 'Your name', 'maxstoreplus' ) . '" /></div></div>',
	'email'  => '<div class="row"><div class="col-xs-12 col-sm-6"><input type="text" name="email" id="email" class="input-form" placeholder="' . esc_html__( 'Your email', 'maxstoreplus' ) . '"/></div></div><!-- /.row -->',
);


$custom_comment_form = array(
	'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
	'comment_field'        => '
    <div class="row">
        <div class="col-md-9 col-xs-12">
            <div class="message-comment">
                <textarea name="comment" id="message" rows="5" class="textarea-form" placeholder="' . esc_html__( 'Your message', 'maxstoreplus' ) . '" ></textarea>
            </div>
        </div>
    </div>',
	'logged_in_as'         => '<p class="logged-in-as">' . sprintf( wp_kses( __( 'Logged in as <a href="%1$s" class="comment-author-url">%2$s</a> <a href="%3$s" class="comment-logout-url">' . esc_html__( 'Log out?', 'maxstoreplus' ) . '</a>', 'maxstoreplus' ), array( 'a' => array( 'href' => array(), 'class' => array() ) ) ), esc_url( admin_url( 'profile.php' ) ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',
	'cancel_reply_link'    => esc_html__( 'Cancel reply', 'maxstoreplus' ),
	'comment_notes_before' => '<h4 class="reply-title">' . esc_html__( 'Leave A Comment', 'maxstoreplus' ) . '</h4>',
	'comment_notes_after'  => '',
	'title_reply'          => '',
	'label_submit'         => esc_html__( 'Add Comment', 'maxstoreplus' ),
);

$cm_area_class = have_comments() ? 'have-comments' : 'no-comment';

?>
<div class="blog-comment">
<div id="comments" class="comments-area <?php echo esc_attr( $cm_area_class ); ?>">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h4 class="comments-title super-title">
            <?php echo esc_html__('Comments','maxstoreplus')?>
		</h4>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'maxstoreplus' ); ?></h2>
				<div class="nav-links">
					<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'maxstoreplus' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'maxstoreplus' ) ); ?></div>
				</div><!-- .nav-links -->
			</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'type'        => 'comment',
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => '90',
					'callback'    => 'maxstoreplus_custom_comment'
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'maxstoreplus' ); ?></h2>
				<div class="nav-links">
					<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'maxstoreplus' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'maxstoreplus' ) ); ?></div>
				</div><!-- .nav-links -->
			</nav><!-- #comment-nav-below -->
		<?php endif; // Check for comment navigation. ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( !comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'maxstoreplus' ); ?></p>
	<?php endif; ?>

</div><!-- #comments -->


<?php comment_form( $custom_comment_form ); ?>
</div>

<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.6.0
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( !comments_open() ) {
	return;
}
$review_count = $product->get_review_count();
?>
<div id="review_form" class="woocommerce-Reviews reviews">
    <div id="comments" class="comments">

		<?php if ( have_comments() ) : ?>
            <h3 class="super-title left">
				<?php echo esc_html__( 'customer reviews', 'maxstoreplus' ) ?>
                <span><?php echo '( ' . $review_count . ' reviews)'; ?></span>
            </h3>

            <ol class="commentlist comment-list">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
            </ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links( apply_filters(
						'woocommerce_comment_pagination_args',
						array(
							'prev_text' => '&larr;',
							'next_text' => '&rarr;',
							'type'      => 'list',
						)
					)
				);
				echo '</nav>';
			endif; ?>

		<?php else : ?>

            <p class="woocommerce-noreviews"><?php _e( 'There are no reviews yet.', 'maxstoreplus' ); ?></p>

		<?php endif; ?>
    </div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

        <div id="review_form_wrapper">
            <div id="review_form">
				<?php
				$commenter = wp_get_current_commenter();

				$comment_form = array(
					'title_reply'         => have_comments() ? __( 'Add a review', 'maxstoreplus' ) : sprintf( __( 'Be the first to review &ldquo;%s&rdquo;', 'maxstoreplus' ), get_the_title() ),
					'title_reply_to'      => __( 'Leave a Reply to %s', 'maxstoreplus' ),
					'comment_notes_after' => '',
					'fields'              => array(
						'author' => '<input placeholder="Your name" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" required /></p>',
						'email'  => '<input placeholder="Your email" id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-required="true" required /></p>',
					),
					'label_submit'        => __( 'Submit', 'maxstoreplus' ),
					'logged_in_as'        => '',
					'comment_field'       => '',
				);

				if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
					$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'maxstoreplus' ), esc_url( $account_page_url ) ) . '</p>';
				}

				$comment_form['comment_field'] = '<p class="comment-form-comment"><textarea placeholder="Your review" id="comment" name="comment" cols="45" rows="8" aria-required="true" required></textarea></p>';

				if ( wc_review_ratings_enabled() ) {
					$comment_form['comment_field'] .= '<p class="comment-form-rating"><label for="rating">' . __( 'Your Rating', 'maxstoreplus' ) . '</label><select name="rating" id="rating" aria-required="true" required>
                                <option value="">' . __( 'Rate&hellip;', 'maxstoreplus' ) . '</option>
                                <option value="5">' . __( 'Perfect', 'maxstoreplus' ) . '</option>
                                <option value="4">' . __( 'Good', 'maxstoreplus' ) . '</option>
                                <option value="3">' . __( 'Average', 'maxstoreplus' ) . '</option>
                                <option value="2">' . __( 'Not that bad', 'maxstoreplus' ) . '</option>
                                <option value="1">' . __( 'Very Poor', 'maxstoreplus' ) . '</option>
                            </select></p>';
				}

				comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
            </div>
        </div>

	<?php else : ?>

        <p class="woocommerce-verification-required"><?php _e( 'Only logged in customers who have purchased this product may leave a review.', 'maxstoreplus' ); ?></p>

	<?php endif; ?>

    <div class="clear"></div>
</div>

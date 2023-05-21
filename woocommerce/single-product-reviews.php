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
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.3.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() ) {
	return;
}

?>
<div class="single-product-review pt-3 pt-md-6 pb-5 pb-md-6 border-top">
	<div id="reviews" class="woocommerce-Reviews container pb-3">

		<?php do_action( 'epicjungle_single_product_reviews_before' ); ?>

		<div class="row">
			<div class="col-md-7">
				<div id="comments">
					<?php
					if ( have_comments() ) :
						wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', [
							'style'        => 'div',
							'format'       => 'html5',
							'avatar_size'  => 50,
							'short_ping'   => false,
							'callback'     => 'woocommerce_comments',
							'end-callback' => function() {
								echo '</div>';
							},


						] ) );

						epicjungle_comments_navigation();
					else :
						?><p class="woocommerce-noreviews alert alert-info"><?php esc_html_e( 'There are no reviews yet.', 'epicjungle' ); ?></p><?php
					endif;
					?>
				</div>
			</div>


			
			<div class="col-md-5 mt-2 pt-4 mt-md-0 pt-md-0">
				<div class="bg-secondary py-5 px-4 rounded-lg">
					<div class="px-xl-3">
						<?php
						if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) :
							$account_page_url = wc_get_page_permalink( 'myaccount' );
							$commenter = wp_get_current_commenter();
							$is_req = (bool) get_option( 'require_name_email', 1 );
							$_cf_args = [];

							$_cf_args['comment_field'] = '';

							if ( wc_review_ratings_enabled() ) {
								$_cf_args['comment_field'] .= sprintf(
									'<div class="form-group comment-form-rating">
										<label for="star-rating" class="p-0">%1$s<span class="text-danger">*</span></label>

										<p class="stars">
											<span class="d-flex font-size-xl">
												<a class="star-1" href="#">1</a>
												<a class="star-2" href="#">2</a>
												<a class="star-3" href="#">3</a>
												<a class="star-4" href="#">4</a>
												<a class="star-5" href="#">5</a>
											</span
										</p>
										
										<select name="rating" id="star-rating" class="custom-select d-none" required>
											<option value="">%2$s</option>
											<option class="star-5" value="5">%3$s</option>
											<option class="star-4" value="4">%4$s</option>
											<option class="star-3" value="3">%5$s</option>
											<option class="star-2" value="2">%6$s</option>
											<option class="star-1" value="1">%7$s</option>
										</select>
									</div>',
									esc_html__( 'Rating', 'epicjungle' ),
									esc_html__( 'Choose rating', 'epicjungle' ),
									esc_html__( 'Perfect', 'epicjungle' ),
									esc_html__( 'Good', 'epicjungle' ),
									esc_html__( 'Average', 'epicjungle' ),
									esc_html__( 'Not that bad', 'epicjungle' ),
									esc_html__( 'Very poor', 'epicjungle' )
								);
							}

							$_cf_args['comment_field'] .= sprintf(
								'<div class="form-group comment-form-comment">
									<label for="comment" class="p-0">%s<span class="text-danger">*</span></label>
									<textarea id="comment" name="comment" class="form-control" rows="8" maxlength="65525" required></textarea>
									<small class="form-text text-muted">'. esc_html__(' Your review must be at least 50 characters.','epicjungle' ) .'</small>
								</div>',
								esc_html__( 'Review', 'epicjungle' )
							);

							// Other arguments
							$_cf_args['logged_in_as']        = '';
							$_cf_args['label_submit']        = esc_html_x( 'Submit a Review', 'front-end', 'epicjungle' );
							$_cf_args['title_reply']         = esc_html_x( 'Write a review', 'front-end', 'epicjungle' );
							$_cf_args['title_reply_to']      = esc_html__( 'Leave a Reply', 'epicjungle' );
							$_cf_args['title_reply_before']  = '<h3 id="reply-title" class="h4 pb-2 comment-reply-title">';
							$_cf_args['title_reply_after']   = '</h3>';
							$_cf_args['submit_button']       = '<button type="submit" name="%1$s" id="%2$s" class="%3$s">%4$s</button>';
							$_cf_args['submit_field']        = '<div class="form-group form-submit mb-0">%1$s%2$s</div>';
							$_cf_args['class_submit']        = 'btn btn-primary btn-shadow btn-block';
							$_cf_args['comment_notes_after'] = '';
							$_cf_args['comment_notes_before'] = sprintf( '<p class="font-size-sm text-muted">%s %s <span class="text-danger">*</span></p>',
								esc_html_x( 'Your email address will not be published.', 'front-end', 'epicjungle' ),
								/* translators: related to comment form; phrase follows by red mark*/
								esc_html_x( 'Required fields are marked', 'front-end', 'epicjungle' )
							);

							if ( $account_page_url ) {
								/* translators: %s opening and closing link tags respectively */
								$_cf_args['must_log_in'] = '<p class="must-log-in font-size-sm text-muted">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'epicjungle' ), '<a href="' . esc_url( $account_page_url ) . '" class="text-primary">', '</a>' ) . '</p>';
							}

							comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $_cf_args ) ); ?>
						<?php else : ?>
							<div class="media">
								<div class="mr-3 font-size-xl text-danger">
									<i class="fe-announcement"></i>
								</div>
								<div class="media-body">
									<p class="woocommerce-verification-required font-size-sm mb-0"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'epicjungle' ); ?></p>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<?php do_action( 'epicjungle_single_product_reviews_after' ); ?>

	</div>
</div>

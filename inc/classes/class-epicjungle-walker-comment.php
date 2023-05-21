<?php
/**
 * Customizing the comment HTML
 *
 * @package EpicJungle
 */
class EpicJungle_Comment_Walker extends Walker_Comment {
	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @since 3.6.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {
		global $post;

		$classes[] = $this->has_children ? 'parent': '';

		if ( $depth > 1 && $depth < 7 ) {
			$classes[] = 'ml-2 ml-md-4';
		}

		?>
		<<?php echo ( 'div' === $args['style'] ) ? 'div' : 'li'; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $classes, $comment ); ?>>
			<div class="comment-inner p-4 border bg-secondary rounded mb-4<?php if ( $depth > 1 ) : ?> pl-2 pl-md-4 border-left" style="border-left-width:3px !important;<?php endif;?>">
				<div class="media align-items-start align-items-md-center mb-2">
					<?php 
						$avatar = get_avatar( $comment, 50, '', '', array( 'class' => 'avatar-img rounded-circle' ) ); 

						if ( $avatar ) : ?>
							<div class="avatar avatar-50 mr-3"><?php echo wp_kses_post( $avatar ); ?></div><?php
						endif;
					?>
					<div class="media-body mt-2 mt-md-0">
						<div class="d-flex justify-content-between align-items-center">
							<span class="h6 mb-0 d-flex align-items-center">
								<?php echo esc_html( get_comment_author( $comment ) ); ?>
								<?php if ( $comment->user_id === $post->post_author ) : ?>
								<span class="badge badge-primary badge-pill ml-2"><?php echo esc_html__( 'Author', 'epicjungle' ); ?></span>
								<?php endif; ?>
							</span>
							<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>" class="small text-black-50 comment-posted-on text-nowrap ml-4">
								<?php echo esc_html( get_comment_date( '', $comment ) ); ?>
							</a>
						</div>
					</div>
				</div>

				<div class="comment-text text-gray-700">
					<?php
					if ( '0' == $comment->comment_approved ) :
						$commenter = wp_get_current_commenter();
						if ( $commenter['comment_author_email'] ) {
							echo esc_html_x( 'Your comment is awaiting moderation.', 'front-end', 'epicjungle' );
						} else {
							echo esc_html_x(
								'Your comment is awaiting moderation. This is a preview, your comment will be visible after it has been approved.',
								'front-end',
								'epicjungle'
							);
						}
					else:
						comment_text();
					endif; ?>
				</div>
					
				<?php 

					echo str_replace( 'comment-reply-link', 'comment-reply-link mr-4', get_comment_reply_link ( array_merge( $args, [
						'add_below' => 'comment-reply-target',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
					] ), $comment ) );
					
					if ( current_user_can( 'edit_comment', $comment->comment_ID ) ) : ?>
						<a class="comment-edit-link" href="<?php echo esc_url( get_edit_comment_link( $comment ) ); ?>"><?php esc_html_e( 'Edit', 'epicjungle' ); ?></a><?php 
					endif; 
				?>
			</div>
			<div id="comment-reply-target-<?php comment_ID(); ?>" class="comment-reply-target"></div>
		<?php
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::end_el()
	 * @see wp_list_comments()
	 *
	 * @param string     $output  Used to append additional content. Passed by reference.
	 * @param WP_Comment $comment The current comment object. Default current comment.
	 * @param int        $depth   Optional. Depth of the current comment. Default 0.
	 * @param array      $args    Optional. An array of arguments. Default empty array.
	 */
	public function end_el( &$output, $comment, $depth = 0, $args = array() ) {
		if ( ! empty( $args['end-callback'] ) ) {
			ob_start();
			call_user_func( $args['end-callback'], $comment, $args, $depth );
			$output .= ob_get_clean();
			return;
		}

		$output .= '</div>'; // close  div.media > div.media-body
	}
}

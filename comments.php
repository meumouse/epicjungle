<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package epicjungle
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}
?>

<section id="comments" class="pb-4 mb-5 comments-area font-size-md" aria-label="<?php esc_attr_e( 'Post Comments', 'epicjungle' ); ?>">
<?php if ( apply_filters('epicjungle_comment_style_enable', false ) ) {
    if ( have_comments() ) :
        ?>
        <h2 class="h3 pb-4 comments-title">
            <?php
                // phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
                printf(
                    /* translators: 1: number of comments, 2: post title */
                    esc_html( _nx( '%1$s Comment', '%1$s Comments', get_comments_number(), 'comments title', 'epicjungle' ) ),
                    number_format_i18n( get_comments_number() )
                );
                // phpcs:enable
            ?>
        </h2>

        <div class="comment-list">
            <?php
                wp_list_comments(
                    array(
                        'style'      => 'div',
                        'short_ping' => true,
                        'callback'   => 'epicjungle_comment',
                    )
                );


            ?>
        </div><!-- .comment-list -->

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through. ?>
        <nav id="comment-nav-below" class="comment-navigation mb-4" role="navigation" aria-label="<?php esc_attr_e( 'Comment Navigation Below', 'epicjungle' ); ?>">
            <span class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'epicjungle' ); ?></span>
            <div class="d-flex justify-content-between">
                <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'epicjungle' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'epicjungle' ) ); ?></div>
            </div>
        </nav><!-- #comment-nav-below -->
            <?php
        endif; // Check for comment navigation.

    endif;

    if ( ! comments_open() && 0 !== intval( get_comments_number() ) && post_type_supports( get_post_type(), 'comments' ) ) :
        ?>
        <p class="no-comments alert alert-warning"><?php esc_html_e( 'Comments are closed.', 'epicjungle' ); ?></p>
        <?php
    endif;

    $args = apply_filters(
        'epicjungle_comment_form_args',
        array(
            'title_reply_before'  => '<span id="reply-title" data-toggle="collapse" data-target="#commentform" class="btn btn-translucent-primary d-block w-100">',
            'title_reply_after'   => '</span>',
            'class_form'          => 'comment-form bg-light rounded-lg box-shadow p-4 p-lg-5 mt-4 collapse',
            'class_submit'        => 'submit btn btn-primary',
            'title_reply'         => esc_html__( 'Join the conversation', 'epicjungle' ),
            'cancel_reply_before' => '<span class="ml-3 font-size-sm">',
            'cancel_reply_after'  => '</span>'
        )
    );

    comment_form( $args );

} else {

    if ( have_comments() ) : ?>
    
        <div class="mb-4">
            <h4 class="font-weight-medium">
                <?php printf(
                    esc_html( _nx( '%1$s Comment', '%1$s Comments ', get_comments_number(), 'comments title', 'epicjungle' ) ),
                    number_format_i18n( get_comments_number() ),
                    get_the_title()
                ); ?>
            </h4>
        </div>

        <div class="list-unstyled comment-list">
            <?php
            wp_list_comments( [
                /* translators: comment reply text */
                'reply_text'  => esc_html__( 'Reply', 'epicjungle' ),
                'format'      => 'html5',
                'avatar_size' => 50,
                'walker'      => new EpicJungle_Comment_Walker(),
                'style'       => 'div',
            ] );
            ?>
        </div><!-- .comment-list -->    

        <?php epicjungle_comments_navigation(); ?>

        <?php if ( ! comments_open() ) : ?>
            <div class="alert alert-warning mt-4 mb-0" role="alert">
                <span class="no-comments"><?php echo esc_html__( 'Comments are closed.', 'epicjungle' ); ?></span>
            </div>
        <?php endif; ?>

    <?php endif;

    comment_form( apply_filters( 'epicjungle_comment_form_args', [
        'title_reply_before'   => '<h4 id="reply-title" class="comment-reply-title mb-3 font-weight-medium">',
        'title_reply_after'    => '</h4>',
        'submit_field'         => '<div class="form-group form-submit d-flex justify-content-center mb-0">%1$s%2$s</div>',
        'submit_button'        => '<button type="submit" name="%1$s" id="%2$s" class="%3$s">%4$s</button>',
        'class_submit'         => 'btn btn-primary btn-wide transition-3d-hover',
        'comment_notes_after'  => '',
        'comment_notes_before' => sprintf( '<p class="font-size-sm text-muted">%s %s <span class="text-danger">*</span></p>',
            esc_html__( 'Your email address will not be published.', 'epicjungle' ),
            /* translators: related to comment form; phrase follows by red mark*/
            esc_html__( 'Required fields are marked','epicjungle' )
        ),
        'comment_field'        => sprintf(
            '<div class="form-group comment-form-comment mb-4">
                <label class="input-label" for="comment">%s</label>
                <textarea id="comment" name="comment" class="form-control" rows="8" maxlength="65525" required></textarea>
            </div>',
            /* translators: label for textarea in comment form */
            esc_html__( 'Comment', 'epicjungle' )
        ),
        'class_container'      => 'comment-respond bg-secondary border p-4 rounded'
    ] ) );
}?>


</section><!-- #comments -->
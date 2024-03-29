<?php
$name = $email = '';

if ( is_user_logged_in() ) {
    $user  = wp_get_current_user();
    $name  = $user->display_name;
    $email = $user->user_email;
}
?>
<!-- Modal markup -->
<div id="wedocs-contact-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="wedocs-contact-modal-form" method="post">
                <div class="modal-header">
                    <h5 class="modal-title"><?php esc_html_e( 'Submit a request', 'epicjungle' ); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div id="wedocs-modal-errors"></div>
                    <div class="wedocs-form-row form-group">
                        <label for="name"><?php esc_html_e( 'Name', 'epicjungle' ); ?></label>
                        <div class="wedocs-form-field">
                            <input class="form-control" type="text" name="name" id="name" placeholder="<?php echo esc_attr__( 'Name', 'epicjungle' ); ?>" value="<?php echo esc_attr( $name ); ?>" required />
                        </div>
                    </div>

                    <div class="wedocs-form-row form-group">
                        <label for="email"><?php esc_html_e( 'Email', 'epicjungle' ); ?></label>
                        <div class="wedocs-form-field">
                            <input class="form-control" type="email" name="email" id="email" placeholder="<?php echo esc_attr__( 'Email', 'epicjungle' ); ?>" value="<?php echo esc_attr( $email ); ?>" <?php disabled( is_user_logged_in() ); ?> required />
                        </div>
                    </div>

                    <div class="wedocs-form-row form-group">
                        <label for="subject"><?php esc_html_e( 'Subject', 'epicjungle' ); ?></label>
                        <div class="wedocs-form-field">
                            <input class="form-control" type="text" name="subject" id="subject" placeholder="<?php echo esc_attr__( 'Subject', 'epicjungle' ); ?>" value="" required />
                        </div>
                    </div>

                    <div class="wedocs-form-row form-group">
                        <label for="message"><?php esc_html_e( 'message', 'epicjungle' ); ?></label>
                        <div class="wedocs-form-field">
                            <textarea class="form-control" name="message" id="message" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Fechar</button>
                    <input type="submit" class="btn btn-primary btn-sm" name="submit" value="<?php echo esc_attr_e( 'Send', 'epicjungle' ); ?>">
                    <input type="hidden" name="doc_id" value="<?php the_ID(); ?>">
                    <input type="hidden" name="action" value="wedocs_contact_feedback">
                </div>
            </form>
        </div>
    </div>
</div>
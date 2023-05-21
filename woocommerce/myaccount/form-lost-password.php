<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;


$epicjungle_forget_password_title = apply_filters( 'epicjungle_forget_password_title',  get_theme_mod('forget_password_title',    'Esqueceu sua senha?' ) );
$epicjungle_forget_password_desc = apply_filters( 'epicjungle_forget_password_desc',  get_theme_mod('forget_password_desc',    'Altere sua senha em três etapas fáceis. Isso ajuda a manter sua nova senha segura.' ) );

?>
<div class="container py-5 py-sm-6 py-md-7">
	<div class="row justify-content-center pt-4">
		<div class="col-lg-7 col-md-9 col-sm-11">
			<?php do_action( 'woocommerce_before_lost_password_form' ); ?>
			
			<?php if ( ! empty ( $epicjungle_forget_password_title ) ): ?>
				<h1 class="h2 pb-3"><?php echo esc_html(  $epicjungle_forget_password_title ); ?></h1>
			<?php endif; ?>

			<?php if ( ! empty ( $epicjungle_forget_password_desc ) ): ?>
				<p class="font-size-sm"><?php echo esc_html(  $epicjungle_forget_password_desc ); ?></p>
			<?php endif; ?>

			<?php if ( apply_filters( 'epicjungle_forget_password_desc', true ) ): ?>
				<ul class="list-unstyled font-size-sm pb-1 mb-4">
	              	<li><span class="text-primary font-weight-semibold mr-1">1.</span><?php echo esc_html__( 'Fill in your email address below.', 'epicjungle'); ?></li>
	              	<li><span class="text-primary font-weight-semibold mr-1">2.</span><?php echo esc_html__( "We'll email you a temporary code.", 'epicjungle' ); ?></li>
	              	<li><span class="text-primary font-weight-semibold mr-1">3.</span><?php echo esc_html__( 'Use the code to change your password on our secure website.','epicjungle'); ?></li>
	            </ul>
	        <?php endif; ?>

			<div class="bg-secondary rounded-lg px-3 py-4 p-sm-4">
				<form method="post" class="woocommerce-ResetPassword lost_reset_password">

					<div class="form-group">
	                  	<label class="form-label" for="user_login"><?php echo esc_html__(' Enter your email address', 'epicjungle');?></label>
						<input class="woocommerce-Input woocommerce-Input--text input-text form-control" type="text" name="user_login" id="user_login" autocomplete="username" />
	                </div>


					<div class="clear"></div>

					<?php do_action( 'woocommerce_lostpassword_form' ); ?>

					<p class="woocommerce-form-row form-row">
						<input type="hidden" name="wc_reset_password" value="true" />
						<button type="submit" class="woocommerce-Button btn btn-primary" value="<?php esc_attr_e( 'Reset password', 'epicjungle' ); ?>"><?php esc_html_e( 'Reset password', 'epicjungle' ); ?></button>
					</p>

					<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

				</form>
			</div>
		</div>
	</div>
</div>
<?php
do_action( 'woocommerce_after_lost_password_form' );

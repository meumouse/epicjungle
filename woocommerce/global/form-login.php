<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     7.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<form class="woocommerce-form woocommerce-form-login login" method="post" <?php echo isset( $hidden ) && $hidden ? 'style="display:none;"' : ''; ?>>

	<?php do_action( 'woocommerce_login_form_start' ); ?>

	<?php echo ! empty( $message ) ? wpautop( wptexturize( $message ) ) : ''; // @codingStandardsIgnoreLine ?>

	 <div class="input-group-overlay form-group">
		<label class="sr-only" for="modal_username"><?php esc_html_e( 'Username or email', 'epicjungle' ); ?><span class="text-danger">*</span></label>

		<div class="input-group-prepend-overlay"><span class="input-group-text"><i class="fe-mail"></i></span></div>
		<input type="text" class="form-control prepended-form-control" name="username" id="modal_username" placeholder="<?php echo esc_html_e( 'Email', 'epicjungle' ); ?>" autocomplete="username" />
	</div>

	<div class="input-group-overlay cs-password-toggle form-group">
		<div class="input-group-prepend-overlay">
			<span class="input-group-text"><i class="fe-lock"></i></span>
		</div>

		<label class="sr-only p-0" for="password"><?php esc_html_e( 'Password', 'epicjungle' ); ?></label>
		<input class="woocommerce-Input woocommerce-Input--text input-text form-control prepended-form-control" type="password" name="password" placeholder="<?php echo esc_html_e( 'Password', 'epicjungle' ); ?>" id="password" autocomplete="current-password" />

		<label class="cs-password-toggle-btn">
			<input class="custom-control-input" type="checkbox"><i class="fe-eye cs-password-toggle-indicator"></i><span class="sr-only"><?php echo esc_html__( 'Show password', 'epicjungle'); ?></span>
		</label>
	</div>

	<?php do_action( 'woocommerce_login_form' ); ?>


	<div class="forget-password-row d-flex justify-content-between align-items-center form-group">
		<div class="custom-control custom-checkbox">
			<input class="woocommerce-form__input woocommerce-form__input-checkbox custom-control-input" name="rememberme" type="checkbox" id="remember-me">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme custom-control-label p-0" for="remember-me">
				<?php echo esc_html__( 'Keep me signed in', 'epicjungle' ); ?>
			</label>
		</div>

		<span class="woocommerce-LostPassword lost_password mt-3 mt-lg-0">
			<a class="nav-link-style font-size-ms" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot password?', 'epicjungle' ); ?></a>
		</span>
	</div>

	<button type="submit" class="woocommerce-button btn btn-primary btn-block woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Sign in', 'epicjungle' ); ?>"><?php esc_html_e( 'Sign in', 'epicjungle' ); ?></button>

	<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
	<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />

	<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes'  ) : ?>
		<p class="register-text font-size-sm pt-3 mb-0"><?php esc_html_e( 'Don&#039;t have an account?', 'epicjungle' ); ?>
		<a id="register-tab" class="font-weight-medium login-register-tab-switcher" href="#" data-view="#modal-signup-view"><?php esc_html_e( 'Sign up', 'epicjungle' ); ?></a></p>
	<?php endif; ?>


	<?php do_action( 'woocommerce_login_form_end' ); ?>

</form>

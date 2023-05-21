<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
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

do_action( 'woocommerce_before_edit_account_form' ); ?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

    <div class="row">
    	<div class="col-sm-6">
            <div class="woocommerce-form-row woocommerce-form-row--first form-group">
				<label for="account_first_name" class="form-label p-0"><?php esc_html_e( 'First name', 'epicjungle' ); ?><sup class="text-danger ml-1">*</sup></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
        	</div>
        </div>

        <div class="col-sm-6">
            <div class="woocommerce-form-row woocommerce-form-row--last form-group">
                <label for="account_last_name" class="form-label p-0"><?php esc_html_e( 'Last Name', 'epicjungle' ); ?><sup class="text-danger ml-1">*</sup></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
            </div>
        </div>
    </div>


	<div class="woocommerce-form-row woocommerce-form-row--wide form-row-wide form-group">
		<label for="account_display_name" class="form-label p-0"><?php esc_html_e( 'Display name', 'epicjungle' ); ?><sup class="text-danger ml-1">*</sup></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" /> <small class="form-text text-muted"><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'epicjungle' ); ?></small>
	</div>

    <div class="woocommerce-form-row woocommerce-form-row--wide form-row-wide form-group">
		<label for="account_email" class="form-label p-0"><?php esc_html_e( 'Email address', 'epicjungle' );?><sup class="text-danger ml-1">*</sup></label>
		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text form-control" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
	</div>

	<div class="woocommerce-form-row woocommerce-form-row--wide form-row-wide form-group">
		<label for="password_current" class="form-label p-0">
			<?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'epicjungle' ); ?>
		</label>
		<div class="cs-password-toggle w-100">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control" name="password_current" id="password_current" autocomplete="off" />
			<label class="cs-password-toggle-btn">
				<input class="custom-control-input" type="checkbox">
				<i class="fe-eye cs-password-toggle-indicator"></i>
				<span class="sr-only"><?php echo esc_html_x( 'Show password', 'front-end', 'epicjungle' ); ?></span>
			</label>
		</div>


	</div>

	<div class="woocommerce-form-row woocommerce-form-row--wide form-row-wide form-group">
		<label for="password_1" class="form-label p-0"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'epicjungle' ); ?></label>
		<div class="cs-password-toggle w-100">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control" name="password_1" id="password_1" autocomplete="off" />
			<label class="cs-password-toggle-btn">
				<input class="custom-control-input" type="checkbox">
				<i class="fe-eye cs-password-toggle-indicator"></i>
				<span class="sr-only"><?php echo esc_html_x( 'Show password', 'front-end', 'epicjungle' ); ?></span>
			</label>
		</div>	
	</div>

	<div class="woocommerce-form-row woocommerce-form-row--wide form-row-wide form-group">
		<label for="password_2" class="form-label p-0"><?php esc_html_e( 'Confirm new password', 'epicjungle' ); ?></label>
		<div class="cs-password-toggle w-100">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control" name="password_2" id="password_2" autocomplete="off" />
			<label class="cs-password-toggle-btn">
				<input class="custom-control-input" type="checkbox">
				<i class="fe-eye cs-password-toggle-indicator"></i>
				<span class="sr-only"><?php echo esc_html_x( 'Show password', 'front-end', 'epicjungle' ); ?></span>
			</label>
		</div>
	</div>


		<?php do_action( 'woocommerce_edit_account_form' ); ?>

		<div class="button-group pt-2">
			<hr class="mb-4">
			<div class="d-flex flex-wrap justify-content-end align-items-center">
				<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
				<button type="submit" class="woocommerce-Button btn btn-primary mt-3 mt-sm-0" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'epicjungle' ); ?>"><i class="fe-save font-size-lg mr-2"></i><?php esc_html_e( 'Save changes', 'epicjungle' ); ?></button>
				<input type="hidden" name="action" value="save_account_details" />
			</div>
		</div>
			

		<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
	        
	 </div>



</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>

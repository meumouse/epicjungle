<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

$header_variant = epicjungle_navbar_variant();
?>
<div class="container bg-overlay-content pb-4 mb-md-3">
	<div class="row">
		<div class="col-lg-4 mb-4 mb-lg-0">
			<div class="bg-light rounded-lg box-shadow-lg">
				<div class="px-4 py-4 mb-1 text-center">
					<div class="user-avatar">
                        <?php echo do_shortcode( '[epicjungle_avatar]' ); ?>
                    </div>
					<h6 class="mb-0 pt-1"><?php echo esc_html( $current_user->display_name ); ?></h6>
					<span class="text-muted font-size-sm"><?php echo esc_html( $current_user->user_email ); ?></span>
				</div>

				<div class="d-lg-none px-4 pb-4 text-center">
					<a class="btn btn-primary px-5 mb-2" href="#account-menu" data-toggle="collapse"><i class="fe-menu mr-2"></i><?php echo esc_html__( 'Account menu', 'epicjungle');?></a>
				</div>
				
				<?php do_action( 'woocommerce_account_navigation' ); ?>
			
			</div>
		</div>

		<div class="col-lg-8">
			<div class="d-flex flex-column h-100 bg-light rounded-lg box-shadow-lg p-3">
				<div class="py-2 p-md-3">
					<div class="d-sm-flex align-items-center justify-content-between pb-2">
	                  	<h1 class="h3 mb-3 text-center text-sm-left"><?php epicjungle_wc_account_title(); ?></h1>
	                  	
	                </div>

					<div class="woocommerce-MyAccount-content w-100">
						<?php
						/**
						 * My Account content.
						 *
						 * @since 2.6.0
						 */
						do_action( 'woocommerce_account_content' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

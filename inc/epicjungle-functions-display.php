<?php

/* 
Displays the photo and the upload controls altogether
It is used for views such as on side bar, dashboard and and my account edit page
*/
function wc_cus_cpp_form( $atts, $content = NULL ) {
	
	global $wpp_location;
	global $wpp_left_col_avatar_size;
	global $wpp_right_col_avatar_size;
	
	$url_edit_account = wc_customer_edit_account_url();
	
	// 1=sidebar, 2=account, 3=avatar on left column, upload on settings page, 4=dashboard
	if( $wpp_location == 2 ): // sidebar
		//$css = custom_css_account();
		$avatar_size = $wpp_right_col_avatar_size;
		$photo_size  = 'full';
	endif;

	$user_id = get_current_user_id();
	$picture_id = get_user_meta( $user_id, 'profile_pic', true );    
	if( trim( $picture_id ) == '' ) :
		$avatar = get_avatar_url( $user_id, array( 'size' => $avatar_size ) );
		$delete_link = '';
	else:
		$avatar = wp_get_attachment_image_src( $picture_id, $photo_size );
		$avatar = $avatar[0];
		$delete_link = '<a class="btn btn-translucent-danger fs-ms" href="'.$url_edit_account.'?action=delete">
	                        <i class="fe-trash"></i> Remover avatar
		                </a>';
	endif;

	$display = '<div class="cust-upload-avatar-wrapper">
			'.cust_get_avatar_widget_image_html( $avatar ).'
			'.cust_get_avatar_widget_actions_html( $delete_link ).'
				</div>';
	echo $display;
}

//
function cust_get_avatar_widget_image_html( $user_id = '', $width = '', $height = '' ) {
    $avatar_url = cust_get_avatar_url( $user_id, $width, $height );
    $display = '
		<div class="cust-avatar-image">
			<img src="'.$avatar_url.'" width="'.$width.'" height="'.$height.'" />
		</div>      
    ';
    return $display;
}


function cust_get_avatar_image_tag( $user_id = '', $width = '', $height = '' ) {
	$avatar_url = cust_get_avatar_url( $user_id, $width, $height );
    $display = '
		<img src="'.$avatar_url.'" width="'.$width.'" height="'.$height.'" />   
    ';
    return $display;
}

/* this function returns the avatar url. It will resize the image only with get_avatar_url (when user has no profile pic). */
function cust_get_avatar_url( $user_id = '', $width = '', $height = '' ) {

	if( $user_id =! '' or $user_id === 0 ) :
		$user_id = get_current_user_id();
	endif;
	
	$picture_id = get_user_meta( $user_id, 'profile_pic', true );   
	 
	if( trim( $picture_id ) == '' ) :
	
		if( $width =! '' or !empty( $width ) ) :
			$size = array( 'size' => $width );
		else:
			$size = array();
		endif;
		$avatar_url = get_avatar_url( $user_id, $size );
	else:
	
		if( $width =! '' or !empty( $width ) ) :
			$size = array( $width, $height );
		else:
			$size = array();
		endif;
		
		$avatar = wp_get_attachment_image_src( $picture_id, $size );
		$avatar_url = $avatar[0];
	endif;
    return $avatar_url;
}

function cust_get_avatar_widget_actions_html( $delete_link ) {
	
	global $wpp_location;
    $edit_account = wc_customer_edit_account_url();
	$span_button_avatar = esc_html__( 'Enviar', 'epicjungle-extensions' );
	$label_input_avatar = esc_html__( 'Escolher arquivo', 'epicjungle-extensions' );
    
	// 1=sidebar, 2=account, 3=avatar on left column, upload on settings page, 4=dashboard, 5=no avatar display, just controls on settings page
	// options used at functions-display.php - cust_get_avatar_widget_actions_html(), settings-submenu-page.php, core.php - set_avatar_hooks()
	if( $wpp_location == 2 ): // 2=account
		$_action = wc_customer_edit_account_url();

	endif;
	
	if( isset( $_SESSION['upload_msg'] ) ):
		$upload_msg = $_SESSION['upload_msg'];
	else:
		$upload_msg = '';
	endif;

    $display = '
		<div class="cust-avatar-actions">
			<div class="cust-submission-result">
				'.$upload_msg.'
			</div>
			<div class="cust-avatar-upload ml-3">
				<form enctype="multipart/form-data" action="'.$_action.'" method="POST">
					<div class="input-group">
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="upload-file-avatar" name="profile_pic">
							<label class="custom-file-label" for="upload-file-avatar">'.$label_input_avatar.'</label>
						</div>
						<div class="input-group-append">
							<button class="btn btn-primary send-file-avatar" type="submit" id="inputSendAvatar" disabled>
								<span id="span-send-avatar" class="text-buy-now">'.$span_button_avatar.'</span>
								<span id="preloader-send-avatar" class="spinner-border spinner-border-md d-none"></span>
							</button>
						</div>
					</div>
				</form>
				<span class="font-size-ms text-muted py-3 d-block">Envie uma imagem JPG, JPEG, GIF, PNG ou Webp. Tamanho máximo de 5MB.</span>
			</div>
			<div class="cust-avatar-delete">
				'.$delete_link.'
			</div>
		</div>   
    ';
    return $display;
}
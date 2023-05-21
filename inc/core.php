<?php

error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

add_filter( 'get_avatar' , 'wc_cus_change_avatar' , 1 , 5 );
function wc_cus_change_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    $user = false;
	
    if ( is_numeric( $id_or_email ) ) :
        $id = (int)$id_or_email;
        $user = get_user_by( 'id' , $id );
        
    elseif ( is_object( $id_or_email ) ) :
        if ( ! empty( $id_or_email->user_id ) ) :
            $id = (int)$id_or_email->user_id;
            
            $user = get_user_by( 'id' , $id );
        endif;
    else :
        $user = get_user_by( 'email', $id_or_email );    
    endif;
	
    if ( $user && is_object( $user ) ) :
		$picture_id = get_user_meta($user->data->ID,'profile_pic');
		if(! empty($picture_id)):
		  $avatar = wp_get_attachment_image_src( $picture_id[0] ); 
		  $avatar = $avatar[0];
			  $avatar = '<img loading="lazy" alt="'.$alt.'" src="'.$avatar.'" class="avatar avatar-'.$size.' photo" height="'.$size.'" width="'.$size.'">';
		endif;
    endif;
	
    return $avatar;
	
}

add_action( 'init', 'upload_woo_avatar' );
function upload_woo_avatar() {
    
    $user_id = get_current_user_id();
    
    if( isset( $_GET['action'] ) and $_GET['action'] == 'delete' ):
        $picture_id = get_user_meta( $user_id, 'profile_pic', true );
        delete_user_meta( $user_id, 'profile_pic' );
        //wp_delete_attachment( $picture_id, true ); // either one will work
        wp_delete_post( $picture_id, true );
    endif;

    if( isset( $_FILES['profile_pic'] ) and $_FILES['profile_pic'] and trim( $_FILES['profile_pic']['name'] ) != '' ):
        $picture_id = wc_cus_upload_picture($_FILES['profile_pic']);
		if( is_int( $picture_id ) ) :
			$_SESSION['upload_mgs'] = '';
        	update_user_meta( $user_id, 'profile_pic', $picture_id );
		else:
			$_SESSION['upload_msg'] = $picture_id;
		endif;
    endif;
	
}


add_action( 'init', 'epicjungle_set_avatar_hook' );
function epicjungle_set_avatar_hook() {
	global $wpp_location;

	// 1=sidebar, 2=account, 3=avatar on left column, upload on settings page, 4=dashboard, 5=no avatar display, just controls on settings page
	// options used at functions-display.php - cust_get_avatar_widget_actions_html(), settings-submenu-page.php, core.php - set_avatar_hooks()
	if( $wpp_location == 1 or $wpp_location == 2 or $wpp_location == 4 ): // 
		
		if( $wpp_location == 2 ): // account page
			$wpp_action = 'woocommerce_before_edit_account_form'; // to show only on account settings section
		endif;
	
		$wpp_function = 'wc_cus_cpp_form'; // to display on top of left hand side menu
		
		if( !empty( $wpp_action ) ):
			add_action( $wpp_action, $wpp_function, 1 ); // to show only on account settings section
		endif;
	
	elseif( $wpp_location == 3 ): // avatar on left column, upload on settings page
	
		$wpp_action = 'woocommerce_before_account_navigation'; // to display on top of left hand side menu
		$wpp_function = 'wc_cus_cpp_form_split_1'; // to display on top of left hand side menu
		
		add_action( $wpp_action, $wpp_function ); // to show only on account settings section
	
		$wpp_action = 'woocommerce_before_edit_account_form'; // to show only on account settings section
		$wpp_function = 'wc_cus_cpp_form_split_2'; // to display on top of left hand side menu
		
		add_action( $wpp_action, $wpp_function, 1 ); // to show only on account settings section
	
	elseif( $wpp_location == 5 ): // no avatar display, just controls on settings page
	
		$wpp_action = 'woocommerce_before_edit_account_form'; // to show only on account settings section
		$wpp_function = 'wc_cus_cpp_form_split_2'; // to display on top of left hand side menu
		
		add_action( $wpp_action, $wpp_function, 1 ); // to show only on account settings section
		
	endif;
}
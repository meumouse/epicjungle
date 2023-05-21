<?php

class EpicJungle_Avatar {
	
	public $submission_error;
	public $some_counter = 0;
	public $pp_user_id   = '';
	public $pp_width     = '';
	public $pp_height    = '';
	public $logged_in_only = false;

    public function __construct(){	
        add_shortcode('epicjungle_avatar', array($this, 'shortcode'));
    }

	public function shortcode( $atts, $content ) {	
		$display = '';
	if( isset( $atts['user_id'] ) ):
		$this->pp_user_id = $atts['user_id'];
	endif;
		
	if( isset( $atts['width'] ) ):
		$this->pp_width = $atts['width'];
	endif;
		
	if( isset( $atts['height'] ) ):
		$this->pp_height = $atts['height'];
	endif;
	$display .= $this->shortcode_content();
	
return $display;
	}
	
	function shortcode_content(){
		$display = '';
		$display .= $this->construct_body();
		return $display;	
	}	
	
	function construct_header(){	
		return $this->display_header();
	}
	
	function display_header(){
		$display = '';
		return $display;
	}
	
	function construct_body(){
		echo cust_get_avatar_image_tag( $this->pp_user_id, $this->pp_width, $this->pp_height );	
	}	
	
	function display_body(){
		$display = '';
		return $display;
	}
	
	function construct_footer(){
		return $this->display_footer();
	}
	
	/* this will display posts row by row */
	function get_rows_display( $_items = array(), $columns = 3 ){
		$display = '';
		if( $_items ) :
			$display .= '<div class="cust-block">';
			$ctr = 0;
			foreach( $_items as $_item ) :
			
				$offset = $ctr % $columns;
				
				if( $offset == 0 ):
					$display .= '<div class="cust-block">';
				endif;
				
				if( $offset < $columns ):
					$display .= '<div class="cust-block-1-'.$columns.'">'.$this->get_row_item_display( $_item ).'</div>';
				endif;
				
				if( $offset == $columns - 1 ):
					$display .= '</div>';
				endif;
			
				//echo $ctr.'%'.$columns.': '.( $ctr % $columns ).'<br />';
				
				$ctr++;
			
			endforeach;
				
			$display .= '</div>';
		endif;
		return $display;
	}
	
	function get_row_item_display( $_item ){
		$display = '';	
		$thumb_id  = $this->get_post_thumb_id_by_post_id( $_item->ID );
		$thumb_url = $this->get_attachment_image_src( $thumb_id, 'thumbnail' ); // thumbnail, medium, large, full
		$display .= '
			<div class="cust-block">
				<div class="cust-block">
					<img src="'.$thumb_url.'" />
				</div>
				<div class="cust-block">
					'.$_item->post_title.'
				</div>
				<div class="cust-block">
					'.$_item->post_content.'
				</div>
			</div>	
		';
		return $display;
	}
	
	function display_footer(){
		$display = '';
		return $display;
	}
	
	// returns post thumb id from library, otherwise "0"
	function get_post_thumb_id_by_post_id( $post_id ){
		$thumb_id = get_post_thumbnail_id( $post_id );
		return $thumb_id;
	}

	/* this returns the image url by size */
	function get_attachment_image_src( $thumb_id, $size = 'thumbnail' ){
		
		$thumb_array = wp_get_attachment_image_src( $thumb_id, $size );
		$thumb_src = $thumb_array[0];
		return $thumb_src;
	}

	/* this returns the image url for full size */
	function get_post_attachment_url_full_size( $thumb_id ){
		
		$thumb_url = wp_get_attachment_url( $thumb_id );
		
		return $thumb_url;
	}	
}
 
$EpicJungle_Avatar = new EpicJungle_Avatar();
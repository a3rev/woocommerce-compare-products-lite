<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */

namespace A3Rev\WCCompare\FrameWork\Settings\Product_Page {

use A3Rev\WCCompare\FrameWork;

// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;

class Compare_Button
{

	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'woo_compare_product_page_button_style';

	/**
	 * @var array
	 */
	public $form_fields = array();

	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		$this->init_form_fields();
	}

	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {

  		// Define settings
     	$this->form_fields = apply_filters( $this->form_key . '_settings_fields', array(

			array(
            	'name' => __( 'Compare Button / Hyperlink Style', 'woocommerce-compare-products' ),
                'type' => 'heading',
                'class'		=> 'produc_page_compare_button_activate_container',
                'id'	=> 'product_page_compare_button_type_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Compare Type', 'woocommerce-compare-products' ),
				'id' 		=> 'product_compare_button_type',
				'class' 	=> 'product_compare_button_type',
				'type' 		=> 'switcher_checkbox',
				'default'	=> 'button',
				'checked_value'		=> 'button',
				'unchecked_value'	=> 'link',
				'checked_label'		=> __( 'Button', 'woocommerce-compare-products' ),
				'unchecked_label' 	=> __( 'Hyperlink', 'woocommerce-compare-products' ),
			),
			array(  
				'name' 		=> __( 'Added to Compare Icon', 'woocommerce-compare-products' ),
				'desc_tip'	=> __( 'Upload a 16px x 16px image, support .jpg, .pgn, .jpeg, .gif formats.', 'woocommerce-compare-products' ),
				'id' 		=> 'woo_compare_product_success_icon',
				'type' 		=> 'upload',
				'separate_option'	=> true,
				'default'	=> WOOCP_IMAGES_URL.'/compare_success.png',
			),
			
			array(
            	'name' 		=> '',
                'type' 		=> 'heading',
          		'class'		=> 'product_page_compare_hyperlink_styling_container',
          		'id'		=> 'product_page_compare_hyperlink_box',
           	),
			array(  
				'name' => __( 'Hyperlink Text', 'woocommerce-compare-products' ),
				'id' 		=> 'product_compare_link_text',
				'type' 		=> 'text',
				'default'	=> __('Compare This*', 'woocommerce-compare-products' )
			),
			array(  
				'name' 		=> __( 'Hyperlink Font', 'woocommerce-compare-products' ),
				'id' 		=> 'product_compare_link_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'line_height' => '1.4em', 'face' => 'Arial, sans-serif', 'style' => 'bold', 'color' => '#000000' )
			),
			
			array(  
				'name' 		=> __( 'Hyperlink Hover Colour', 'woocommerce-compare-products' ),
				'id' 		=> 'product_compare_link_font_hover_colour',
				'type' 		=> 'color',
				'default'	=> '#999999'
			),
			
			array(
            	'name' 		=> '',
                'type' 		=> 'heading',
          		'class' 	=> 'product_page_compare_button_styling_container',
          		'id'		=> 'product_page_compare_button_box',
           	),
			array(  
				'name' 		=> __( 'Button Text', 'woocommerce-compare-products' ),
				'id' 		=> 'product_compare_button_text',
				'type' 		=> 'text',
				'default'	=> __('Compare This*', 'woocommerce-compare-products' )
			),
			array(  
				'name' 		=> __( 'Button Font', 'woocommerce-compare-products' ),
				'id' 		=> 'product_compare_button_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'line_height' => '1.4em', 'face' => 'Arial, sans-serif', 'style' => 'bold', 'color' => '#FFFFFF' )
			),
			array(  
				'name' 		=> __( 'Button Padding', 'woocommerce-compare-products' ),
				'desc' 		=> __( 'Padding from Button text to Button border', 'woocommerce-compare-products' ),
				'id' 		=> 'product_compare_button_padding',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array(  'id' 		=> 'product_compare_button_padding_tb',
	 										'name' 		=> __( 'Top/Bottom', 'woocommerce-compare-products' ),
	 										'class' 	=> '',
	 										'css'		=> 'width:40px;',
	 										'default'	=> '7' ),
	 
	 								array(  'id' 		=> 'product_compare_button_padding_lr',
	 										'name' 		=> __( 'Left/Right', 'woocommerce-compare-products' ),
	 										'class' 	=> '',
	 										'css'		=> 'width:40px;',
	 										'default'	=> '8' ),
	 							)
			),
			array(  
				'name' 		=> __( 'Background Colour', 'woocommerce-compare-products' ),
				'id' 		=> 'product_compare_button_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#476381'
			),
			array(  
				'name' 		=> __( 'Colour Gradient From', 'woocommerce-compare-products' ),
				'id' 		=> 'product_compare_button_bg_colour_from',
				'type' 		=> 'color',
				'default'	=> '#538bbc'
			),
			
			array(  
				'name' 		=> __( 'Colour Gradient To', 'woocommerce-compare-products' ),
				'id' 		=> 'product_compare_button_bg_colour_to',
				'type' 		=> 'color',
				'default'	=> '#476381'
			),
			array(  
				'name' 		=> __( 'Button Border', 'woocommerce-compare-products' ),
				'id' 		=> 'product_compare_button_border',
				'type' 		=> 'border',
				'default'	=> array( 'width' => '1px', 'style' => 'solid', 'color' => '#476381', 'corner' => 'rounded' , 'top_left_corner' => 3 , 'top_right_corner' => 3 , 'bottom_left_corner' => 3 , 'bottom_right_corner' => 3 ),
			),
			array(  
				'name' => __( 'Button Shadow', 'woocommerce-compare-products' ),
				'id' 		=> 'product_compare_button_shadow',
				'type' 		=> 'box_shadow',
				'default'	=> array( 'enable' => 0, 'h_shadow' => '5px' , 'v_shadow' => '5px', 'blur' => '2px' , 'spread' => '2px', 'color' => '#999999', 'inset' => '' )
			),
			
        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {

	if ( $("input.product_compare_button_type:checked").val() == 'button') {
		$(".product_page_compare_hyperlink_styling_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
	} else {
		$(".product_page_compare_button_styling_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
	}

	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.product_compare_button_type', function( event, value, status ) {
		$('.product_page_compare_button_styling_container').attr('style','display:none;');
		$('.product_page_compare_hyperlink_styling_container').attr('style','display:none;');
		if ( status == 'true') {
			$(".product_page_compare_button_styling_container").slideDown();
		} else {
			$(".product_page_compare_hyperlink_styling_container").slideDown();
		}
	});
});
})(jQuery);
</script>
    <?php	
	}
}

}

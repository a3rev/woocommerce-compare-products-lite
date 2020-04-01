<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */

namespace A3Rev\WCCompare\FrameWork\Settings\Comparison_Page {

use A3Rev\WCCompare\FrameWork;

// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;

class Page_Style
{

	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'woo_compare_page_style';

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
            	'name' 		=> __( 'Comparison Page Header', 'woocommerce-compare-products' ),
                'type' 		=> 'heading',
                'id'		=> 'comparison_page_header_box',
                'is_box'	=> true,
           	),

           	array(  
				'name' 		=> __( 'Header Image', 'woocommerce-compare-products' ),
				'desc_tip'	=> __( 'Upload an image with formats .jpg, .pgn, .jpeg. Any size.', 'woocommerce-compare-products' ),
				'id' 		=> 'woo_compare_logo',
				'type' 		=> 'upload',
				'separate_option'	=> true,
			),
			array(  
				'name' 		=> __( 'Background Colour', 'woocommerce-compare-products' ),
				'id' 		=> 'header_bg_colour',
				'type' 		=> 'bg_color',
				'default'	=> array( 'enable' => 1, 'color' => '#FFFFFF' )
			),
			array(  
				'name' 		=> __( 'Bottom Border', 'woocommerce-compare-products' ),
				'id' 		=> 'header_bottom_border',
				'type' 		=> 'border_styles',
				'default'	=> array( 'width' => '3px', 'style' => 'solid', 'color' => '#666666' ),
			),
			
			array(
            	'name' 		=> __( 'Comparison Page Body', 'woocommerce-compare-products' ),
                'type' 		=> 'heading',
                'id'		=> 'comparison_page_body_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Background Colour', 'woocommerce-compare-products' ),
				'id' 		=> 'body_bg_colour',
				'type' 		=> 'bg_color',
				'default'	=> array( 'enable' => 1, 'color' => '#FFFFFF' )
			),
			array(  
				'name' 		=> __( 'Comparison Empty Window Message Text', 'woocommerce-compare-products' ),
				'desc' 		=> __( "Default <code>'[default_value]'</code>", 'woocommerce-compare-products' ),
				'id' 		=> 'no_product_message_text',
				'type' 		=> 'text',
				'default'	=> __('You do not have any product to compare.', 'woocommerce-compare-products' )
			),
			array(  
				'name' 		=> __( 'Message Font', 'woocommerce-compare-products' ),
				'id' 		=> 'no_product_message_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'line_height' => '1.4em', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#000000' )
			),
			array(  
				'name' 		=> __( "Text Alignment", 'woocommerce-compare-products' ),
				'id' 		=> 'no_product_message_align',
				'css' 		=> 'width:80px;',
				'type' 		=> 'select',
				'default'	=> 'center',
				'options'	=> array(
						'left'			=> __( 'Left', 'woocommerce-compare-products' ) ,	
						'center'		=> __( 'Center', 'woocommerce-compare-products' ) ,	
						'right'			=> __( 'Right', 'woocommerce-compare-products' ) ,
					),
			),
        ));
	}
	
}

}

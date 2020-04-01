<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */

namespace A3Rev\WCCompare\FrameWork\Settings\Product_Page {

use A3Rev\WCCompare\FrameWork;

// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;

class Compare_Tab
{

	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'woo_compare_product_page_tab';

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
            	'name' 		=> __( "Product Page Compare Tab", 'woocommerce-compare-products' ),
                'type' 		=> 'heading',
                'id'		=> 'product_page_compare_tab_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( "Compare Features Tab", 'woocommerce-compare-products' ),
				'class'		=> 'disable_compare_featured_tab',
				'id' 		=> 'disable_compare_featured_tab',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 0,
				'checked_value'		=> 0,
				'unchecked_value' 	=> 1,
				'checked_label'		=> __( 'ON', 'woocommerce-compare-products' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-compare-products' ),
			),
			
			array(
            	'name' 		=> __( "Compare Tab Position", 'woocommerce-compare-products' ),
				'class'		=> 'produc_page_compare_tab_activate_container',
                'type' 		=> 'heading',
                'id'		=> 'product_page_compare_tab_position_box',
           	),
			array(  
				'name' 		=> __( 'Compare Features Tab', 'woocommerce-compare-products' ),
				'desc_tip'	=> __( 'Select the position of the Compare Features tab on the default WooCommerce product page Nav bar. Products Compare feature list shows under the tab.', 'woocommerce-compare-products' ),
				'id' 		=> 'auto_compare_featured_tab',
				'type' 		=> 'onoff_radio',
				'default'	=> 29,
				'onoff_options' => array(
					array(
						'val' 				=> 9,
						'text' 				=> __( 'Before Description tab', 'woocommerce-compare-products' ),
						'checked_label'		=> __( 'ON', 'woocommerce-compare-products' ) ,
						'unchecked_label' 	=> __( 'OFF', 'woocommerce-compare-products' ) ,
					),
					array(
						'val' 				=> 19,
						'text' 				=> __( 'Between  Description and Additional tabs', 'woocommerce-compare-products' ),
						'checked_label'		=> __( 'ON', 'woocommerce-compare-products' ) ,
						'unchecked_label' 	=> __( 'OFF', 'woocommerce-compare-products' ) ,
					),
					array(
						'val' 				=> 29,
						'text' 				=> __( 'Between  Additional and Reviews tabs', 'woocommerce-compare-products' ),
						'checked_label'		=> __( 'ON', 'woocommerce-compare-products' ) ,
						'unchecked_label' 	=> __( 'OFF', 'woocommerce-compare-products' ) ,
					),
					array(
						'val' 				=> 31,
						'text' 				=> __( 'After Reviews tab', 'woocommerce-compare-products' ),
						'checked_label'		=> __( 'ON', 'woocommerce-compare-products' ) ,
						'unchecked_label' 	=> __( 'OFF', 'woocommerce-compare-products' ) ,
					),
				),
			),
			array(  
				'name' 		=> __( 'Compare Tab Name', 'woocommerce-compare-products' ),
				'id' 		=> 'compare_featured_tab',
				'type' 		=> 'text',
				'default'	=> __('Technical Details', 'woocommerce-compare-products' )
			),

        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
	
	$(document).ready(function() {
		
		if ( $("input.disable_compare_featured_tab:checked").val() != '0') {
			$(".produc_page_compare_tab_activate_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
		}
		
		$(document).on( "a3rev-ui-onoff_checkbox-switch", '.disable_compare_featured_tab', function( event, value, status ) {
			$(".produc_page_compare_tab_activate_container").attr('style','display:none;');
			if ( status == 'true' ) {
				$(".produc_page_compare_tab_activate_container").slideDown();
			}
		});
		
	});
	
})(jQuery);
</script>
    <?php	
	}
	
}

}

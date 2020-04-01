<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */

namespace A3Rev\WCCompare\FrameWork\Settings {

use A3Rev\WCCompare\FrameWork;

// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------
WC Compare Product Page Global Settings

TABLE OF CONTENTS

- var parent_tab
- var subtab_data
- var option_name
- var form_key
- var position
- var form_fields
- var form_messages

- __construct()
- subtab_init()
- set_default_settings()
- get_settings()
- subtab_data()
- add_subtab()
- settings_form()
- init_form_fields()

-----------------------------------------------------------------------------------*/

class Product_Page extends FrameWork\Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'product-page';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'woo_compare_product_page_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'woo_compare_product_page_settings';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 1;
	
	/**
	 * @var array
	 */
	public $form_fields = array();
	
	/**
	 * @var array
	 */
	public $form_messages = array();
		
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		
		add_action( 'plugins_loaded', array( $this, 'init_form_fields' ), 1 );
		$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'Product Page Settings successfully saved.', 'woocommerce-compare-products' ),
				'error_message'		=> __( 'Error: Product Page Settings can not save.', 'woocommerce-compare-products' ),
				'reset_message'		=> __( 'Product Page Settings successfully reseted.', 'woocommerce-compare-products' ),
			);
			
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );

		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* subtab_init() */
	/* Sub Tab Init */
	/*-----------------------------------------------------------------------------------*/
	public function subtab_init() {
		
		add_filter( $this->plugin_name . '-' . $this->parent_tab . '_settings_subtabs_array', array( $this, 'add_subtab' ), $this->position );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* set_default_settings()
	/* Set default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function set_default_settings() {		
		$GLOBALS[$this->plugin_prefix.'admin_interface']->reset_settings( $this->form_fields, $this->option_name, false );
	}

	/*-----------------------------------------------------------------------------------*/
	/* get_settings()
	/* Get settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function get_settings() {		
		$GLOBALS[$this->plugin_prefix.'admin_interface']->get_settings( $this->form_fields, $this->option_name );
	}
	
	/**
	 * subtab_data()
	 * Get SubTab Data
	 * =============================================
	 * array ( 
	 *		'name'				=> 'my_subtab_name'				: (required) Enter your subtab name that you want to set for this subtab
	 *		'label'				=> 'My SubTab Name'				: (required) Enter the subtab label
	 * 		'callback_function'	=> 'my_callback_function'		: (required) The callback function is called to show content of this subtab
	 * )
	 *
	 */
	public function subtab_data() {
		
		$subtab_data = array( 
			'name'				=> 'product-page-settings',
			'label'				=> __( 'Product Page Settings', 'woocommerce-compare-products' ),
			'callback_function'	=> 'wc_compare_product_page_global_settings_form',
		);
		
		if ( $this->subtab_data ) return $this->subtab_data;
		return $this->subtab_data = $subtab_data;
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* add_subtab() */
	/* Add Subtab to Admin Init
	/*-----------------------------------------------------------------------------------*/
	public function add_subtab( $subtabs_array ) {
	
		if ( ! is_array( $subtabs_array ) ) $subtabs_array = array();
		$subtabs_array[] = $this->subtab_data();
		
		return $subtabs_array;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* settings_form() */
	/* Call the form from Admin Interface
	/*-----------------------------------------------------------------------------------*/
	public function settings_form() {		
		$output = '';
		$output .= $GLOBALS[$this->plugin_prefix.'admin_interface']->admin_forms( $this->form_fields, $this->form_key, $this->option_name, $this->form_messages );
		
		return $output;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {
		
  		// Define settings
     	$this->form_fields = array(
			array(
            	'name' 		=> __( "Add to Compare from Product Page", 'woocommerce-compare-products' ),
                'type' 		=> 'heading',
                'id'		=> 'show_compare_product_pages_box',
                'is_box'	=> true,
           	),
			array(
				'name' 		=> __( "Compare Feature", 'woocommerce-compare-products' ),
				'class'		=> 'disable_product_page_compare',
				'id' 		=> 'disable_product_page_compare',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 0,
				'checked_value'		=> 0,
				'unchecked_value' 	=> 1,
				'checked_label'		=> __( 'ON', 'woocommerce-compare-products' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-compare-products' ),
			),

        );

		global $wc_compare_product_page_compare_button_settings;
		$wc_compare_product_page_compare_button_settings = new Product_Page\Compare_Button();
		$this->form_fields = array_merge( $this->form_fields, $wc_compare_product_page_compare_button_settings->form_fields );

		$this->form_fields =  array_merge( $this->form_fields, array(
			array(
            	'name' 		=> __( "Button / Hyperlink Position", 'woocommerce-compare-products' ),
            	'id'		=> 'produc_page_activate_box',
				'class'		=> 'produc_page_compare_button_activate_container',
                'type' 		=> 'heading',
                'is_box'	=> true,
           	),
			array(
				'name' 		=> __( 'Button/ Hyperlink Position', 'woocommerce-compare-products' ),
				'desc'		=> __( 'Position relative to Add to Cart button location', 'woocommerce-compare-products' ),
				'id' 		=> 'product_page_button_position',
				'type' 		=> 'switcher_checkbox',
				'default'	=> 'above',
				'checked_value'		=> 'above',
				'unchecked_value'	=> 'below',
				'checked_label' 	=> __( 'Above', 'woocommerce-compare-products' ),
				'unchecked_label'	=> __( 'Below', 'woocommerce-compare-products' ),
			),
			array(  
				'name' 		=> __( 'Button Margin', 'woocommerce-compare-products' ),
				'id' 		=> 'product_page_button_margin',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array( 
											'id' 		=> 'product_page_button_margin_top',
	 										'name' 		=> __( 'Top', 'woocommerce-compare-products' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 10 ),
	 
	 								array(  'id' 		=> 'product_page_button_margin_bottom',
	 										'name' 		=> __( 'Bottom', 'woocommerce-compare-products' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 10 ),
											
									array( 
											'id' 		=> 'product_page_button_margin_left',
	 										'name' 		=> __( 'Left', 'woocommerce-compare-products' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
											
									array( 
											'id' 		=> 'product_page_button_margin_right',
	 										'name' 		=> __( 'Right', 'woocommerce-compare-products' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
	 							)
			),
			array(  
				'name' 		=> __( "Custom Position", 'woocommerce-compare-products' ),
				'desc'		=> __( "ON to deactivate default button position settings created by the plugin.", 'woocommerce-compare-products' ).'<br />'.__('Then use this function to manually postion the Compare button on product pages', 'woocommerce-compare-products' )."<br /><code>&lt;?php if ( function_exists('woo_add_compare_button' ) ) echo woo_add_compare_button(); ?&gt;</code>",
				'id' 		=> 'auto_add',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'yes',
				'checked_value'		=> 'no',
				'unchecked_value' 	=> 'yes',
				'checked_label'		=> __( 'ON', 'woocommerce-compare-products' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-compare-products' ),
			),
		));

		global $wc_compare_product_page_view_compare_button_settings;
		$wc_compare_product_page_view_compare_button_settings = new Product_Page\View_Compare_Button();
		$this->form_fields = array_merge( $this->form_fields, $wc_compare_product_page_view_compare_button_settings->form_fields );

		global $wc_compare_product_page_compare_tab_settings;
		$wc_compare_product_page_compare_tab_settings = new Product_Page\Compare_Tab();
		$this->form_fields = array_merge( $this->form_fields, $wc_compare_product_page_compare_tab_settings->form_fields );

		$this->form_fields = apply_filters( $this->form_key . '_settings_fields', $this->form_fields );
	}
	
	public function include_script() {
		global $wc_compare_product_page_compare_button_settings;
		global $wc_compare_product_page_view_compare_button_settings;
		global $wc_compare_product_page_compare_tab_settings;
	?>
<script>
(function($) {
	
	$(document).ready(function() {
		
		if ( $("input.disable_product_page_compare:checked").val() != '0') {
			$(".produc_page_compare_button_activate_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
		}
		
		$(document).on( "a3rev-ui-onoff_checkbox-switch", '.disable_product_page_compare', function( event, value, status ) {
			$('.produc_page_compare_button_activate_container').attr('style','display:none;');
			if ( status == 'true' ) {
				$(".produc_page_compare_button_activate_container").slideDown();
			}
		});
		
	});
	
})(jQuery);
</script>
    <?php
    	$wc_compare_product_page_compare_button_settings->include_script();
    	$wc_compare_product_page_view_compare_button_settings->include_script();
    	$wc_compare_product_page_compare_tab_settings->include_script();
	}
	
}

}

// global code
namespace {

/** 
 * wc_compare_product_page_global_settings_form()
 * Define the callback function to show subtab content
 */
function wc_compare_product_page_global_settings_form() {
	global $wc_compare_product_page_global_settings;
	$wc_compare_product_page_global_settings->settings_form();
}

}

<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */

namespace A3Rev\WCCompare\FrameWork\Settings {

use A3Rev\WCCompare\FrameWork;

// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------
WC Comparison Page Global Settings

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

class Comparison_Page extends FrameWork\Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'comparison-page';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'woo_compare_comparison_page_global_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'woo_compare_comparison_page_global_settings';
	
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
				'success_message'	=> __( 'Comparison Page Settings successfully saved.', 'woocommerce-compare-products' ),
				'error_message'		=> __( 'Error: Comparison Page Settings can not save.', 'woocommerce-compare-products' ),
				'reset_message'		=> __( 'Comparison Page Settings successfully reseted.', 'woocommerce-compare-products' ),
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
			'name'				=> 'general-settings',
			'label'				=> __( 'General Settings', 'woocommerce-compare-products' ),
			'callback_function'	=> 'wc_compare_comparison_page_global_settings_form',
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
            	'name' 		=> __( "Comparison Page Setup", 'woocommerce-compare-products' ),
                'type' 		=> 'heading',
                'id'		=> 'comparison_page_configuration_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Open Compare Table in', 'woocommerce-compare-products' ),
				'id' 		=> 'open_compare_type',
				'type' 		=> 'onoff_radio',
				'default'	=> 'new_page',
				'onoff_options' => array(
					array(
						'val' 				=> 'window',
						'text' 				=> __( 'Pop-up Window', 'woocommerce-compare-products' ),
						'checked_label'		=> __( 'ON', 'woocommerce-compare-products' ) ,
						'unchecked_label' 	=> __( 'OFF', 'woocommerce-compare-products' ) ,
					),
					array(
						'val' 				=> 'new_page',
						'text' 				=> __( 'New Tab', 'woocommerce-compare-products' ) . '. '.__("(Use this if concerned about browser pop-up blockers).", 'woocommerce-compare-products' ),
						'checked_label'		=> __( 'ON', 'woocommerce-compare-products' ) ,
						'unchecked_label' 	=> __( 'OFF', 'woocommerce-compare-products' ) ,
					),
				),
			),
			
			array(
            	'name' 		=> __( "Comparison Page Shortcode", 'woocommerce-compare-products' ),
				'desc'		=> __( "A 'Product Comparison' page with the shortcode [product_comparison_page] inserted should have been auto created on install. If not you need to manually create a new page and add the shortcode. Then set that page below so the plugin knows where to find it.", 'woocommerce-compare-products' ),
                'type' 		=> 'heading',
                'id'		=> 'comparison_page_shortcode_box',
           	),
			array(  
				'name' 		=> __( 'Product Comparison Page', 'woocommerce-compare-products' ),
				'desc' 		=> __( 'Page contents', 'woocommerce-compare-products' ).': [product_comparison_page]',
				'id' 		=> 'product_compare_id',
				'type' 		=> 'single_select_page',
				'default'	=> '',
				'separate_option'	=> true,
				'placeholder'		=> __( 'Select Page', 'woocommerce-compare-products' ),
				'css'		=> 'width:300px;',
			),

        );

		$wc_compare_comparison_page_style_settings = new Comparison_Page\Page_Style();
		$this->form_fields = array_merge( $this->form_fields, $wc_compare_comparison_page_style_settings->form_fields );

		$this->form_fields = array_merge( $this->form_fields, array(
			array(
            	'name' 		=> __( "DYNAMIC STYLE SUPER POWERS", 'woocommerce-compare-products' ),
                'type' 		=> 'heading',
                'desc'		=> '<img class="rwd_image_maps" src="'.WOOCP_IMAGES_URL.'/wc_comparison_page_premium.png" usemap="#comparisonpageMap" style="width: auto; max-width: 100%;" border="0" />
<map name="comparisonpageMap" id="comparisonpageMap">
	<area shape="rect" coords="18,320,345,365" href="'.$this->pro_plugin_page_url.'" target="_blank" />
</map>',
				'alway_open'=> true,
                'id'		=> 'comparison_page_premium_box',
                'is_box'	=> true,
           	)
		));

		$this->form_fields = apply_filters( $this->form_key . '_settings_fields', $this->form_fields );
	}

	public function include_script() {
		wp_enqueue_script( 'jquery-rwd-image-maps' );
	}

}

}

// global code
namespace {

/** 
 * wc_compare_comparison_page_global_settings_form()
 * Define the callback function to show subtab content
 */
function wc_compare_comparison_page_global_settings_form() {
	global $wc_compare_comparison_page_global_settings;
	$wc_compare_comparison_page_global_settings->settings_form();
}

}

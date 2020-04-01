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

class Global_Panel extends FrameWork\Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'global-settings';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = '';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'woo_compare_global_settings';
	
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
				'success_message'	=> __( 'Global Settings successfully saved.', 'woocommerce-compare-products' ),
				'error_message'		=> __( 'Error: Global Settings can not save.', 'woocommerce-compare-products' ),
				'reset_message'		=> __( 'Global Settings successfully reseted.', 'woocommerce-compare-products' ),
			);
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'after_save_settings' ) );
		
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
	/* after_save_settings()
	/* Process when clean on deletion option is un selected */
	/*-----------------------------------------------------------------------------------*/
	public function after_save_settings() {
		if ( ( isset( $_POST['bt_save_settings'] ) || isset( $_POST['bt_reset_settings'] ) ) && get_option( $this->plugin_name . '_clean_on_deletion' ) == 0  )  {
			$uninstallable_plugins = (array) get_option('uninstall_plugins');
			unset($uninstallable_plugins[ $this->plugin_path ]);
			update_option('uninstall_plugins', $uninstallable_plugins);
		}
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
			'callback_function'	=> 'wc_compare_global_settings_form',
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
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
			array(
            	'name' 		=> __( 'Plugin Framework Global Settings', 'woocommerce-compare-products' ),
            	'id'		=> 'plugin_framework_global_box',
                'type' 		=> 'heading',
                'first_open'=> true,
                'is_box'	=> true,
           	),
           	array(
           		'name'		=> __( 'Customize Admin Setting Box Display', 'woocommerce-compare-products' ),
           		'desc'		=> __( 'By default each admin panel will open with all Setting Boxes in the CLOSED position.', 'woocommerce-compare-products' ),
                'type' 		=> 'heading',
           	),
           	array(
				'type' 		=> 'onoff_toggle_box',
			),
           	array(
           		'name'		=> __( 'Google Fonts', 'woocommerce-compare-products' ),
           		'desc'		=> __( 'By Default Google Fonts are pulled from a static JSON file in this plugin. This file is updated but does not have the latest font releases from Google.', 'woocommerce-compare-products' ),
                'type' 		=> 'heading',
           	),
           	array(
                'type' 		=> 'google_api_key',
           	),
           	array(
            	'name' 		=> __( 'House Keeping', 'woocommerce-compare-products' ),
                'type' 		=> 'heading',
            ),
			array(
				'name' 		=> __( 'Clean up on Deletion', 'woocommerce-compare-products' ),
				'desc' 		=> __( 'On deletion (not deactivate) the plugin will completely remove all tables and data it created, leaving no trace it was ever here.', 'woocommerce-compare-products' ),
				'id' 		=> $this->plugin_name . '_clean_on_deletion',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 1,
				'separate_option'	=> true,
				'free_version'		=> true,
				'checked_value'		=> 1,
				'unchecked_value'	=> 0,
				'checked_label'		=> __( 'ON', 'woocommerce-compare-products' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-compare-products' ),
			),

			array(
            	'name' 		=> __( 'Getting Started', 'woocommerce-compare-products' ),
            	'id'		=> 'compare_getting_started_box',
                'type' 		=> 'heading',
                'is_box'	=> true,
           	),
           	array(
           		'name'		=> __( 'Quick Start', 'woocommerce-compare-products' ),
           		'desc'		=> __( 'Here is a 9 step guide for a fast start', 'woocommerce-compare-products' ) .
'<ul style="padding-left: 20px;">
	<li>1. ' . __( "Go to WC Compare > Settings & Style menu and checked that Compare Feature is switched ON for Product Page and Product Card. Note the compare button / Hyperlink will not show on any product until the feature is activated on that product.", 'woocommerce-compare-products' ) . '</li>
	<li>2. ' . __( "Go to your widgets menu and add the Woo Compare Widget to the widget areas where you want it to show.", 'woocommerce-compare-products' ) . '</li>
	<li>3. ' . __( "Go to the WC Compare > Category and Feature menu.", 'woocommerce-compare-products' ) . '</li>
	<li>4. ' . __( "Edit the Features that you see in the Un-Assigned Features Box. If there is nothing in that box then either add some Product Attributes or click the [ Add New ] button that is to the right of the Categories & Features title at the top of the page.", 'woocommerce-compare-products' ) . '</li>
	<li>5. ' . __( "Once you have assigned at least 1 Compare Feature to a Compare category it is then available for adding the compare feature to products.", 'woocommerce-compare-products' ) . '</li>
	<li>6. ' . __( "Go to your products menu and select a product and edit it.", 'woocommerce-compare-products' ) . '</li>
	<li>7. ' . __( "Go the 'Compare Feature Fields' and Activate the compare Feature. If it is a Variable Product you also activate and set the compare feature for each variation.", 'woocommerce-compare-products' ) . '</li>
	<li>8. ' . __( "Update the product and view it in a browser - Congratulations you have just created your first product with the compare feature.", 'woocommerce-compare-products' ) . '</li>
	<li>9. ' . __( "Go to the Settings & Style Menu and use the dynamic settings boxes and their options to edit the way compare shows on the front end.", 'woocommerce-compare-products' ) . '</li>
</ul>',
                'type' 		=> 'heading',
           	),
           	array(
           		'name'		=> __( 'How Comparison Works', 'woocommerce-compare-products' ),
           		'desc'		=> __( 'Comparison Data Sets', 'woocommerce-compare-products' ) .
'<ul style="padding-left: 20px;">
	<li>* ' . __( "To create meaningful features and specification data that can be compared on products by customers, that data must be created.", 'woocommerce-compare-products' ) . '</li>
	<li>* ' . __( "That specific data once created is then assigned to specific products so users can view a table of data that applies to that product and thus creates a meaningful comparison of features and specs.", 'woocommerce-compare-products' ) . '</li>
	<li>* ' . __( "A data set comprises a Compare Category with Compare features and that features data.", 'woocommerce-compare-products' ) . '</li>
</ul>',
                'type' 		=> 'heading',
           	),
           	array(
           		'name'		=> __( 'Creating Comparison Data Sets', 'woocommerce-compare-products' ),
           		'desc'		=> __( 'On first install of WooCommerce Compare Products Free version', 'woocommerce-compare-products' ) .
'<ul style="padding-left: 20px;">
	<li>1. ' . __( "All existing Product > Categories are created as Compare Categories.", 'woocommerce-compare-products' ) . '</li>
	<li>2. ' . __( "All existing Product > Attributes are created as Compare Features.", 'woocommerce-compare-products' ) . '</li>
	<li>3. ' . __( "All existing Product > Attributes > Terms are created as the Compare Features Input Data.", 'woocommerce-compare-products' ) . '</li>
	<li>4. ' . __( "Go to the WC Compare > Category & Feature Menu to view those.", 'woocommerce-compare-products' ) . '</li>
</ul>',
                'type' 		=> 'heading',
           	),
           	array(
           		'name'		=> __( 'Things to know', 'woocommerce-compare-products' ),
           		'desc'		=> __( 'Once installed WooCommerce Compare Products will', 'woocommerce-compare-products' ) .
'<ul style="padding-left: 20px;">
	<li>1. ' . __( "Each time a new Product Category is created it is auto created as a Compare Category.", 'woocommerce-compare-products' ) . '</li>
	<li>2. ' . __( "Each time a new Product Attribute is created it is auto created as a Compare Feature.", 'woocommerce-compare-products' ) . '</li>
	<li>3. ' . __( "Compare Categories and Compare Features can be created on the WC Category & Feature menu independent of your Product Categories and Product Attributes.", 'woocommerce-compare-products' ) . '</li>
	<li>4. ' . __( "Compare Categories and Compare Features created on the WC Category & Feature menu are NOT created as Product Categories or Product Attributes.", 'woocommerce-compare-products' ) . '</li>
	<li>5. ' . __( "Deleting a Product Category, Product Attribute DOES NOT delete the corresponding Compare Category / Compare Feature and vice versa.", 'woocommerce-compare-products' ) . '</li>
	<li>6. ' . __( "When a Product > Attribute is created, Terms are created for it after the Attribute is created. The Attribute is auto created as a Un-Assigned Compare Feature - BUT any terms created are NOT auto created as the Compare Feature input data. That must be done by editing the Compare Attribute on the WC Category and Feature Menu.", 'woocommerce-compare-products' ) . '</li>
	<li>7. ' . __( "Compare Products Premium works differently in that the compare feature is fully intergrated into Product Categories, Attributes and their Terms and does not have the 2 as separate data like the Free version has.", 'woocommerce-compare-products' ) . '</li>
	<li>8. ' . __( "When upgrading to the Premium version no data created on the Free version is lost.", 'woocommerce-compare-products' ) . '</li>
</ul>',
                'type' 		=> 'heading',
           	),

        ));
	}
}

}

// global code
namespace {

/** 
 * wc_compare_product_page_global_settings_form()
 * Define the callback function to show subtab content
 */
function wc_compare_global_settings_form() {
	global $wc_compare_global_settings;
	$wc_compare_global_settings->settings_form();
}

}

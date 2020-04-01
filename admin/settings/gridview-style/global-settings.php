<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */

namespace A3Rev\WCCompare\FrameWork\Settings {

use A3Rev\WCCompare\FrameWork;

// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------
WC Compare Grid View Global Settings

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

class Grid_View extends FrameWork\Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'product-cards';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'woo_compare_grid_view_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'woo_compare_grid_view_settings';
	
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
				'success_message'	=> __( 'Product Card Settings successfully saved.', 'woocommerce-compare-products' ),
				'error_message'		=> __( 'Error: Product Card Settings can not save.', 'woocommerce-compare-products' ),
				'reset_message'		=> __( 'Product Card Settings successfully reseted.', 'woocommerce-compare-products' ),
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
			'name'				=> 'product-card-settings',
			'label'				=> __( 'Product Card Settings', 'woocommerce-compare-products' ),
			'callback_function'	=> 'wc_compare_grid_view_global_settings_form',
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
            	'name' 		=> __( "Add to Compare from Product Cards", 'woocommerce-compare-products' ),
                'type' 		=> 'heading',
                'id'		=> 'product_cards_compare_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( "Compare Feature", 'woocommerce-compare-products' ),
				'class'		=> 'disable_grid_view_compare',
				'id' 		=> 'disable_grid_view_compare',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 0,
				'checked_value'		=> 0,
				'unchecked_value' 	=> 1,
				'checked_label'		=> __( 'ON', 'woocommerce-compare-products' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-compare-products' ),
			),
			
			array(
            	'name' 		=> __( "Position on Product Cards", 'woocommerce-compare-products' ),
				'desc'		=> __('Position applies to all product cards on the Shop, Product Category and Product Tag pages.', 'woocommerce-compare-products' ),
				'class'		=> 'grid_view_compare_activate_container',
                'type' 		=> 'heading',
                'id'		=> 'product_cards_compare_button_position_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Vertical Position', 'woocommerce-compare-products' ),
				'desc'		=> __( 'Position relative to Add to Cart Button. Tip: Change position if Compare Button/Link does not show.', 'woocommerce-compare-products' ),
				'id' 		=> 'grid_view_button_position',
				'type' 		=> 'switcher_checkbox',
				'default'	=> 'above',
				'checked_value'		=> 'above',
				'unchecked_value'	=> 'below',
				'checked_label' 	=> __( 'Above', 'woocommerce-compare-products' ),
				'unchecked_label'	=> __( 'Below', 'woocommerce-compare-products' ),
			),
			array(  
				'name' 		=> __( 'Button Margin', 'woocommerce-compare-products' ),
				'id' 		=> 'grid_view_button_margin',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array( 
											'id' 		=> 'grid_view_button_margin_top',
	 										'name' 		=> __( 'Top', 'woocommerce-compare-products' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 10 ),
	 
	 								array(  'id' 		=> 'grid_view_button_margin_bottom',
	 										'name' 		=> __( 'Bottom', 'woocommerce-compare-products' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 10 ),
											
									array( 
											'id' 		=> 'grid_view_button_margin_left',
	 										'name' 		=> __( 'Left', 'woocommerce-compare-products' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
											
									array( 
											'id' 		=> 'grid_view_button_margin_right',
	 										'name' 		=> __( 'Right', 'woocommerce-compare-products' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
	 							)
			),

			array(
            	'name' 		=> __( "DYNAMIC STYLE SUPER POWERS", 'woocommerce-compare-products' ),
                'type' 		=> 'heading',
                'desc'		=> '<img class="rwd_image_maps" src="'.WOOCP_IMAGES_URL.'/wc_product_cards_premium.png" usemap="#productCardsMap" style="width: auto; max-width: 100%;" border="0" />
<map name="productCardsMap" id="productCardsMap">
	<area shape="rect" coords="555,60,935,104" href="'.$this->pro_plugin_page_url.'" target="_blank" />
</map>',
				'alway_open'=> true,
                'id'		=> 'product_cards_premium_box',
                'is_box'	=> true,
           	),

        );

		$this->form_fields = apply_filters( $this->form_key . '_settings_fields', $this->form_fields );
	}
	
	public function include_script() {
		wp_enqueue_script( 'jquery-rwd-image-maps' );
	?>
<script>
(function($) {
	
	$(document).ready(function() {
		
		if ( $("input.disable_grid_view_compare:checked").val() != '0') {
			$(".grid_view_compare_activate_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
		}
		
		$(document).on( "a3rev-ui-onoff_checkbox-switch", '.disable_grid_view_compare', function( event, value, status ) {
			$(".grid_view_compare_activate_container").attr('style','display:none;');
			if ( status == 'true' ) {
				$(".grid_view_compare_activate_container").slideDown();
			}
		});
	});
	
})(jQuery);
</script>
    <?php
	}
	
}

}

// global code
namespace {

/** 
 * wc_compare_grid_view_global_settings_form()
 * Define the callback function to show subtab content
 */
function wc_compare_grid_view_global_settings_form() {
	global $wc_compare_grid_view_global_settings;
	$wc_compare_grid_view_global_settings->settings_form();
}

}

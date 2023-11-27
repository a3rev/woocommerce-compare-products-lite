<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */

use A3Rev\WCCompare;

/**
 * Install Database, settings option and auto add widget to sidebar
 */
function woocp_install() {

	// Upgrade database for site have used Lite is less than 2.2.0
	if ( get_option( 'a3rev_woocp_lite_version', false ) != false
			&& version_compare(get_option('a3rev_woocp_lite_version'), '2.1.9.3') === -1 ) {

		include( WOOCP_DIR. '/includes/updates/compare-update-2.1.9.3.php' );
	}

	update_option('a3rev_woocp_pro_version', '2.4.6');
	update_option('a3rev_woocp_lite_version', WOOCP_VERSION );
	$product_compare_id = WCCompare\Functions::create_page( esc_sql( 'product-comparison' ), '', __('Product Comparison', 'woocommerce-compare-products' ), '[product_comparison_page]' );
	update_option('product_compare_id', $product_compare_id);

	WCCompare\Data::install_database();
	WCCompare\Data\Categories::install_database();
	WCCompare\Data\Categories_Fields::install_database();

	delete_metadata( 'user', 0, $GLOBALS[WOOCP_PREFIX.'admin_init']->plugin_name . '-' . 'plugin_framework_global_box' . '-' . 'opened', '', true );


	update_option('a3rev_woocp_just_installed', true);
}

if ( is_admin() ) {

	global $wc_admin_compare_features;
	$wc_admin_compare_features = new WCCompare\Features_Backend();

	// Editor
	include_once ( WOOCP_DIR. '/tinymce3/tinymce.php' );

}

function woocp_init() {
	if ( get_option( 'a3rev_woocp_just_installed' ) ) {
		delete_option( 'a3rev_woocp_just_installed' );

		// Set Settings Default from Admin Init
		$GLOBALS[WOOCP_PREFIX.'admin_init']->set_default_settings();

		// Build sass
		$GLOBALS[WOOCP_PREFIX.'less']->plugin_build_sass();

		update_option( 'a3rev_woocp_install_default_data_start', true );
	}

	if ( get_option( 'a3rev_woocp_install_default_data_start' ) ) {
		delete_option( 'a3rev_woocp_install_default_data_start' );
		new WCCompare\Install();
	}

	woocp_plugin_textdomain();
}

// Add language
add_action('init', 'woocp_init');

// Add custom style to dashboard
add_action( 'admin_enqueue_scripts', array( '\A3Rev\WCCompare\Hook_Filter', 'a3_wp_admin' ) );

// Add admin sidebar menu css
add_action( 'admin_enqueue_scripts', array( '\A3Rev\WCCompare\Hook_Filter', 'admin_sidebar_menu_css' ) );

// Plugin loaded
add_action( 'plugins_loaded', array( '\A3Rev\WCCompare\Functions', 'plugins_loaded' ), 8 );

// Add text on right of Visit the plugin on Plugin manager page
add_filter( 'plugin_row_meta', array('\A3Rev\WCCompare\Hook_Filter', 'plugin_extra_links'), 10, 2 );

/**
 * Create WOO Compare Widget
 */
add_action( 'widgets_init', function() { register_widget( '\A3Rev\WCCompare\Widget' ); } );

// Need to call Admin Init to show Admin UI
$GLOBALS[WOOCP_PREFIX.'admin_init']->init();

// Set nocache constants to comparision page
add_action('init', array( '\A3Rev\WCCompare\Hook_Filter', 'nocache_ours_page' ), 0 );

$current_db_version = get_option( 'woocommerce_db_version', null );

// Add upgrade notice to Dashboard pages
add_filter( $GLOBALS[WOOCP_PREFIX.'admin_init']->plugin_name . '_plugin_extension_boxes', array( '\A3Rev\WCCompare\Hook_Filter', 'plugin_extension_box') );

// Add extra link on left of Deactivate link on Plugin manager page
add_action('plugin_action_links_' . WOOCP_NAME, array( '\A3Rev\WCCompare\Hook_Filter', 'settings_plugin_links' ) );

// Replace the template file from plugin
add_filter('template_include', array('\A3Rev\WCCompare\Hook_Filter', 'template_loader') );

// Add Admin Menu
add_action('admin_menu', array( '\A3Rev\WCCompare\Hook_Filter', 'register_admin_screen' ), 9 );

// AJAX add to cart for variable products
add_action('wp_ajax_woocp_variable_add_to_cart', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_variable_ajax_add_to_cart') );
add_action('wp_ajax_nopriv_woocp_variable_add_to_cart', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_variable_ajax_add_to_cart') );

// AJAX add to compare
add_action('wp_ajax_woocp_add_to_compare', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_add_to_compare') );
add_action('wp_ajax_nopriv_woocp_add_to_compare', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_add_to_compare') );

// AJAX remove product from compare popup
add_action('wp_ajax_woocp_remove_from_popup_compare', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_remove_from_popup_compare') );
add_action('wp_ajax_nopriv_woocp_remove_from_popup_compare', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_remove_from_popup_compare') );

// AJAX update compare popup
add_action('wp_ajax_woocp_update_compare_popup', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_update_compare_popup') );
add_action('wp_ajax_nopriv_woocp_update_compare_popup', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_update_compare_popup') );

// AJAX update compare widget
add_action('wp_ajax_woocp_update_compare_widget', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_update_compare_widget') );
add_action('wp_ajax_nopriv_woocp_update_compare_widget', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_update_compare_widget') );

// AJAX update total compare
add_action('wp_ajax_woocp_update_total_compare', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_update_total_compare') );
add_action('wp_ajax_nopriv_woocp_update_total_compare', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_update_total_compare') );

// AJAX remove product from compare widget
add_action('wp_ajax_woocp_remove_from_compare', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_remove_from_compare') );
add_action('wp_ajax_nopriv_woocp_remove_from_compare', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_remove_from_compare') );

// AJAX clear compare widget
add_action('wp_ajax_woocp_clear_compare', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_clear_compare') );
add_action('wp_ajax_nopriv_woocp_clear_compare', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_clear_compare') );

// AJAX get compare feature fields for variations of product
add_action('wp_ajax_woocp_get_variation_compare', array('\A3Rev\WCCompare\MetaBox', 'woocp_get_variation_compare') );
add_action('wp_ajax_nopriv_woocp_get_variation_compare', array('\A3Rev\WCCompare\MetaBox', 'woocp_get_variation_compare') );

// AJAX get compare feature fields for variation when change compare category
add_action('wp_ajax_woocp_variation_get_fields', array('\A3Rev\WCCompare\MetaBox', 'woocp_variation_get_fields') );
add_action('wp_ajax_nopriv_woocp_variation_get_fields', array('\A3Rev\WCCompare\MetaBox', 'woocp_variation_get_fields') );

// AJAX get compare feature fields for product when change compare category
add_action('wp_ajax_woocp_product_get_fields', array('\A3Rev\WCCompare\MetaBox', 'woocp_product_get_fields') );
add_action('wp_ajax_nopriv_woocp_product_get_fields', array('\A3Rev\WCCompare\MetaBox', 'woocp_product_get_fields') );

// AJAX update orders for compare fields in dashboard
add_action('wp_ajax_woocp_update_orders', array('\A3Rev\WCCompare\Admin\Fields', 'woocp_update_orders') );
add_action('wp_ajax_nopriv_woocp_update_orders', array('\A3Rev\WCCompare\Admin\Fields', 'woocp_update_orders') );

// AJAX update orders for compare categories in dashboard
add_action('wp_ajax_woocp_update_cat_orders', array('\A3Rev\WCCompare\Admin\Categories', 'woocp_update_cat_orders') );
add_action('wp_ajax_nopriv_woocp_update_cat_orders', array('\A3Rev\WCCompare\Admin\Categories', 'woocp_update_cat_orders') );

// Include google fonts into header
add_action( 'wp_enqueue_scripts', array( '\A3Rev\WCCompare\Hook_Filter', 'add_google_fonts'), 9 );

// Include google fonts into header
add_action( 'woocp_comparison_page_header', array( '\A3Rev\WCCompare\Hook_Filter', 'add_google_fonts_comparison_page'), 11 );

// Add script into footer to hanlde the event from widget, popup
add_action('get_footer', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_footer_script') );

// Set selected attributes for variable products
add_filter('woocommerce_product_default_attributes', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_set_selected_attributes') );

// Add Compare Button on Shop page
$woo_compare_grid_view_settings = get_option( 'woo_compare_grid_view_settings', array() );
if ( ! isset( $woo_compare_grid_view_settings['disable_grid_view_compare'] ) || $woo_compare_grid_view_settings['disable_grid_view_compare'] != 1 ) {
	if ( ! isset( $woo_compare_grid_view_settings['grid_view_button_position'] ) || $woo_compare_grid_view_settings['grid_view_button_position'] == 'above' )
		add_action('woocommerce_before_template_part', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_shop_add_compare_button'), 10, 3);
	else
		add_action('woocommerce_after_shop_loop_item', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_shop_add_compare_button_below_cart'), 11);
}

// Add Compare Button on Product Details page
$woo_compare_product_page_settings = get_option( 'woo_compare_product_page_settings', array() );
if ( ! isset( $woo_compare_product_page_settings['disable_product_page_compare'] ) || $woo_compare_product_page_settings['disable_product_page_compare'] != 1 ) {
	if (!isset($woo_compare_product_page_settings['product_page_button_position']) || $woo_compare_product_page_settings['product_page_button_position'] == 'above' ) {
		add_action('woocommerce_before_add_to_cart_button', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_details_add_compare_button') );
	} else {
		add_action('woocommerce_after_add_to_cart_button', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_details_add_compare_button'), 1);
	}
}

// Add Compare Featured Field tab into Product Details page
if ( ! isset( $woo_compare_product_page_settings['disable_compare_featured_tab'] ) || $woo_compare_product_page_settings['disable_compare_featured_tab'] != 1 ) {
	add_filter( 'woocommerce_product_tabs', array('\A3Rev\WCCompare\Hook_Filter', 'woocp_product_featured_tab_woo_2_0') );
}

// Create Compare Category when Product Category is created
add_action( 'create_product_cat',  array('\A3Rev\WCCompare\Hook_Filter', 'auto_create_compare_category'), 10, 2 );

// Create Compare Feature when Product Variation is created
add_action( 'admin_init', array('\A3Rev\WCCompare\Hook_Filter', 'auto_create_compare_feature'), 1);

// Add compare feature fields box into Edit product page
add_action( 'admin_menu', array('\A3Rev\WCCompare\MetaBox', 'compare_meta_boxes'), 1 );
if (in_array(basename($_SERVER['PHP_SELF']), array('post.php', 'page.php', 'page-new.php', 'post-new.php'))) {
	add_action('admin_footer', array('\A3Rev\WCCompare\MetaBox', 'admin_include_variation_compare_scripts'));
}
// For variations
add_action( 'woocommerce_product_after_variable_attributes', array('\A3Rev\WCCompare\MetaBox', 'variable_compare_meta_boxes'), 1, 3 );
add_action( 'woocommerce_save_product_variation', array('\A3Rev\WCCompare\MetaBox', 'save_product_variation'), 11, 2 );

if (in_array(basename($_SERVER['PHP_SELF']), array('post.php', 'page.php', 'page-new.php', 'post-new.php'))) {
	add_action('save_post', array('\A3Rev\WCCompare\MetaBox', 'save_compare_meta_boxes' ), 11 );
}

// Add shortcode [woocommerce_compare_attributes_table]
add_shortcode('woocommerce_compare_attributes_table', function( $attributes ) {
	if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) return;

	if ( ! is_array( $attributes ) ) {
		$attributes = array();
	}

	extract( array_merge( array(
		'product_id'         => 0,
		'use_wootheme_style' => 'true',
    ), $attributes ) );

    if ( 'false' === $use_wootheme_style ) {
    	$use_wootheme_style = false;
    } else {
    	$use_wootheme_style = true;
    }

    $output = WCCompare\Hook_Filter::show_compare_fields( $product_id, $use_wootheme_style );

    return $output;

} );

// Check upgrade functions
add_action( 'init', 'woo_cp_lite_upgrade_plugin' );
function woo_cp_lite_upgrade_plugin () {

	// Upgrade to 2.0.0
	if(version_compare(get_option('a3rev_woocp_pro_version'), '2.0.0') === -1){
		include( WOOCP_DIR. '/includes/updates/compare-update-2.0.0.php' );
		update_option('a3rev_woocp_pro_version', '2.0.0');
	}
	// Upgrade to 2.0.1
	if(version_compare(get_option('a3rev_woocp_pro_version'), '2.0.1') === -1){
		include( WOOCP_DIR. '/includes/updates/compare-update-2.0.1.php' );
		update_option('a3rev_woocp_pro_version', '2.0.1');
	}
	// Upgrade to 2.0.6
	if(version_compare(get_option('a3rev_woocp_pro_version'), '2.0.6') === -1){
		include( WOOCP_DIR. '/includes/updates/compare-update-2.0.6.php' );
		update_option('a3rev_woocp_pro_version', '2.0.6');
	}
	// Upgrade to 2.1.0
	if(version_compare(get_option('a3rev_woocp_pro_version'), '2.1.0') === -1){
		include( WOOCP_DIR. '/includes/updates/compare-update-2.1.0.php' );
		update_option('a3rev_woocp_pro_version', '2.1.0');
	}

	// Upgrade to 2.1.8
	if(version_compare(get_option('a3rev_woocp_pro_version'), '2.1.8') === -1){
		include( WOOCP_DIR. '/includes/updates/compare-update-2.1.8.php' );
		WCCompare\Functions::lite_upgrade_version_2_1_8();

		update_option('a3rev_woocp_pro_version', '2.1.8');
		update_option('a3rev_woocp_lite_version', '2.1.8');
	}

	// Upgrade to 2.1.9.3
	if( version_compare(get_option('a3rev_woocp_lite_version'), '2.1.9.3') === -1 ) {
		include( WOOCP_DIR. '/includes/updates/compare-update-2.1.9.3.php' );
		update_option('a3rev_woocp_lite_version', '2.1.9.3');
	}

	// Upgrade to 2.3.0
	if( version_compare(get_option('a3rev_woocp_lite_version'), '2.3.0') === -1 ){
		update_option('a3rev_woocp_lite_version', '2.3.0');

		// Build sass
		$GLOBALS[WOOCP_PREFIX.'less']->plugin_build_sass();
	}

	// Upgrade to 2.4.0
	if ( version_compare(get_option('a3rev_woocp_lite_version'), '2.4.0') === -1 ) {
		update_option('a3rev_woocp_lite_version', '2.4.0');
		update_option('wc_compare_product_style_version', time() );
	}

	// Upgrade to 2.5.0
	if(version_compare(get_option('a3rev_woocp_lite_version'), '2.5.0') === -1){
		update_option('a3rev_woocp_lite_version', '2.5.0');
		include( WOOCP_DIR. '/includes/updates/compare-update-2.5.0.php' );

		// Build sass
		$GLOBALS[WOOCP_PREFIX.'less']->plugin_build_sass();
	}

	// Upgrade to 3.1.0
	if(version_compare(get_option('a3rev_woocp_lite_version'), '3.1.0') === -1){
		update_option('a3rev_woocp_lite_version', '3.1.0');

		// Build sass
		$GLOBALS[WOOCP_PREFIX.'less']->plugin_build_sass();
	}

	update_option('a3rev_woocp_pro_version', '4.1.0');
	update_option('a3rev_woocp_lite_version', WOOCP_VERSION );

}

<?php
/**
 * WC Compare Products Uninstall
 *
 * Uninstalling deletes options, tables, and pages.
 *
 */
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) 
	exit();

global $wpdb;
$plugin_key = 'woo_compare';

// Delete Google Font
delete_option( $plugin_key . '_google_api_key' . '_enable' );
delete_transient( $plugin_key . '_google_api_key' . '_status' );
delete_option( $plugin_key . '_google_font_list' );

if ( get_option( $plugin_key . '_clean_on_deletion' ) == 1 ) {
	delete_option( $plugin_key . '_google_api_key' );
	delete_option( $plugin_key . '_toggle_box_open' );
	delete_option( $plugin_key . '-custom-boxes' );

	delete_metadata( 'user', 0,  $plugin_key . '-' . 'plugin_framework_global_box' . '-' . 'opened', '', true );


	delete_option( 'woo_compare_product_page_settings' );
	delete_option( 'woo_compare_product_page_button_style' );
	delete_option( 'woo_compare_product_page_tab' );
	delete_option( 'woo_compare_product_page_view_compare_style' );
	delete_option( 'woo_compare_widget_clear_all_style' );
	delete_option( 'woo_compare_widget_button_style' );
	delete_option( 'woo_compare_widget_style' );
	delete_option( 'woo_compare_widget_thumbnail_style' );
	delete_option( 'woo_compare_widget_title_style' );
	delete_option( 'woo_compare_grid_view_button_style' );
	delete_option( 'woo_compare_grid_view_settings' );
	delete_option( 'woo_compare_gridview_view_compare_style' );
	delete_option( 'woo_compare_addtocart_style' );
	delete_option( 'woo_compare_close_window_button_style' );
	delete_option( 'woo_compare_comparison_page_global_settings' );
	delete_option( 'woo_compare_page_style' );
	delete_option( 'woo_compare_print_page_settings' );
	delete_option( 'woo_compare_product_prices_style' );
	delete_option( 'woo_compare_table_content_style' );
	delete_option( 'woo_compare_table_style' );
	delete_option( 'woo_compare_viewcart_style' );
	
	delete_option( 'woo_compare_addtocart_success' );
	delete_option( 'woo_compare_logo' );
	delete_option( 'woo_compare_gridview_product_success_icon' );
	delete_option( 'woo_compare_product_success_icon' );
	delete_option( 'woo_compare_basket_icon' );
	
	delete_option( 'a3rev_woocp_lite_version' );
	
	delete_post_meta_by_key('_woo_deactivate_compare_feature');
	delete_post_meta_by_key('_woo_compare_category');
	delete_post_meta_by_key('_woo_compare_category_name');
	
	// Delete compare product meta
	$wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key LIKE '_woo_compare_field-%';");

	wp_delete_post( get_option('product_compare_id') , true );
	
	$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'woo_compare_fields');
	$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'woo_compare_categories');
	$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'woo_compare_cat_fields');
	
	delete_option( $plugin_key . '_clean_on_deletion' );
}

<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Product Pages Data Update
$woo_compare_product_page_settings = get_option('woo_compare_product_page_settings');

$woo_compare_product_page_button_style = get_option('woo_compare_product_page_button_style', array() );
$woo_compare_product_page_button_style['product_compare_button_bg_colour'] = $woo_compare_product_page_button_style['button_bg_colour'];
$woo_compare_product_page_button_style['product_compare_button_bg_colour_from'] = $woo_compare_product_page_button_style['button_bg_colour_from'];
$woo_compare_product_page_button_style['product_compare_button_bg_colour_to'] = $woo_compare_product_page_button_style['button_bg_colour_to'];
$woo_compare_product_page_button_style['product_compare_button_border'] = $woo_compare_product_page_button_style['button_border'];
$woo_compare_product_page_button_style['product_compare_button_font'] = $woo_compare_product_page_button_style['button_font'];
$woo_compare_product_page_button_style['product_compare_button_shadow'] = $woo_compare_product_page_button_style['button_shadow'];
$woo_compare_product_page_settings = array_merge( $woo_compare_product_page_button_style,  $woo_compare_product_page_settings );

$woo_compare_product_page_view_compare_style = get_option('woo_compare_product_page_view_compare_style', array() );
$woo_compare_product_page_view_compare_style['product_view_button_bg_colour'] = $woo_compare_product_page_view_compare_style['button_bg_colour'];
$woo_compare_product_page_view_compare_style['product_view_button_bg_colour_from'] = $woo_compare_product_page_view_compare_style['button_bg_colour_from'];
$woo_compare_product_page_view_compare_style['product_view_button_bg_colour_to'] = $woo_compare_product_page_view_compare_style['button_bg_colour_to'];
$woo_compare_product_page_view_compare_style['product_view_button_border'] = $woo_compare_product_page_view_compare_style['button_border'];
$woo_compare_product_page_view_compare_style['product_view_button_font'] = $woo_compare_product_page_view_compare_style['button_font'];
$woo_compare_product_page_view_compare_style['product_view_button_shadow'] = $woo_compare_product_page_view_compare_style['button_shadow'];
$woo_compare_product_page_settings = array_merge( $woo_compare_product_page_view_compare_style,  $woo_compare_product_page_settings );

$woo_compare_product_page_tab = get_option('woo_compare_product_page_tab', array() );
$woo_compare_product_page_settings = array_merge( $woo_compare_product_page_tab,  $woo_compare_product_page_settings );

update_option('woo_compare_product_page_settings', $woo_compare_product_page_settings);


// Comparison Page Data Update
$woo_compare_comparison_page_global_settings = get_option('woo_compare_comparison_page_global_settings');

$woo_compare_page_style = get_option('woo_compare_page_style', array() );
if ( isset( $woo_compare_page_style['header_bg_colour'] ) ) {
	$header_bg_colour = $woo_compare_page_style['header_bg_colour'];
	$woo_compare_page_style['header_bg_colour'] = array( 'enable' => 1, 'color' => $header_bg_colour );
}
if ( isset( $woo_compare_page_style['body_bg_colour'] ) ) {
	$body_bg_colour = $woo_compare_page_style['body_bg_colour'];
	$woo_compare_page_style['body_bg_colour'] = array( 'enable' => 1, 'color' => $body_bg_colour );
}
$woo_compare_comparison_page_global_settings = array_merge( $woo_compare_page_style, $woo_compare_comparison_page_global_settings );

update_option('woo_compare_comparison_page_global_settings', $woo_compare_comparison_page_global_settings);

?>
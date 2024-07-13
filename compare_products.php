<?php
/*
Plugin Name: Compare Products for WooCommerce
Description: Compare Products uses your existing WooCommerce Product Categories and Product Attributes to create Compare Product Features for all your products. A sidebar Compare basket is created that users add products to and view the Comparison in a Compare this pop-up screen.
Version: 3.2.1
Requires at least: 6.0
Tested up to: 6.6
Author: a3rev Software
Author URI: https://a3rev.com/
Text Domain: woocommerce-compare-products
Domain Path: /languages
WC requires at least: 6.0.0
WC tested up to: 9.0
License: This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007

	WooCommerce Compare Products PRO. Plugin for the WooCommerce plugin.
	Copyright © 2011 A3 Revolution

	A3 Revolution
	admin@a3rev.com
	PO Box 1170
	Gympie 4570
	QLD Australia
*/

define('WOOCP_FILE_PATH', dirname(__FILE__));
define('WOOCP_DIR_NAME', basename(WOOCP_FILE_PATH));
define('WOOCP_FOLDER', dirname(plugin_basename(__FILE__)));
define('WOOCP_NAME', plugin_basename(__FILE__));
define('WOOCP_URL', untrailingslashit(plugins_url('/', __FILE__)));
define('WOOCP_DIR', WP_PLUGIN_DIR . '/' . WOOCP_FOLDER);
define('WOOCP_JS_URL', WOOCP_URL . '/assets/js');
define('WOOCP_CSS_URL', WOOCP_URL . '/assets/css');
define('WOOCP_IMAGES_URL', WOOCP_URL . '/assets/images');
if (!defined("WOOCP_AUTHOR_URI")) define("WOOCP_AUTHOR_URI", "https://a3rev.com/shop/woocommerce-compare-products/");

define( 'WOOCP_KEY', 'woo_compare' );
define( 'WOOCP_PREFIX', 'wc_compare_' );
define( 'WOOCP_VERSION',  '3.2.1' );
define( 'WOOCP_G_FONTS',  true );

// declare compatibility with new HPOS of WooCommerce
add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );

use \A3Rev\WCCompare\FrameWork;

if ( version_compare( PHP_VERSION, '5.6.0', '>=' ) ) {
	require __DIR__ . '/vendor/autoload.php';

	/**
	 * Plugin Framework init
	 */
	$GLOBALS[WOOCP_PREFIX.'admin_interface'] = new FrameWork\Admin_Interface();

	global $wc_compare_settings_page;
	$wc_compare_settings_page = new FrameWork\Pages\WC_Compare();

	$GLOBALS[WOOCP_PREFIX.'admin_init'] = new FrameWork\Admin_Init();

	$GLOBALS[WOOCP_PREFIX.'less'] = new FrameWork\Less_Sass();

	// End - Plugin Framework init

	global $wp_version;
	if ( version_compare( $wp_version, '5.5', '>=' ) ) {
		// Gutenberg Blocks init
		global $wc_compare_blocks;
		$wc_compare_blocks = new \A3Rev\WCCompare\Blocks();

		require 'src/blocks/compare-button/block.php';
		require 'src/blocks/compare-list/block.php';
	}

} else {
	return;
}

/**
 * Load Localisation files.
 *
 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
 *
 * Locales found in:
 * 		- WP_LANG_DIR/woocommerce-compare-products/woocommerce-compare-products-LOCALE.mo
 * 	 	- WP_LANG_DIR/plugins/woocommerce-compare-products-LOCALE.mo
 *  	- /wp-content/plugins/woocommerce-compare-products/languages/woocommerce-compare-products-LOCALE.mo (which if not found falls back to)
 */
function woocp_plugin_textdomain() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'woocommerce-compare-products' );

	load_textdomain( 'woocommerce-compare-products', WP_LANG_DIR . '/woocommerce-compare-products/woocommerce-compare-products-' . $locale . '.mo' );
	load_plugin_textdomain( 'woocommerce-compare-products', false, WOOCP_FOLDER . '/languages/' );
}

// Old code
include 'old/class-wc-compare-grid-view-settings.php';

include 'admin/compare_init.php';

/**
 * Show compare button
 */
function woo_add_compare_button($product_id = '', $echo = false)
{
    $html = \A3Rev\WCCompare\Hook_Filter::add_compare_button($product_id);
    if ($echo) echo $html;
    else return $html;
}

/**
 * Show compare fields panel
 */
function woo_show_compare_fields($product_id = '', $echo = false)
{
    $html = \A3Rev\WCCompare\Hook_Filter::show_compare_fields($product_id);
    if ($echo) echo $html;
    else return $html;
}

/**
 * Call when the plugin is activated
 */
register_activation_hook(__FILE__, 'woocp_install');

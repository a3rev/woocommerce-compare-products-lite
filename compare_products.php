<?php
/*
Plugin Name: WooCommerce Compare Products LITE
Description: Compare Products uses your existing WooCommerce Product Categories and Product Attributes to create Compare Product Features for all your products. A sidebar Compare basket is created that users add products to and view the Comparison in a Compare this pop-up screen.
Version: 2.6.4
Requires at least: 4.5
Tested up to: 4.9.7
Author: a3rev Software
Author URI: https://a3rev.com/
Text Domain: woocommerce-compare-products
Domain Path: /languages
WC requires at least: 2.0.0
WC tested up to: 3.4.4
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
define( 'WOOCP_VERSION',  '2.6.4' );

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


include ('admin/admin-ui.php');
include ('admin/admin-interface.php');

include ('admin/admin-pages/admin-product-comparison-page.php');

include ('admin/admin-init.php');
include ('admin/less/sass.php');

// Old code
include 'old/class-wc-compare-grid-view-settings.php';

include 'classes/class-wc-compare-filter.php';
include 'classes/data/class-wc-compare-data.php';
include 'classes/data/class-wc-compare-categories-data.php';
include 'classes/data/class-wc-compare-categories-fields-data.php';
include 'widgets/compare_widget.php';

include 'classes/class-wc-compare-functions.php';

include 'admin/compare_init.php';

/**
 * Show compare button
 */
function woo_add_compare_button($product_id = '', $echo = false)
{
    $html = WC_Compare_Hook_Filter::add_compare_button($product_id);
    if ($echo) echo $html;
    else return $html;
}

/**
 * Show compare fields panel
 */
function woo_show_compare_fields($product_id = '', $echo = false)
{
    $html = WC_Compare_Hook_Filter::show_compare_fields($product_id);
    if ($echo) echo $html;
    else return $html;
}

/**
 * Call when the plugin is activated
 */
register_activation_hook(__FILE__, 'woocp_install');

?>
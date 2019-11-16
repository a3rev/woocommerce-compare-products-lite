<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

\A3Rev\WCCompare\Functions::create_page( esc_sql( 'product-comparison' ), '', __('Product Comparison', 'woocommerce-compare-products' ), '[product_comparison_page]' );
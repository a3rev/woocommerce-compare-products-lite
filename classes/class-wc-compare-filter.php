<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Hook Filter
 *
 * Hook anf Filter into woocommerce plugin
 *
 * Table Of Contents
 *
 * register_admin_screen()
 * template_loader()
 * add_google_fonts()
 * include_customized_style()
 * woocp_shop_add_compare_button()
 * woocp_shop_add_compare_button_below_cart()
 * woocp_details_add_compare_button()
 * woocp_details_add_compare_button_below_cart()
 * add_compare_button()
 * show_compare_fields()
 * woocp_variable_ajax_add_to_cart()
 * woocp_add_to_compare()
 * woocp_remove_from_popup_compare()
 * woocp_update_compare_popup()
 * woocp_update_compare_widget()
 * woocp_update_total_compare()
 * woocp_remove_from_compare()
 * woocp_clear_compare()
 * woocp_footer_script()
 * woocp_variable_add_to_cart_script()
 * woocp_product_featured_tab_woo_2_0()
 * woocp_product_featured_panel_woo_2_0()
 * woocp_set_selected_attributes()
 * auto_create_compare_category()
 * auto_create_compare_feature()
 * a3_wp_admin()
 * admin_sidebar_menu_css()
 * plugin_extra_links()
 */

namespace A3Rev\WCCompare;

class Hook_Filter
{
	public static function register_admin_screen () {
		
		$product_comparison = add_menu_page( __('Product Comparison', 'woocommerce-compare-products' ), __('WC Compare', 'woocommerce-compare-products' ), 'manage_options', 'woo-compare-features', array( '\A3Rev\WCCompare\Admin\Features_Panel', 'admin_screen' ), null, '55.222');
		
		$compare_features = add_submenu_page('woo-compare-features', __( 'Compare Category & Feature', 'woocommerce-compare-products' ), __( 'Category & Feature', 'woocommerce-compare-products' ), 'manage_options', 'woo-compare-features', array( '\A3Rev\WCCompare\Admin\Features_Panel', 'admin_screen' ) );
		
		$compare_products = add_submenu_page('woo-compare-features', __( 'Compare Products Manager', 'woocommerce-compare-products' ), __( 'Product Manager', 'woocommerce-compare-products' ), 'manage_options', 'woo-compare-products', array( '\A3Rev\WCCompare\Admin\Products', 'woocp_products_manager' ) );
				
	} // End register_admin_screen()
	
	public static function template_loader( $template ) {
		global $product_compare_id;
		global $post;

		if ( is_object( $post ) && $product_compare_id == $post->ID ) {
			
			$file 	= 'product-compare.php';
			$find[] = $file;
			$find[] = apply_filters( 'woocommerce_template_url', 'woocommerce/' ) . $file;
			
			$template = locate_template( $find );
			if ( ! $template ) $template = WOOCP_FILE_PATH . '/templates/' . $file;

		}
	
		return $template;
	}
	
	public static function nocache_ours_page() {
		global $product_compare_id;
		
		$woocp_page_uris   = array();
		// Exclude querystring when using page ID
		$woocp_page_uris[] = 'p=' . $product_compare_id;
		$woocp_page_uris[] = 'page_id=' . $product_compare_id;
		
		// Exclude permalinks
		$comparision_page      = get_post( $product_compare_id );
		
		if ( ! is_null( $comparision_page ) )
			$woocp_page_uris[] = '/' . $comparision_page->post_name;
		
		if ( is_array( $woocp_page_uris ) ) {
			foreach( $woocp_page_uris as $uri ) {
				if ( strstr( $_SERVER['REQUEST_URI'], $uri ) ) {
					if ( ! defined( 'DONOTCACHEPAGE' ) )
						define( "DONOTCACHEPAGE", "true" );
		
					if ( ! defined( 'DONOTCACHEOBJECT' ) )
						define( "DONOTCACHEOBJECT", "true" );
		
					if ( ! defined( 'DONOTCACHEDB' ) )
						define( "DONOTCACHEDB", "true" );
		
					nocache_headers();
				}
			}
		}
	}
	
	public static function add_google_fonts() {
		global $woo_compare_product_page_settings;
		$google_fonts = array( 
							$woo_compare_product_page_settings['product_compare_link_font']['face'], 
							$woo_compare_product_page_settings['product_compare_button_font']['face'], 
							$woo_compare_product_page_settings['product_view_compare_link_font']['face'], 
							$woo_compare_product_page_settings['product_view_button_font']['face'], 
						);
						
		$google_fonts = apply_filters( 'wc_compare_google_fonts', $google_fonts );
		
		$GLOBALS[WOOCP_PREFIX.'fonts_face']->generate_google_webfonts( $google_fonts );
	}
	
	public static function add_google_fonts_comparison_page() {
		global $woo_compare_comparison_page_global_settings;
		$google_fonts = array( 
							$woo_compare_comparison_page_global_settings['no_product_message_font']['face'],
						);
						
		$google_fonts = apply_filters( 'wc_comparison_page_google_fonts', $google_fonts );
		
		$GLOBALS[WOOCP_PREFIX.'fonts_face']->generate_google_webfonts( $google_fonts );
	}
	
	public static function include_customized_style() {
		include( WOOCP_DIR. '/templates/customized_style.php' );
	}

	public static function woocp_shop_add_compare_button($template_name, $template_path, $located) {
		global $post;
		global $product;
		global $woo_compare_grid_view_settings;
		global $woo_compare_comparison_page_global_settings;
		global $product_compare_id;
		extract($woo_compare_grid_view_settings);
		if ($template_name == 'loop/add-to-cart.php') {
			$product_id = $product->get_id();
			if ( $post && ($post->post_type == 'product' || $post->post_type == 'product_variation') && Functions::check_product_activate_compare($product_id) && Functions::check_product_have_cat($product_id)) {
				$compare_grid_view_custom_class = '';
				$compare_grid_view_text = __('Compare This', 'woocommerce-compare-products' );
				$compare_grid_view_class = 'woo_bt_compare_this_button';
				
				$view_compare_html = '';
				
				$compare_html = '<div class="woo_grid_compare_button_container"><a href="#" onclick="event.preventDefault();" class="woo_bt_compare_this '.$compare_grid_view_class.' '.$compare_grid_view_custom_class.'" id="woo_bt_compare_this_'.$product_id.'" rel="nofollow">'.$compare_grid_view_text.'</a>' . $view_compare_html . '<input type="hidden" id="input_woo_bt_compare_this_'.$product_id.'" name="product_compare_'.$product_id.'" value="'.$product_id.'" /></div>';
				echo $compare_html;
			}
		}
	}
	
	public static function woocp_shop_add_compare_button_below_cart() {
		global $post;
		global $product;
		global $woo_compare_grid_view_settings;
		global $woo_compare_comparison_page_global_settings;
		global $product_compare_id;

		if ( $woo_compare_grid_view_settings['disable_grid_view_compare'] == 1 || $woo_compare_grid_view_settings['grid_view_button_position'] == 'above' ) return;

		extract($woo_compare_grid_view_settings);
			$product_id = $product->get_id();
			if (($post->post_type == 'product' || $post->post_type == 'product_variation') && Functions::check_product_activate_compare($product_id) && Functions::check_product_have_cat($product_id)) {
				$compare_grid_view_custom_class = '';
				$compare_grid_view_text = __('Compare This', 'woocommerce-compare-products' );
				$compare_grid_view_class = 'woo_bt_compare_this_button';
				
				$view_compare_html = '';
				
				$compare_html = '<div class="woo_grid_compare_button_container"><a href="#" onclick="event.preventDefault();" class="woo_bt_compare_this '.$compare_grid_view_class.' '.$compare_grid_view_custom_class.'" id="woo_bt_compare_this_'.$product_id.'" rel="nofollow">'.$compare_grid_view_text.'</a>' . $view_compare_html . '<input type="hidden" id="input_woo_bt_compare_this_'.$product_id.'" name="product_compare_'.$product_id.'" value="'.$product_id.'" /></div>';
				echo $compare_html;
			}
	}

	public static function woocp_details_add_compare_button() {
		global $post;
		global $product;
		global $woo_compare_product_page_settings;
		global $woo_compare_comparison_page_global_settings;
		global $product_compare_id;
		$product_id = $product->get_id();
		if (($post->post_type == 'product' || $post->post_type == 'product_variation') && Functions::check_product_activate_compare($product_id) && $woo_compare_product_page_settings['auto_add'] == 'yes' && Functions::check_product_have_cat($product_id)) {
			
			$widget_compare_popup_view_button = '';
			if ( $woo_compare_comparison_page_global_settings['open_compare_type'] != 'new_page' ) $widget_compare_popup_view_button = 'woo_bt_view_compare_popup';
				
			$product_compare_custom_class = '';
			$product_compare_text = $woo_compare_product_page_settings['product_compare_button_text'];
			$product_compare_class = 'woo_bt_compare_this_button';
			if ($woo_compare_product_page_settings['product_compare_button_type'] == 'link') {
				$product_compare_custom_class = '';
				$product_compare_text = $woo_compare_product_page_settings['product_compare_link_text'];
				$product_compare_class = 'woo_bt_compare_this_link';
			}
			
			$view_compare_html = '';
			if ($woo_compare_product_page_settings['disable_product_view_compare'] == 0) {
				$product_view_compare_custom_class = '';
				$product_view_compare_text = $woo_compare_product_page_settings['product_view_compare_link_text'];
				$product_view_compare_class = 'woo_bt_view_compare_link';
				if ($woo_compare_product_page_settings['product_view_compare_button_type'] == 'button') {
					$product_view_compare_custom_class = '';
					$product_view_compare_text = $woo_compare_product_page_settings['product_view_compare_button_text'];
					$product_view_compare_class = 'woo_bt_view_compare_button';
				}
				$product_compare_page = get_permalink($product_compare_id);
				if ($woo_compare_comparison_page_global_settings['open_compare_type'] != 'new_page') {
					$product_compare_page = '#';
				}
				$view_compare_html = '<div style="clear:both;"></div><a class="woo_bt_view_compare '.$widget_compare_popup_view_button.' '.$product_view_compare_class.' '.$product_view_compare_custom_class.'" href="'.$product_compare_page.'" target="_blank" alt="" title="" style="display:none;">'.$product_view_compare_text.'</a>';
			}
			$compare_html = '<div class="woo_compare_button_container"><a href="#" onclick="event.preventDefault();" class="woo_bt_compare_this '.$product_compare_class.' '.$product_compare_custom_class.'" id="woo_bt_compare_this_'.$product_id.'" rel="nofollow">'.$product_compare_text.'</a>' . $view_compare_html . '<input type="hidden" id="input_woo_bt_compare_this_'.$product_id.'" name="product_compare_'.$product_id.'" value="'.$product_id.'" /></div>';
			echo $compare_html;
		}
	}
	
	public static function woocp_details_add_compare_button_below_cart($template_name, $template_path, $located){
		global $post;
		global $product;
		global $woo_compare_product_page_settings;
		global $woo_compare_comparison_page_global_settings;
		global $product_compare_id;
		if (in_array($template_name, array('single-product/add-to-cart/simple.php', 'single-product/add-to-cart/grouped.php', 'single-product/add-to-cart/external.php', 'single-product/add-to-cart/variable.php'))) {
			$product_id = $product->get_id();
			if (($post->post_type == 'product' || $post->post_type == 'product_variation') && Functions::check_product_activate_compare($product_id) && $woo_compare_product_page_settings['auto_add'] == 'yes' && Functions::check_product_have_cat($product_id)) {
				
				$widget_compare_popup_view_button = '';
				if ( $woo_compare_comparison_page_global_settings['open_compare_type'] != 'new_page' ) $widget_compare_popup_view_button = 'woo_bt_view_compare_popup';
				
				$product_compare_custom_class = '';
				$product_compare_text = $woo_compare_product_page_settings['product_compare_button_text'];
				$product_compare_class = 'woo_bt_compare_this_button';
				if ($woo_compare_product_page_settings['product_compare_button_type'] == 'link') {
					$product_compare_custom_class = '';
					$product_compare_text = $woo_compare_product_page_settings['product_compare_link_text'];
					$product_compare_class = 'woo_bt_compare_this_link';
				}
				
				$view_compare_html = '';
				if ($woo_compare_product_page_settings['disable_product_view_compare'] == 0) {
					$product_view_compare_custom_class = '';
					$product_view_compare_text = $woo_compare_product_page_settings['product_view_compare_link_text'];
					$product_view_compare_class = 'woo_bt_view_compare_link';
					if ($woo_compare_product_page_settings['product_view_compare_button_type'] == 'button') {
						$product_view_compare_custom_class = '';
						$product_view_compare_text = $woo_compare_product_page_settings['product_view_compare_button_text'];
						$product_view_compare_class = 'woo_bt_view_compare_button';
					}
					$product_compare_page = get_permalink($product_compare_id);
					if ($woo_compare_comparison_page_global_settings['open_compare_type'] != 'new_page') {
						$product_compare_page = '#';
					}
					$view_compare_html = '<div style="clear:both;"></div><a class="woo_bt_view_compare '.$widget_compare_popup_view_button.' '.$product_view_compare_class.' '.$product_view_compare_custom_class.'" href="'.$product_compare_page.'" target="_blank" alt="" title="" style="display:none;">'.$product_view_compare_text.'</a>';
				}
			
				$compare_html = '<div class="woo_compare_button_container"><a href="#" onclick="event.preventDefault();" class="woo_bt_compare_this '.$product_compare_class.' '.$product_compare_custom_class.'" id="woo_bt_compare_this_'.$product_id.'" rel="nofollow">'.$product_compare_text.'</a>' . $view_compare_html . '<input type="hidden" id="input_woo_bt_compare_this_'.$product_id.'" name="product_compare_'.$product_id.'" value="'.$product_id.'" /></div>';
				echo $compare_html;
			}
		}
	}

	public static function get_current_product_id( $product_id = 0 ) {

		if ( empty( $product_id ) ) {
	    	global $product;

	    	if ( $product && is_a( $product, 'WC_Product' ) ) {
	    		$product_id = $product->get_id();
	    	}
	    }

	    // Get current product ID from Query Loop block of WP Predictive Search
		if ( empty( $product_id ) ) {
			global $psobject;
			if ( $psobject ) {
				$product_id = $psobject->id;
			}
		}

	    if ( empty( $product_id ) ) {
			global $post;
			if ( $post ) {
				$product_id = $post->ID;
			}
		}

		return $product_id;
	}

	public static function add_compare_button( $product_id='', $custom_button = '' ) {
		global $woo_compare_product_page_settings;
		global $woo_compare_comparison_page_global_settings;
		global $product_compare_id;

		$product_id = self::get_current_product_id( $product_id );

		if ( empty( $product_id ) ) return '';

		$post_type = get_post_type($product_id);
		$html = '';
		if (($post_type == 'product' || $post_type == 'product_variation') && Functions::check_product_activate_compare($product_id) && Functions::check_product_have_cat($product_id)) {
			
			$widget_compare_popup_view_button = '';
			if ( $woo_compare_comparison_page_global_settings['open_compare_type'] != 'new_page' ) $widget_compare_popup_view_button = 'woo_bt_view_compare_popup';
				
			$product_compare_custom_class = '';
			$product_compare_text = $woo_compare_product_page_settings['product_compare_button_text'];
			$product_compare_class = 'woo_bt_compare_this_button';
			if ($woo_compare_product_page_settings['product_compare_button_type'] == 'link') {
				$product_compare_custom_class = '';
				$product_compare_text = $woo_compare_product_page_settings['product_compare_link_text'];
				$product_compare_class = 'woo_bt_compare_this_link';
			}
			
			$view_compare_html = '';
			if ($woo_compare_product_page_settings['disable_product_view_compare'] == 0) {
				$product_view_compare_custom_class = '';
				$product_view_compare_text = $woo_compare_product_page_settings['product_view_compare_link_text'];
				$product_view_compare_class = 'woo_bt_view_compare_link';
				if ($woo_compare_product_page_settings['product_view_compare_button_type'] == 'button') {
					$product_view_compare_custom_class = '';
					$product_view_compare_text = $woo_compare_product_page_settings['product_view_compare_button_text'];
					$product_view_compare_class = 'woo_bt_view_compare_button';
				}
				$product_compare_page = get_permalink($product_compare_id);
				if ($woo_compare_comparison_page_global_settings['open_compare_type'] != 'new_page') {
					$product_compare_page = '#';
				}
				$view_compare_html = '<div style="clear:both;"></div><a class="woo_bt_view_compare '.$widget_compare_popup_view_button.' '.$product_view_compare_class.' '.$product_view_compare_custom_class.'" href="'.$product_compare_page.'" target="_blank" alt="" title="" style="display:none;">'.$product_view_compare_text.'</a>';
			}

			$input_hidden = '<input type="hidden" id="input_woo_bt_compare_this_'.$product_id.'" name="product_compare_'.$product_id.'" value="'.$product_id.'" />';
			if ( empty( $custom_button ) ) {
				$html .= '<div class="woo_compare_button_container"><a href="#" onclick="event.preventDefault();" class="woo_bt_compare_this '.$product_compare_class.' '.$product_compare_custom_class.'" id="woo_bt_compare_this_'.$product_id.'" rel="nofollow">'.$product_compare_text.'</a>' . $view_compare_html . $input_hidden . '</div>';
			} else {
				$html = sprintf( $custom_button, $view_compare_html . $input_hidden );
			}
		}

		return $html;
	}

	public static function show_compare_fields($product_id='', $use_wootheme_style=true) {
		$product_id = self::get_current_product_id( $product_id );

		if ( empty( $product_id ) ) return '';

		global $woo_compare_comparison_page_global_settings;

		$html = '';
		$variations_list = Functions::get_variations($product_id);
		if (is_array($variations_list) && count($variations_list) > 0) {
			foreach ($variations_list as $variation_id) {
				if (Functions::check_product_activate_compare($variation_id) && Functions::check_product_have_cat($variation_id)) {
					$compare_category = get_post_meta( $variation_id, '_woo_compare_category', true );
					$compare_fields = Data\Categories_Fields::get_results("cat_id='".$compare_category."'", 'cf.field_order ASC');
					if (is_array($compare_fields) && count($compare_fields)>0) {
						$html .= '<div class="compare_product_variation"><h2>'.Functions::get_variation_name($variation_id).'</h2></div>';
						if ($use_wootheme_style) 
							$html .= '<table class="compare_featured_fields shop_attributes">'; 
						else 
							$html .= '<ul class="compare_featured_fields">';
						$fixed_width = ' width="60%"';
						foreach ($compare_fields as $field_data) {
							$field_value = get_post_meta( $variation_id, '_woo_compare_'.$field_data->field_key, true );
							if (is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
							if (is_array($field_value) && count($field_value) > 0) $field_value = implode(', ', $field_value);
							elseif (is_array($field_value) && count($field_value) < 0) $field_value = $woo_compare_comparison_page_global_settings['empty_text'];
							if (trim($field_value) == '') $field_value = $woo_compare_comparison_page_global_settings['empty_text'];
							$field_unit = '';
							if (trim($field_data->field_unit) != '') $field_unit = ' <span class="compare_featured_unit">('.trim(stripslashes($field_data->field_unit)).')</span>';
							if ($use_wootheme_style) 
								$html .= '<tr><th><span class="compare_featured_name">'.stripslashes($field_data->field_name).'</span>'.$field_unit.'</th><td '.$fixed_width.'><span class="compare_featured_value">'.$field_value.'</span></td></tr>';
							else
								$html .= '<li class="compare_featured_item"><span class="compare_featured_name"><strong>'.stripslashes($field_data->field_name).'</strong>'.$field_unit.'</span> : <span class="compare_featured_value">'.$field_value.'</span></li>';
							$fixed_width = '';
						}
						if ($use_wootheme_style) 
							$html .= '</table>';
						else 
							$html .= '</ul>';
					}
				}
			}
		}elseif (Functions::check_product_activate_compare($product_id) && Functions::check_product_have_cat($product_id)) {
			$compare_category = get_post_meta( $product_id, '_woo_compare_category', true );
			$compare_fields = Data\Categories_Fields::get_results("cat_id='".$compare_category."'", 'cf.field_order ASC');
			if (is_array($compare_fields) && count($compare_fields)>0) {
				if ($use_wootheme_style) 
					$html .= '<table class="compare_featured_fields shop_attributes">'; 
				else 
					$html .= '<ul class="compare_featured_fields">';
				$fixed_width = ' width="60%"';
				foreach ($compare_fields as $field_data) {
					$field_value = get_post_meta( $product_id, '_woo_compare_'.$field_data->field_key, true );
					if (is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
					if (is_array($field_value) && count($field_value) > 0) $field_value = implode(', ', $field_value);
					elseif (is_array($field_value) && count($field_value) < 0) $field_value = $woo_compare_comparison_page_global_settings['empty_text'];
					if (trim($field_value) == '') $field_value = $woo_compare_comparison_page_global_settings['empty_text'];
					$field_unit = '';
					if (trim($field_data->field_unit) != '') $field_unit = ' <span class="compare_featured_unit">('.trim(stripslashes($field_data->field_unit)).')</span>';
					if ($use_wootheme_style) 
						$html .= '<tr><th><span class="compare_featured_name">'.stripslashes($field_data->field_name).'</span>'.$field_unit.'</th><td '.$fixed_width.'><span class="compare_featured_value">'.$field_value.'</span></td></tr>';
					else
						$html .= '<li class="compare_featured_item"><span class="compare_featured_name"><strong>'.stripslashes($field_data->field_name).'</strong>'.$field_unit.'</span> : <span class="compare_featured_value">'.$field_value.'</span></li>';
					$fixed_width = '';
				}
				if ($use_wootheme_style) 
					$html .= '</table>';
				else 
					$html .= '</ul>';
			}
		}
		return $html;
	}

	public static function woocp_variable_ajax_add_to_cart() {

		// Get product ID to add and quantity
		$variation_id   = absint( $_REQUEST['product_id'] );
		$mypost = get_post($variation_id);
		$product_id   = (int) apply_filters('woocommerce_add_to_cart_product_id', $mypost->post_parent);
		$quantity    = (isset($_REQUEST['quantity'])) ? absint( $_REQUEST['quantity'] ) : 1;
		$attributes   = (array) maybe_unserialize(get_post_meta($product_id, '_product_attributes', true));
		$variations   = array();

		$my_variation = new \WC_Product_Variation($variation_id, $product_id);
		$variation_data = $my_variation->get_variation_attributes();

		// Add to cart validation
		$passed_validation  = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);

		if ($passed_validation && \WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation_data)) {
			// Return html fragments
			$data = apply_filters('woocommerce_add_to_cart_fragments', $data);

		} else {
			$data = array(
				'error' => true,
				'product_url' => get_permalink( $product_id )
			);
		}

		echo json_encode( $data );
		die();
	}

	public static function woocp_add_to_compare() {

		$product_id  = absint( $_REQUEST['product_id'] );
		Functions::add_product_to_compare_list($product_id);

		die();
	}

	public static function woocp_remove_from_popup_compare() {

		$product_id  = absint( $_REQUEST['product_id'] );
		Functions::delete_product_on_compare_list($product_id);

		die();
	}
	
	public static function woocp_update_compare_popup() {
		$result = Functions::get_compare_list_html_popup();
		$result .= '<script src="'. WOOCP_JS_URL.'/fixedcolumntable/fixedcolumntable.js"></script>';
		echo json_encode( $result );
		die();
	}

	public static function woocp_update_compare_widget() {
		$result = Functions::get_compare_list_html_widget();
		echo json_encode( $result );
		die();
	}

	public static function woocp_update_total_compare() {
		$result = Functions::get_total_compare_list();
		echo json_encode( $result );
		die();
	}

	public static function woocp_remove_from_compare() {
		$product_id  = absint( $_REQUEST['product_id'] );
		Functions::delete_product_on_compare_list($product_id);
		die();
	}

	public static function woocp_clear_compare() {
		Functions::clear_compare_list();
		die();
	}

	public static function woocp_footer_script() {
		global $product_compare_id;
		global $woo_compare_comparison_page_global_settings;
		$woocp_compare_events = wp_create_nonce("woocp-compare-events");
		$woocp_compare_popup = wp_create_nonce("woocp-compare-popup");

		$script_add_on = '';
		$script_add_on .= '<script type="text/javascript">
				jQuery(document).ready(function($) {
						var ajax_url = "'.admin_url( 'admin-ajax.php', 'relative' ).'";
						woo_compare_widget_load();';
						
			$script_add_on .= '
						$(document).on("click", ".woo_compare_popup_button_go, .woo_bt_view_compare_popup", function (event){
							var compare_url = "'.get_permalink($product_compare_id).'";
							window.open(compare_url, "'.__('Product_Comparison', 'woocommerce-compare-products' ).'", "scrollbars=1, width=980, height=650");
							event.preventDefault();
							return false;
					 
					  });';

		$script_add_on .= '
						$(document).on("click", ".woo_bt_compare_this", function(){
							var woo_bt_compare_current = $(this);
							var product_id = $("#input_"+$(this).attr("id")).val();
							$(".woo_compare_widget_loader").show();
							$(".woo_compare_widget_container").html("");
							var data = {
								action: 		"woocp_add_to_compare",
								product_id: 	product_id,
								security: 		"'.$woocp_compare_events.'"
							};
							$.post( ajax_url, data, function(response) {
								//woo_bt_compare_current.siblings(".woo_add_compare_success").show();
								woo_bt_compare_current.addClass("compared");
								woo_bt_compare_current.siblings(".woo_bt_view_compare").show();
								//setTimeout(function(){
								//	woo_bt_compare_current.siblings(".woo_add_compare_success").hide();
								//}, 3000);
								data = {
									action: 		"woocp_update_compare_widget",
									security: 		"'.$woocp_compare_events.'"
								};
								$.post( ajax_url, data, function(response) {
									result = JSON.parse( response );
									$(".woo_compare_widget_loader").hide();
									$(".woo_compare_widget_container").html(result);
								});
								woo_update_total_compare_list();
							});
						});

						$(document).on("click", ".woo_compare_remove_product", function(){
							var remove_product_id = $(this).attr("rel");
							$(".woo_compare_widget_loader").show();
							$(".woo_compare_widget_container").html("");
							var data = {
								action: 		"woocp_remove_from_compare",
								product_id: 	remove_product_id,
								security: 		"'.$woocp_compare_events.'"
							};
							$.post( ajax_url, data, function(response) {
								data = {
									action: 		"woocp_update_compare_widget",
									security: 		"'.$woocp_compare_events.'"
								};
								$.post( ajax_url, data, function(response) {
									result = JSON.parse( response );
									$(".woo_compare_widget_loader").hide();
									$(".woo_compare_widget_container").html(result);
								});
								woo_update_total_compare_list();
							});
						});
						$(document).on("click", ".woo_compare_clear_all", function(){
							$(".woo_compare_widget_loader").show();
							$(".woo_compare_widget_container").html("");
							var data = {
								action: 		"woocp_clear_compare",
								security: 		"'.$woocp_compare_events.'"
							};
							$.post( ajax_url, data, function(response) {
								data = {
									action: 		"woocp_update_compare_widget",
									security: 		"'.$woocp_compare_events.'"
								};
								$.post( ajax_url, data, function(response) {
									result = JSON.parse( response );
									$(".woo_compare_widget_loader").hide();
									$(".woo_compare_widget_container").html(result);
								});
								woo_update_total_compare_list();
							});
						});

						function woo_update_total_compare_list(){
							var data = {
								action: 		"woocp_update_total_compare",
								security: 		"'.$woocp_compare_events.'"
							};
							$.post( ajax_url, data, function(response) {
								total_compare = JSON.parse( response );
								$("#total_compare_product").html(total_compare);
							});
						}
						
						function woo_compare_widget_load() {
							$(".woo_compare_widget_loader").show();
							$(".woo_compare_widget_container").html("");
							var data = {
								action: 		"woocp_update_compare_widget",
								security: 		"'.$woocp_compare_events.'"
							};
							$.post( ajax_url, data, function(response) {
								result = JSON.parse( response );
								$(".woo_compare_widget_loader").hide();
								$(".woo_compare_widget_container").html(result);
							});
							woo_update_total_compare_list();
						}

					});
				</script>';
		echo $script_add_on;
	}

	public static function woocp_variable_add_to_cart_script() {
		$woocp_add_to_cart_nonce = wp_create_nonce("woocp-add-to-cart");
		$script_add_on = '';
		$script_add_on .= '<script type="text/javascript">
				(function($){
					$(function(){
						if ( typeof wc_add_to_cart_params !== "undefined" ) {

							// Ajax add to cart
							$(document).on("click", ".add_to_cart_button", function() {

								// AJAX add to cart request
								var $thisbutton = $(this);

								if ($thisbutton.is(".product_type_variation")) {
									if (!$thisbutton.attr("data-product_id")) return true;

									$thisbutton.removeClass("added");
									$thisbutton.addClass("loading");

									var data = {
										action: 		"woocp_variable_add_to_cart",
										product_id: 	$thisbutton.attr("data-product_id"),
										security: 		"'.$woocp_add_to_cart_nonce.'"
									};

									// Trigger event
									$("body").trigger("adding_to_cart");

									// Ajax action
									$.post( wc_add_to_cart_params.ajax_url, data, function(response) {

										$thisbutton.removeClass("loading");

										// Get response
										data = JSON.parse( response );

										if (data.error && data.product_url) {
											window.location = data.product_url;
											return;
										}

										fragments = data;

										// Block fragments class
										if (fragments) {
											$.each(fragments, function(key, value) {
												$(key).addClass("updating");
											});
										}

										// Block widgets and fragments
										$(".widget_shopping_cart, .shop_table.cart, .updating, .cart_totals").fadeTo("400", "0.6").block({message: null, overlayCSS: {background: "transparent url('.str_replace( array( 'http:', 'https:' ), '', \WC()->plugin_url() ).'/assets/images/ajax-loader.gif) no-repeat center", opacity: 0.6}});

										// Changes button classes
										$thisbutton.addClass("added");

										// Cart widget load
										if ($(".widget_shopping_cart").length>0) {
											$(".widget_shopping_cart").eq(0).on( "load", window.location + " .widget_shopping_cart:eq(0) > *", function() {

												// Replace fragments
												if (fragments) {
													$.each(fragments, function(key, value) {
														$(key).replaceWith(value);
													});
												}

												// Unblock
												$(".widget_shopping_cart, .updating").css("opacity", "1").unblock();

												$("body").trigger("cart_widget_refreshed");
											} );
										} else {
											// Replace fragments
											if (fragments) {
												$.each(fragments, function(key, value) {
													$(key).replaceWith(value);
												});
											}

											// Unblock
											$(".widget_shopping_cart, .updating").css("opacity", "1").unblock();
										}

										// Cart page elements
										$(".shop_table.cart").on( "load", window.location + " .shop_table.cart:eq(0) > *", function() {

											$("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").addClass("buttons_added").append("<input type=\"button\" value=\"+\" id=\"add1\" class=\"plus\" />").prepend("<input type=\"button\" value=\"-\" id=\"minus1\" class=\"minus\" />");

											$(".shop_table.cart").css("opacity", "1").unblock();

											$("body").trigger("cart_page_refreshed");
										});

										$(".cart_totals").on( "load", window.location + " .cart_totals:eq(0) > *", function() {
											$(".cart_totals").css("opacity", "1").unblock();
										});

										// Trigger event so themes can refresh other areas
										$("body").trigger("added_to_cart");

									});

									return false;

								} else {
									return true;
								}

							});
						}
					});
				})(jQuery);
				</script>';
		echo $script_add_on;
	}
	
	public static function woocp_product_featured_tab_woo_2_0( $tabs = array() ) {
		global $product, $post;
		global $woo_compare_product_page_settings;
		
		$compare_featured_tab = trim($woo_compare_product_page_settings['compare_featured_tab']);
		if ($compare_featured_tab == '') $compare_featured_tab = __('Technical Details', 'woocommerce-compare-products' );

		$show_compare_featured_tab = false;
		$product_id = $post->ID;
		$variations_list = Functions::get_variations($product_id);
		if (is_array($variations_list) && count($variations_list) > 0) {
			foreach ($variations_list as $variation_id) {
				if (Functions::check_product_activate_compare($variation_id) && Functions::check_product_have_cat($variation_id)) {
					$compare_category = get_post_meta( $variation_id, '_woo_compare_category', true );
					$compare_fields = Data\Categories_Fields::get_results("cat_id='".$compare_category."'", 'cf.field_order ASC');
					if (is_array($compare_fields) && count($compare_fields)>0) {
						$show_compare_featured_tab = true;
						break;
					}
				}
			}
		}elseif (Functions::check_product_activate_compare($product_id) && Functions::check_product_have_cat($product_id)) {
			$compare_category = get_post_meta( $product_id, '_woo_compare_category', true );
			$compare_fields = Data\Categories_Fields::get_results("cat_id='".$compare_category."'", 'cf.field_order ASC');
			if (is_array($compare_fields) && count($compare_fields)>0) {
				$show_compare_featured_tab = true;
			}
		}

		if ($show_compare_featured_tab) {
		
			$tabs['compare-featured'] = array(
				'title'    => esc_attr( stripslashes( $compare_featured_tab ) ),
				'priority' => $woo_compare_product_page_settings['auto_compare_featured_tab'],
				'callback' => array( __CLASS__, 'woocp_product_featured_panel_woo_2_0')
			);
		}
		
		return $tabs;
	}
	
	public static function woocp_product_featured_panel_woo_2_0() {
		global $post;
		echo self::show_compare_fields($post->ID);
	}
	
	public static function woocp_set_selected_attributes($default_attributes) {
		if (isset($_REQUEST['variation_selected']) && $_REQUEST['variation_selected'] > 0) {
			$variation_id = absint( $_REQUEST['variation_selected'] );
			$mypost = get_post($variation_id);
			if ($mypost != NULL && $mypost->post_type == 'product_variation') {
				$attributes = (array) maybe_unserialize(get_post_meta($mypost->post_parent, '_product_attributes', true));
				$my_variation = new \WC_Product_Variation($variation_id, $mypost->post_parent);
				$variation_data = $my_variation->get_variation_attributes();
				if (is_array($attributes) && count($attributes) > 0) {
					foreach ($attributes as $attribute) {
						if ( !$attribute['is_variation'] ) continue;
						$taxonomy = 'attribute_' . sanitize_title($attribute['name']);
						if (isset($variation_data[$taxonomy])) {
							$default_attributes[sanitize_title($attribute['name'])] = $variation_data[$taxonomy];							
						}
					}
				}
			}
		}
		return $default_attributes;
	}
	
	public static function auto_create_compare_category($term_id) {
		$term = get_term( $term_id, 'product_cat' );
		$check_existed = Data\Categories::get_count("category_name='".trim($term->name)."'");
		if ($check_existed < 1 ) {
			Data\Categories::insert_row(array('category_name' => trim(addslashes($term->name))));
		}
	}
	
	public static function auto_create_compare_feature() {
		if (isset($_POST['add_new_attribute']) && $_POST['add_new_attribute']) {
			//check_admin_referer( 'woocommerce-add-new_attribute' );
			$attribute_name = (string) sanitize_title($_POST['attribute_name']);
			$attribute_type = (string) sanitize_text_field( $_POST['attribute_type'] );
			$attribute_label = (string) sanitize_text_field( $_POST['attribute_label'] );
			
			if (!$attribute_label) $attribute_label = ucwords($attribute_name);
			
			if (!$attribute_name) $attribute_name = sanitize_title($attribute_label);
			
			if ($attribute_name && strlen($attribute_name)<30 && $attribute_type && !taxonomy_exists( 'pa_'.$attribute_name )) {
				
				$check_existed = Data::get_count("field_name='".$attribute_label."'");
				if ($check_existed < 1 ) {
					$feature_id = Data::insert_row(array('field_name' => $attribute_label, 'field_type' => 'input-text', 'field_unit' => '', 'default_value' => '' ) );
				}
			}
		}
	}
	
	public static function a3_wp_admin() {
		wp_enqueue_style( 'a3rev-wp-admin-style', WOOCP_CSS_URL . '/a3_wp_admin.css' );
	}
	
	public static function admin_sidebar_menu_css() {
		wp_enqueue_style( 'a3rev-wc-cp-admin-sidebar-menu-style', WOOCP_CSS_URL . '/admin_sidebar_menu.css' );
	}

	public static function plugin_extension_box( $boxes = array() ) {

		$support_box = '<a href="'.$GLOBALS[WOOCP_PREFIX.'admin_init']->support_url.'" target="_blank" alt="'.__('Go to Support Forum', 'woocommerce-compare-products' ).'"><img src="'.WOOCP_IMAGES_URL.'/go-to-support-forum.png" /></a>';

		$boxes[] = array(
			'content' => $support_box,
			'css' => 'border: none; padding: 0; background: none;'
		);

		$review_box = '<div style="margin-bottom: 5px; font-size: 12px;"><strong>' . __('Is this plugin is just what you needed? If so', 'woocommerce-compare-products' ) . '</strong></div>';
        $review_box .= '<a href="https://wordpress.org/support/view/plugin-reviews/woocommerce-compare-products#postform" target="_blank" alt="'.__('Submit Review for Plugin on WordPress', 'woocommerce-compare-products' ).'"><img src="'.WOOCP_IMAGES_URL.'/a-5-star-rating-would-be-appreciated.png" /></a>';

        $boxes[] = array(
            'content' => $review_box,
            'css' => 'border: none; padding: 0; background: none;'
        );

		$pro_box = '<a href="'.$GLOBALS[WOOCP_PREFIX.'admin_init']->pro_plugin_page_url.'" target="_blank" alt="'.__('WooCommerce Compare Product', 'woocommerce-compare-products' ).'"><img src="'.WOOCP_IMAGES_URL.'/pro-version.jpg" /></a>';

		$boxes[] = array(
			'content' => $pro_box,
			'css' => 'border: none; padding: 0; background: none;'
		);

		$free_woocommerce_box = '<a href="https://profiles.wordpress.org/a3rev/#content-plugins" target="_blank" alt="'.__('Free WooCommerce Plugins', 'woocommerce-compare-products' ).'"><img src="'.WOOCP_IMAGES_URL.'/free-woocommerce-plugins.jpg" /></a>';

		$boxes[] = array(
			'content' => $free_woocommerce_box,
			'css' => 'border: none; padding: 0; background: none;'
		);

		$free_wordpress_box = '<a href="https://profiles.wordpress.org/a3rev/#content-plugins" target="_blank" alt="'.__('Free WordPress Plugins', 'woocommerce-compare-products' ).'"><img src="'.WOOCP_IMAGES_URL.'/free-wordpress-plugins.png" /></a>';

		$boxes[] = array(
			'content' => $free_wordpress_box,
			'css' => 'border: none; padding: 0; background: none;'
		);

		$connect_box = '<div style="margin-bottom: 5px;">' . __('Connect with us via','woocommerce-compare-products' ) . '</div>';
		$connect_box .= '<a href="https://www.facebook.com/a3rev" target="_blank" alt="'.__('a3rev Facebook', 'woocommerce-compare-products' ).'" style="margin-right: 5px;"><img src="'.WOOCP_IMAGES_URL.'/follow-facebook.png" /></a> ';
		$connect_box .= '<a href="https://twitter.com/a3rev" target="_blank" alt="'.__('a3rev Twitter', 'woocommerce-compare-products' ).'"><img src="'.WOOCP_IMAGES_URL.'/follow-twitter.png" /></a>';

		$boxes[] = array(
			'content' => $connect_box,
			'css' => 'border-color: #3a5795;'
		);

		return $boxes;
	}
	
	public static function plugin_extra_links($links, $plugin_name) {
		if ( $plugin_name != WOOCP_NAME) {
			return $links;
		}

		$links[] = '<a href="'.$GLOBALS[WOOCP_PREFIX.'admin_init']->support_url.'" target="_blank">'.__('Support', 'woocommerce-compare-products' ).'</a>';
		return $links;
	}

	public static function settings_plugin_links($actions) {
		$actions = array_merge( array( 'settings' => '<a href="admin.php?page=woo-compare-settings">' . __( 'Settings', 'woocommerce-compare-products' ) . '</a>' ), $actions );

		return $actions;
	}
}

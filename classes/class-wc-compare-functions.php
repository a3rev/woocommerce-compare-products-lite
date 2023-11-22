<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Functions
 *
 * Table Of Contents
 *
 * plugins_loaded()
 * get_variations()
 * get_variation_name()
 * get_product_url()
 * check_product_activate_compare()
 * check_product_have_cat()
 * add_product_to_compare_list()
 * get_compare_list()
 * get_total_compare_list()
 * delete_product_on_compare_list()
 * woocp_the_product_price()
 * get_compare_list_html_widget()
 * get_compare_list_html_popup()
 * get_post_thumbnail()
 * printPage()
 * create_page()
 * plugin_pro_notice()
 */

namespace A3Rev\WCCompare;

class Functions 
{
	
	/** 
	 * Set global variable when plugin loaded
	 */
	public static function plugins_loaded() {
		global $product_compare_id;
		global $wpdb;
		$product_compare_id = get_option('product_compare_id');
		
		$page_data = null;
		if ($product_compare_id)
			$page_data = $wpdb->get_row( "SELECT ID, post_name FROM `" . $wpdb->posts . "` WHERE `post_content` LIKE '%[product_comparison_page]%' AND `ID` = '".$product_compare_id."' AND `post_type` = 'page' LIMIT 1" );
		
		if ( $page_data == null )
			$page_data = $wpdb->get_row( "SELECT ID, post_name FROM `" . $wpdb->posts . "` WHERE `post_content` LIKE '%[product_comparison_page]%' AND `post_type` = 'page' ORDER BY ID DESC LIMIT 1" );
		
		$product_compare_id = $page_data->ID;
	}
	
	/**
	 * Get all compare cats
	 */
	public static function get_all_compare_cats( $parent = 0, $append_str = '' ) {
		
		$compare_cats = array();
		$all_product_cats = get_terms( 'product_cat', array( 'hide_empty' => false, 'parent' => $parent ) );

		if ( ! empty( $all_product_cats ) && !is_wp_error( $all_product_cats ) ) {
			foreach ( $all_product_cats as $cat ) {
				$cat->name = $append_str . $cat->name;
				$compare_cats[] = $cat;
				
				$compare_cats = array_merge( $compare_cats, self::get_all_compare_cats( $cat->term_id, $append_str . '&ndash; ' ) );
			}
		}
		
		return $compare_cats;
	}

	/**
	 * Get variations or child product from variable product and grouped product
	 */
	public static function get_variations($product_id) {
		$product_avalibale = array();
		$terms = wp_get_object_terms( $product_id, 'product_type', array('fields' => 'names') );

		// If it is variable product
		if (sanitize_title($terms[0]) == 'variable') {
			$attributes = (array) maybe_unserialize( get_post_meta($product_id, '_product_attributes', true) );

			// See if any are set
			$variation_attribute_found = false;
			if ($attributes) foreach ($attributes as $attribute) {
					if (isset($attribute['is_variation'])) :
						$variation_attribute_found = true;
					break;
					endif;
				}
			if ($variation_attribute_found) {
				$args = array(
					'post_type' => 'product_variation',
					'post_status' => array('publish'),
					'numberposts' => -1,
					'orderby' => 'id',
					'order' => 'asc',
					'post_parent' => $product_id
				);
				$variations = get_posts($args);
				if ($variations) {
					foreach ($variations as $variation) {
						if (self::check_product_activate_compare($variation->ID) && self::check_product_have_cat($variation->ID)) {
							$product_avalibale[] = $variation->ID;
						}
					}
				}
			}
		}
		// If it is grouped product
		elseif (sanitize_title($terms[0]) == 'grouped') {
			$args = array(
				'post_type' => 'product',
				'post_status' => array('publish'),
				'numberposts' => -1,
				'orderby' => 'id',
				'order' => 'asc',
				'post_parent' => $product_id
			);
			$variations = get_posts($args);
			if ($variations) {
				foreach ($variations as $variation) {
					if (self::check_product_activate_compare($variation->ID) && self::check_product_have_cat($variation->ID)) {
						$product_avalibale[] = $variation->ID;
					}
				}
			}
		}

		return $product_avalibale;
	}

	/**
	 * Get variation name from variation id
	 */
	public static function get_variation_name($variation_id) {
		$mypost = get_post($variation_id);
		$product_name = '';
		if ($mypost != NULL) {
			if ($mypost->post_type == 'product_variation') {
				$attributes = (array) maybe_unserialize(get_post_meta($mypost->post_parent, '_product_attributes', true));
				$my_variation = new \WC_Product_Variation($variation_id, $mypost->post_parent);

				$variation_data = $my_variation->get_variation_attributes();
				$variation_name = '';
				if (is_array($attributes) && count($attributes) > 0) {
					foreach ($attributes as $attribute) {
						if ( !$attribute['is_variation'] ) continue;
						$taxonomy = 'attribute_' . sanitize_title($attribute['name']);
						if (isset($variation_data[$taxonomy])) {
							if (taxonomy_exists(sanitize_title($attribute['name']))) {
								$term = get_term_by('slug', $variation_data[$taxonomy], sanitize_title($attribute['name']));
								if (!is_wp_error($term) && isset($term->name) && $term->name != '') {
									$value = $term->name;
									$variation_name .= ' '.$value;
								}
							}else {
								$variation_name .= ' '. wc_clean( $variation_data[$taxonomy] );
							}
						}

					}
				}

				$product_name = get_the_title($mypost->post_parent).' -'.$variation_name;
			}else {
				$product_name = get_the_title($variation_id);
			}
		}

		return $product_name;
	}

	/**
	 * Get product url
	 */
	public static function get_product_url($product_id) {
		$product = wc_get_product( $product_id );

		$product_url = $product->get_permalink();

		return $product_url;
	}

	/**
	 * check product or variation is deactivated or activated
	 */
	public static function check_product_activate_compare($product_id) {
		if (get_post_meta( $product_id, '_woo_deactivate_compare_feature', true ) != 'yes') {
			return true;
		}else {
			return false;
		}
	}

	/**
	 * Check product that is assigned the compare category for it
	 */
	public static function check_product_have_cat( $product_id ) {
		$compare_category = get_post_meta( $product_id, '_woo_compare_category', true );
		if ($compare_category > 0 && Data\Categories::get_count("id='".$compare_category."'") > 0) {
			$compare_fields = Data\Categories_Fields::get_fieldid_results($compare_category);
			if (is_array($compare_fields) && count($compare_fields)>0) {
				return true;
			}else {
				return false;
			}
		}else {
			return false;
		}
	}

	/**
	 * Add a product or variations of product into compare widget list
	 */
	public static function add_product_to_compare_list($product_id) {
		$product_list = self::get_variations($product_id);
		if (count($product_list) < 1 && self::check_product_activate_compare($product_id) && self::check_product_have_cat($product_id)) $product_list = array($product_id);
		if (is_array($product_list) && count($product_list) > 0) {
			if (isset($_COOKIE['woo_compare_list']))
				$current_compare_list = (array) unserialize($_COOKIE['woo_compare_list']);
			else
				$current_compare_list = array();
			foreach ($product_list as $product_add) {
				if (!in_array($product_add, $current_compare_list)) {
					$current_compare_list[] = (int)$product_add;
				}
			}
			
			setcookie( "woo_compare_list", serialize($current_compare_list), 0, COOKIEPATH, COOKIE_DOMAIN, false, true );
		}
	}

	/**
	 * Get list product ids , variation ids
	 */
	public static function get_compare_list() {
		if (isset($_COOKIE['woo_compare_list']))
			$current_compare_list = (array) unserialize($_COOKIE['woo_compare_list']);
		else
			$current_compare_list = array();
		$return_compare_list = array();
		if (is_array($current_compare_list) && count($current_compare_list) > 0) {
			foreach ($current_compare_list as $product_id) {
				if (self::check_product_activate_compare($product_id)) {
					$return_compare_list[] = (int)$product_id;
				}
			}
		}
		return $return_compare_list;
	}

	/**
	 * Get total products in complare list
	 */
	public static function get_total_compare_list() {
		if (isset($_COOKIE['woo_compare_list']))
			$current_compare_list = (array) unserialize($_COOKIE['woo_compare_list']);
		else
			$current_compare_list = array();
		$return_compare_list = array();
		if (is_array($current_compare_list) && count($current_compare_list) > 0) {
			foreach ($current_compare_list as $product_id) {
				if (self::check_product_activate_compare($product_id)) {
					$return_compare_list[] = (int)$product_id;
				}
			}
		}
		return count($return_compare_list);
	}

	/**
	 * Remove a product out compare list
	 */
	public static function delete_product_on_compare_list($product_id) {
		if (isset($_COOKIE['woo_compare_list']))
			$current_compare_list = (array) unserialize($_COOKIE['woo_compare_list']);
		else
			$current_compare_list = array();
		$key = array_search($product_id, $current_compare_list);
		unset($current_compare_list[$key]);
		setcookie( "woo_compare_list", serialize($current_compare_list), 0, COOKIEPATH, COOKIE_DOMAIN, false, true );
	}

	/**
	 * Clear compare list
	 */
	public static function clear_compare_list() {
		setcookie( "woo_compare_list", serialize(array()), 0, COOKIEPATH, COOKIE_DOMAIN, false, true );
	}

	/**
	 * Get price of product, variation to show on popup compare
	 */
	public static function woocp_the_product_price( $product_id, $no_decimals = false, $only_normal_price = false ) {
		global $woo_query, $woo_variations, $wpdb;
		$price = $full_price = get_post_meta( $product_id, '_woo_price', true );

		if ( ! $only_normal_price ) {
			$special_price = get_post_meta( $product_id, '_woo_special_price', true );

			if ( ( $full_price > $special_price ) && ( $special_price > 0 ) )
				$price = $special_price;
		}

		if ( $no_decimals == true )
			$price = array_shift( explode( ".", $price ) );

		$price = apply_filters( 'woo_do_convert_price', $price );
		$args = array(
			'display_as_html' => false,
			'display_decimal_point' => ! $no_decimals
		);
		if ($price > 0) {
			$output = woo_currency_display( $price, $args );
			return $output;
		}
	}

	/**
	 * Get compare widget on sidebar
	 */
	public static function get_compare_list_html_widget() {
		global $product_compare_id;
		global $woo_compare_comparison_page_global_settings;
		$woo_compare_basket_icon = WOOCP_IMAGES_URL.'/compare_remove.png';
		$compare_list = self::get_compare_list();
		$html = '';
		if (is_array($compare_list) && count($compare_list)>0) {
			$html .= '<ul class="compare_widget_ul">';
			foreach ($compare_list as $product_id) {
				$thumbnail_html = '';
					$thumbnail_html = self::get_post_thumbnail($product_id, 64, 9999, 'woo_compare_widget_thumbnail');
					if (trim($thumbnail_html) == '') {
						$thumbnail_html = '<img class="woo_compare_widget_thumbnail" alt="" src="'. wc_placeholder_img_src() .'" />';
					}
				$html .= '<li class="compare_widget_item">';
				$html .= '<div class="compare_remove_column"><a class="woo_compare_remove_product" rel="'.$product_id.'"><img class="woo_compare_remove_icon" src="'.$woo_compare_basket_icon.'" /></a></div>';
				$html .= '<div class="compare_title_column"><a class="woo_compare_widget_item" href="'.self::get_product_url($product_id).'">'.$thumbnail_html.self::get_variation_name($product_id).'</a></div>';
				$html .= '<div style="clear:both;"></div></li>';
			}
			$html .= '</ul>';
			$html .= '<div class="compare_widget_action">';
			
			$widget_clear_all_custom_class = '';
			$widget_clear_all_text = __('Clear All', 'woocommerce-compare-products' );
			$widget_clear_all_class = 'woo_compare_clear_all_link';
			
			$clear_html = '<div style="clear:both"></div><div class="woo_compare_clear_all_container"><a class="woo_compare_clear_all '.$widget_clear_all_class.' '.$widget_clear_all_custom_class.'">'.$widget_clear_all_text.'</a></div><div style="clear:both"></div>';
						
			$widget_button_custom_class = '';
			$widget_button_text = __('Compare', 'woocommerce-compare-products' );
			$widget_button_class = 'woo_compare_widget_button_go';
			
			$product_compare_page = get_permalink($product_compare_id);
			if ($woo_compare_comparison_page_global_settings['open_compare_type'] != 'new_page') {
				$product_compare_page = '#';
			}
			
			$widget_compare_popup_button = '';
			if ( $woo_compare_comparison_page_global_settings['open_compare_type'] != 'new_page' ) $widget_compare_popup_button = 'woo_compare_popup_button_go';
			
			$html .= '<div class="woo_compare_widget_button_container"><a class="woo_compare_button_go '.$widget_compare_popup_button.' '.$widget_button_class.' '.$widget_button_custom_class.'" href="'.$product_compare_page.'" target="_blank" alt="" title="">'.$widget_button_text.'</a></div>';
			
			$html .= '<div style="clear:both"></div></div>';
		}else {
			$html .= '<div class="no_compare_list">'.__( 'Nothing to Compare Text', 'woocommerce-compare-products' ).'</div>';
		}
		return $html;
	}

	/**
	 * Get compare list on popup
	 */
	public static function get_compare_list_html_popup() {
		global $woo_compare_comparison_page_global_settings;
		$current_db_version = get_option( 'woocommerce_db_version', null );
		$compare_list = self::get_compare_list();
		$woo_compare_basket_icon = WOOCP_IMAGES_URL.'/compare_remove.png';
		$html = '';
		$product_cats = array();
		$products_fields = array();
		$products_prices = array();
		$custom_class = '';
		$add_to_cart_text = apply_filters( 'add_to_cart_text', __('Add to cart', 'woocommerce-compare-products' ) );
		$add_to_cart_button_class = 'add_to_cart_link_type';
		
		if (is_array($compare_list) && count($compare_list)>0) {
			$html .= '<div id="compare-wrapper"><div class="compare-products">';
			$html .= '<table id="product_comparison" class="compare_popup_table" border="1" bordercolor="#D6D6D6" cellpadding="5" cellspacing="0" width="">';
			$html .= '<tbody><tr class="row_1 row_product_detail"><th class="column_first first_row"><div class="column_first_wide">&nbsp;';
			$html .= '</div></th>';
			$i = 0;
			foreach ($compare_list as $product_id) {
				$product_cat = get_post_meta( $product_id, '_woo_compare_category', true );
				$products_fields[$product_id] = Data\Categories_Fields::get_fieldid_results($product_cat);
				if ($product_cat > 0) {
					$product_cats[] = $product_cat;
				}
				$i++;
				
				$current_product = wc_get_product($product_id);
				
				$product_name = self::get_variation_name($product_id);
				
				$product_price = $current_product->get_price_html();
				
				/**
				 * Add code check show or hide price and add to cart button support for Woo Catalog Visibility Options plugin
				 */
				$show_add_to_cart = true;
				if (class_exists('WC_CVO_Visibility_Options')) {
					global $wc_cvo;
					/**
					 * Check show or hide price
					 */
					 if (($wc_cvo->setting('wc_cvo_prices') == 'secured' && !catalog_visibility_user_has_access()) || $wc_cvo->setting('wc_cvo_prices') == 'disabled') {
						 $product_price = '';
					 }
					 
					 /**
					 * Check show or hide add to cart button
					 */
					 if (($wc_cvo->setting('wc_cvo_atc') == 'secured' && !catalog_visibility_user_has_access()) || $wc_cvo->setting('wc_cvo_atc') == 'disabled') {
						 $show_add_to_cart = false;
					 }
				}
				$products_prices[$product_id] = $product_price;
				$image_src = self::get_post_thumbnail($product_id, 220, 180, 'compare_product_image');
				if (trim($image_src) == '') {
					$image_src = '<img class="compare_product_image" alt="'.$product_name.'" src="'. wc_placeholder_img_src() .'" />';
				}
				$html .= '<td class="first_row column_'.$i.'"><div class="td-spacer"><div class="woo_compare_popup_remove_product_container"><a class="woo_compare_popup_remove_product" rel="'.$product_id.'" style="cursor:pointer;">Remove <img src="'.$woo_compare_basket_icon.'" border=0 /></a></div>';
				$html .= '<div class="compare_image_container">'.$image_src.'</div>';
				$html .= '<div class="compare_product_name">'.$product_name.'</div>';
				$html .= '<div class="compare_price">'.$products_prices[$product_id].'</div>';
					if ( $show_add_to_cart && $current_product->is_in_stock() ) {
						if ( ! $current_product->is_type( 'external' ) ) {
							$cart_url = add_query_arg( array( 'post_type' => 'product', 'add-to-cart' => $product_id ), get_permalink( $product_id ) );
						} else if ( $current_product->is_type( 'external' ) ) {
							$cart_url = $current_product->get_product_url();
							$add_to_cart_text_external = $current_product->get_button_text();
						}
						switch (get_post_type($product_id)) :
							case "product_variation" :
								$class 	= 'is_variation';
								$cart_url = self::get_product_url($product_id);
								break;
							default :
								$class  = 'simple ajax_add_to_cart';
								break;
						endswitch;
						$html .= '<div class="compare_add_cart">';
						if ( $current_product->is_type( 'external' ) ) {
							$html .= sprintf('<a href="%s" rel="nofollow" class="button add_to_cart_button %s product_type_%s %s" target="_blank">%s</a>', $cart_url, $add_to_cart_button_class, $class, $custom_class, $add_to_cart_text_external);
						} else {
							$html .= sprintf('<a href="%s" data-product_id="%s" class="button add_to_cart_button %s product_type_%s %s" target="_blank">%s</a>', $cart_url, $product_id, $add_to_cart_button_class, $class, $custom_class, $add_to_cart_text);
						}
						$html .= '<a class="virtual_added_to_cart" href="#">&nbsp;</a>';
						$html .= '</div>';
					}
				$html .= '</div></td>';
			}
			$html .= '</tr>';
			$product_cats = implode(",", $product_cats);
			$compare_fields = Data\Categories_Fields::get_results('cat_id IN('.$product_cats.')', 'cf.cat_id ASC, cf.field_order ASC');
			if (is_array($compare_fields) && count($compare_fields)>0) {
				$j = 1;
				foreach ($compare_fields as $field_data) {
					$j++;
					$html .= '<tr class="row_'.$j.'">';
					if (trim($field_data->field_unit) != '')
						$html .= '<th class="column_first"><div class="compare_value">'.stripslashes($field_data->field_name).' ('.trim(stripslashes($field_data->field_unit)).')</div></th>';
					else
						$html .= '<th class="column_first"><div class="compare_value">'.stripslashes($field_data->field_name).'</div></th>';
					$i = 0;
					foreach ($compare_list as $product_id) {
						$i++;
						$empty_cell_class = '';
						$empty_text_class = '';
						if (in_array($field_data->id, $products_fields[$product_id])) {
							$field_value = get_post_meta( $product_id, '_woo_compare_'.$field_data->field_key, true );
							if (is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
							if (is_array($field_value) && count($field_value) > 0) $field_value = implode(', ', $field_value);
							elseif (is_array($field_value) && count($field_value) < 0) $field_value = '';
						}else {
							$field_value = '';
						}
						if ($field_value == '') {
							$empty_cell_class = 'empty_cell';
							$empty_text_class = 'empty_text';
						}
						$html .= '<td class="column_'.$i.' '.$empty_cell_class.'"><div class="td-spacer '.$empty_text_class.' compare_'.$field_data->field_key.'">'.$field_value.'</div></td>';
					}
					$html .= '</tr>';
					if ($j==2) $j=0;
				}
				
					$j++;
					if ($j>2) $j=1;
					$html .= '<tr class="row_'.$j.' row_end"><th class="column_first">&nbsp;</th>';
					$i = 0;
					foreach ($compare_list as $product_id) {
						$i++;
						$html .= '<td class="column_'.$i.'">';
						$html .= '<div class="td-spacer compare_price">'.$products_prices[$product_id].'</div>';
						$html .= '</td>';
					}
			}
			$html .= '</tbody></table>';
			$html .= '</div></div>';
		}else {
			$html .= '<div class="no_compare_list">'.$woo_compare_comparison_page_global_settings['no_product_message_text'].'</div>';
		}
		return $html;
	}

	public static function get_post_thumbnail($postid=0, $width=220, $height=180, $class='') {
		$mediumSRC = '';
		// Get the product ID if none was passed
		if ( empty( $postid ) )
			$postid = get_the_ID();

		// Load the product
		$product = get_post( $postid );

		if (has_post_thumbnail($postid)) {
			$thumbid = get_post_thumbnail_id($postid);
			$attachmentArray = wp_get_attachment_image_src($thumbid, array(0 => $width, 1 => $height), false);
			$mediumSRC = $attachmentArray[0];
			if (trim($mediumSRC != '')) {
				return '<img class="'.$class.'" src="'.$mediumSRC.'" />';
			}
		}
		if (trim($mediumSRC == '')) {
			$args = array( 'post_parent' => $postid , 'numberposts' => 1, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'DESC', 'orderby' => 'ID', 'post_status' => null);
			$attachments = get_posts($args);
			if ($attachments) {
				foreach ( $attachments as $attachment ) {
					$mediumSRC = wp_get_attachment_image( $attachment->ID, array(0 => $width, 1 => $height), true, array('class' => $class) );
					break;
				}
			}
		}

		if (trim($mediumSRC == '')) {
			// Get ID of parent product if one exists
			if ( !empty( $product->post_parent ) )
				$postid = $product->post_parent;

			if (has_post_thumbnail($postid)) {
				$thumbid = get_post_thumbnail_id($postid);
				$attachmentArray = wp_get_attachment_image_src($thumbid, array(0 => $width, 1 => $height), false);
				$mediumSRC = $attachmentArray[0];
				if (trim($mediumSRC != '')) {
					return '<img class="'.$class.'" src="'.$mediumSRC.'" />';
				}
			}
			if (trim($mediumSRC == '')) {
				$args = array( 'post_parent' => $postid , 'numberposts' => 1, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'DESC', 'orderby' => 'ID', 'post_status' => null);
				$attachments = get_posts($args);
				if ($attachments) {
					foreach ( $attachments as $attachment ) {
						$mediumSRC = wp_get_attachment_image( $attachment->ID, array(0 => $width, 1 => $height), true, array('class' => $class) );
						break;
					}
				}
			}
		}
		return $mediumSRC;
	}
		
	public static function printPage($link, $total = 0,$currentPage = 1,$div = 3,$rows = 5, $li = false, $a_class= ''){
		if(!$total || !$rows || !$div || $total<=$rows) return false;
		$nPage = floor($total/$rows) + (($total%$rows)?1:0);
		$nDiv  = floor($nPage/$div) + (($nPage%$div)?1:0);	
		$currentDiv = floor(($currentPage-1)/$div) ;	
		$sPage = '';	
		if($currentDiv) {	
			if($li){
				$sPage .= '<li><span class="pagenav"><a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', 1, $link).'">&laquo;</a></span></li>';	
				$sPage .= '<li><span class="pagenav"><a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', $currentDiv*$div, $link).'">'.__("Back", 'woocommerce-compare-products' ).'</a></span></li>';	
			}else{
				$sPage .= '<a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', 1, $link).'">&laquo;</a> ';	
				$sPage .= '<a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', $currentDiv*$div, $link).'">'.__("Back", 'woocommerce-compare-products' ).'</a> ';	
			}
		}
		$count =($nPage<=($currentDiv+1)*$div)?($nPage-$currentDiv*$div):$div;	
		for($i=1;$i<=$count;$i++){	
			$page = ($currentDiv*$div + $i);	
			if($li){
				$sPage .= '<li '.(($page==$currentPage)? 'class="current"':'class="page-numbers"').'><span class="pagenav"><a title="" href="'.add_query_arg('pp', ($currentDiv*$div + $i ), $link).'" '.(($page==$currentPage)? 'class="current '.$a_class.'"':'class="page-numbers '.$a_class.'"').'>'.$page.'</a></span></li>';
			}else{
				$sPage .= '<a title="" href="'.add_query_arg('pp', ($currentDiv*$div + $i ), $link).'" '.(($page==$currentPage)? 'class="current '.$a_class.'"':'class="page-numbers '.$a_class.'"').'>'.$page.'</a> ';
			}
		}	
		if($currentDiv < $nDiv - 1){	
			if($li){	
				$sPage .= '<li><span class="pagenav"><a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', ((($currentDiv+1)*$div)+1), $link).'">'.__("Next", 'woocommerce-compare-products' ).'</a></span></li>';	
				$sPage .= '<li><span class="pagenav"><a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', (($nDiv*$div )-2), $link).'">&raquo;</a></span></li>';	
			}else{
				$sPage .= '<a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', ((($currentDiv+1)*$div)+1), $link).'">'.__("Next", 'woocommerce-compare-products' ).'</a> ';	
				$sPage .= '<a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', (($nDiv*$div )-2), $link).'">&raquo;</a>';	
			}
		}	
		return 	$sPage;	
	}
	
	/**
	 * Create Page
	 */
	public static function create_page( $slug, $option, $page_title = '', $page_content = '', $post_parent = 0 ) {
		global $wpdb;
				
		$page_id = $wpdb->get_var( "SELECT ID FROM `" . $wpdb->posts . "` WHERE `post_content` LIKE '%$page_content%'  AND `post_type` = 'page' ORDER BY ID DESC LIMIT 1" );
		 
		if ( $page_id != NULL ) 
			return $page_id;
		
		$page_data = array(
			'post_status' 		=> 'publish',
			'post_type' 		=> 'page',
			'post_author' 		=> 1,
			'post_name' 		=> $slug,
			'post_title' 		=> $page_title,
			'post_content' 		=> $page_content,
			'post_parent' 		=> $post_parent,
			'comment_status' 	=> 'closed'
		);
		$page_id = wp_insert_post( $page_data );
		
		return $page_id;
	}
}

<?php
/**
 * WooCommerce Compare Meta Box
 *
 * Add Meta box into Product Edit screen page
 *
 * Table Of Contents
 *
 * compare_meta_boxes()
 * woocp_product_get_fields()
 * woo_compare_feature_box()
 * woo_show_field_of_cat()
 * woo_variations_compare_feature_box()
 * woo_variation_show_field_of_cat()
 * woocp_get_variation_compare()
 * woocp_variation_get_fields()
 * variable_compare_meta_boxes()
 * save_compare_meta_boxes()
 */

namespace A3Rev\WCCompare;

class MetaBox 
{
	public static function compare_meta_boxes() {
		global $post;
		$pagename = 'product';
		add_meta_box( 'woo_compare_feature_box', __('Compare Feature Fields', 'woocommerce-compare-products' ), array(__CLASS__, 'woo_compare_feature_box'), $pagename, 'side', 'high'
			, array( 
				'__block_editor_compatible_meta_box' => true,
				'__back_compat_meta_box' => false,
			) );
	}

	public static function woocp_product_get_fields() {
		check_ajax_referer( 'woocp-product-compare', 'security' );
		$cat_id = absint( $_REQUEST['cat_id'] );
		$post_id = absint( $_REQUEST['post_id'] );
		self::woo_show_field_of_cat($post_id, $cat_id);
		die();
	}

	public static function woo_compare_feature_box() {
		$woocp_product_compare = wp_create_nonce("woocp-product-compare");
		global $post;
		$post_id = $post->ID;
		$deactivate_compare_feature = get_post_meta( $post_id, '_woo_deactivate_compare_feature', true );
		$compare_category = get_post_meta( $post_id, '_woo_compare_category', true );
?>
        <script type="text/javascript">
		(function($){
			$(function(){
				$(document).on('click', '.deactivate_compare_feature', function(){
					if ($(this).is(':checked')) {
						$(this).siblings(".compare_feature_activate_form").show();
					} else {
						$(this).siblings(".compare_feature_activate_form").hide();
					}
				});
				$("#compare_category").on('change', function(){
					var cat_id = $(this).val();
					var post_id = <?php echo $post_id; ?>;
					$(".compare_widget_loader").show();
					var data = {
                        action: 'woocp_product_get_fields',
                        cat_id: cat_id,
                        post_id: post_id,
                        security: '<?php echo $woocp_product_compare; ?>'
                    };
                    $.post('<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>', data, function(response) {
						$(".compare_widget_loader").hide();
						$("#compare_cat_fields").html(response);
					});
				});
			});
		})(jQuery);
		</script>
        <input id='deactivate_compare_feature' type='checkbox' value='no' <?php if ( $deactivate_compare_feature == 'no' ) echo 'checked="checked"'; else echo ''; ?> name='_woo_deactivate_compare_feature' class="deactivate_compare_feature" style="float:none; width:auto; display:inline-block;" />
		<label style="display:inline-block" for='deactivate_compare_feature' class='small'><?php _e( "Activate Compare Feature for this Product", 'woocommerce-compare-products' ); ?></label>
        <div class="compare_feature_activate_form" style=" <?php if ( $deactivate_compare_feature == 'yes') { echo 'display:none;';} ?>">
            <p><label style="display:inline-block" for='compare_category' class='small'><?php _e( "Select a  Compare Category for this Product", 'woocommerce-compare-products' ); ?></label> :
                <select name="_woo_compare_category" id="compare_category" style="width:200px;">
                    <option value="0"><?php _e('Select...', 'woocommerce-compare-products' ); ?></option>
            <?php
            $compare_cats = Data\Categories::get_results('', 'category_order ASC');
            if (is_array($compare_cats) && count($compare_cats)>0) {
                foreach ($compare_cats as $cat_data) {
                    if ($compare_category == $cat_data->id) {
                        echo '<option selected="selected" value="'.$cat_data->id.'">'.stripslashes($cat_data->category_name).'</option>';
                    }else {
                        echo '<option value="'.$cat_data->id.'">'.stripslashes($cat_data->category_name).'</option>';
                    }
                }
            }
    ?>
                </select> <img class="compare_widget_loader" style="display:none;" src="<?php echo WOOCP_IMAGES_URL; ?>/ajax-loader.gif" border=0 />
            </p>
            <div id="compare_cat_fields"><?php self::woo_show_field_of_cat($post_id, $compare_category); ?></div>
		</div>                
	<?php
	}

	public static function woo_show_field_of_cat($post_id=0, $cat_id=0) {
		if ($cat_id > 0 && Data\Categories::get_count("id='".$cat_id."'") > 0) {
?>
    	<style>
			.comparison_category_features_data { border: none !important;}
			.comparison_category_features_data th{padding:5px 5px 5px 0px !important;}
			.comparison_category_features_data td input[type="checkbox"],
			.comparison_category_features_data td input[type="radio"] {
				min-width: 16px !important;
			}
			@media screen and ( max-width: 782px ) {
				.comparison_category_features_data textarea, .comparison_category_features_data input[type="text"], .comparison_category_features_data input[type="email"], .comparison_category_features_data input[type="number"], .comparison_category_features_data input[type="password"], .comparison_category_features_data select {
					width: 100% !important;	
				}
			}
		</style>
        <table cellspacing="0" cellpadding="5" style="width: 100%;" class="form-table comparison_category_features_data">
            <tbody>
        <?php
			$compare_fields = Data\Categories_Fields::get_results("cat_id='".$cat_id."'", 'cf.field_order ASC');
			if (is_array($compare_fields) && count($compare_fields)>0) {

				foreach ($compare_fields as $field_data) {
?>
                <tr class="form-field">
                    <th valign="top" scope="row"><label style="display:inline-block" for="<?php echo $field_data->field_key; ?>"><strong><?php echo stripslashes($field_data->field_name); ?> : </strong></label><?php if (trim($field_data->field_unit) != '') { ?><br />(<?php echo trim(stripslashes($field_data->field_unit)); ?>)<?php } ?></th>
                    <td>
               	<?php
					$field_value = get_post_meta( $post_id, '_woo_compare_'.$field_data->field_key, true );
					switch ($field_data->field_type) {
					case "text-area":
						echo '<textarea style="width:400px" name="_woo_compare_'.$field_data->field_key.'" id="'.$field_data->field_key.'">'.$field_value.'</textarea>';
						break;

					case "checkbox":
						$default_value = nl2br($field_data->default_value);
						$field_option = explode('<br />', $default_value);
						if (is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
						if (!is_array($field_value)) $field_value = array();
						if (is_array($field_option) && count($field_option) > 0) {
							foreach ($field_option as $option_value) {
								$option_value = trim(stripslashes($option_value));
								if (in_array($option_value, $field_value)) {
									echo '<input type="checkbox" name="_woo_compare_'.$field_data->field_key.'[]" value="'.esc_attr($option_value).'" checked="checked" style="float:none; width:auto; display:inline-block;" /> '.esc_attr( $option_value ).' &nbsp;&nbsp;&nbsp;';
								}else {
									echo '<input type="checkbox" name="_woo_compare_'.$field_data->field_key.'[]" value="'.esc_attr($option_value).'" style="float:none; width:auto; display:inline-block;" /> '.esc_attr( $option_value ).' &nbsp;&nbsp;&nbsp;';
								}
							}
						}
						break;

					case "radio":
						$default_value = nl2br($field_data->default_value);
						$field_option = explode('<br />', $default_value);
						if (is_array($field_option) && count($field_option) > 0) {
							foreach ($field_option as $option_value) {
								$option_value = trim(stripslashes($option_value));
								if ($option_value == $field_value) {
									echo '<input type="radio" name="_woo_compare_'.$field_data->field_key.'" value="'.esc_attr($option_value).'" checked="checked" style="float:none; width:auto; display:inline-block;" /> '.esc_attr( $option_value ).' &nbsp;&nbsp;&nbsp;';
								}else {
									echo '<input type="radio" name="_woo_compare_'.$field_data->field_key.'" value="'.esc_attr($option_value).'" style="float:none; width:auto; display:inline-block;" /> '.esc_attr( $option_value ).' &nbsp;&nbsp;&nbsp;';
								}
							}
						}
						break;

					case "drop-down":
						$default_value = nl2br($field_data->default_value);
						$field_option = explode('<br />', $default_value);
						echo '<select name="_woo_compare_'.$field_data->field_key.'" id="'.$field_data->field_key.'" style="width:400px">';
						echo '<option value="">'.__( "Select value", 'woocommerce-compare-products' ).'</option>';
						if (is_array($field_option) && count($field_option) > 0) {
							foreach ($field_option as $option_value) {
								$option_value = trim(stripslashes($option_value));
								if ($option_value == $field_value) {
									echo '<option value="'.esc_attr($option_value).'" selected="selected">'.esc_attr( $option_value ).'</option>';
								}else {
									echo '<option value="'.esc_attr($option_value).'">'.esc_attr( $option_value ).'</option>';
								}
							}
						}
						echo '</select>';
						break;

					case "multi-select":
						$default_value = nl2br($field_data->default_value);
						$field_option = explode('<br />', $default_value);
						if (is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
						if (!is_array($field_value)) $field_value = array();
						echo '<select multiple="multiple" name="_woo_compare_'.$field_data->field_key.'[]" id="'.$field_data->field_key.'" style="width:400px">';
						if (is_array($field_option) && count($field_option) > 0) {
							foreach ($field_option as $option_value) {
								$option_value = trim(stripslashes($option_value));
								if (in_array($option_value, $field_value)) {
									echo '<option value="'.esc_attr($option_value).'" selected="selected">'.esc_attr( $option_value ).'</option>';
								}else {
									echo '<option value="'.esc_attr($option_value).'">'.esc_attr( $option_value ).'</option>';
								}
							}
						}
						echo '</select>';
						break;

					default:
						echo '<input style="width:400px" type="text" name="_woo_compare_'.$field_data->field_key.'" id="'.$field_data->field_key.'" value="'.esc_attr( $field_value ).'" />';
						break;
					}
?>
                    </td>
                </tr>
        <?php
				}
			}else {
?>
        		<tr><td><i style="text-decoration:blink"><?php _e('There are no Features created for this category, please add some.', 'woocommerce-compare-products' ); ?> <a href="admin.php?page=woo-compare-features" target="_blank"><?php _e('This page', 'woocommerce-compare-products' ); ?></a></i></td></tr>
        <?php
			}
?>
        	</tbody>
        </table>
		<?php
		}
	}

	public static function woo_variations_compare_feature_box($post_id) {
		$deactivate_compare_feature = get_post_meta( $post_id, '_woo_deactivate_compare_feature', true );
		$compare_category = get_post_meta( $post_id, '_woo_compare_category', true );
?>
	<div>
        <input id='deactivate_compare_feature_<?php echo $post_id; ?>' type='checkbox' value='no' <?php if ( $deactivate_compare_feature == 'no' ) echo 'checked="checked"'; else echo ''; ?> class="deactivate_compare_feature" name='variable_woo_deactivate_compare_feature[<?php echo $post_id; ?>]' style="float:none; width:auto; display:inline-block;" />
		<label style="display:inline-block" for='deactivate_compare_feature_<?php echo $post_id; ?>' class='small'><?php _e( "Activate Compare Feature for this Product", 'woocommerce-compare-products' ); ?></label>
        <div class="compare_feature_activate_form" style=" <?php if ( $deactivate_compare_feature == 'yes') { echo 'display:none;';} ?>">
            <p><label style="display:inline-block" for='variable_woo_compare_category_<?php echo $post_id; ?>' class='small'><?php _e( "Select a  Compare Category for this Product", 'woocommerce-compare-products' ); ?></label> :
                <select name="variable_woo_compare_category[<?php echo $post_id; ?>]" class="variable_compare_category" id="variable_woo_compare_category_<?php echo $post_id; ?>" style="width:200px;" rel="<?php echo $post_id; ?>">
                    <option value="0"><?php _e('Select...', 'woocommerce-compare-products' ); ?></option>
            <?php
            $compare_cats = Data\Categories::get_results('', 'category_order ASC');
            if (is_array($compare_cats) && count($compare_cats)>0) {
                foreach ($compare_cats as $cat_data) {
                    if ($compare_category == $cat_data->id) {
                        echo '<option selected="selected" value="'.$cat_data->id.'">'.stripslashes($cat_data->category_name).'</option>';
                    }else {
                        echo '<option value="'.$cat_data->id.'">'.stripslashes($cat_data->category_name).'</option>';
                    }
                }
            }
    ?>
                </select> <img id="variable_compare_widget_loader_<?php echo $post_id; ?>" style="display:none;" src="<?php echo WOOCP_IMAGES_URL; ?>/ajax-loader.gif" border=0 />
            </p>
            <div id="variable_compare_cat_fields_<?php echo $post_id; ?>"><?php self::woo_variation_show_field_of_cat($post_id, $compare_category); ?></div>
		</div>
	</div>
	<?php
	}

	public static function woo_variation_show_field_of_cat($post_id=0, $cat_id=0) {
		if ($cat_id > 0 && Data\Categories::get_count("id='".$cat_id."'") > 0) {
?>
    	<style>
			.comparison_category_features_data { border: none !important;}
			.comparison_category_features_data th{padding:5px 5px 5px 0px !important;}
			.comparison_category_features_data td input[type="checkbox"],
			.comparison_category_features_data td input[type="radio"] {
				min-width: 16px !important;
			}
		</style>
        <table cellspacing="0" cellpadding="5" style="width: 100%;" class="form-table comparison_category_features_data">
            <tbody>
        <?php
			$compare_fields = Data\Categories_Fields::get_results("cat_id='".$cat_id."'", 'cf.field_order ASC');
			if (is_array($compare_fields) && count($compare_fields)>0) {

				foreach ($compare_fields as $field_data) {
?>
                <tr class="form-field">
                    <th valign="top" scope="row"><label style="display:inline-block" for="<?php echo $field_data->field_key; ?>_<?php echo $post_id; ?>"><strong><?php echo stripslashes($field_data->field_name); ?> : </strong></label><?php if (trim($field_data->field_unit) != '') { ?><br /> (<?php echo trim(stripslashes($field_data->field_unit)); ?>)<?php } ?></th>
                    <td>
               	<?php
					$field_value = get_post_meta( $post_id, '_woo_compare_'.$field_data->field_key, true );
					switch ($field_data->field_type) {
					case "text-area":
						echo '<textarea style="width:400px" name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.']" id="'.$field_data->field_key.'_'.$post_id.'">'.$field_value.'</textarea>';
						break;

					case "checkbox":
						$default_value = nl2br($field_data->default_value);
						$field_option = explode('<br />', $default_value);
						if (is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
						if (!is_array($field_value)) $field_value = array();
						if (is_array($field_option) && count($field_option) > 0) {
							foreach ($field_option as $option_value) {
								$option_value = trim(stripslashes($option_value));
								if (in_array($option_value, $field_value)) {
									echo '<input type="checkbox" name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.'][]" value="'.esc_attr($option_value).'" checked="checked" style="float:none; width:auto; display:inline-block;" /> '.esc_attr( $option_value ).' &nbsp;&nbsp;&nbsp;';
								}else {
									echo '<input type="checkbox" name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.'][]" value="'.esc_attr($option_value).'" style="float:none; width:auto; display:inline-block;" /> '.esc_attr( $option_value ).' &nbsp;&nbsp;&nbsp;';
								}
							}
						}
						break;

					case "radio":
						$default_value = nl2br($field_data->default_value);
						$field_option = explode('<br />', $default_value);
						if (is_array($field_option) && count($field_option) > 0) {
							foreach ($field_option as $option_value) {
								$option_value = trim(stripslashes($option_value));
								if ($option_value == $field_value) {
									echo '<input type="radio" name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.']" value="'.esc_attr($option_value).'" checked="checked" style="float:none; width:auto; display:inline-block;" /> '.esc_attr( $option_value ).' &nbsp;&nbsp;&nbsp;';
								}else {
									echo '<input type="radio" name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.']" value="'.esc_attr($option_value).'" style="float:none; width:auto; display:inline-block;" /> '.esc_attr( $option_value ).' &nbsp;&nbsp;&nbsp;';
								}
							}
						}
						break;

					case "drop-down":
						$default_value = nl2br($field_data->default_value);
						$field_option = explode('<br />', $default_value);
						echo '<select name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.']" id="'.$field_data->field_key.'_'.$post_id.'" style="width:400px">';
						echo '<option value="">'.__( "Select value", 'woocommerce-compare-products' ).'</option>';
						if (is_array($field_option) && count($field_option) > 0) {
							foreach ($field_option as $option_value) {
								$option_value = trim(stripslashes($option_value));
								if ($option_value == $field_value) {
									echo '<option value="'.esc_attr($option_value).'" selected="selected">'.esc_attr( $option_value ).'</option>';
								}else {
									echo '<option value="'.esc_attr($option_value).'">'.esc_attr( $option_value ).'</option>';
								}
							}
						}
						echo '</select>';
						break;

					case "multi-select":
						$default_value = nl2br($field_data->default_value);
						$field_option = explode('<br />', $default_value);
						if (is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
						if (!is_array($field_value)) $field_value = array();
						echo '<select multiple="multiple" name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.'][]" id="'.$field_data->field_key.'_'.$post_id.'" style="width:400px">';
						if (is_array($field_option) && count($field_option) > 0) {
							foreach ($field_option as $option_value) {
								$option_value = trim(stripslashes($option_value));
								if (in_array($option_value, $field_value)) {
									echo '<option value="'.esc_attr($option_value).'" selected="selected">'.esc_attr( $option_value ).'</option>';
								}else {
									echo '<option value="'.esc_attr($option_value).'">'.esc_attr( $option_value ).'</option>';
								}
							}
						}
						echo '</select>';
						break;

					default:
						echo '<input style="width:400px" type="text" name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.']" id="'.$field_data->field_key.'_'.$post_id.'" value="'.esc_attr( $field_value ).'" />';
						break;
					}
?>
                    </td>
                </tr>
        <?php
				}
			}else {
?>
        		<tr><td><i style="text-decoration:blink"><?php _e('There are no Features created for this category, please add some.', 'woocommerce-compare-products' ); ?> <a href="admin.php?page=woo-compare-features" target="_blank"><?php _e('This page', 'woocommerce-compare-products' ); ?></a></i></td></tr>
        <?php
			}
?>
        	</tbody>
        </table>
<?php
		}
	}

	public static function woocp_get_variation_compare() {
		check_ajax_referer( 'woocp-variable-compare', 'security' );
		$variation_id = absint( $_REQUEST['variation_id'] );
		echo self::woo_variations_compare_feature_box($variation_id);
		die();
	}

	public static function woocp_variation_get_fields() {
		check_ajax_referer( 'woocp-variable-compare', 'security' );
		$cat_id = absint( $_REQUEST['cat_id'] );
		$post_id = absint( $_REQUEST['post_id'] );
		self::woo_variation_show_field_of_cat($post_id, $cat_id);
		die();
	}

	public static function variable_compare_meta_boxes( $loop, $variation_data, $variation ) {
		self::woo_variations_compare_feature_box( $variation->ID );
	}

	public static function admin_include_variation_compare_scripts() {
		self::variable_compare_meta_boxes_scripts();
	}

	public static function variable_compare_meta_boxes_scripts() {
		global $post;
		$post_status = get_post_status($post->ID);
		$post_type = get_post_type($post->ID);
		if ($post_type == 'product' && $post_status != false) {
			$woocp_variable_compare = wp_create_nonce("woocp-variable-compare");

			ob_start();
?>
			jQuery(function(){

				jQuery(document).on("change", ".variable_compare_category", function(){
						var cat_id = jQuery(this).val();
						var post_id = jQuery(this).attr("rel");
						jQuery("#variable_compare_widget_loader_"+post_id).show();
						var data = {
							action: 'woocp_variation_get_fields',
							cat_id: cat_id,
							post_id: post_id,
							security: '<?php echo $woocp_variable_compare; ?>'
						};
						jQuery.post('<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>', data, function(response) {
							jQuery("#variable_compare_widget_loader_"+post_id).hide();
							jQuery("#variable_compare_cat_fields_"+post_id).html(response);
						});
				});
			});

<?php
			$javascript = ob_get_clean();

			wc_enqueue_js( $javascript );
		}
	}

	public static function save_compare_meta_boxes($post_id) {
		$post_status = get_post_status($post_id);
		$post_type = get_post_type($post_id);
		if ($post_type == 'product' && $post_status != false) {
			if (isset($_REQUEST['_woo_deactivate_compare_feature']) && $_REQUEST['_woo_deactivate_compare_feature'] == 'no') {
				update_post_meta($post_id, '_woo_deactivate_compare_feature', 'no');
			}else {
				update_post_meta($post_id, '_woo_deactivate_compare_feature', 'yes');
			}
			
			$compare_category = 0;
			if ( isset($_REQUEST['_woo_compare_category']) ) {
				$compare_category = sanitize_text_field( $_REQUEST['_woo_compare_category'] );
				update_post_meta( $post_id, '_woo_compare_category', $compare_category );
			}

			$category_data = Data\Categories::get_row($compare_category);
			if ( $category_data != NULL ) update_post_meta($post_id, '_woo_compare_category_name', stripslashes($category_data->category_name));

			$compare_fields = Data\Categories_Fields::get_results("cat_id='".$compare_category."'", 'cf.field_order ASC');
			if (is_array($compare_fields) && count($compare_fields)>0) {
				foreach ($compare_fields as $field_data) {
					if ( isset( $_REQUEST['_woo_compare_'.$field_data->field_key] ) ) {

						$attributes_data = $_REQUEST['_woo_compare_'.$field_data->field_key];
						if ( is_array( $attributes_data ) ) {
							$attributes_data = array_map( 'sanitize_text_field', $attributes_data );
						} else {
							$attributes_data = sanitize_text_field( $attributes_data );
						}
						update_post_meta($post_id, '_woo_compare_'.$field_data->field_key, $attributes_data );
					}
				}
			}

			if (isset($_REQUEST['variable_post_id'])) {
				$variable_ids = $_REQUEST['variable_post_id'];
				foreach ( $variable_ids as $variation_id ) {
					$variation_id = absint( $variation_id );
					$post_type = get_post_type($variation_id);
					if ($post_type == 'product_variation') {
						if ( isset( $_REQUEST['variable_woo_deactivate_compare_feature'][$variation_id] ) && $_REQUEST['variable_woo_deactivate_compare_feature'][$variation_id] == 'no' ) {
							update_post_meta($variation_id, '_woo_deactivate_compare_feature', 'no');
						} else {
							update_post_meta($variation_id, '_woo_deactivate_compare_feature', 'yes');
						}
						
						$variation_compare_category = 0;
						if ( isset($_REQUEST['variable_woo_compare_category'][$variation_id]) ) {
							$variation_compare_category = sanitize_text_field( $_REQUEST['variable_woo_compare_category'][$variation_id] );
							update_post_meta( $variation_id, '_woo_compare_category', $variation_compare_category );
						}

						$variation_category_data = Data\Categories::get_row($variation_compare_category);
						if ( $variation_category_data != NULL ) update_post_meta($variation_id, '_woo_compare_category_name', stripslashes($variation_category_data->category_name));

						$compare_fields = Data\Categories_Fields::get_results("cat_id='".$variation_compare_category."'", 'cf.field_order ASC');
						if (is_array($compare_fields) && count($compare_fields)>0) {
							foreach ($compare_fields as $field_data) {
								if ( isset( $_REQUEST['variable_woo_compare_'.$field_data->field_key][$variation_id] ) ) {

									$attributes_data = $_REQUEST['variable_woo_compare_'.$field_data->field_key][$variation_id];
									if ( is_array( $attributes_data ) ) {
										$attributes_data = array_map( 'sanitize_text_field', $attributes_data );
									} else {
										$attributes_data = sanitize_text_field( $attributes_data );
									}
									update_post_meta($variation_id, '_woo_compare_'.$field_data->field_key, $attributes_data);
								}
							}
						}
					}
				}
			}
		}
	}

	public static function save_product_variation( $variation_id, $i ) {
		if ( isset( $_POST['variable_woo_deactivate_compare_feature'][$variation_id] ) && $_POST['variable_woo_deactivate_compare_feature'][$variation_id] == 'no' ) {
			update_post_meta($variation_id, '_woo_deactivate_compare_feature', 'no');
		} else {
			update_post_meta($variation_id, '_woo_deactivate_compare_feature', 'yes');
		}

		$variation_compare_category = 0;
		if ( isset($_POST['variable_woo_compare_category'][$variation_id]) ) {
			$variation_compare_category = absint( $_POST['variable_woo_compare_category'][$variation_id] );
			update_post_meta( $variation_id, '_woo_compare_category', $variation_compare_category );
		}

		$variation_category_data = Data\Categories::get_row($variation_compare_category);
		if ( $variation_category_data != NULL ) update_post_meta($variation_id, '_woo_compare_category_name', stripslashes($variation_category_data->category_name));

		$compare_fields = Data\Categories_Fields::get_results("cat_id='".$variation_compare_category."'", 'cf.field_order ASC');
		if (is_array($compare_fields) && count($compare_fields)>0) {
			foreach ($compare_fields as $field_data) {
				if ( isset( $_POST['variable_woo_compare_'.$field_data->field_key][$variation_id] ) ) {

					$attributes_data = $_POST['variable_woo_compare_'.$field_data->field_key][$variation_id];
					if ( is_array( $attributes_data ) ) {
						$attributes_data = array_map( 'sanitize_text_field', $attributes_data );
					} else {
						$attributes_data = sanitize_text_field( $attributes_data );
					}

					update_post_meta($variation_id, '_woo_compare_'.$field_data->field_key, $attributes_data );
				}
			}
		}
	}
}

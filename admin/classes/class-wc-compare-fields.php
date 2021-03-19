<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Fields
 *
 * Table Of Contents
 *
 * init_features_actions()
 * woocp_features_manager()
 * woocp_features_orders()
 * woocp_update_orders()
 * features_search_area()
 */

namespace A3Rev\WCCompare\Admin;

use A3Rev\WCCompare;

class Fields 
{
	public static $default_types = array(
		'input-text' => array('name' => 'Input Text', 'description' => 'Use when option is single Line of Text'),
		'text-area' => array('name' => 'Text Area', 'description' => 'When option is Multiple lines of Text'),
		'checkbox' => array('name' => 'Check Box', 'description' => 'Options in a row allows multiple select'),
		'radio' => array('name' => 'Radio button', 'description' => 'Like check box but only single select'),
		'drop-down' => array('name' => 'Drop Down', 'description' => 'Options in dropdown, only select one'),
		'multi-select' => array('name' => 'Multi Select', 'description' => 'Like Drop Down but mutiple select'),
		'wp-video'	=> array('name' => 'Video Player', 'description' => 'Text Field to add Video URL'),
		'wp-audio'	=> array('name' => 'Audio Player', 'description' => 'Text Field to add Audio URL'),
	);
	
	public static function init_features_actions() {
		$result_msg = '';

		if (isset($_REQUEST['bt_save_field'])) {
			$field_name = trim(strip_tags(addslashes($_REQUEST['field_name'])));
			if (isset($_REQUEST['field_id']) && $_REQUEST['field_id'] > 0) {
				$field_id = absint( $_REQUEST['field_id'] );
				$count_field_name = WCCompare\Data::get_count("field_name = '".$field_name."' AND id != '".$field_id."'");
				if ($field_name != '' && $count_field_name == 0) {
					$result = WCCompare\Data::update_row($_REQUEST);
					if (isset($_REQUEST['field_cats']) && count((array)$_REQUEST['field_cats']) > 0) {
						foreach ($_REQUEST['field_cats'] as $cat_id) {
							$cat_id = absint( $cat_id );
							$check_existed = WCCompare\Data\Categories_Fields::get_count("cat_id='".$cat_id."' AND field_id='".$field_id."'");
							if ($check_existed == 0) {
								WCCompare\Data\Categories_Fields::insert_row($cat_id, $field_id);
							}
						}
						WCCompare\Data\Categories_Fields::delete_row("field_id='".$field_id."' AND cat_id NOT IN(".implode(',', array_map( 'absint', $_REQUEST['field_cats'] ) ).")");
					}else {
						WCCompare\Data\Categories_Fields::delete_row("field_id='".$field_id."'");
					}
					$result_msg = '<div class="updated" id="result_msg"><p>'.__('Compare Feature Successfully edited', 'woocommerce-compare-products' ).'.</p></div>';
				}else {
					$result_msg = '<div class="error" id="result_msg"><p>'.__('Nothing edited! You already have a Compare Feature with that name. Use the Features Search function to find it. Use unique names to edit each Compare Feature.', 'woocommerce-compare-products' ).'</p></div>';
				}
			}else {
				$count_field_name = WCCompare\Data::get_count("field_name = '".$field_name."'");
				if ($field_name != '' && $count_field_name == 0) {
					$field_id = WCCompare\Data::insert_row($_REQUEST);
					if ($field_id > 0) {
						WCCompare\Data\Categories_Fields::delete_row("field_id='".$field_id."'");
						if (isset($_REQUEST['field_cats']) && count((array)$_REQUEST['field_cats']) > 0) {
							foreach ($_REQUEST['field_cats'] as $cat_id) {
								WCCompare\Data\Categories_Fields::insert_row( absint( $cat_id ), $field_id);
							}
						}
						$result_msg = '<div class="updated" id="result_msg"><p>'.__('Compare Feature Successfully created', 'woocommerce-compare-products' ).'.</p></div>';
					}else {
						$result_msg = '<div class="error" id="result_msg"><p>'.__('Compare Feature Error created', 'woocommerce-compare-products' ).'.</p></div>';
					}

				}else {
					$result_msg = '<div class="error" id="result_msg"><p>'.__('Nothing created! You already have a Compare Feature with that name. Use the Features Search function to find it. Use unique names to create each Compare Feature.', 'woocommerce-compare-products' ).'</p></div>';
				}
			}
		}elseif (isset($_REQUEST['bt_delete'])) {
			$list_fields_delete = $_REQUEST['un_fields'];
			if (is_array($list_fields_delete) && count($list_fields_delete) > 0) {
				foreach ($list_fields_delete as $field_id) {
					$field_id = absint( $field_id );
					WCCompare\Data::delete_row($field_id);
					WCCompare\Data\Categories_Fields::delete_row("field_id='".$field_id."'");
				}
				$result_msg = '<div class="updated" id="result_msg"><p>'.__('Compare Feature successfully deleted', 'woocommerce-compare-products' ).'.</p></div>';
			}else {
				$result_msg = '<div class="updated" id="result_msg"><p>'.__('Please select item(s) to delete', 'woocommerce-compare-products' ).'.</p></div>';
			}
		}

		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'field-delete') {
			$field_id = absint( $_REQUEST['field_id'] );
			if (isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] > 0) {
				WCCompare\Data\Categories_Fields::delete_row("field_id='".$field_id."' AND cat_id='". absint( $_REQUEST['cat_id'] ) ."'");
				$result_msg = '<div class="updated" id="result_msg"><p>'.__('Compare Feature successfully removed', 'woocommerce-compare-products' ).'.</p></div>';
			}else {
				WCCompare\Data::delete_row($field_id);
				WCCompare\Data\Categories_Fields::delete_row("field_id='".$field_id."'");
				$result_msg = '<div class="updated" id="result_msg"><p>'.__('Compare Feature successfully deleted', 'woocommerce-compare-products' ).'.</p></div>';
			}
		}
		
		return $result_msg;
	}
	
	public static function woocp_features_manager() {
		global $wpdb;
?>
        <h3 id="add_feature"><?php if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'field-edit') { _e('Edit Compare Product Features', 'woocommerce-compare-products' ); }else { _e('Add Compare Product Features', 'woocommerce-compare-products' ); }?></h3>
        <form action="admin.php?page=woo-compare-features" method="post" name="form_add_compare" id="form_add_compare">
        <?php
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'field-edit') {
			$field_id = absint( $_REQUEST['field_id'] );
			$field = WCCompare\Data::get_row($field_id);
		?>
        	<input type="hidden" value="<?php echo $field_id; ?>" name="field_id" id="field_id" />
        <?php
		}else {
			$field_id = 0;
		}
		$have_value = false;
?>
        	<table cellspacing="0" class="widefat post fixed">
            	<thead>
                	<tr><th class="manage-column" scope="col"><?php if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'field-edit') { _e('Edit Compare Features', 'woocommerce-compare-products' ); }else { _e('Create New Compare Features', 'woocommerce-compare-products' ); } ?></th></tr>
                </thead>
                <tbody>
                	<tr>
                    	<td>
                        	<table cellspacing="0" class="form-table">
                            	<tr>
                                	<th><div class="help_tip a3-plugin-ui-icon a3-plugin-ui-help-icon" data-tip="<?php _e('This is the Feature Name that users see in the Compare Fly-Out Window, for example-  System Height', 'woocommerce-compare-products' ) ?>"></div> <label for="field_name"><?php _e('Feature Name', 'woocommerce-compare-products' ); ?></label></th>
                                    <td><input type="text" name="field_name" id="field_name" value="<?php if (!empty($field)) echo stripslashes($field->field_name); ?>" style="width:300px" /></td>
                                </tr>
                                <tr>
                                	<th><div class="help_tip a3-plugin-ui-icon a3-plugin-ui-help-icon" data-tip="<?php _e("e.g kgs, mm, lbs, cm, inches - the unit of measurement shows after the Feature name in (brackets). If you leave this blank you will just see the Feature name.", 'woocommerce-compare-products' ) ?>"></div> <label for="field_unit"><?php _e('Feature Unit of Measurement', 'woocommerce-compare-products' ); ?></label></th>
                                    <td><input type="text" name="field_unit" id="field_unit" value="<?php if (!empty($field)) echo stripslashes($field->field_unit); ?>" style="width:300px" /></td>
                                </tr>
                                <tr>
                                	<th><div class="help_tip a3-plugin-ui-icon a3-plugin-ui-help-icon" data-tip="<?php _e("Users don't see this. Use to set the data input field type that you will use on to enter the Products data for this feature.", 'woocommerce-compare-products' ) ?>"></div> <label for="field_type"><?php _e('Feature Input Type', 'woocommerce-compare-products' ); ?></label></th>
                                    <td>
                                    	<select style="width:300px;" name="field_type" id="field_type" class="chzn-select">
                            <?php
		foreach ( self::$default_types as $type => $type_name) {
			if ( in_array( $type, array( 'wp-video', 'wp-audio' ) ) ) {
				echo '<option value="'.$type.'" >'.$type_name['name'].' - '.$type_name['description'].'</option>';
			} elseif (!empty($field) && $type == $field->field_type) {
				echo '<option value="'.$type.'" selected="selected">'.$type_name['name'].' - '.$type_name['description'].'</option>';
			} else {
				echo '<option value="'.$type.'">'.$type_name['name'].' - '.$type_name['description'].'</option>';
			}
		}
		if (!empty($field) && in_array($field->field_type, array('checkbox' , 'radio', 'drop-down', 'multi-select'))) {
			$have_value = true;
		}
?>
                            </select>
                                    </td>
                                </tr>
                                <tr id="field_value" <?php if (!$have_value) { echo 'style="display:none"';} ?>>
                                	<th><div class="help_tip a3-plugin-ui-icon a3-plugin-ui-help-icon" data-tip="<?php _e("You have selected one of the Check Box, Radio Button, Drop Down, Mutli Select Input Types. Type your Options here, one line for each option.", 'woocommerce-compare-products' ) ?>"></div> <label for="default_value"><?php _e('Enter Input Type options', 'woocommerce-compare-products' ); ?></label></th>
                                    <td><textarea style="width:300px;height:100px;" name="default_value" id="default_value"><?php if (!empty($field)) echo stripslashes($field->default_value); ?></textarea></td>
                                </tr>
                                <tr>
                                	<th><div class="help_tip a3-plugin-ui-icon a3-plugin-ui-help-icon" data-tip="<?php _e("Assign features to one or more Categories. Features such as Colour, Size, Weight can be applicable to many Product categories. Create the Feature once and assign it to one or multiple categories.", 'woocommerce-compare-products' ) ?>"></div> <label for="field_type"><?php _e('Assign Feature to Categories', 'woocommerce-compare-products' ); ?></label></th>
                                    <td>
                                    <?php
								$all_cat = WCCompare\Data\Categories::get_results('', 'category_order ASC');
								$cat_fields = WCCompare\Data\Categories_Fields::get_catid_results($field_id);
								if (is_array($all_cat) && count($all_cat) > 0) {
								?>
								<select multiple="multiple" name="field_cats[]" data-placeholder="<?php _e('Select Compare Categories', 'woocommerce-compare-products' ); ?>" style="width:300px; height:80px;" class="chzn-select">
									<?php
                                    foreach ($all_cat as $cat) {
                                        if (in_array($cat->id, (array)$cat_fields)) {
                                    ?>
                                        <option value="<?php echo $cat->id; ?>" selected="selected"><?php echo stripslashes($cat->category_name); ?></option>
                                    <?php
                                        } else {
                                    ?>
                                        <option value="<?php echo $cat->id; ?>"><?php echo stripslashes($cat->category_name); ?></option>
                                    <?php	
                                        }
                                    }
                                    ?>
								</select>
                                <?php 
								}
								?>
                                    </td>
                                </tr>
                        	</table>
                    	</td>
                    </tr>
                </tbody>
            </table>
            <p class="submit">
	        	<input type="submit" name="bt_save_field" id="bt_save_field" class="button button-primary" value="<?php if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'field-edit') { _e('Save', 'woocommerce-compare-products' ); }else { _e('Create', 'woocommerce-compare-products' ); } ?>"  /> 
                <input type="button" class="button" onclick="window.location='admin.php?page=woo-compare-features'" value="<?php _e('Cancel', 'woocommerce-compare-products' ); ?>" />
	    	</p>
        </form>
        <script>
(function($) {
	$(document).ready(function() {
		var old_type_selected = $("select#field_type").val();
		$("select#field_type").on( 'change', function() {
			var field_type = $(this).val();
			if ( field_type == 'wp-video' || field_type == 'wp-audio' ) {
				alert('<?php _e( 'This Type just is enabled on PRO version.', 'woocommerce-compare-products' ); ?>');
				$(this).val( old_type_selected );
				if(old_type_selected == 'checkbox' || old_type_selected == 'radio' || old_type_selected == 'drop-down' || old_type_selected == 'multi-select'){
					$("#field_value").show();
				}else{
					$("#field_value").hide();
				}
			}
			$("select#field_type").trigger("chosen:updated");
		});
	});
})(jQuery);
		</script>
        <div style="clear:both"></div>
        <?php
	}

	public static function woocp_features_orders() {
		$unavaliable_fields = WCCompare\Data\Categories_Fields::get_unavaliable_field_results('field_name ASC');
		if (is_array($unavaliable_fields) && count($unavaliable_fields) > 0) {
			$un_i = 0;
?>

        <h3 id="#un_assigned"><?php _e('Un-Assigned Features (Assign to a Category to activate)', 'woocommerce-compare-products' ); ?></h3>
        <form action="admin.php?page=woo-compare-features" method="post" name="form_delete_fields" id="form_delete_fields" style="margin-bottom:30px;">
        	<table cellspacing="0" class="widefat post fixed" style="width:535px;">
            	<thead>
                	<tr>
                    	<th width="25" class="manage-column" scope="col" style="white-space: nowrap;"><input id="toggle1" class="toggle" type="checkbox" style="margin:0;" /></th>
                        <th width="30" class="manage-column" scope="col" style="white-space: nowrap;"><?php _e('No', 'woocommerce-compare-products' ); ?></th>
                        <th class="manage-column" scope="col"><?php _e('Feature Name', 'woocommerce-compare-products' ); ?></th>
                        <th width="90" class="manage-column" scope="col" style="text-align:right"><?php _e('Type', 'woocommerce-compare-products' ); ?></th>
                        <th width="100" class="manage-column" scope="col" style="text-align:right"></th>
                    </tr>
                </thead>
                <tbody>
                <?php
			foreach ($unavaliable_fields as $field_data) {
				$un_i++;
?>
                	<tr>
                    	<td><input class="list_fields" type="checkbox" name="un_fields[]" value="<?php echo $field_data->id; ?>" /></td>
                        <td><?php echo $un_i; ?></td>
                        <td><?php echo stripslashes($field_data->field_name); ?></td>
                        <td align="right"><?php echo self::$default_types[$field_data->field_type]['name']; ?></td>
                        <td align="right"><a href="admin.php?page=woo-compare-features&act=field-edit&field_id=<?php echo $field_data->id; ?>" class="c_field_edit" title="<?php _e('Edit', 'woocommerce-compare-products' ) ?>" ><?php _e('Edit', 'woocommerce-compare-products' ) ?></a> | <a href="admin.php?page=woo-compare-features&act=field-delete&field_id=<?php echo $field_data->id; ?>" class="c_field_delete" onclick="javascript:return confirmation('<?php _e('Are you sure you want to delete', 'woocommerce-compare-products' ) ; ?> #<?php echo htmlspecialchars($field_data->field_name); ?>');" title="<?php _e('Delete', 'woocommerce-compare-products' ) ?>" ><?php _e('Delete', 'woocommerce-compare-products' ) ?></a></td>
                	</tr>
                 <?php } ?>
                </tbody>
            </table>
            <div style="margin-top:10px;"><input type="submit" name="bt_delete" id="bt_delete" class="button button-primary" value="<?php _e('Delete', 'woocommerce-compare-products' ) ; ?>" onclick="if (confirm('<?php _e('Are you sure about deleting this?', 'woocommerce-compare-products' ) ; ?>')) return true; else return false" /></div>
            </form>
        <?php
		}
		
		$compare_cats = WCCompare\Data\Categories::get_results('', 'category_order ASC');
		if (is_array($compare_cats) && count($compare_cats)>0) {
?>
        <h3><?php _e('Manage Compare Categories and Features', 'woocommerce-compare-products' ); ?></h3>
        <p><?php _e('Use drag and drop to change Category order and Feature order within Categories.', 'woocommerce-compare-products' ) ?></p>
        <div class="updated below-h2 update_feature_order_message" style="display:none"><p></p></div>
        <div style="clear:both"></div>
        <ul style="margin:0; padding:0;" class="sorttable">
        <?php
			foreach ($compare_cats as $cat) {
				$compare_fields = WCCompare\Data\Categories_Fields::get_results("cat_id='".$cat->id."'", 'cf.field_order ASC');
?>
        <li id="recordsArray_<?php echo $cat->id; ?>">
          <input type="hidden" name="compare_orders_<?php echo $cat->id; ?>" class="compare_category_id" value="<?php echo $cat->id; ?>"  />
  		  <table cellspacing="0" class="widefat post fixed sorttable" id="compare_orders_<?php echo $cat->id; ?>" style="width:535px; margin-bottom:20px;">
            <thead>
            <tr>
              <th width="25" style="white-space: nowrap;"><span class="c_field_name">&nbsp;</span></th>
              <th><strong><?php echo stripslashes($cat->category_name) ;?></strong> :</th>
              <th width="90"></th>
              <th width="100" style="text-align:right; font-size:12px;white-space: nowrap;"><a href="admin.php?page=woo-compare-features&act=cat-edit&category_id=<?php echo $cat->id; ?>" class="c_field_edit" title="<?php _e('Edit', 'woocommerce-compare-products' ) ?>"><?php _e('Edit', 'woocommerce-compare-products' ) ?></a> | <a href="admin.php?page=woo-compare-features&act=cat-delete&category_id=<?php echo $cat->id; ?>" title="<?php _e('Delete', 'woocommerce-compare-products' ) ?>" class="c_field_delete" onclick="javascript:return confirmation('<?php _e('Are you sure you want to delete', 'woocommerce-compare-products' ) ; ?> #<?php echo htmlspecialchars($cat->category_name); ?>');"><?php _e('Delete', 'woocommerce-compare-products' ) ?></a><?php if (is_array($compare_fields) && count($compare_fields)>0) { ?> | <span class="c_openclose_table c_close_table" id="expand_<?php echo $cat->id; ?>">&nbsp;</span><?php }else {?> | <span class="c_openclose_none">&nbsp;</span><?php }?></th>
            </tr>
            </thead>
            <tbody class="expand_<?php echo $cat->id; ?>">
               	<?php
				if (is_array($compare_fields) && count($compare_fields)>0) {
					$i= 0;
					foreach ($compare_fields as $field_data) {
						$i++;
?>
                <tr id="recordsArray_<?php echo $field_data->id; ?>" style="display:none">
                	<td><span class="compare_sort"><?php echo $i; ?></span>.</td>
                    <td><div class="c_field_name"><?php echo stripslashes($field_data->field_name); ?></div></td>
                    <td align="right"><?php echo self::$default_types[$field_data->field_type]['name']; ?></td>
                    <td align="right"><a href="admin.php?page=woo-compare-features&act=field-edit&field_id=<?php echo $field_data->id; ?>" class="c_field_edit" title="<?php _e('Edit', 'woocommerce-compare-products' ) ?>" ><?php _e('Edit', 'woocommerce-compare-products' ) ?></a> | <a href="admin.php?page=woo-compare-features&act=field-delete&field_id=<?php echo $field_data->id; ?>&cat_id=<?php echo $cat->id; ?>" class="c_field_delete" onclick="javascript:return confirmation('<?php _e('Are you sure you want to remove', 'woocommerce-compare-products' ) ; ?> #<?php echo htmlspecialchars($field_data->field_name); ?> <?php _e('from', 'woocommerce-compare-products' ) ; ?> #<?php echo htmlspecialchars($cat->category_name); ?>');" title="<?php _e('Remove', 'woocommerce-compare-products' ) ?>" ><?php _e('Remove', 'woocommerce-compare-products' ) ?></a></td>
                </tr>
                <?php
					}
				}else {
					echo '<tr><td colspan="4">'.__('You have not assigned any Features to this category yet. No Hurry!', 'woocommerce-compare-products' ).'</td></tr>';
				}
?>
            </tbody>
          </table>
        </li>
        <?php
			}
?>
        </ul>
        		<?php wp_enqueue_script('jquery-ui-sortable'); ?>
                <?php $woocp_update_order = wp_create_nonce("woocp-update-order"); ?>
                <?php $woocp_update_cat_order = wp_create_nonce("woocp-update-cat-order"); ?>
                <script type="text/javascript">
					(function($){
						$(function(){
							$(".c_openclose_table").on('click', function() {
								if ( $(this).hasClass('c_close_table') ) {
									$(this).removeClass("c_close_table");
									$(this).addClass("c_open_table");
									$("tbody."+$(this).attr('id')+" tr").css('display', '');
								} else {
									$(this).removeClass("c_open_table");
									$(this).addClass("c_close_table");
									$("tbody."+$(this).attr('id')+" tr").css('display', 'none');
								}
							});

							var fixHelper = function(e, ui) {
								ui.children().each(function() {
									$(this).width($(this).width());
								});
								return ui;
							};

							$(".sorttable tbody").sortable({ helper: fixHelper, placeholder: "ui-state-highlight", opacity: 0.8, cursor: 'move', update: function() {
								var cat_id = $(this).parent('table').siblings(".compare_category_id").val();
								var order = $(this).sortable("serialize") + '&action=woocp_update_orders&security=<?php echo $woocp_update_order; ?>&cat_id='+cat_id;
								$.post("<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>", order, function(theResponse){
									$(".update_feature_order_message p").html(theResponse);
									$(".update_feature_order_message").show();
									$("#compare_orders_"+cat_id).find(".compare_sort").each(function(index){
										$(this).html(index+1);
									});
								});
							}
							});

							$("ul.sorttable").sortable({ placeholder: "ui-state-highlight", opacity: 0.8, cursor: 'move', update: function() {
								var order = $(this).sortable("serialize") + '&action=woocp_update_cat_orders&security=<?php echo $woocp_update_cat_order; ?>';
								$.post("<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>", order, function(theResponse){
									$(".update_feature_order_message p").html(theResponse).show();
									$(".update_feature_order_message").show();
								});
							}
							});
						});
					})(jQuery);
				</script>
        <?php
		}
	}

	public static function woocp_update_orders() {
		check_ajax_referer( 'woocp-update-order', 'security' );
		$updateRecordsArray  = $_REQUEST['recordsArray'];
		$cat_id = absint( $_REQUEST['cat_id'] );
		$listingCounter = 1;
		foreach ($updateRecordsArray as $recordIDValue) {
			WCCompare\Data\Categories_Fields::update_order($cat_id, absint( $recordIDValue ), $listingCounter);
			$listingCounter++;
		}
		
		_e('You just save the order for Compare Features.', 'woocommerce-compare-products' );
		die();
	}
	
	public static function features_search_area() {
		global $wpdb;
	?>
    	<div class="icon32 icon32-compare-product" id="icon32-compare-product"><br></div>
        <h1><?php _e('Categories & Features', 'woocommerce-compare-products' ); ?> <a href="admin.php?page=woo-compare-features&act=add-new" class="add-new-h2"><?php _e('Add New', 'woocommerce-compare-products' ); ?></a></h1>
        <div style="clear:both;height:12px"></div>
        <form method="get" action="admin.php?page=woo-compare-features" name="compare_search_features">
            <input type="hidden" name="page" value="woo-compare-features"  />
            <input type="hidden" name="tab" value="features"  />
        <?php
		$s_feature = '';
		if (isset($_REQUEST['s_feature']) && trim($_REQUEST['s_feature']) != '') $s_feature = trim(stripslashes($_REQUEST['s_feature'])); 
		?>
        	<table class="form-table" style="width:535px;">
                <tbody>
                	<tr valign="top">
                    	<th class="titledesc" scope="rpw" style="padding-left:0;"><input type="text" name="s_feature" id="s_feature" value="<?php echo $s_feature; ?>" style="min-width:300px" /></th>
                        <td class="forminp search_features_td" style="padding-right:0; text-align:right;"><input type="submit" id="search_features" name="" value="<?php _e('Search Features', 'woocommerce-compare-products' ); ?>" class="button"></td>
                    </tr>
                </tbody>
            </table>
        <?php
		if (isset($_REQUEST['s_feature'])) {
			$p = 1;
			$rows = 25;
			if (isset($_REQUEST['pp'])) $p = sanitize_text_field( $_REQUEST['pp'] );
			if (isset($_REQUEST['rows'])) $rows = sanitize_text_field( $_REQUEST['rows'] );
			$start = ($p - 1 ) * $rows;
			$end = $start+$rows;
			$div = 5;
			$keyword = trim(stripslashes($_REQUEST['s_feature']));
			
			// fixed for 4.1.2
			$link = esc_url( add_query_arg(array('pp' => '', 'rows' => $rows, 's_feature' => $keyword ) ) );
			
			$character = 'latin1';
			if ( $wpdb->has_cap( 'collation' ) ) 
				if( ! empty($wpdb->charset ) ) $character = "$wpdb->charset";
			
			$where = "LOWER( CONVERT( field_name USING ".$character.") ) LIKE '%".strtolower(trim( sanitize_text_field( $_REQUEST['s_feature'] ) ) )."%'";
			
			$total = WCCompare\Data::get_count($where);
			if ($end > $total) $end = $total;
			$items = WCCompare\Data::get_results($where, 'field_name ASC', $start.','.$rows);
			
			$innerPage = WCCompare\Functions::printPage($link, $total, $p, $div, $rows, false);
			
			?>
            <h3><?php _e('Found', 'woocommerce-compare-products' ); ?> <?php echo $total; ?> <?php _e('feature(s)', 'woocommerce-compare-products' ); ?></h3>
            <?php
			if ($total > 0) {
			?>
        	<table cellspacing="0" class="widefat post fixed" style="width:535px;">
            	<thead>
                	<tr>
                        <th class="manage-column" scope="col"><?php _e('Feature Name', 'woocommerce-compare-products' ); ?></th>
                        <th width="90" class="manage-column" scope="col" style="text-align:right"><?php _e('Type', 'woocommerce-compare-products' ); ?></th>
                        <th width="100" class="manage-column" scope="col" style="text-align:right"></th>
                    </tr>
                </thead>
                <tbody>
                <?php
			foreach ($items as $field_data) {
?>
                	<tr>
                        <td><?php echo stripslashes($field_data->field_name); ?></td>
                        <td align="right"><?php echo self::$default_types[$field_data->field_type]['name']; ?></td>
                        <td align="right"><a href="admin.php?page=woo-compare-features&act=field-edit&field_id=<?php echo $field_data->id; ?>" class="c_field_edit" title="<?php _e('Edit', 'woocommerce-compare-products' ) ?>" ><?php _e('Edit', 'woocommerce-compare-products' ) ?></a> | <a href="admin.php?page=woo-compare-features&act=field-delete&field_id=<?php echo $field_data->id; ?>" class="c_field_delete" onclick="javascript:return confirmation('<?php _e('Are you sure you want to delete', 'woocommerce-compare-products' ) ; ?> #<?php echo htmlspecialchars($field_data->field_name); ?>');" title="<?php _e('Delete', 'woocommerce-compare-products' ) ?>" ><?php _e('Delete', 'woocommerce-compare-products' ) ?></a></td>
                	</tr>
                 <?php } ?>
                </tbody>
                <tfoot>
					<tr>
						<th class="manage-column column-title" colspan="3" style="padding:2px 7px">
                    		<div class="tablenav">
                                <span class="search_item_title"><?php _e('Show', 'woocommerce-compare-products' ); ?>:</span>
                                <select name="rows" class="number_items">
                            <?php $number_items_array = array('15' => '15', '25' => '25', '50' => '50', '75' => '75', '100' => '100', '200' => '200', '1000000' => 'All'); 
                                foreach($number_items_array as $key => $value){
                                    if($key == $rows)
                                        echo "<option selected='selected' value='$key'>$value</option>";
                                    else
                                        echo "<option value='$key'>$value</option>";
                                }
                            ?>
                                </select>
                                <input type="submit" class="button" value="<?php _e('Go', 'woocommerce-compare-products' ); ?>" name="" id="search_items" />
                                <div class="tablenav-pages"><span class="displaying-num"><?php _e('Displaying', 'woocommerce-compare-products' ) ; ?> <?php echo ($start+1); ?> - <?php echo $end; ?> <?php _e('of', 'woocommerce-compare-products' ) ; ?> <?php echo $total; ?></span><?php echo $innerPage;?></div>
                            </div>
						</th>
					</tr>
				</tfoot>
            </table>
            <?php
			}
		}
		?>
        </form>
    <?php	
	}

}

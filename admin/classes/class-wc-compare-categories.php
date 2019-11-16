<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Categories
 *
 * Table Of Contents
 *
 * init_categories_actions()
 * woocp_categories_manager()
 * woocp_update_cat_orders()
 */

namespace A3Rev\WCCompare\Admin;

use A3Rev\WCCompare;

class Categories
{
	
	public static function init_categories_actions() {
		global $wpdb;
		$cat_msg = '';
		if(isset($_REQUEST['bt_save_cat'])){
			$category_name = trim(strip_tags(addslashes($_REQUEST['category_name'])));
			if(isset($_REQUEST['category_id']) && $_REQUEST['category_id'] > 0){
				$old_data = WCCompare\Data\Categories::get_row( absint( $_REQUEST['category_id'] ) );
				$count_category_name = WCCompare\Data\Categories::get_count("category_name = '".$category_name."' AND id != '". absint( $_REQUEST['category_id'] )."'");
				if ($category_name != '' && $count_category_name == 0) {
					$result = WCCompare\Data\Categories::update_row($_REQUEST);
					$wpdb->query('UPDATE '.$wpdb->prefix.'postmeta SET meta_value="'.$category_name.'" WHERE meta_value="'.$old_data->category_name.'" AND meta_key="_wpsc_compare_category_name" ');
					$cat_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Category Successfully edited', 'woocommerce-compare-products' ).'.</p></div>';
				}else {
					$cat_msg = '<div class="error below-h2" id="result_msg"><p>'.__('Nothing edited! You already have a Compare Category with that name. Use unique names to edit each Compare Category.', 'woocommerce-compare-products' ).'</p></div>';
				}
			}else{
				$count_category_name = WCCompare\Data\Categories::get_count("category_name = '".$category_name."'");
				if ($category_name != '' && $count_category_name == 0) {
					$category_id = WCCompare\Data\Categories::insert_row($_REQUEST);
					if ($category_id > 0) {
						$cat_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Category Successfully created', 'woocommerce-compare-products' ).'.</p></div>';
					}else {
						$cat_msg = '<div class="error below-h2" id="result_msg"><p>'.__('Compare Category Error created', 'woocommerce-compare-products' ).'.</p></div>';
					}
				}else {
					$cat_msg = '<div class="error below-h2" id="result_msg"><p>'.__('Nothing created! You already have a Compare Category with that name. Use unique names to create each Compare Category.', 'woocommerce-compare-products' ).'</p></div>';
				}
			}
		}
		
		if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-delete'){
			$category_id = absint($_REQUEST['category_id']);
			WCCompare\Data\Categories::delete_row($category_id);
			WCCompare\Data\Categories_Fields::delete_row("cat_id='".$category_id."'");
			$cat_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Category deleted','woocommerce-compare-products' ).'.</p></div>';
		}
		return $cat_msg;
	}
	
	public static function woocp_categories_manager() {
		global $wpdb;
?>

        <h3><?php if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit') { _e('Edit Compare Product Categories', 'woocommerce-compare-products' );}else { _e('Add Compare Product Categories', 'woocommerce-compare-products' ); } ?></h3>
        <?php if(isset($_REQUEST['act']) && $_REQUEST['act'] != 'cat-edit'){?><p><?php _e('Create Categories based on groups of products that share the same compare feature list.', 'woocommerce-compare-products' ); ?></p><?php } ?>
        <form action="admin.php?page=woo-compare-features" method="post" name="form_add_compare" id="form_add_compare">
        <?php
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit') {
			$category_id = absint( $_REQUEST['category_id'] );
			$cat_data = WCCompare\Data\Categories::get_row($category_id);
		?>
        	<input type="hidden" value="<?php echo $category_id; ?>" name="category_id" id="category_id" />
        <?php		
			}
		?>
        	<table class="form-table">
                <tbody>
                	<tr valign="top">
                    	<th class="titledesc" scope="rpw"><label for="category_name"><?php if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit'){ _e('Edit Category Name', 'woocommerce-compare-products' ); } else { _e('Category Name', 'woocommerce-compare-products' ); } ?></label></th>
                        <td class="forminp"><input type="text" name="category_name" id="category_name" value="<?php if (!empty($cat_data)) { echo stripslashes($cat_data->category_name); } ?>" style="min-width:300px" /></td>
                    </tr>
                </tbody>
            </table>
            <p class="submit">
	        	<input type="submit" name="bt_save_cat" id="bt_save_cat" class="button button-primary" value="<?php if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit') { _e('Save', 'woocommerce-compare-products' ); }else { _e('Create', 'woocommerce-compare-products' ); } ?>"  /> <?php if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit') { ?><input type="button" class="button" onclick="window.location='admin.php?page=woo-compare-features'" value="<?php _e('Cancel', 'woocommerce-compare-products' ); ?>" /><?php } ?>
	    	</p>
        </form>
	<?php
	}

	public static function woocp_update_cat_orders() {
		check_ajax_referer( 'woocp-update-cat-order', 'security' );
		$updateRecordsArray  = $_REQUEST['recordsArray'];

		$listingCounter = 1;
		foreach ($updateRecordsArray as $recordIDValue) {
			WCCompare\Data\Categories::update_order( absint( $recordIDValue ), $listingCounter);
			$listingCounter++;
		}
		
		_e('You just save the order for compare categories.', 'woocommerce-compare-products' );
		die();
	}

}

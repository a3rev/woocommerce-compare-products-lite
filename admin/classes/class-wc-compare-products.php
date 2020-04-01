<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Products Manager
 *
 * Table Of Contents
 *
 * woocp_get_products()
 * woocp_popup_features()
 * woocp_products_manager()
 * woocp_compare_products_script()
 */

namespace A3Rev\WCCompare\Admin;

class Products 
{

	public static function woocp_products_manager() {
		add_action('admin_footer', array( __CLASS__, 'woocp_compare_products_script') );
?>
<div id="htmlForm">
    <div style="clear:both"></div>
	<div class="wrap">
		<h1><?php _e('WooCommerce Compare Products Manager', 'woocommerce-compare-products' ); ?></h1>
		<div id="a3_plugin_panel_container">
			<div id="a3_plugin_panel_upgrade_area"><div id="a3_plugin_panel_extensions"><?php echo $GLOBALS[WOOCP_PREFIX.'admin_init']->plugin_extension_boxes(); ?></div></div>
			<div id="a3_plugin_panel_fields">
				<div class="a3rev_panel_container" style="visibility: visible; height: auto; overflow: inherit;">
					<div style="" class="a3rev_panel_box " id="product_cards_welcome_steve_box">
						<div class="a3rev_panel_box_handle" data-box-id="product_cards_welcome_steve_box" data-form-key="woo_compare_grid_view_settings">
							<h3 class="a3-plugin-ui-panel-box enable_toggle_box_save box_open"><?php echo __( 'PRODUCT EDITING SUPER POWERS', 'woocommerce-compare-products' ); ?></h3>
						</div>
						<div class="a3rev_panel_box_inside box_open" id="product_cards_welcome_steve_box_box_inside" style="visibility: visible; height: auto; overflow: inherit; display: block;">
							<div class="a3rev_panel_inner">
								<div class="a3rev_panel_box_description">
									<p>
										<img class="rwd_image_maps" src="<?php echo WOOCP_IMAGES_URL; ?>/woo_product.png" usemap="#Map" style="width: auto; max-width: 100%;" border="0" />
										<map name="Map" id="Map">
											<area shape="rect" coords="357,185,850,242" href="<?php echo $GLOBALS[WOOCP_PREFIX.'admin_init']->pro_plugin_page_url; ?>" target="_blank" />
										</map>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	}

	public static function woocp_compare_products_script() {
		wp_enqueue_script( 'jquery-rwd-image-maps' );
	}
}

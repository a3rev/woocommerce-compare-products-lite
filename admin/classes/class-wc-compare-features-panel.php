<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Features Panel
 *
 * Table Of Contents
 *
 * admin_screen()
 */

namespace A3Rev\WCCompare\Admin;

use A3Rev\WCCompare;

class Features_Panel 
{
	
	public static function admin_screen () {
		?>
	<style>
		.chzn-container{margin-right:2px;}
		.field_title{width:205px; padding:0 8px 0 10px; float:left;}
		.help_tip{cursor: help;line-height: 1;margin: -4px 0 0 5px;padding: 0;vertical-align: middle;}
		.compare_set_1{width:46%; float:left; margin-right:5%; margin-bottom:15px;}
		.compare_set_2{width:46%; float:left; margin-bottom:15px;}
		.ui-state-highlight{background:#F6F6F6; height:24px; padding:8px 0 0; border:1px dotted #DDD; margin-bottom:20px;}
		ul.compare_orders{float:left; margin:0; width:100%}
		ul.compare_orders li{padding-top:8px; border-top:1px solid #DFDFDF; margin:5px 0; line-height:20px;}
		ul.compare_orders li.first_record{border-top:none; padding-top:0;}
		ul.compare_orders .compare_sort{float:left; width:60px;}
		.c_field_name{padding-left:20px; background:url(<?php echo WOOCP_IMAGES_URL; ?>/icon_sort.png) no-repeat 0 center;}
		.c_openclose_table{cursor:pointer;}
		.c_openclose_none{width:16px; height:16px; display:inline-block;}
		.c_close_table{background:url(<?php echo get_option('siteurl'); ?>/wp-admin/images/arrows.png) no-repeat center 0px; width:16px; height:16px; display:inline-block;}
		.c_open_table{background:url(<?php echo get_option('siteurl'); ?>/wp-admin/images/arrows.png) no-repeat center -35px; width:16px; height:16px; display:inline-block;}
		ul.compare_orders .c_field_type{width:120px; float:left;}
		ul.compare_orders .c_field_manager{background:url(<?php echo WOOCP_IMAGES_URL; ?>/icon_fields.png) no-repeat 0 0; width:16px; height:16px; display:inline-block;}
		.tablenav-pages{float:right;}
		.c_field_edit, .c_field_delete{cursor:pointer;}
		.widefat th input {
			vertical-align:middle;
			padding:3px 8px;
			margin:auto;
		}
		.widefat th, .widefat td {
			overflow: inherit !important;	
		}
		.chzn-container-multi .chzn-choices {
			min-height:100px;	
		}

		ul.feature_compare_orders .compare_sort{margin-right:10px; float:none; width:auto;}
		ul.feature_compare_orders .c_field_name{margin-right:10px;padding:5px 0 5px 20px; float:none; width:auto;}
		ul.feature_compare_orders .c_field_action{float:right;}
		ul.feature_compare_orders .c_field_type{float:right; margin-right:10px; width:70px;}
		
		.icon32-compare-product {
			background:url(<?php echo WOOCP_IMAGES_URL; ?>/a3-plugins.png) no-repeat left top !important;
		}
		@media screen and ( max-width: 782px ) {
			.a3rev_manager_panel_container table {
				width:100% !important;	
			}
			.a3rev_manager_panel_container td.search_features_td {
				text-align:left !important;	
			}
		}
	</style>
	<script>
		(function($){
			$(function(){
				$("#field_type").on('change', function() {
					var field_type = $(this).val();
					if(field_type == 'checkbox' || field_type == 'radio' || field_type == 'drop-down' || field_type == 'multi-select'){
						$("#field_value").slideDown();
					}else{
						$("#field_value").slideUp();
					}
				});
				$('#toggle1').on('click', function(){
					if($('#toggle1').is(':checked')){
						$(".list_fields").prop("checked", true);
						$(".toggle2").prop("checked", true);
					}else{
						$(".list_fields").prop("checked",false);
						$(".toggle2").prop("checked",false);
					}
				});
				$('#toggle2').on('click', function(){
					if($('#toggle2').is(':checked')){
						$(".list_fields").prop("checked", true);
						$(".toggle1").prop("checked", true);
					}else{
						$(".list_fields").prop("checked",false);
						$(".toggle1").prop("checked",false);
					}
				});
			});
		})(jQuery);
		function confirmation(text) {
			var answer = confirm(text)
			if (answer){
				return true;
			}else{
				return false;
			}
		}		
	</script>
        <div id="htmlForm">
	        <div style="clear:both"></div>
			<div class="wrap">
				<h1></h1>
				<div id="a3_plugin_panel_container">
					<div id="a3_plugin_panel_upgrade_area"><div id="a3_plugin_panel_extensions"><?php echo $GLOBALS[WOOCP_PREFIX.'admin_init']->plugin_extension_boxes(); ?></div></div>
					<div id="a3_plugin_panel_fields">
						<div class="a3rev_panel_container a3rev_manager_panel_container">
							<?php 
								echo Fields::init_features_actions();
								echo Categories::init_categories_actions();
							?>
							<?php
							if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'add-new') {
								Categories::woocp_categories_manager();
								Fields::woocp_features_manager();
							} else if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit') {
								Categories::woocp_categories_manager();
							} else if (isset($_REQUEST['act']) &&  $_REQUEST['act'] == 'field-edit') {
								Fields::woocp_features_manager();
							} else if (isset($_REQUEST['s_feature'])) {
								Fields::features_search_area();
							} else {
								Fields::features_search_area();
								Fields::woocp_features_orders();
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	
}

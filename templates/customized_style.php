<style>
<?php
// Grid View Button Style
global $woo_compare_grid_view_settings;
extract($woo_compare_grid_view_settings);
?>
@charset "UTF-8";
/* CSS Document */

/* Grid View Button Style */
.woo_grid_compare_button_container {
	display: block; 
	text-align:center; 
	margin: <?php echo $grid_view_button_margin_top; ?>px <?php echo $grid_view_button_margin_right; ?>px <?php echo $grid_view_button_margin_bottom; ?>px <?php echo $grid_view_button_margin_left; ?>px !important;
}
.woo_grid_compare_button_container .woo_bt_compare_this {
	position: relative !important;
	cursor:pointer;
	display: inline-block !important;
	line-height: 1 !important;
}
.wp-block-compare-button .woo_bt_compare_this {
	position: relative !important;
	overflow: visible;
}
.woo_grid_compare_button_container .woo_bt_compare_this_button {
	padding: 7px 8px !important;
	margin:0;
	
	/*Background*/
	background-color: #476381 !important;
	background: -webkit-gradient(
					linear,
					left top,
					left bottom,
					color-stop(.2, #538bbc),
					color-stop(1, #476381)
				) !important;;
	background: -moz-linear-gradient(
					center top,
					#538bbc 20%,
					#476381 100%
				) !important;;
	
		
	/*Border*/
	border: 1px solid #476381 !important;
  	border-radius: 3px 3px 3px 3px !important;
  	-moz-border-radius: 3px 3px 3px 3px !important;
  	-webkit-border-radius: 3px 3px 3px 3px !important;
	
	/* Shadow */
	box-shadow: none !important;
  	-moz-box-shadow: none !important;
  	-webkit-box-shadow: none !important;
	
	/* Font */
	font: bold 12px/1.4em Arial, sans-serif !important;
  	color: #FFFFFF !important;
	
	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}

.woo_grid_compare_button_container .woo_bt_compare_this_link {
	/* Font */
	font: bold 12px/1.4em Arial, sans-serif !important;
  	color: #000000 !important;
}
.woo_grid_compare_button_container .woo_bt_compare_this_link:hover {
	color: #999999 !important;
}
.woo_grid_compare_button_container .woo_bt_compare_this.compare_adding:before,
.wp-block-compare-button .woo_bt_compare_this.compare_adding:before {
	background: url(<?php echo WOOCP_IMAGES_URL; ?>/ajax-loader.gif) no-repeat scroll 0 center transparent;
	position: absolute;
	right:-26px;
    content: "";
    height: 16px;
    text-indent: 0;
    width: 16px;
}
.woo_grid_compare_button_container .woo_bt_compare_this.compared:before {
	background: url(<?php echo WOOCP_IMAGES_URL; ?>/compare_success.png) no-repeat scroll 0 center transparent;
	position: absolute;
	right:-26px;
    content: "";
    height: 16px;
    text-indent: 0;
    width: 16px;
}

/* Grid View View Compare Style */
.woo_grid_compare_button_container .woo_bt_view_compare,
.wp-block-compare-button .woo_bt_view_compare {
	position:relative !important;
	cursor:pointer !important;
	line-height: 1 !important;
	display:inline-block;
	margin-top:5px !important;
}

.woo_grid_compare_button_container .woo_bt_view_compare_link,
.wp-block-compare-button.is_grid_view .woo_bt_view_compare_link {
	/* Font */
	font: bold 12px/1.4em Arial, sans-serif !important;
  	color: #000000 !important;
}
.woo_grid_compare_button_container .woo_bt_view_compare_link:hover,
.wp-block-compare-button.is_grid_view .woo_bt_view_compare_link:hover {
	color: #999999 !important;
}

<?php
// Product Page Button Style
global $woo_compare_product_page_settings;
extract($woo_compare_product_page_settings);
?>
/* Product Page Button Style */
.woo_compare_button_container { 
	clear:both;
	margin: <?php echo $product_page_button_margin_top; ?>px <?php echo $product_page_button_margin_right; ?>px <?php echo $product_page_button_margin_bottom; ?>px <?php echo $product_page_button_margin_left; ?>px !important;
}
.woo_compare_button_container .woo_bt_compare_this {
	position:relative !important;
	cursor:pointer !important;
	display: inline-block !important;
	line-height: 1 !important;
}
.woo_compare_button_container .woo_bt_compare_this_button {
	padding: <?php echo $product_compare_button_padding_tb; ?>px <?php echo $product_compare_button_padding_lr; ?>px !important;
	margin:0;
	
	/*Background*/
	background-color: <?php echo $product_compare_button_bg_colour; ?> !important;
	background: -webkit-gradient(
					linear,
					left top,
					left bottom,
					color-stop(.2, <?php echo $product_compare_button_bg_colour_from; ?>),
					color-stop(1, <?php echo $product_compare_button_bg_colour_to; ?>)
				) !important;;
	background: -moz-linear-gradient(
					center top,
					<?php echo $product_compare_button_bg_colour_from; ?> 20%,
					<?php echo $product_compare_button_bg_colour_to; ?> 100%
				) !important;;
	
	/*Border*/
	<?php echo $GLOBALS[WOOCP_PREFIX.'admin_interface']->generate_border_css( $woo_compare_product_page_settings['product_compare_button_border'] ); ?>
	
	/* Shadow */
	<?php echo $GLOBALS[WOOCP_PREFIX.'admin_interface']->generate_shadow_css( $woo_compare_product_page_settings['product_compare_button_shadow'] ); ?>
	
	/* Font */
	<?php echo $GLOBALS[WOOCP_PREFIX.'fonts_face']->generate_font_css( $woo_compare_product_page_settings['product_compare_button_font'] ); ?>
	
	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}

.woo_compare_button_container .woo_bt_compare_this_link {
	/* Font */
	<?php echo $GLOBALS[WOOCP_PREFIX.'fonts_face']->generate_font_css( $product_compare_link_font ); ?>
}
.woo_compare_button_container .woo_bt_compare_this_link:hover {
	color: <?php echo $product_compare_link_font_hover_colour; ?> !important;
}
.woo_compare_button_container .woo_bt_compare_this.compare_adding:before {
	background: url(<?php echo WOOCP_IMAGES_URL; ?>/ajax-loader.gif) no-repeat scroll 0 center transparent;
	position: absolute;
	right:-26px;
    content: "";
    height: 16px;
    text-indent: 0;
    width: 16px;
}
.woo_compare_button_container .woo_bt_compare_this.compared:before {
<?php 
$woo_compare_product_success_icon = get_option('woo_compare_product_success_icon');
if ( $woo_compare_product_success_icon != '') {
?>
	background: url(<?php echo $woo_compare_product_success_icon; ?>) no-repeat scroll 0 center transparent;
<?php	
} else {
?>
	background: url(<?php echo WOOCP_IMAGES_URL; ?>/compare_success.png) no-repeat scroll 0 center transparent;
<?php
}
?>
	position: absolute;
	right:-26px;
    content: "";
    height: 16px;
    text-indent: 0;
    width: 16px;
}

/* Product Page View Compare Style */
.woo_compare_button_container .woo_bt_view_compare {
	position:relative !important;
	cursor:pointer !important;
	line-height: 1 !important;
	display:inline-block;
	margin-top:5px !important;
}
.woo_compare_button_container .woo_bt_view_compare_button,
.wp-block-compare-button.is_single_view .woo_bt_view_compare_button {
	padding: <?php echo $product_view_compare_button_padding_tb; ?>px <?php echo $product_view_compare_button_padding_lr; ?>px !important;
	margin:0;
	
	/*Background*/
	background-color: <?php echo $product_view_button_bg_colour; ?> !important;
	background: -webkit-gradient(
					linear,
					left top,
					left bottom,
					color-stop(.2, <?php echo $product_view_button_bg_colour_from; ?>),
					color-stop(1, <?php echo $product_view_button_bg_colour_to; ?>)
				) !important;;
	background: -moz-linear-gradient(
					center top,
					<?php echo $product_view_button_bg_colour_from; ?> 20%,
					<?php echo $product_view_button_bg_colour_to; ?> 100%
				) !important;;
	
	/*Border*/
	<?php echo $GLOBALS[WOOCP_PREFIX.'admin_interface']->generate_border_css( $woo_compare_product_page_settings['product_view_button_border'] ); ?>
	
	/* Shadow */
	<?php echo $GLOBALS[WOOCP_PREFIX.'admin_interface']->generate_shadow_css( $woo_compare_product_page_settings['product_view_button_shadow'] ); ?>
	
	/* Font */
	<?php echo $GLOBALS[WOOCP_PREFIX.'fonts_face']->generate_font_css( $woo_compare_product_page_settings['product_view_button_font'] ); ?>
	
	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}

.woo_compare_button_container .woo_bt_view_compare_link,
.wp-block-compare-button.is_single_view .woo_bt_view_compare_link {
	/* Font */
	<?php echo $GLOBALS[WOOCP_PREFIX.'fonts_face']->generate_font_css( $product_view_compare_link_font ); ?>
}
.woo_compare_button_container .woo_bt_view_compare_link:hover,
.wp-block-compare-button.is_single_view .woo_bt_view_compare_link:hover {
	color: <?php echo $product_view_compare_link_font_hover_colour; ?> !important;
}


/* Compare Widget Title Style */
#compare_widget_title_container {
	float: left !important;
  	padding: 5px 5px !important;
  	margin-top: 0px !important;
  	margin-bottom: 10px !important;
	
	/*Background*/
	background-color: #FFFFFF !important
	
	/*Border*/
	border: 0px solid #476381 !important;
  	border-radius: 0px !important;
  	-moz-border-radius: 0px !important;
  	-webkit-border-radius: 0px !important;
}

#compare_widget_title_container #compare_widget_title_text {
	/* Font */
	font: bold 12px/1.4em Arial, sans-serif !important;
  	color: #000000 !important;
}

#total_compare_product {
	/* Font */
	font: normal 12px/1.4em Arial, sans-serif !important;
  	color: #000000 !important;
}


/* Compare Widget Style */
.no_compare_list {
	/* Font */
	font: bold 12px/1.4em Arial, sans-serif !important;
	color: #000000 !important;
}
ul.compare_widget_ul {
	list-style:none !important;
	margin-left:0 !important;
	margin-right:0 !important;
	padding-left:0 !important;
	padding-right:0 !important;	
}
ul.compare_widget_ul li.compare_widget_item {
	background:none !important;
	list-style:none !important;
	margin-left:0 !important;
	margin-right:0 !important;
	padding-left:0 !important;
	padding-right:0 !important;
	margin-bottom:5px;
}
.woo_compare_remove_product {
	cursor:pointer;
	display:inline-block !important;
	text-decoration: none !important;
}
.woo_compare_remove_icon {
	border:none !important;
	padding:0 !important;
	margin:6px 0 0 !important;	
	max-width:10px !important;
	max-height:10px !important;
}
.woo_compare_widget_item {
	display:block !important;
	text-decoration:none;	
}

.compare_widget_action {
	margin-top:10px;	
}

/* Compare Thumbnail Style */
.woo_compare_widget_thumbnail {
	width: 64px !important;
	max-width: 100% !important;
	min-width: auto !important;
	height: auto !important;
	float: left !important;
  	margin: 0 5px 2px 0 !important;
  	padding: 2px !important;
	/*Background*/
	background-color: #FFFFFF !important;
	
	/*Border*/
	border: 1px solid #CDCDCE !important;
  	border-radius: 0px !important;
  	-moz-border-radius: 0px !important;
  	-webkit-border-radius: 0px !important;
	
	/* Shadow */
	box-shadow: none !important;
  	-moz-box-shadow: none !important;
 	-webkit-box-shadow: none !important;
	
}

.compare_remove_column {
	float: right;
}
.compare_title_column {
	margin-right:15px;
}

/* Compare Widget Button Style */
.woo_compare_widget_button_container { 
	text-align:center;
	float: right !important;
}
.woo_compare_button_go {
	cursor:pointer;
	display: inline-block !important;
	line-height: 1 !important;
	margin:0;
}
.woo_compare_widget_button_go {
	padding: 7px 8px !important;
	/*Background*/
	background-color: #476381 !important;
	background: -webkit-gradient(
					linear,
					left top,
					left bottom,
					color-stop(.2, #538bbc),
					color-stop(1, #476381)
				) !important;;
	background: -moz-linear-gradient(
					center top,
					#538bbc 20%,
					#476381 100%
				) !important;;
	
		
	/*Border*/
	border: 1px solid #476381 !important;
  	border-radius: 3px 3px 3px 3px !important;
  	-moz-border-radius: 3px 3px 3px 3px !important;
  	-webkit-border-radius: 3px 3px 3px 3px !important;
	
	/* Shadow */
	box-shadow: none !important;
  	-moz-box-shadow: none !important;
  	-webkit-box-shadow: none !important;
	
	/* Font */
	font: bold 12px/1.4em Arial, sans-serif !important;
  	color: #FFFFFF !important;
	
	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}
.woo_compare_widget_link_go {
	/* Font */
	font: bold 12px/1.4em Arial, sans-serif !important;
  	color: #000000 !important;
}
.woo_compare_widget_link_go:hover {
	color: #999999 !important;
}


/* Compare Widget Clear All Items Style */
.woo_compare_clear_all_container {
	text-align:center;
	float: right !important;
	margin-top: 8px !important;
}
.woo_compare_clear_all {
	cursor:pointer;
	display: inline-block !important;
	line-height: 1 !important;
	margin:0;
}
.woo_compare_clear_all_button {
	padding: 7px 8px !important;
	/*Background*/
	background-color: #476381 !important;
	background: -webkit-gradient(
					linear,
					left top,
					left bottom,
					color-stop(.2, #538bbc),
					color-stop(1, #476381)
				) !important;;
	background: -moz-linear-gradient(
					center top,
					#538bbc 20%,
					#476381 100%
				) !important;;
	
		
	/*Border*/
	border: 1px solid #476381 !important;
  	border-radius: 3px 3px 3px 3px !important;
  	-moz-border-radius: 3px 3px 3px 3px !important;
  	-webkit-border-radius: 3px 3px 3px 3px !important;
	
	/* Shadow */
	box-shadow: none !important;
  	-moz-box-shadow: none !important;
  	-webkit-box-shadow: none !important;
	
	/* Font */
	font: bold 12px/1.4em Arial, sans-serif !important;
  	color: #FFFFFF !important;
	
	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}
.woo_compare_clear_all_link {
	/* Font */
	font: bold 12px/1.4em Arial, sans-serif !important;
  	color: #000000 !important;
}
.woo_compare_clear_all_link:hover {
	color: #999999 !important;
}

/* 3RD Party Contact Form */
.3rd_inquiry_form_container {
	margin-top:10px;	
}

/* Video & Audio Container */
.woocp_video_type_container {
	width:80%;
	position: relative;
	padding-bottom: 45%; /* 16:9 */
	padding-top: 25px;
	height: 0;
}
.woocp_video_type_container iframe {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
}
.woocp_audio_type_container {
	width:80%;
	padding:5px 0;	
}
</style>
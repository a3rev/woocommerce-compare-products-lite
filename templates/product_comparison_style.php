<style>
<?php
// Grid View Button Style
global $woo_compare_comparison_page_global_settings;
extract($woo_compare_comparison_page_global_settings);
?>
@charset "UTF-8";
/* CSS Document */

/* Comparison Page Body Style */
body {
	<?php echo $GLOBALS[WOOCP_PREFIX.'admin_interface']->generate_background_color_css( $body_bg_colour ); ?>
}

.compare_print_container {
	z-index:9;	
}
/* Comparison Page Header Style */
.compare_heading {
	/*Background*/
	<?php echo $GLOBALS[WOOCP_PREFIX.'admin_interface']->generate_background_color_css( $header_bg_colour ); ?>
	/*Border*/
	border-bottom: <?php echo esc_attr( $header_bottom_border['width'] ); ?> <?php echo esc_attr( $header_bottom_border['style'] ); ?> <?php echo esc_attr( $header_bottom_border['color'] ); ?> !important;
}

/* Comparison Empty Window Message Style */
.no_compare_list {
	text-align: <?php echo $no_product_message_align; ?>;
	/* Font */
	<?php echo $GLOBALS[WOOCP_PREFIX.'fonts_face']->generate_font_css( $woo_compare_comparison_page_global_settings['no_product_message_font'] ); ?>
}


/* Print Message Style */
.woo_compare_print_msg {
	text-align: right;
	/* Font */
	font: normal 12px/1.4em Arial, sans-serif !important;
  	color: #000000 !important;
}

<?php
// Print Button Style
?>

/* Print Button Style */
.woo_compare_print {
	float:right;
	cursor:pointer;
	display: inline-block;
	line-height: 1 !important;
	margin: 0 10px 5px 0 !important;
	padding: 7px 10px !important;
}
.compare_print_button_type {
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
.compare_print_link_type {
	position:relative;
	/* Font */
	font: bold 14px/1.4em Arial, sans-serif !important;
  	color: #21759B !important;
}
.compare_print_link_type:hover {
	color: #D54E21 !important;
}


/* Close Button Style */
.woo_compare_close {
	float:right;
	cursor:pointer;
	display: inline-block;
	line-height: 1 !important;
	padding: 7px 10px !important;
	margin: 0 10px 5px 0 !important;
}
.compare_close_button_type {
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
.compare_close_link_type {
	position:relative;
	/* Font */
	font: bold 14px/1.4em Arial, sans-serif !important;
  	color: #21759B !important;
}
.compare_close_link_type:hover {
	color: #D54E21 !important;
}

/* Table Style */
#bg-labels {
	<?php echo $GLOBALS[WOOCP_PREFIX.'admin_interface']->generate_background_color_css( $body_bg_colour ); ?>
}
#nameTableHldr {
	background-color: #FFF !important;
}
#product_comparison {
	/*Border*/
	border: 1px solid #D6D6D6 !important;
  	border-radius: 0px !important;
  	-moz-border-radius: 0px !important;
  	-webkit-border-radius: 0px !important;
	border-collapse:collapse !important;
}
#nameTable {
	/*Border*/
	border: 1px solid #D6D6D6 !important;
  	border-radius: 0px !important;
  	-moz-border-radius: 0px !important;
  	-webkit-border-radius: 0px !important;
	border-collapse:collapse !important;
}

/* Tabe First Cell Style */
tr.row_product_detail th, tr.row_product_detail td {
	/*Background*/
	background-color: #FFFFFF !important;
}
tr.row_2 td, tr.row_2 th {
	background-color: #F6F6F6 !important;
}
/* Tabe Cell Style */
#product_comparison td, #nameTable td {
	border-right: 1px solid #D6D6D6 !important;
  	border-bottom: 1px solid #D6D6D6 !important;
	border-left:none;
}
#product_comparison th, #nameTable th {
	border:none;	
}
#bg-labels span, .td-spacer {
	padding-top: 10px !important;
  	padding-bottom: 10px !important;
  	padding-left: 10px !important;
  	padding-right: 10px !important;
}

/* Add To Cart */
.compare_add_cart a.add_to_cart_button_type {
	position:relative;
	display:inline-block;
	padding: 7px 8px !important;
	margin-bottom:5px !important;
	
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

.compare_add_cart a.add_to_cart_link_type {
	position:relative;
	/* Font */
	font: bold 12px/1.4em Arial, sans-serif !important;
  	color: #21759B !important;
}
.compare_add_cart a.add_to_cart_link_type:hover {
	color: #D54E21 !important;
}
.compare_add_cart a.added:before {
	background: url(<?php echo WOOCP_IMAGES_URL; ?>/addtocart_success.png) no-repeat scroll 0 center transparent;
	position: absolute;
	right:-26px;
    content: "";
    height: 16px;
    text-indent: 0;
    width: 16px;
}

/* View Cart */
.compare_add_cart a.added_to_cart {
	display:block;
	/* Font */
	font: normal 12px/1.4em Arial, sans-serif !important;
  	color: #21759B !important;
}
.compare_add_cart a.added_to_cart:hover {
  	color: #D54E21 !important;
}
.compare_add_cart .virtual_added_to_cart {
	display:block;
	visibility:hidden;
	/* Font */
	font: normal 12px/1.4em Arial, sans-serif !important;
  	color: #21759B !important;
}


/* Compare Feature Titles ( Left Fixed Column) Style */
.compare_value {
	/* Font */
	font: bold 12px/1.4em Arial, sans-serif !important;
  	color: #000000 !important;
	
	text-align: right !important;
}

/* Table Rows Feature Values Font */
.td-spacer {
	/* Font */
	font: normal 12px/1.4em Arial, sans-serif !important;
  	color: #000000 !important;
}

.td-spacer iframe {
	z-index:8;	
}

/* Empty Feature Values Row Cell Display */
#product_comparison td.empty_cell {
	/*Background*/
	background-color: #F6F6F6 !important;
}
.empty_text {
	/* Font */
	font: normal 12px/1.4em Arial, sans-serif !important;
  	color: #000000 !important;
}

/* Product Name Font */
.compare_product_name {
	/* Font */
	font: bold 12px/1.4em Arial, sans-serif !important;
  	color: #CC3300 !important;
}

/* Price Style */
.compare_price {
	/* Font */
	font: bold 16px/1.4em Arial, sans-serif !important;
  	color: #CC3300 !important;
}

/* For Print Page*/
.compare_popup_print .hide_in_print {
	display: none !important;	
}
.compare_popup_print .compare_heading {
	position:absolute !important;
}
.compare_popup_print .compare_value {
	text-align: right !important;
  	padding-top: 10px !important;
  	padding-bottom: 10px !important;
  	padding-left: 10px !important;
  	padding-right: 10px !important;
	width:215px !important;
}
.compare_popup_print #product_comparison th, .compare_popup_print #product_comparison td {
	border-right: 1px solid #D6D6D6 !important;
  	border-bottom: 1px solid #D6D6D6 !important;
}

/* For Media on WP 4.4 */
.wp-audio-shortcode {
	visibility: visible !important;
}
</style>
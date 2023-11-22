<?php
/**
 * The Template for compare products
 *
 * Override this template by copying it to yourtheme/woocommerce/product-compare.php
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

		$woo_compare_logo = get_option('woo_compare_logo');
		$suffix	= defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		
		global $woo_compare_comparison_page_global_settings;
		
		$wc_frontend_script_path = str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() ) . '/assets/js/frontend/';
		
		// Variables for JS scripts
		$add_to_cart_params = array(
			'ajax_url'                => WC()->ajax_url(),
			'wc_ajax_url'             => WC_AJAX::get_endpoint( "%%endpoint%%" ),
			'i18n_view_cart'          => __('View Cart &rarr;', 'woocommerce-compare-products' ),
			'cart_url'                => apply_filters( 'woocommerce_add_to_cart_redirect', wc_get_cart_url(), null ),
			'is_cart'                 => false,
			'cart_redirect_after_add' => get_option( 'woocommerce_cart_redirect_after_add' )
		);
?>
<!doctype html>
<html>
<head>
<!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> -->
<?php global $post; ?>
<?php $site_url = str_replace( array( 'http:', 'https:' ), '', get_option('siteurl') ); ?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo $post->post_title; ?> | <?php bloginfo('name'); ?></title>
<meta name="description" content="Default Description" />
<meta name="keywords" content="<?php bloginfo('name'); ?>" />
<meta name="robots" content="INDEX,FOLLOW" />
<script type="text/javascript" src="<?php echo $site_url; ?>/wp-includes/js/jquery/jquery.js"></script>
<script src="<?php echo WOOCP_JS_URL; ?>/jquery.printElement.js"></script>
<?php do_action('woocp_comparison_page_header'); ?>
<?php
	$wc_frontend_scripts_class = new WC_Frontend_Scripts();
	$wc_frontend_scripts_class->load_scripts();
?>
</head>
<body>
		<?php
			$print_button_class = 'compare_print_button_type';
			$print_custom_class = '';
			$print_button_text = __('Print this page', 'woocommerce-compare-products' );

			$close_button_class = 'compare_close_button_type';
			$close_custom_class = '';
			$close_button_text = __('Close window', 'woocommerce-compare-products' );
		?>
    	<div class="compare_print_container"><div id="compare_popup_container" class="compare_popup_container">
        <link type="text/css" href="<?php echo WOOCP_JS_URL; ?>/fixedcolumntable/fixedcolumntable.css" rel="stylesheet" />
        <?php 
		$_upload_dir = wp_upload_dir();
		if ( file_exists( $_upload_dir['basedir'] . '/sass/wc_product_comparison.min.css' ) ) {
			echo '<link media="screen" type="text/css" href="' . str_replace(array('http:','https:'), '', $_upload_dir['baseurl'] ) . '/sass/wc_product_comparison.min.css?ver='.$GLOBALS[WOOCP_PREFIX.'less']->get_css_file_version().'" rel="stylesheet" />' . "\n";
		} else {
			include( WOOCP_DIR. '/templates/product_comparison_style.php' ); 
		}
		?>
        <?php do_action('woocp_comparison_table_before'); ?>
				<div class="compare_heading">
					<?php if ( $woo_compare_logo != '') { ?>
                    <img class="compare_logo" src="<?php echo $woo_compare_logo; ?>" alt="<?php _e('Compare Products', 'woocommerce-compare-products' ); ?>" />
                    <?php } else { ?>
                    <h1><?php _e('Compare Products', 'woocommerce-compare-products' ); ?></h1>
                    <?php } ?>
                    <div class="print_control">
                        <?php if ($woo_compare_comparison_page_global_settings['open_compare_type'] != 'new_page') { ?><a class="woo_compare_close <?php echo $close_button_class ;?> <?php echo $close_custom_class ;?>" href="#" onClick="window.close();"><span><?php echo $close_button_text ;?></span></a><?php } ?>
                        <a id="woo_compare_print" class="woo_compare_print <?php echo $print_button_class ;?> <?php echo $print_custom_class ;?>" href="#"><span><?php echo $print_button_text ;?></span></a>
                        <div style="clear:both;"></div>
                    	<div class="woo_compare_print_msg"><?php echo __('Refine selections to 3 products and print!', 'woocommerce-compare-products' );?></div>
                    </div>
                </div>
            	<div style="clear:both;"></div>
                <div class="popup_woo_compare_widget_loader" style="display:none;"><img src="<?php echo WOOCP_IMAGES_URL; ?>/ajax-loader.gif" border=0 /></div>
                <div class="compare_popup_wrap">
                    <?php echo \A3Rev\WCCompare\Functions::get_compare_list_html_popup();?>
                </div>
        <?php do_action('woocp_comparison_table_after'); ?>
        </div>
        </div>
        <?php
			$woocp_compare_events = wp_create_nonce("woocp-compare-events");
		?>
        <script type="text/javascript">
			jQuery(document).ready(function($) {
						var ajax_url = "<?php echo admin_url( 'admin-ajax.php', 'relative' );?>";
						$(document).on("click", "#woo_compare_print", function(){
							$(".compare_print_container").printElement({
								printBodyOptions:{
								styleToAdd:"overflow:visible !important;",
								classNameToAdd : "compare_popup_print"
								}
							});
						});
						$(document).on("click", ".woo_compare_popup_remove_product", function(){
							var popup_remove_product_id = $(this).attr("rel");
							$(".popup_woo_compare_widget_loader").show();
							$(".compare_popup_wrap").html("");
							$("#bg-labels").remove();
							var data = {
								action: 		"woocp_remove_from_popup_compare",
								product_id: 	popup_remove_product_id,
								security: 		"<?php echo $woocp_compare_events; ?>"
							};
							$.post( ajax_url, data, function(response) {
								data = {
									action: 		"woocp_update_compare_popup",
									security: 		"<?php echo $woocp_compare_events; ?>"
								};
								$.post( ajax_url, data, function(response) {
									result = JSON.parse( response );
									$(".popup_woo_compare_widget_loader").hide();
									$(".compare_popup_wrap").html(result);
								});

								data = {
									action: 		"woocp_update_compare_widget",
									security: 		"<?php echo $woocp_compare_events; ?>"
								};
								$.post( ajax_url, data, function(response) {
									new_widget = JSON.parse( response );
									$(".woo_compare_widget_container").html(new_widget);
								});
							});
						});
						$(document).on( 'click', '.add_to_cart_button', function() {
							$(this).parent().find('.virtual_added_to_cart').remove();
							setTimeout(function(){ $(document).find('.added_to_cart').attr('target', 'parent'); }, 3000);
						});
			});
		</script>
        <?php do_action('woocp_comparison_page_footer'); ?>
        <script type="text/javascript">
		/* !![CDATA[ */
		var wc_add_to_cart_params = <?php echo json_encode( apply_filters( 'woocommerce_get_script_data', $add_to_cart_params, 'wc-add-to-cart' ), JSON_FORCE_OBJECT) ?>;
		/* ]]> */
		</script>
        <script src="<?php echo WOOCP_JS_URL; ?>/fixedcolumntable/fixedcolumntable.js"></script>
        <script src="<?php echo $wc_frontend_script_path; ?>add-to-cart<?php echo $suffix; ?>.js"></script>
        <script src="<?php echo str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() ); ?>/assets/js/jquery-blockui/jquery.blockUI<?php echo $suffix; ?>.js"></script>
</body>
</html>
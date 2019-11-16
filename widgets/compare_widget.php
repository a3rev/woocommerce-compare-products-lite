<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */

/**
 * WooCommerce Compare Widget
 *
 * Table Of Contents
 *
 * WC_Compare_Widget()
 * widget()
 * update()
 * form()
 */

namespace A3Rev\WCCompare;

class Widget extends \WP_Widget
{

	function __construct() {
		$widget_ops = array(
			'classname'   => 'woo_compare_widget',
			'customize_selective_refresh' => true,
		);
		parent::__construct('woo_compare_widget', __('WOO Compare Products', 'woocommerce-compare-products' ), $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$total_compare_product = 0;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		
		echo $before_widget;
		
		if ( $title != '')
			echo $before_title . $title . ' <span class="total_compare_product_container">(<span id="total_compare_product">'.$total_compare_product.'</span>)</span>' . $after_title;
		else
			echo $before_title . __( 'Compare Products', 'woocommerce-compare-products' ).' <span class="total_compare_product_container">(<span id="total_compare_product">'.$total_compare_product.'</span>)</span>' . $after_title;


		echo '<div class="woo_compare_widget_container"></div><div class="woo_compare_widget_loader" style="display:none; text-align:center"><img src="'.WOOCP_IMAGES_URL.'/ajax-loader.gif" border=0 /></div>';

		echo $after_widget;

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;

	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = strip_tags($instance['title']);
?>

        <p>
          	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', 'woocommerce-compare-products' ); ?> :
            	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
          	</label>
        </p>
		<?php
	}
}

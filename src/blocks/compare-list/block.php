<?php
/**
 * Server-side rendering of the `core/post-title` block.
 *
 * @package WordPress
 */

/**
 * Renders the `core/post-title` block on the server.
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Block default content.
 * @param WP_Block $block      Block instance.
 *
 * @return string Returns the filtered post title for the current post wrapped inside "h1" tags.
 */
function render_block_a3_wc_compare_list( $attributes, $content, $block ) {
	$wrapper_attributes = get_block_wrapper_attributes();

	$output_html = '';

	$title = ! empty( $attributes['title'] ) ? $attributes['title'] : '';
	if ( ! empty( $title ) ) {
		global $woo_compare_widget_style;
		$total_compare_product = 0;

		$before_total_text = $woo_compare_widget_style['before_total_text'];
		$after_total_text  = $woo_compare_widget_style['after_total_text'];

		$output_html .= '<div id="compare_widget_title_container"><span id="compare_widget_title_text">' . $title . ' <span class="total_compare_product_container">'.$before_total_text.'<span id="total_compare_product">'.$total_compare_product.'</span>'.$after_total_text.'</span>' . '</span></div><div style="clear:both"></div>';
	}

	$output_html .= '<div class="woo_compare_widget_container"><ul class="compare_widget_ul"></ul></div>';
	$output_html .= '<div id="compare_widget_footer_container"></div>';

	return sprintf( '<div %1$s>%2$s</div>', $wrapper_attributes, $output_html );
}

/**
 * Registers the `core/post-title` block on the server.
 */
function register_block_a3_wc_compare_list() {
	register_block_type(
		__DIR__ . '/block.json',
		array(
			'render_callback' => 'render_block_a3_wc_compare_list',
		)
	);
}
add_action( 'init', 'register_block_a3_wc_compare_list' );

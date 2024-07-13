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
function render_block_a3_wc_compare_button( $attributes, $content, $block ) {
	if ( ! empty( $block->context['postId'] ) ) {
		$product_id = $block->context['postId'];
	} else {
		$product_id = \A3Rev\WCCompare\Hook_Filter::get_current_product_id( 0 );
	}

	if ( empty( $product_id ) ) return '';

	$container_classes = '';
	$container_classes .= isset( $attributes['width'] ) ? ' has-custom-width wp-block-button__width-' . $attributes['width'] : '';
	$container_classes .= isset( $attributes['textAlign'] ) ? ' has-text-align-' . $attributes['textAlign'] : '';
	$container_classes .= is_product() ? ' is_single_view' : ' is_grid_view';
    
    $classes = 'wp-block-button__link wp-element-button woo_bt_compare_this';
	$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => $classes ) );

    $btText = ! empty( $attributes['content'] ) ? wp_kses_post( $attributes['content'] ) : __( 'Compare This*' );

    $buttonOutput = '<div class="wp-block-button wp-block-compare-button '.$container_classes.'"><a href="#" onclick="event.preventDefault();" '.$wrapper_attributes.' id="woo_bt_compare_this_'.$product_id.'" data-product-id="'.$product_id.'" rel="nofollow">'.$btText.'</a>%s</div>';

    $output = \A3Rev\WCCompare\Hook_Filter::add_compare_button( $product_id, $buttonOutput );

	return $output;
}

/**
 * Registers the `core/post-title` block on the server.
 */
function register_block_a3_wc_compare_button() {
	register_block_type(
		__DIR__ . '/block.json',
		array(
			'render_callback' => 'render_block_a3_wc_compare_button',
		)
	);
}
add_action( 'init', 'register_block_a3_wc_compare_button' );

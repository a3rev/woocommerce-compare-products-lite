<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

namespace A3Rev\WCCompare;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Blocks {

	public function __construct() {
		add_action( 'init', array( $this, 'register_block' ) );

		// Hook: Editor assets.
		add_action( 'enqueue_block_assets', array( $this, 'cgb_editor_assets' ) );
	}

	public function create_a3blocks_section() {

		add_filter( 'block_categories_all', function( $categories ) {

			$category_slugs = wp_list_pluck( $categories, 'slug' );

			if ( in_array( 'a3rev-blocks', $category_slugs ) ) {
				return $categories;
			}

			return array_merge(
				array(
					array(
						'slug' => 'a3rev-blocks',
						'title' => __( 'a3rev Blocks' ),
						'icon' => '',
					),
				),
				$categories
			);
		}, 2 );
	}

	public function register_block() {
		$this->create_a3blocks_section();
	}

	/**
	 * Enqueue Gutenberg block assets for backend editor.
	 *
	 * @uses {wp-blocks} for block type registration & related functions.
	 * @uses {wp-element} for WP Element abstraction — structure of blocks.
	 * @uses {wp-i18n} to internationalize the block's text.
	 * @uses {wp-editor} for WP editor styles.
	 * @since 1.0.0
	 */
	function cgb_editor_assets() { // phpcs:ignore

		if ( ! is_admin() ) {
			return;
		}

		$js_deps = apply_filters( 'woocp_block_js_deps', array( 'wp-block-editor', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-data', 'wp-compose', 'wp-components' ) );

		wp_register_script(
			'wc-cp-block-editor', // Handle.
			plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ),
			$js_deps,
			WOOCP_VERSION,
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);

		wp_localize_script( 'wc-cp-block-editor', 'compare_list_block_editor', array( 
			'preview'    => WOOCP_URL.  '/src/assets/preview.jpg',
		) );

		// Styles.
		wp_register_style(
			'wc-cp-block-editor', // Handle.
			plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
			array( 'wp-edit-blocks' ),
			WOOCP_VERSION
		);
	}
}

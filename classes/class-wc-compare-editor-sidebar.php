<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */

namespace A3Rev\WCCompare;

class EditorSidebar {

	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_meta_fields' ) );
		add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_sidebar_assets' ) );
		add_action( 'updated_post_meta', array( __CLASS__, 'sync_category_name' ), 10, 4 );
		add_action( 'added_post_meta', array( __CLASS__, 'sync_category_name' ), 10, 4 );
	}

	public static function register_meta_fields() {
		register_post_meta( 'product', '_woo_deactivate_compare_feature', array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'default'       => 'yes',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		) );

		register_post_meta( 'product', '_woo_compare_category', array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'default'       => '0',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		) );

		$all_fields = Data\Categories_Fields::get_results( '', 'cf.field_order ASC' );
		if ( ! is_array( $all_fields ) || empty( $all_fields ) ) {
			return;
		}

		$registered = array();
		foreach ( $all_fields as $field ) {
			$meta_key = '_woo_compare_' . $field->field_key;
			if ( isset( $registered[ $meta_key ] ) ) {
				continue;
			}
			$registered[ $meta_key ] = true;

			if ( in_array( $field->field_type, array( 'checkbox', 'multi-select' ), true ) ) {
				register_post_meta( 'product', $meta_key, array(
					'show_in_rest'  => array(
						'schema' => array(
							'type'  => 'array',
							'items' => array( 'type' => 'string' ),
						),
					),
					'single'        => true,
					'type'          => 'array',
					'default'       => array(),
					'auth_callback' => function () {
						return current_user_can( 'edit_posts' );
					},
				) );
			} else {
				register_post_meta( 'product', $meta_key, array(
					'show_in_rest'  => true,
					'single'        => true,
					'type'          => 'string',
					'default'       => '',
					'auth_callback' => function () {
						return current_user_can( 'edit_posts' );
					},
				) );
			}
		}
	}

	/**
	 * Keep _woo_compare_category_name in sync when category is changed via REST API.
	 */
	public static function sync_category_name( $meta_id, $object_id, $meta_key, $meta_value ) {
		if ( '_woo_compare_category' !== $meta_key ) {
			return;
		}
		if ( 'product' !== get_post_type( $object_id ) ) {
			return;
		}
		$category_data = Data\Categories::get_row( $meta_value );
		if ( null !== $category_data ) {
			update_post_meta( $object_id, '_woo_compare_category_name', stripslashes( $category_data->category_name ) );
		}
	}

	public static function enqueue_sidebar_assets() {
		$screen = get_current_screen();
		if ( ! $screen || 'product' !== $screen->post_type ) {
			return;
		}

		$categories    = array();
		$category_fields = array();

		$compare_cats = Data\Categories::get_results( '', 'category_order ASC' );
		if ( is_array( $compare_cats ) && count( $compare_cats ) > 0 ) {
			foreach ( $compare_cats as $cat_data ) {
				$cat_id = (string) $cat_data->id;

				$categories[] = array(
					'value' => $cat_id,
					'label' => stripslashes( $cat_data->category_name ),
				);

				$fields    = Data\Categories_Fields::get_results( "cat_id='" . $cat_data->id . "'", 'cf.field_order ASC' );
				$cat_fields = array();
				if ( is_array( $fields ) && count( $fields ) > 0 ) {
					foreach ( $fields as $field ) {
						$options = array();
						if ( in_array( $field->field_type, array( 'checkbox', 'radio', 'drop-down', 'multi-select' ), true )
							&& trim( $field->default_value ) !== '' ) {
							$default_value = nl2br( $field->default_value );
							$raw_options   = explode( '<br />', $default_value );
							foreach ( $raw_options as $opt ) {
								$opt = trim( stripslashes( $opt ) );
								if ( '' !== $opt ) {
									$options[] = $opt;
								}
							}
						}
						$cat_fields[] = array(
							'key'     => $field->field_key,
							'name'    => stripslashes( $field->field_name ),
							'type'    => $field->field_type,
							'unit'    => trim( stripslashes( $field->field_unit ) ),
							'options' => $options,
						);
					}
				}
				$category_fields[ $cat_id ] = $cat_fields;
			}
		}

		wp_enqueue_script(
			'wc-compare-editor-sidebar',
			WOOCP_URL . '/admin/assets/js/wc-compare-editor-sidebar.js',
			array( 'wp-plugins', 'wp-edit-post', 'wp-editor', 'wp-components', 'wp-data', 'wp-element', 'wp-i18n' ),
			WOOCP_VERSION,
			true
		);

		wp_localize_script( 'wc-compare-editor-sidebar', 'wcCompareEditorData', array(
			'categories'     => $categories,
			'categoryFields' => (object) $category_fields,
			'addFeaturesUrl' => admin_url( 'admin.php?page=woo-compare-features' ),
		) );
	}
}

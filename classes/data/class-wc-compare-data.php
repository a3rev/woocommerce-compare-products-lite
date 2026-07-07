<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Fields Data
 *
 * Table Of Contents
 *
 * install_database()
 * get_row()
 * get_maximum_order()
 * get_count()
 * get_results()
 * insert_row()
 * update_row()
 * update_field_key()
 * update_items_order()
 * update_order()
 * delete_rows()
 * delete_row()
 * check_field_key()
 * check_field_key_for_update()
 */

namespace A3Rev\WCCompare;

class Data 
{
	public static function install_database() {
		global $wpdb;
		$collate = '';
		if ( $wpdb->has_cap( 'collation' ) ) {
			if( ! empty($wpdb->charset ) ) $collate .= "DEFAULT CHARACTER SET $wpdb->charset";
			if( ! empty($wpdb->collate ) ) $collate .= " COLLATE $wpdb->collate";
		}
	
		$table_woo_compare_fields = $wpdb->prefix. "woo_compare_fields";
		if ($wpdb->get_var("SHOW TABLES LIKE '$table_woo_compare_fields'") != $table_woo_compare_fields) {
			$sql = "CREATE TABLE IF NOT EXISTS `{$table_woo_compare_fields}` (
				  `id` int(11) NOT NULL auto_increment,
				  `field_name` blob NOT NULL,
				  `field_key` varchar(250) NOT NULL,
				  `field_type` varchar(250) NOT NULL,
				  `default_value` blob NOT NULL,
				  `field_unit` blob NOT NULL,
				  `field_description` blob NOT NULL,
				  `field_order` int(11) NOT NULL,
				  PRIMARY KEY  (`id`)
				) $collate; ";

			$wpdb->query($sql);
		}
	}
	

	public static function get_row($id, $where='', $output_type='OBJECT') {
		global $wpdb;
		$table_name = $wpdb->prefix. "woo_compare_fields";
		$id = absint( $id );
		if (trim($where) != '')
			$where = ' AND '.$where;
		$result = $wpdb->get_row("SELECT * FROM {$table_name} WHERE id='$id' {$where}", $output_type);
		return $result;
	}

	public static function get_maximum_order($where='') {
		global $wpdb;
		$table_name = $wpdb->prefix . "woo_compare_fields";
		if (trim($where) != '')
			$where = " WHERE {$where} ";
		$maximum = $wpdb->get_var("SELECT MAX(field_order) FROM {$table_name} {$where}");

		return $maximum;
	}

	public static function get_count($where='') {
		global $wpdb;
		$table_name = $wpdb->prefix . "woo_compare_fields";
		if (trim($where) != '')
			$where = " WHERE {$where} ";
		$count = $wpdb->get_var("SELECT COUNT(id) FROM {$table_name} {$where}");

		return $count;
	}

	public static function get_results($where='', $order='', $limit ='', $output_type='OBJECT') {
		global $wpdb;
		$table_name = $wpdb->prefix . "woo_compare_fields";
		if (trim($where) != '')
			$where = " WHERE {$where} ";
		if (trim($order) != '')
			$order = " ORDER BY {$order} ";
		if (trim($limit) != '')
			$limit = " LIMIT {$limit} ";
		$result = $wpdb->get_results("SELECT * FROM {$table_name} {$where} {$order} {$limit}", $output_type);
		return $result;
	}

	public static function insert_row($args) {
		global $wpdb;
		$table_name = $wpdb->prefix. "woo_compare_fields";
		$field_name = strip_tags( wp_unslash( $args['field_name'] ) );
		$field_type = strip_tags( wp_unslash( $args['field_type'] ) );
		$default_value = strip_tags( wp_unslash( $args['default_value'] ) );
		$field_unit = strip_tags( wp_unslash( $args['field_unit'] ), '<sup>' );
		$field_description = '';
		$field_order = self::get_maximum_order();
		$field_order++;
		$field_key = '';
		$data = array(
			'field_name'        => $field_name,
			'field_key'         => $field_key,
			'field_type'        => $field_type,
			'default_value'     => $default_value,
			'field_unit'        => $field_unit,
			'field_description' => $field_description,
			'field_order'       => $field_order,
		);
		$formats = array( '%s', '%s', '%s', '%s', '%s', '%s', '%d' );
		if (trim($field_key) == '') {
			$inserted = $wpdb->insert( $table_name, $data, $formats );
			if ($inserted) {
				$field_id = $wpdb->insert_id;
				$field_key = 'field-'.$field_id;
				self::update_field_key($field_id, $field_key);
				return $field_id;
			}else {
				return false;
			}
		}else {
			if (self::check_field_key($field_key)) {
				$data['field_key'] = $field_key;
				$inserted = $wpdb->insert( $table_name, $data, $formats );
				if ($inserted) {
					$field_id = $wpdb->insert_id;
					return $field_id;
				}else {
					return false;
				}
			}else {
				return false;
			}
		}
	}

	public static function update_row($args) {
		global $wpdb;
		$table_name = $wpdb->prefix. "woo_compare_fields";
		$field_name = strip_tags( wp_unslash( $args['field_name'] ) );
		$field_type = strip_tags( wp_unslash( $args['field_type'] ) );
		$default_value = strip_tags( wp_unslash( $args['default_value'] ) );
		$field_unit = strip_tags( wp_unslash( $args['field_unit'] ), '<sup>' );
		$field_description = '';
		$query = $wpdb->update(
			$table_name,
			array(
				'field_name'        => $field_name,
				'field_type'        => $field_type,
				'default_value'     => $default_value,
				'field_unit'        => $field_unit,
				'field_description' => $field_description,
			),
			array( 'id' => absint( $args['field_id'] ) ),
			array( '%s', '%s', '%s', '%s', '%s' ),
			array( '%d' )
		);
		return $query;

	}

	public static function update_field_key($field_id, $field_key) {
		global $wpdb;
		$table_name = $wpdb->prefix. "woo_compare_fields";
		$query = $wpdb->update( $table_name, array( 'field_key' => $field_key ), array( 'id' => absint( $field_id ) ), array( '%s' ), array( '%d' ) );
		return $query;
	}

	public static function update_items_order($item_orders=array()) {
		if (is_array($item_orders) && count($item_orders) > 0) {
			foreach ($item_orders as $field_id => $field_order) {
				self::update_order($field_id, $field_order);
			}
		}
	}

	public static function update_order($field_id, $field_order=0) {
		global $wpdb;
		$table_name = $wpdb->prefix. "woo_compare_fields";
		$query = $wpdb->update( $table_name, array( 'field_order' => absint( $field_order ) ), array( 'id' => absint( $field_id ) ), array( '%d' ), array( '%d' ) );
		return $query;
	}

	public static function delete_rows($items=array()) {
		if (is_array($items) && count($items) > 0) {
			foreach ($items as $field_id) {
				self::delete_row($field_id);
			}
		}
	}

	public static function delete_row($field_id) {
		global $wpdb;
		$table_name = $wpdb->prefix. "woo_compare_fields";
		$result = $wpdb->delete( $table_name, array( 'id' => absint( $field_id ) ), array( '%d' ) );
		return $result;
	}

	public static function check_field_key($field_key) {
		global $wpdb;
		$count = self::get_count( $wpdb->prepare( "field_key=%s", $field_key ) );
		if ($count > 0) return false;
		else return true;
	}

	public static function check_field_key_for_update($field_id, $field_key) {
		global $wpdb;
		$count = self::get_count( $wpdb->prepare( "id!=%d AND field_key=%s", absint( $field_id ), $field_key ) );
		if ($count > 0) return false;
		else return true;
	}
}

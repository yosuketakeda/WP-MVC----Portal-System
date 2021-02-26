<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Upload page functions
 *
 * @author     Nirjhar Lo
 * @package    dronespov
 */
if ( ! class_exists( 'DRONESPOV_UPLOAD' ) ) {

	class DRONESPOV_UPLOAD {

		public function get_user_list() {

			$list = array();

			$args = array(
				'role'    => 'dronespov_client',
			);
			$users = get_users( $args );
			foreach ( $users as $user ) {
				$fname = get_user_meta($user->ID, 'first_name', true);
				$lname = get_user_meta($user->ID, 'last_name', true);
				$company = get_user_meta($user->ID, '_company', true);
				$list[] = array( 'id' => $user->ID, 'name' => $fname . ' ' . $lname, 'company' => $company);
			}

			return $list;
		}


		public function get_project_list() {

			$projects = array();

			global $wpdb;
			$table = $wpdb->prefix . 'dronespov_invoices';

			$fetch = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT project FROM $table"
				), ARRAY_A );

			foreach ($fetch as $item) {
				$projects[] = base64_decode($item['project']);
			}

			return array_unique($projects);
		}


		public function get_items_list() {

			$items = array();

			global $wpdb;
			$table = $wpdb->prefix . 'dronespov_invoices';

			$fetch = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT row FROM $table"
				), ARRAY_A );

			foreach ($fetch as $item) {
				$row = maybe_unserialize($item['row']);
				if (is_array($row)) {
					foreach ($row as $key => $value) {
						foreach ($value as $i => $elem) {
							$items[] = $i;
						}
					}
				}
			}

			return array_unique($items);
		}


		public function get_tax_list() {

			$items = array();

			global $wpdb;
			$table = $wpdb->prefix . 'dronespov_invoices';

			$fetch = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT tax FROM $table"
				), ARRAY_A );

			foreach ($fetch as $item) {
				$items[] = $item['tax'];
			}

			return array_unique($items);
		}


		public function editable_data() {

			if (isset($_REQUEST['edit'])) {
				$invoice_id = $_REQUEST['edit'];
			}

			if (!$invoice_id) {
				return false;
			}

			global $wpdb;

			$table = $wpdb->prefix . 'dronespov_invoices';
			$fetch = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table WHERE ID = %d", $invoice_id), ARRAY_A );

			if (isset($fetch[0]) && !empty($fetch[0])) {
				return $fetch[0];
			} else {
				return false;
			}
		}
	}
}

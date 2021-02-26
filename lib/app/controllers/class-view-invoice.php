<?php
/**
 * View invoice
 *
 * @author     Nirjhar Lo
 * @package    dronespov
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'DRONESPOV_INVOICE_VIEW' ) ) {

	final class DRONESPOV_INVOICE_VIEW {


		public function __construct() {

			$path = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
			$parts = explode('/', $path);
			$this->invoice_id = $parts[(count($parts) - 1)];

			$this->user_id = get_current_user_id();

			$this->list = new DRONESPOV_ADMIN_LIST();
		}


		public function filter_view_invoice() {

			global $wpdb;

			$bill_to = false;
			$table = $wpdb->prefix . 'dronespov_invoices';

			$fetch = $wpdb->get_results(
				$wpdb->prepare("SELECT bill_to FROM $table WHERE ID = %d AND is_trash = 0", $this->invoice_id),
				ARRAY_A );

			if (!empty($fetch[0])) {
				$bill_to = $fetch[0]['bill_to'];
			}

			if ($bill_to != $this->user_id) {
				wp_safe_redirect(site_url() . '/login');
			}
		}


		public function filter_for_admin_view_invoice() {

			global $wpdb;

			$created_by = false;
			$table = $wpdb->prefix . 'dronespov_invoices';

			$fetch = $wpdb->get_results(
				$wpdb->prepare("SELECT created_by FROM $table WHERE ID = %d AND is_trash = 0", $this->invoice_id),
				ARRAY_A );

			if (!empty($fetch[0])) {
				$created_by = $fetch[0]['created_by'];
			}

			if ($this->user_id != 1 && $created_by != $this->user_id) {
				wp_safe_redirect(site_url() . '/admin/list_invoice?type=invoices');
			}
		}


		public function get_old_invoice() {

			$path = false;

			global $wpdb;
			$table = $wpdb->prefix . 'dronespov_old_invoices';

			$fetch = $wpdb->get_results(
				$wpdb->prepare("SELECT url FROM $table WHERE invoice_id = %d ORDER BY ID DESC LIMIT 1", $this->invoice_id),
				ARRAY_A );

			if (isset($fetch[0]['url']) && !empty($fetch[0]['url'])) {
				$path = $fetch[0]['url'];
			}

			return $path;
		}


		public function get_invoice() {

			$col = array();

			global $wpdb;
			$table = $wpdb->prefix . 'dronespov_invoices';

			$fetch = $wpdb->get_results(
				$wpdb->prepare("SELECT * FROM $table WHERE ID = %d", $this->invoice_id),
				ARRAY_A );

			if (!empty($fetch[0])) {
				$row = $fetch[0];

				$col['id'] = $row['ID'];
				$col['name'] = $this->mask_the_string($this->list->get_name($row['bill_to']));
				$col['company'] = $this->list->get_company($row['bill_to']);
				$col['address'] = $this->format_address($this->list->get_address($row['bill_to']));
				$col['items'] = $this->get_items(maybe_unserialize($row['row']));
				$col['amounts'] = $this->get_amounts(maybe_unserialize($row['row']));
				$col['project'] = base64_decode($row['project']);
				$col['tax'] = $row['tax'];
				$col['total'] = $row['total'];
				$col['notes'] = stripslashes(base64_decode($row['notes']));
				$col['invoice_date'] = $this->list->format_date($row['invoice_date']);
				$col['due_date'] = $this->list->format_date($row['due_date']);
				$col['admin_company'] = $this->list->get_admin_company();
				$col['admin_phone'] = $this->list->get_admin_phone();
				$col['admin_address'] = $this->format_admin_address($this->list->get_admin_address());
				$col['admin_email'] = $this->list->get_admin_email();
				$col['is_estimate'] = $row['is_estimate'];
				$col['created_by'] = intval($row['created_by']);
			}

			return $col;
		}


		public function format_address($address) {

			$old_exploded = explode(',', $address);

			$exploded = array();
			foreach ($old_exploded as $value) {
				$exploded[] = $this->mask_the_string($value);
			}

			$country = $exploded[(count($exploded) - 1)];
			$zip = $exploded[(count($exploded) - 2)];
			$state = $exploded[(count($exploded) - 3)];
			$city = $exploded[(count($exploded) - 4)];

			$remaining = array_slice($exploded, 0, (count($exploded) - 4));
			array_walk($remaining, 'trim');

			return array(implode(', ', $remaining), trim($city) . ', ' . trim($state) . ' ' . trim($zip), trim($country));
		}


		public function format_address_for_paid_email($address) {

			$exploded = explode(',', $address);

			$country = $exploded[(count($exploded) - 1)];
			$zip = $exploded[(count($exploded) - 2)];
			$state = $exploded[(count($exploded) - 3)];
			$city = $exploded[(count($exploded) - 4)];

			$remaining = array_slice($exploded, 0, (count($exploded) - 4));
			array_walk($remaining, 'trim');

			return array(implode(', ', $remaining), trim($city) . ', ' . trim($state) . ' ' . trim($zip), trim($country));
		}


		public function format_admin_address($address) {

			$exploded = explode(',', $address);

			$country = $exploded[(count($exploded) - 1)];
			$zip = $exploded[(count($exploded) - 2)];
			$state = $exploded[(count($exploded) - 3)];
			$city = $exploded[(count($exploded) - 4)];

			$remaining = array_slice($exploded, 0, (count($exploded) - 4));
			array_walk($remaining, 'trim');

			return array(implode(', ', $remaining), trim($city) . ', ' . trim($state) . ' ' . trim($zip), trim($country));
		}


		public function get_items($row) {

			$data = array();
			if (is_array($row)) {
				foreach ($row as $item) {
					foreach ($item as $key => $value) {
						$data[] = $key;
					}
				}
			}

			return $data;
		}


		public function get_amounts($row) {

			$data = array();
			if (is_array($row)) {
				foreach ($row as $item) {
					foreach ($item as $key => $value) {
						$data[] = $value;
					}
				}
			}

			return $data;
		}


		public function mask_the_string($string) {

			$roles = get_userdata($this->user_id)->roles;
			if ( $this->user_id == DRONESPOV_ADMIN_ID || in_array('dronespov_client', $roles) ) {
				return $string;
			} else {
				if (strlen(trim($string)) >= 1) {
					return str_repeat( 'x', strlen(trim($string)));
				}
			}
		}
	}
}

<?php
/**
 * List function
 *
 * @author     Nirjhar Lo
 * @package    dronespov
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'DRONESPOV_ADMIN_LIST_DELETED' ) ) {

	final class DRONESPOV_ADMIN_LIST_DELETED {

		public function get_invoice_list() {

			$data = array();

			$data = $this->get_data();
			$data = $this->format_data($data);

			return $data;
		}


		public function get_data() {

			global $wpdb;

			$table = $wpdb->prefix . 'dronespov_invoices';

			$today = date( 'y-m-d', strtotime("today"));
			$user_id = get_current_user_id();

			if ($user_id == 1) {
				$fetch = $wpdb->get_results(
					$wpdb->prepare("SELECT * FROM $table WHERE is_trash = 1 ORDER BY ID DESC"),
					ARRAY_A );
			} else {
				$fetch = $wpdb->get_results(
					$wpdb->prepare("SELECT * FROM $table WHERE is_trash = 1 AND created_by = %d ORDER BY ID DESC", $user_id),
					ARRAY_A );
			}

			return $fetch;
		}


		public function format_data($fetch) {

			$output = array();
			foreach ($fetch as $row) {

				$col = array();

				$col['id'] = $row['ID'];
				$col['name'] = $this->get_name($row['bill_to']);
				$col['company'] = $this->get_company($row['bill_to']);
				$col['items'] = $this->get_items(maybe_unserialize($row['row']));
				$col['amounts'] = $this->get_amounts(maybe_unserialize($row['row']));
				$col['project'] = ($row['project'] == '' ? '--' : base64_decode($row['project']));
				$col['tax'] = $row['tax'];
				$col['total'] = ($row['total'] == 0 ? '--' : $row['total']);
				$col['notes'] = base64_decode($row['notes']);
				$col['invoice_date'] = $this->format_date($row['invoice_date']);
				$col['due_date'] = ($row['due_date'] == '0000-00-00' ? '--' : $this->format_date($row['due_date']));
				$col['delete_date'] = $this->format_date($row['delete_date']);
				$col['payment'] = $this->get_payment_status($row['status']);
				$col['status'] = $this->get_date_status($row['due_date'], $row['status']);

				$output[] = $col;
			}

			return $output;
		}


		public function get_admin_email() {

			$email = get_user_meta( DRONESPOV_ADMIN_ID, '_dronespov_company_email', true );

			return esc_attr($email);
		}


		public function get_admin_company() {

			$name = get_user_meta( DRONESPOV_ADMIN_ID, '_dronespov_company_name', true );

			return esc_attr($name);
		}


		public function get_admin_phone() {

			$phone = get_user_meta( DRONESPOV_ADMIN_ID, '_dronespov_company_phone', true );

			return esc_attr($phone);
		}


		public function get_admin_address() {

			$array = array();

			$array['street'] = get_user_meta( DRONESPOV_ADMIN_ID, '_dronespov_company_street', true );
			$array['city'] = get_user_meta( DRONESPOV_ADMIN_ID, '_dronespov_company_city', true );
			$array['state'] = get_user_meta( DRONESPOV_ADMIN_ID, '_dronespov_company_state', true );
			$array['zip'] = get_user_meta( DRONESPOV_ADMIN_ID, '_dronespov_company_zip', true );
			$array['country'] = get_user_meta( DRONESPOV_ADMIN_ID, '_dronespov_company_country', true );

			$output = implode(', ', $array);

			return esc_attr($output);
		}


		public function get_name($id) {

			$name = false;

			$fname = get_user_meta($id, 'first_name', true);
			$lname = get_user_meta($id, 'last_name', true);
			$name = $fname . ' ' . $lname;

			return $name;
		}


		public function get_company($id) {

			$company = false;
			$company = get_user_meta($id, '_company', true);

			return $company;
		}


		public function get_address($id) {

			$address = false;
			$address = get_user_meta($id, '_address', true);
			$array = maybe_unserialize($address);

			if (is_array($array) > 0) {
				$output = implode(', ', $array);
			} else {
				$output = $array;
			}

			return $output;
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

			$text = implode('<br />', $data);
			return $text;
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

			$text = '$' . implode('<br />$', $data);
			return $text;
		}


		public function format_date($date) {

			return date( 'm/d/y', strtotime($date));
		}


		public function get_date_status($date, $status) {

			if (intval($status) == 1) {
				return 'Paid';
			}

			$current = strtotime("today");
			if ($current <= strtotime($date)) {
				return 'Due';
			} else {
				return 'Overdue';
			}
		}


		public function get_payment_status($status) {

			if (intval($status) == 1) {
				return 'Check';
			} else {
				return 'Unpaid';
			}
		}
	}
}

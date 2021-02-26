<?php
/**
 * List function
 *
 * @author     Nirjhar Lo
 * @package    dronespov
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'DRONESPOV_CLIENT_LIST' ) ) {

	final class DRONESPOV_CLIENT_LIST {

		public function get_tabs() {

			return array('estimates', 'invoices');
		}

		public function get_estimate_list() {

			$data = array();

			$user_id = get_current_user_id();

			$data = $this->get_estimate_data($user_id);

			$data = $this->format_data($data);

			return $data;
		}

		public function get_invoice_list() {

			$data = array();

			$user_id = get_current_user_id();

			$due_data = $this->get_data($user_id, 'due');
			$overdue_data = $this->get_data($user_id, 'overdue');
			$paid_data = $this->get_data($user_id, 'paid');

			$data['due'] = $this->format_data($due_data);
			$data['overdue'] = $this->format_data($overdue_data);
			$data['paid'] = $this->format_data($paid_data);

			return $data;
		}


		public function get_totals() {

			$data = array();

			$user_id = get_current_user_id();

			$data['due'] = $this->get_total_amount($user_id, 'due');
			$data['overdue'] = $this->get_total_amount($user_id, 'overdue');
			$data['paid'] = $this->get_total_amount($user_id, 'paid');

			return $data;
		}


		public function get_data($user_id, $type) {

			global $wpdb;

			$table = $wpdb->prefix . 'dronespov_invoices';

			$today = date( 'y-m-d', strtotime("today"));

			if ($type == 'due') {

				$fetch = $wpdb->get_results(
					$wpdb->prepare("SELECT * FROM $table WHERE bill_to = %d AND due_date >= %s AND status = 0 AND is_trash = 0 AND is_estimate = 0 ORDER BY ID DESC", $user_id, $today),
					ARRAY_A );

			} elseif ($type == 'overdue') {

				$fetch = $wpdb->get_results(
					$wpdb->prepare("SELECT * FROM $table WHERE bill_to = %d AND due_date < %s AND status = 0 AND is_trash = 0 AND is_estimate = 0 ORDER BY ID DESC", $user_id, $today),
					ARRAY_A );

			} elseif ($type == 'paid') {

				$fetch = $wpdb->get_results(
					$wpdb->prepare("SELECT * FROM $table WHERE bill_to = %d AND status = 1 AND is_trash = 0 AND is_estimate = 0 ORDER BY ID DESC", $user_id),
					ARRAY_A );

			}

			return $fetch;
		}


		public function get_total_amount($user_id, $type) {

			global $wpdb;

			$table = $wpdb->prefix . 'dronespov_invoices';

			$today = date( 'y-m-d', strtotime("today"));

			if ($type == 'due') {

				$fetch = $wpdb->get_results(
					$wpdb->prepare("SELECT SUM(total) FROM $table WHERE bill_to = %d AND due_date >= %s AND status = 0 AND is_trash = 0 AND is_estimate = 0", $user_id, $today),
					ARRAY_A );

			} elseif ($type == 'overdue') {

				$fetch = $wpdb->get_results(
					$wpdb->prepare("SELECT SUM(total) FROM $table WHERE bill_to = %d AND due_date < %s AND status = 0 AND is_trash = 0 AND is_estimate = 0", $user_id, $today),
					ARRAY_A );

			} elseif ($type == 'paid') {

				$fetch = $wpdb->get_results(
					$wpdb->prepare("SELECT SUM(total) FROM $table WHERE bill_to = %d AND status = 1 AND is_trash = 0 AND is_estimate = 0", $user_id),
					ARRAY_A );

			}

			return $fetch[0]['SUM(total)'];
		}


		public function get_estimate_data($user_id) {

			global $wpdb;

			$table = $wpdb->prefix . 'dronespov_invoices';

			$fetch = $wpdb->get_results(
				$wpdb->prepare("SELECT * FROM $table WHERE bill_to = %d AND is_estimate = 1 AND is_trash = 0 ORDER BY ID DESC", $user_id),
				ARRAY_A );

			return $fetch;
		}


		public function format_data($fetch) {

			$output = array();
			foreach ($fetch as $row) {

				$col = array();

				$col['id'] = $row['ID'];
				$col['project'] = ($row['project'] == '' ? '--' : base64_decode($row['project']));
				$col['total'] = ($row['total'] == 0 ? '--' : $row['total']);
				$col['invoice_date'] = ($row['invoice_date'] == '0000-00-00' ? '--' : $this->format_date($row['invoice_date']));
				$col['due_date'] = ($row['due_date'] == '0000-00-00' ? '--' : $this->format_date($row['due_date']));
				$col['status'] = ($row['is_estimate'] == '1' ? 'Estimate' : false);

				$output[] = $col;
			}

			return $output;
		}


		public function get_amounts($row) {

			$row = $this->format_item_amount_array($row);
			$text = '$' . implode('<br />$', $row);
			return $text;
		}


		public function format_date($date) {

			return date( 'm/d/y', strtotime($date));
		}


		public function get_date_delay($date) {

			$current = strtotime("today");
			if ($current < strtotime($date)) {
				return 'None';
			} else {
				$diff = date_diff(date_create(date( 'y-m-d', $current)), date_create(date( 'y-m-d', strtotime($date))));
				return ltrim($diff->format("%R%a day"), '-');
			}
		}
	}
}

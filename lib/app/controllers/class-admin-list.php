<?php
/**
 * List function
 *
 * @author     Nirjhar Lo
 * @package    dronespov
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'DRONESPOV_ADMIN_LIST' ) ) {

	final class DRONESPOV_ADMIN_LIST {


		public function get_tabs() {

			return array('estimates', 'invoices');
		}

		public function get_estimate_list() {

			$data = array();

			$data = $this->get_estimate_data();

			$data = $this->format_data($data, 'due');

			return $data;
		}

		public function get_invoice_list() {

			$data = array();

			$due_data = $this->get_data('due');
			$overdue_data = $this->get_data('overdue');
			$paid_data = $this->get_data('paid');

			$data['due'] = $this->format_data($due_data, 'due');
			$data['overdue'] = $this->format_data($overdue_data, 'overdue');
			$data['paid'] = $this->format_data($paid_data, 'paid');

			return $data;
		}

		public function get_totals() {

			$data = array();

			$user_id = get_current_user_id();

			$data['due'] = $this->get_total_amount('due');
			$data['overdue'] = $this->get_total_amount('overdue');
			$data['paid'] = $this->get_total_amount('paid');

			return $data;
		}


		public function get_data($type) {

			global $wpdb;

			$table = $wpdb->prefix . 'dronespov_invoices';

			$today = date( 'y-m-d', strtotime("today"));
			$user_id = get_current_user_id();

			if ($type == 'due') {

				if ($user_id == 1) {
					$fetch = $wpdb->get_results(
						$wpdb->prepare("SELECT * FROM $table WHERE due_date >= %s AND status = 0 AND is_trash = 0 AND is_estimate = 0 ORDER BY ID DESC", $today),
						ARRAY_A );
				} else {
					$fetch = $wpdb->get_results(
						$wpdb->prepare("SELECT * FROM $table WHERE due_date >= %s AND status = 0 AND is_trash = 0 AND is_estimate = 0 AND created_by = %d ORDER BY ID DESC LIMIT 5000", $today, $user_id),
						ARRAY_A );
				}

			} elseif ($type == 'overdue') {

				if ($user_id == 1) {
					$fetch = $wpdb->get_results(
						$wpdb->prepare("SELECT * FROM $table WHERE due_date < %s AND status = 0 AND is_trash = 0 AND is_estimate = 0 ORDER BY ID DESC", $today),
						ARRAY_A );
				} else {
					$fetch = $wpdb->get_results(
						$wpdb->prepare("SELECT * FROM $table WHERE due_date < %s AND status = 0 AND is_trash = 0 AND is_estimate = 0 AND created_by = %d ORDER BY ID DESC LIMIT 5000", $today, $user_id),
						ARRAY_A );
				}

			} elseif ($type == 'paid') {

				if ($user_id == 1) {
					$fetch = $wpdb->get_results(
						$wpdb->prepare("SELECT * FROM $table WHERE status = 1 AND is_trash = 0 AND is_estimate = 0 ORDER BY ID DESC"),
						ARRAY_A );
				} else {
					$fetch = $wpdb->get_results(
						$wpdb->prepare("SELECT * FROM $table WHERE status = 1 AND is_trash = 0 AND is_estimate = 0 AND created_by = %d ORDER BY ID DESC LIMIT 5000", $user_id),
						ARRAY_A );
				}

			}

			return $fetch;
		}


		public function get_total_amount($type) {

			global $wpdb;

			$table = $wpdb->prefix . 'dronespov_invoices';

			$today = date( 'y-m-d', strtotime("today"));
			$user_id = get_current_user_id();

			if ($type == 'due') {

				if ($user_id == 1) {
					$fetch = $wpdb->get_results(
						$wpdb->prepare("SELECT SUM(total) FROM $table WHERE due_date >= %s AND status = 0 AND is_trash = 0 AND is_estimate = 0", $today),
						ARRAY_A );
				} else {
					$fetch = $wpdb->get_results(
						$wpdb->prepare("SELECT SUM(total) FROM $table WHERE due_date >= %s AND status = 0 AND is_trash = 0 AND is_estimate = 0 AND created_by = %d", $today, $user_id),
						ARRAY_A );
				}

			} elseif ($type == 'overdue') {

				if ($user_id == 1) {
					$fetch = $wpdb->get_results(
						$wpdb->prepare("SELECT SUM(total) FROM $table WHERE due_date < %s AND status = 0 AND is_trash = 0 AND is_estimate = 0", $today),
						ARRAY_A );
				} else {
					$fetch = $wpdb->get_results(
						$wpdb->prepare("SELECT SUM(total) FROM $table WHERE due_date < %s AND status = 0 AND is_trash = 0 AND is_estimate = 0 AND created_by = %d", $today, $user_id),
						ARRAY_A );
				}

			} elseif ($type == 'paid') {

				if ($user_id == 1) {
					$fetch = $wpdb->get_results(
						$wpdb->prepare("SELECT SUM(total) FROM $table WHERE status = 1 AND is_trash = 0 AND is_estimate = 0"),
						ARRAY_A );
				} else {
					$fetch = $wpdb->get_results(
						$wpdb->prepare("SELECT SUM(total) FROM $table WHERE status = 1 AND is_trash = 0 AND is_estimate = 0 AND created_by = %d", $user_id),
						ARRAY_A );
				}

			}

			return $fetch[0]['SUM(total)'];
		}


		public function get_estimate_data() {

			global $wpdb;

			$table = $wpdb->prefix . 'dronespov_invoices';
			$user_id = get_current_user_id();

			if ($user_id == 1) {
				$fetch = $wpdb->get_results(
					$wpdb->prepare("SELECT * FROM $table WHERE is_estimate = 1 AND is_trash = 0 ORDER BY ID DESC"),
					ARRAY_A );
			} else {
				$fetch = $wpdb->get_results(
					$wpdb->prepare("SELECT * FROM $table WHERE is_estimate = 1 AND is_trash = 0 AND created_by = %d ORDER BY ID DESC LIMIT 5000", $user_id),
					ARRAY_A );
			}

			return $fetch;
		}


		public function format_data($fetch, $type) {

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
				$col['payment'] = $this->get_payment_status($row['status']);
				$col['status'] = ($row['is_estimate'] == '1' ? 'Estimate' : $this->get_date_status($row['due_date'], $row['status']) );
				$col['change_pay'] = $this->get_change_payment_status($row['status'], $row['ID'], $type);
				$col['convert'] = $this->get_convert_status($row['is_estimate'], $row['ID']);

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


		public function get_change_payment_status($status, $id, $type) {

			$link = '';
			$pay_nonce_url = wp_nonce_url( '?pay_invoice_id=' . $id . '&tab=' . $type . '&type=invoices', 'wp_nonce_' . $id );
			$unpay_nonce_url = wp_nonce_url( '?unpay_invoice_id=' . $id . '&tab=' . $type . '&type=invoices', 'wp_nonce_' . $id );

			if (intval($status) != 1) {
				$link = '<a href="javascript:void();" data-toggle="modal" data-target=".delete-' . $id . '">' . __('Mark paid', 'dronespov') . '</a>';
				$link .= '<div class="modal fade delete-' . $id . '">
					<div class="modal-dialog modal-simple modal-sm">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
							</div>
							<div class="modal-body">
								<p>' . sprintf(__('Click OK to mark invoice %s as paid.', 'dronespov'), $id) . '</p>
							</div>
							<div class="modal-footer">
								<a href="' . $pay_nonce_url . '" type="button" class="btn btn-primary waves-effect waves-classic">OK</a>
							</div>
						</div>
					</div>
				</div>';
			} else {
				$link = '<a href="' . $unpay_nonce_url . '">' . __('Mark unpaid', 'dronespov') . '</a>';
			}

			return $link;
		}


		public function get_convert_status($estimate, $id) {

			$link = '';
			$nonce_url = wp_nonce_url( '?estimate=' . $id, 'convert_nonce_' . $id );

			if (intval($estimate) == 1) {
				$link = '<a class="btn btn-xs btn-success" href="' . $nonce_url . '"
				data-toggle="tooltip" data-placement="bottom" data-trigger="hover" data-original-title="Convert to Invoice">
					<span><i class="icon md-refresh" aria-hidden="true"></i></span>
				</a>';
			}

			return $link;
		}
	}
}

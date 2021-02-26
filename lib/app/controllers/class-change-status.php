<?php
/**
 * Change Status
 *
 * @author     Nirjhar Lo
 * @package    dronespov
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'DRONESPOV_CHANGE_STATUS' ) ) {

	final class DRONESPOV_CHANGE_STATUS {

		public function __construct() {

			$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
			if (false !== strpos($path, 'admin/list_invoice')) {
				$this->mark_paid();
				$this->mark_unpaid();
				$this->delete();
				$this->convert();
				$this->convert_inverse();
				$this->duplicate();
			}
			if (false !== strpos($path, 'admin/deleted_invoice')) {
				$this->restore();
				$this->parmanetly_delete();
			}
		}


		public function mark_paid() {

			if (isset($_GET['pay_invoice_id'])) {

				$invoice_id = $_GET['pay_invoice_id'];
				$nonce = $_GET['_wpnonce'];
				$date = date( 'y-m-d', strtotime("today"));

				if (!wp_verify_nonce( $nonce, 'wp_nonce_' . $invoice_id )) {
					return;
				}

				global $wpdb;

				$table = $wpdb->prefix . 'dronespov_invoices';

				$fetch = $wpdb->get_results(
					$wpdb->prepare(
				        "SELECT bill_to, status FROM $table WHERE ID = %d AND is_trash = 0",
				        $invoice_id
				    ), ARRAY_A );

				if (intval($fetch[0]['status']) == 0) {
					$wpdb->update(
						$table,
						array('status' => 1, 'paid_date' => $date),
						array('ID' => $invoice_id, 'is_trash' => 0, 'status' => 0),
						array('%d', '%s'),
						array('%d', '%d', '%d')
					);

					$bill_to = $fetch[0]['bill_to'];
					$email = new DRONESPOV_EMAIL();
					$email->paid_email($bill_to, $invoice_id);

				}
			}
		}


		public function mark_unpaid() {

			if (isset($_GET['unpay_invoice_id'])) {

				$invoice_id = $_GET['unpay_invoice_id'];
				$nonce = $_GET['_wpnonce'];
				$date = date( 'y-m-d', strtotime("today"));

				if (!wp_verify_nonce( $nonce, 'wp_nonce_' . $invoice_id )) {
					return;
				}

				global $wpdb;

				$table = $wpdb->prefix . 'dronespov_invoices';

				$fetch = $wpdb->get_results(
					$wpdb->prepare(
				        "SELECT bill_to, status FROM $table WHERE ID = %d AND is_trash = 0",
				        $invoice_id
				    ), ARRAY_A );

				if (intval($fetch[0]['status']) == 1) {
					$wpdb->update(
						$table,
						array('status' => 0, 'paid_date' => NULL),
						array('ID' => $invoice_id, 'is_trash' => 0),
						array('%d', '%s'),
						array('%d', '%d')
					);
				}
			}
		}


		public function delete() {

			if (isset($_GET['delete'])) {

				$invoice_id = $_GET['delete'];
				$nonce = $_GET['_wpnonce'];

				if (!isset($_GET['type']) && !wp_verify_nonce( $nonce, 'delete_nonce_' . $invoice_id )) {
					return;
				}

				if (isset($_GET['type']) && ($_GET['type'] == 'estimates') && !wp_verify_nonce( $nonce, 'estimate_delete_nonce_' . $invoice_id )) {
					return;
				}

				global $wpdb;

				$table = $wpdb->prefix . 'dronespov_invoices';

				$wpdb->update(
					$table,
					array('is_trash' => 1, 'delete_date' => date( 'y-m-d', strtotime("today"))),
					array('ID' => $invoice_id),
					array('%d', '%s'),
					array('%d')
				);
			}
		}


		public function convert() {

			if (isset($_GET['estimate'])) {

				$invoice_id = $_GET['estimate'];
				$nonce = $_GET['_wpnonce'];

				if (!wp_verify_nonce( $nonce, 'convert_nonce_' . $invoice_id )) {
					return;
				}

				global $wpdb;

				$table = $wpdb->prefix . 'dronespov_invoices';

				$wpdb->update(
					$table,
					array('is_estimate' => 0, 'added_on' => current_time( 'mysql' )),
					array('ID' => $invoice_id),
					array('%d','%s'),
					array('%d')
				);
			}
		}


		public function convert_inverse() {

			if (isset($_GET['invoice_to_estimate'])) {

				$invoice_id = $_GET['invoice_to_estimate'];
				$nonce = $_GET['_wpnonce'];

				if (!wp_verify_nonce( $nonce, 'convert_to_estimate_nonce_' . $invoice_id )) {
					return;
				}

				global $wpdb;

				$table = $wpdb->prefix . 'dronespov_invoices';

				$wpdb->update(
					$table,
					array('is_estimate' => 1, 'added_on' => current_time( 'mysql' )),
					array('ID' => $invoice_id),
					array('%d','%s'),
					array('%d')
				);
			}
		}


		public function duplicate() {

			if (isset($_GET['duplicate'])) {

				$invoice_id = $_GET['duplicate'];
				$nonce = $_GET['_wpnonce'];

				if (!wp_verify_nonce( $nonce, 'duplicate_nonce_' . $invoice_id )) {
					return;
				}

				global $wpdb;

				$table = $wpdb->prefix . 'dronespov_invoices';

				$fetch = $wpdb->get_results(
					$wpdb->prepare("SELECT * FROM $table WHERE ID = %d", $invoice_id),
					ARRAY_A );

				if (empty($fetch[0])) {
					return;
				}

				$row = $fetch[0];
				$data = array(
					'bill_to' => $row['bill_to'],
					'project' => $row['project'],
					'row' => $row['row'],
					'tax' => $row['tax'],
					'total' => $row['total'],
					'notes' => $row['notes'],
					'invoice_date' => $row['invoice_date'],
					'due_date' => $row['due_date'],
					'paid_date' => $row['paid_date'],
					'status' => $row['status'],
					'is_estimate' => $row['is_estimate'],
					'is_trash' => $row['is_trash'],
					'added_on' => current_time( 'mysql' )
				);

				$format = array('%d','%s','%s','%d','%d','%s','%s','%s','%s','%d','%d','%d','%s');

				$wpdb->insert($table,$data,$format);

				wp_safe_redirect(site_url() . '/admin/create_invoice/?edit=' . $wpdb->insert_id);
				exit();
			}
		}


		public function restore() {

			if (isset($_GET['restore'])) {

				$invoice_id = $_GET['restore'];
				$nonce = $_GET['_wpnonce'];

				if (!wp_verify_nonce( $nonce, 'restore_nonce_' . $invoice_id )) {
					return;
				}

				global $wpdb;

				$table = $wpdb->prefix . 'dronespov_invoices';

				$wpdb->update(
					$table,
					array('is_trash' => 0, 'delete_date' => NULL),
					array('ID' => $invoice_id),
					array('%d', '%s'),
					array('%d')
				);
			}
		}


		public function parmanetly_delete() {

			if (isset($_GET['delete_parma'])) {

				$invoice_id = $_GET['delete_parma'];
				$nonce = $_GET['_wpnonce'];

				if (!wp_verify_nonce( $nonce, 'delete_parma_nonce_' . $invoice_id )) {
					return;
				}

				global $wpdb;

				$table = $wpdb->prefix . 'dronespov_invoices';
				$file_table = $wpdb->prefix . 'dronespov_old_invoices';

				$file_path = $this->get_old_invoice($invoice_id);
				wp_delete_file( $file_path );

				$wpdb->delete(
					$file_table,
					array('invoice_id' => $invoice_id),
					array('%d')
				);

				$wpdb->delete(
					$table,
					array('ID' => $invoice_id),
					array('%d')
				);
			}
		}


		public function get_old_invoice($invoice_id) {

			$path = false;

			global $wpdb;
			$table = $wpdb->prefix . 'dronespov_old_invoices';

			$fetch = $wpdb->get_results(
				$wpdb->prepare("SELECT path FROM $table WHERE invoice_id = %d ORDER BY ID DESC LIMIT 1", $invoice_id),
				ARRAY_A );

			if (isset($fetch[0]['path']) && !empty($fetch[0]['path'])) {
				$path = $fetch[0]['path'];
			}

			return $path;
		}
	}
}

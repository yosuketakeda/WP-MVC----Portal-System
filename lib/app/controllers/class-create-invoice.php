<?php
/**
 * Upload invoice
 *
 * @author     Nirjhar Lo
 * @package    dronespov
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'DRONESPOV_CREATE_INVOICE' ) ) {

	final class DRONESPOV_CREATE_INVOICE {

		public function __construct() {

			$this->upload_invoice();
			$this->create_invoice();
		}


		public function create_invoice() {

			global $dronespov_create_invoice_message;

			if (isset($_POST['dronespov-new-invoice']) && wp_verify_nonce( $_POST['_wpnonce'], 'dronespov_new_invoice' )) {

				$edit = (isset($_POST['edit']) ? intval(sanitize_text_field($_POST['edit'])) : false);
				$uploaded = (isset($_POST['uploaded']) ? intval(sanitize_text_field($_POST['uploaded'])) : false);

				$bill_to = (isset($_POST['bill_to']) ? intval(sanitize_text_field($_POST['bill_to'])) : false);
				$project = (isset($_POST['project']) ? base64_encode(sanitize_text_field($_POST['project'])) : false);
				$row = (isset($_POST['row']) ? $this->format_items($_POST['row']) : false);
				$tax = (isset($_POST['tax']) ? intval(sanitize_text_field($_POST['tax'])) : false);
				$total = (isset($_POST['total']) ? intval(sanitize_text_field($_POST['total'])) : false);
				$notes = (isset($_POST['notes']) ? base64_encode(nl2br($_POST['notes'])) : false);
				$invoice_date = (isset($_POST['invoice_date']) ? $this->format_date(sanitize_text_field($_POST['invoice_date'])) : false);
				$due_date = (isset($_POST['due_date']) ? $this->format_date(sanitize_text_field($_POST['due_date'])) : false);
				$status = ($uploaded ? 1 : 0);
				$type = (isset($_POST['type']) ? intval(sanitize_text_field($_POST['type'])) : false);

				if (($uploaded && $bill_to) || (!$uploaded && $bill_to && $project && $row && isset($total) && $invoice_date && $due_date)) {

					global $wpdb;

					$table = $wpdb->prefix . 'dronespov_invoices';

					$data = array(
						'bill_to' => $bill_to,
						'project' => $project,
						'row' => $row,
						'tax' => $tax,
						'total' => $total,
						'notes' => $notes,
						'invoice_date' => $invoice_date,
						'due_date' => $due_date,
						'status' => $status,
						'is_estimate' => $type,
						'added_on' => current_time( 'mysql' ),
						'created_by' => get_current_user_id()
					);

					$format = array('%d','%s','%s','%d','%d','%s','%s','%s','%d','%d', '%s', '%d');

					if ($edit) {
						$where = array('ID' => $edit );
						$where_format = array('%d');
						$inserts = $wpdb->update($table,$data,$where,$format,$where_format);
					} else {
						$inserts = $wpdb->insert($table,$data,$format);
					}

					if ($type == 1) {
						$text = 'estimate';
					} else {
						$text = 'invoice';
					}

					$due_or_overdue = $this->due_or_overdue($due_date);

					if (false != $inserts) {
						if ($edit) {
							$dronespov_create_invoice_message = __('Successfully updated.', 'dronespov');
						} else {
							$dronespov_create_invoice_message = '<a href="' . site_url() . '/admin/list_invoice/?type=' . ($text == 'invoice' ? 'invoices&tab=' . $due_or_overdue : 'estimates') . '">' . __('Successfully created.', 'dronespov') . '</a>';
						}
					}

				} else {
					$dronespov_create_invoice_message = __('All fields are required.', 'dronespov');
				}
			}
		}


		public function upload_invoice() {

			global $dronespov_upload_invoice_message;

			if (isset($_POST['dronespov-upload-invoice']) && wp_verify_nonce( $_POST['_wpnonce'], 'dronespov_upload_new_invoice' )) {

				$bill_to = (isset($_POST['bill_to']) ? intval(sanitize_text_field($_POST['bill_to'])) : false);
				$invoice_ID = (isset($_POST['invoice_id']) ? intval(sanitize_text_field($_POST['invoice_id'])) : false);
				$type = (isset($_POST['upload_type']) ? intval(sanitize_text_field($_POST['upload_type'])) : false);

				if ($bill_to && $invoice_ID && $type) {

					global $wpdb;

					$table = $wpdb->prefix . 'dronespov_invoices';
					$file_table = $wpdb->prefix . 'dronespov_old_invoices';

					$path = $this->upload_controller();

					if (!isset($path['path']) || empty($path['path'])) {
						$dronespov_upload_invoice_message = __('Uploading failed. Please retry.', 'dronespov');
						return;
					}

					$wpdb->delete(
						$file_table,
						array('invoice_id' => $invoice_ID),
						array('%d')
					);

					$file_data = array(
						'invoice_id' => $invoice_ID,
						'url' => $path['url'],
						'path' => $path['path'],
						'upload_date' => date( 'y-m-d', strtotime("today"))
					);
					$file_format = array('%d','%s','%s');
					$wpdb->insert($file_table,$file_data,$file_format);

					if (false != $wpdb->insert_id) {

						$wpdb->delete(
							$table,
							array('ID' => $invoice_ID),
							array('%d')
						);

						$data = array(
							'ID' => $invoice_ID,
							'bill_to' => $bill_to,
							'project' => '',
							'row' => '',
							'tax' => '',
							'total' => '',
							'notes' => '',
							'invoice_date' => '',
							'due_date' => '',
							'status' => 1,
							'is_estimate' => $type,
							'added_on' => current_time( 'mysql' ),
							'created_by' => get_current_user_id()
						);

						$format = array('%d','%s','%s','%d','%d','%s','%s','%s','%d','%d','%s','%d');
						$wpdb->insert($table,$data,$format);

						if (false != $wpdb->insert_id) {
							$dronespov_upload_invoice_message = __('Successfully uploaded.', 'dronespov');
						}
					} else {
						$dronespov_upload_invoice_message = __('Couldn\'t update file path to DB.', 'dronespov');
					}

				} else {
					$dronespov_upload_invoice_message = __('All fields are mandetory.', 'dronespov');
				}
			}
		}


		public function upload_controller() {

			global $dronespov_upload_invoice_message;

			$upload = false;
			$file = $_FILES['old_invoice'];
			$type = $file['type'];

			// Check in your file type
			if( $type != 'application/pdf' ) {
				$dronespov_upload_invoice_message = __('Only PDF files are allowed.', 'dronespov');
			} else {

				if (!function_exists('wp_handle_upload')){
					require_once(ABSPATH . 'wp-admin/includes/image.php');
					require_once(ABSPATH . 'wp-admin/includes/file.php');
					require_once(ABSPATH . 'wp-admin/includes/media.php');
				}
				$overrides = array( 'test_form' => false);
				add_filter( 'upload_dir', array( $this, 'custom_upload_dir' ) );
				$attachment = wp_handle_upload($file, $overrides);
				remove_filter( 'upload_dir', array( $this, 'custom_upload_dir' ) );

				if( is_array( $attachment ) && array_key_exists( 'url', $attachment ) ) {
					$upload['path'] = $attachment['file'];
					$upload['url'] = $attachment['url'];
				}
			}

			return $upload;
		}


		public function format_items($row) {

			$items = $row['item'];
			$amounts = $row['amount'];

			$data = array();
			foreach($items as $key => $item) {
				$data[$key] = array(sanitize_text_field($item) => intval(sanitize_text_field($amounts[$key])));
			}

			return maybe_serialize($data);
		}


		public function format_date($date) {

    	return $date;
		}


		public function custom_upload_dir( $dir_data ) {

			$custom_dir = 'invoices';

			return array(
        		'path' => $dir_data[ 'basedir' ] . '/' . $custom_dir,
        		'url' => WP_CONTENT_URL . '/uploads/' . $custom_dir,
        		'subdir' => '/' . $custom_dir,
        		'basedir' => $dir_data[ 'error' ],
        		'error' => $dir_data[ 'error' ],
    		);
		}


		public function due_or_overdue($date) {

			$current = strtotime("today");
			if ($current <= strtotime($date)) {
				$type = 'due';
			} else {
				$type = 'overdue';
			}

			return $type;
		}
	}
}

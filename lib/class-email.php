<?php
use Api2Pdf\Api2Pdf;

/**
 * Trigger emails
 *
 * @author     Nirjhar Lo
 * @package    dronespov
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'DRONESPOV_EMAIL' ) ) {

	final class DRONESPOV_EMAIL {


		protected static $html_to_pdf_api_key = 'daf4934a-ab52-453b-aaf3-9ef411a368a3';

		public function due_email() {

			$time = get_option('_due_trigger_email_time');
			$sub_template = get_option('_due_trigger_email_sub_template');
			$template = get_option('_due_trigger_email_template');

			$hour = $time['hour'];
			$minute = $time['minute'];

			$target = str_pad($hour, 2, "0", STR_PAD_LEFT) . ':' . str_pad($minute, 2, "0", STR_PAD_LEFT);
			$time_target = strtotime("today $target");
			$now = strtotime("now");
			$time_diff = ($now - $time_target);

			if ($time_diff > 0 && $time_diff <= 3600) {

				$due_list = $this->get_just_due_invoice_list();
				foreach ($due_list as $item) {
					$bill_to = $item['bill_to_id'];
					$insert_id = $item['id_number'];

					$company = $this->company($bill_to);
					$first_name = $this->first_name($bill_to);
					$last_name = $this->last_name($bill_to);
					$invoice_link = site_url() . '/client/list_invoice/';

					$today = date( 'm/d/y', strtotime("today"));

					$subject = str_replace(['{first_name}', '{last_name}', '{invoice_link}', '{company_name}', '{invoice_number}', '{todays_date}'], [$first_name, $last_name, $invoice_link, $company, $insert_id, $today], $sub_template);
					$body = str_replace(['{first_name}', '{last_name}', '{invoice_link}', '{company_name}', '{invoice_number}', '{todays_date}'], [$first_name, $last_name, $invoice_link, $company, $insert_id, $today], $template);

					$to = $this->get_email($bill_to);

					wp_mail( $to, $subject, $body );
				}
			}
		}


		public function overdue_email() {

			$time = get_option('_overdue_trigger_email_time');
			$sub_template = get_option('_overdue_trigger_email_sub_template');
			$template = get_option('_overdue_trigger_email_template');

			$hour = $time['hour'];
			$minute = $time['minute'];

			$target = str_pad($hour, 2, "0", STR_PAD_LEFT) . ':' . str_pad($minute, 2, "0", STR_PAD_LEFT);
			$time_target = strtotime("today $target");
			$now = strtotime("now");
			$time_diff = ($now - $time_target);

			if ($time_diff > 0 && $time_diff <= 3600) {
				$overdue_list = $this->get_just_overdue_invoice_list();
				foreach ($overdue_list as $item) {
					$bill_to = $item['bill_to_id'];
					$insert_id = $item['id_number'];
					$delay = $item['delay'];

					$company = $this->company($bill_to);
					$first_name = $this->first_name($bill_to);
					$last_name = $this->last_name($bill_to);
					$invoice_link = site_url() . '/client/list_invoice/';

					$today = date( 'm/d/y', strtotime("today"));

					$subject = str_replace(['{first_name}', '{last_name}', '{invoice_link}', '{company_name}', '{invoice_number}', '{delay_days}', '{todays_date}'], [$first_name, $last_name, $invoice_link, $company, $insert_id, $delay, $today], $sub_template);
					$body = str_replace(['{first_name}', '{last_name}', '{invoice_link}', '{company_name}', '{invoice_number}', '{delay_days}', '{todays_date}'], [$first_name, $last_name, $invoice_link, $company, $insert_id, $delay, $today], $template);

					$to = $this->get_email($bill_to);

					wp_mail( $to, $subject, $body );
				}
			}
		}


		public function added_email() {

			$time = get_option('_added_trigger_email_time');
			$sub_template = get_option('_added_trigger_email_sub_template');
			$template = get_option('_added_trigger_email_template');

			$hour = $time['hour'];
			$minute = $time['minute'];

			$target = str_pad($hour, 2, "0", STR_PAD_LEFT) . ':' . str_pad($minute, 2, "0", STR_PAD_LEFT);
			$time_target = strtotime("today $target");
			$now = strtotime("now");
			$time_diff = ($now - $time_target);

			if ($time_diff > 0 && $time_diff <= 3600) {
				$added_list = $this->get_just_added_invoice_list($time);

				foreach ($added_list as $added) {

					$bill_to = $added['bill_to_id'];
					$insert_id = $added['id_number'];

					$company = $this->company($bill_to);
					$first_name = $this->first_name($bill_to);
					$last_name = $this->last_name($bill_to);
					$invoice_link = site_url() . '/client/list_invoice/';

					$today = date( 'm/d/y', strtotime("today"));

					$subject = str_replace(['{first_name}', '{last_name}', '{invoice_link}', '{company_name}', '{invoice_number}', '{todays_date}'], [$first_name, $last_name, $invoice_link, $company, $insert_id, $today], $sub_template);
					$body = str_replace(['{first_name}', '{last_name}', '{invoice_link}', '{company_name}', '{invoice_number}', '{todays_date}'], [$first_name, $last_name, $invoice_link, $company, $insert_id, $today], $template);

					$to = $this->get_email($bill_to);

					wp_mail( $to, $subject, $body );
				}
			}
		}


		public function paid_email($bill_to, $invoice_id) {

			$sub_template = get_option('_paid_trigger_email_sub_template');
			$template = get_option('_paid_trigger_email_template');

			$company = $this->company($bill_to);
			$first_name = $this->first_name($bill_to);
			$last_name = $this->last_name($bill_to);

			$list = new DRONESPOV_ADMIN_LIST();
			$view = new DRONESPOV_INVOICE_VIEW();
			$company_name = $list->get_company($bill_to);
			$billing_address = $view->format_address_for_paid_email($list->get_address($bill_to));

			$invoice_link = site_url() . '/client/view_invoice/' . $invoice_id;

			$today = date( 'm/d/Y', strtotime("today"));

			$subject = str_replace(['{first_name}', '{last_name}', '{invoice_link}', '{company_name}', '{invoice_number}', '{todays_date}'], [$first_name, $last_name, $invoice_link, $company, '#' . $invoice_id, $today], $sub_template);

			global $wpdb;

			$table = $wpdb->prefix . 'dronespov_invoices';
			$fetch = $wpdb->get_results(
				$wpdb->prepare("SELECT row, project, tax, total, due_date FROM $table WHERE ID = %d", $invoice_id),
				ARRAY_A );
			$row = maybe_unserialize($fetch[0]['row']);
			$project = base64_decode($fetch[0]['project']);
			$paid_date = $today;
			$total = $fetch[0]['total'];
			$tax = $fetch[0]['tax'];
			$rows = $this->get_items_amounts($row);

			require_once( DRONESPOV_PATH . "/lib/app/email/paid.php" );
			$body = overdue_email_template($invoice_id, $project, $paid_date, $total, $tax, $rows, $company_name, $billing_address);

			$to = $this->get_email($bill_to);
			$headers = array('Content-Type: text/html; charset=UTF-8');

			$filename = 'Receipt-Invoice-' . $invoice_id . '.pdf';
			$attachments[] = $this->get_attachment($filename, $body);

			wp_mail( $to, $subject, $body, $headers, $attachments );
		}


		protected function get_just_added_invoice_list($time) {

			$output = array();

			global $wpdb;
			$table = $wpdb->prefix . 'dronespov_invoices';

			$hour = $time['hour'];
			$minute = $time['minute'];
			$now = str_pad($hour, 2, "0", STR_PAD_LEFT) . ':' . str_pad($minute, 2, "0", STR_PAD_LEFT);

			$today = date( 'y-m-d H:i:s', strtotime("today $now"));
			$yesterday = date( 'y-m-d H:i:s', strtotime("yesterday $now"));

			$fetch = $wpdb->get_results(
				$wpdb->prepare("SELECT ID, bill_to FROM $table WHERE added_on > %s AND added_on <= %s AND is_estimate = 0 AND status = 0 AND is_trash = 0", $yesterday, $today),
				ARRAY_A );

			foreach ($fetch as $row) {

				$col = array();

				$col['id'] = $row['ID'];
				$col['bill_to'] = $row['bill_to'];

				$output[] = $col;
			}

			$data = array();
			if (count($output) > 0) {
				$bill_to = array_unique(array_column($output, 'bill_to'));
				foreach ($bill_to as $client) {

					$item = array();
					$ids = array();
					foreach ($output as $value) {
						if ($value['bill_to'] == $client ) {
							$ids[] = $value['id'];
						}
					}

					$item['id_number'] = ((count($ids) > 1) ? '#' . $ids[0] . '-' . $ids[(count($ids) - 1)] : '#' . $ids[0]);
					$item['bill_to_id'] = $client;

					$data[] = $item;
				}
			}

			return $data;
		}


		protected function get_just_due_invoice_list() {

			$output = array();
			global $wpdb;

			$table = $wpdb->prefix . 'dronespov_invoices';

			$today = date( 'y-m-d H:i:s', strtotime("today"));

			$fetch = $wpdb->get_results(
				$wpdb->prepare("SELECT ID, bill_to, due_date FROM $table WHERE due_date = %s AND status = 0 AND is_estimate = 0 AND is_trash = 0", $today),
				ARRAY_A );

			foreach ($fetch as $row) {

				$col = array();

				$col['id'] = $row['ID'];
				$col['bill_to'] = $row['bill_to'];
				$col['due_date'] = $row['due_date'];

				$output[] = $col;
			}

			$data = array();
			if (count($output) > 0) {
				$bill_to = array_unique(array_column($output, 'bill_to'));
				foreach ($bill_to as $client) {

					$item = array();
					$ids = array();
					$due_date = array();
					foreach ($output as $value) {
						if ($value['bill_to'] == $client ) {
							$ids[] = $value['id'];
							$due_date[] = $value['due_date'];
						}
					}

					$item['id_number'] = ((count($ids) > 1) ? '#' . $ids[0] . '-' . $ids[(count($ids) - 1)] : '#' . $ids[0]);
					$item['bill_to_id'] = $client;
					$item['due_date'] = $due_date[0];

					$data[] = $item;
				}
			}

			return $data;
		}


		protected function get_just_overdue_invoice_list() {

			$output = array();
			global $wpdb;

			$table = $wpdb->prefix . 'dronespov_invoices';
			$interval = intval(get_option('_overdue_trigger_email_interval'));

			$x = $interval;
			while($x <= 30) {
				if ($x % $interval == 0) {
					$previousday = date( 'y-m-d', strtotime("-{$x} day", strtotime("today")));
					$fetch = $wpdb->get_results(
						$wpdb->prepare("SELECT * FROM $table WHERE due_date = %s AND status = 0 AND is_estimate = 0 AND is_trash = 0", $previousday),
						ARRAY_A );

					if (count($fetch) > 0) {
						foreach ($fetch as $row) {

							$col = array();

							$col['id'] = $row['ID'];
							$col['bill_to'] = $row['bill_to'];
							$col['delay'] = $x;

							$output[] = $col;
						}
					}
				}
				$x = $x + $interval;
			}

			$data = array();
			if (count($output) > 0) {
				$bill_to = array_unique(array_column($output, 'bill_to'));
				foreach ($bill_to as $client) {

					$item = array();
					$ids = array();
					$delay = array();
					foreach ($output as $value) {
						if ($value['bill_to'] == $client ) {
							$ids[] = $value['id'];
							$delay[] = $value['delay'];
						}
					}

					$item['id_number'] = ((count($ids) > 1) ? '#' . $ids[0] . '-' . $ids[(count($ids) - 1)] : '#' . $ids[0]);
					$item['bill_to_id'] = $client;
					$item['delay'] = $delay[0];

					$data[] = $item;
				}
			}

			return $data;
		}


		protected function company($bill_to) {

			$company = get_user_meta($bill_to, '_company', true);

			return $company;
		}


		protected function first_name($bill_to) {

			$fname = get_user_meta($bill_to, 'first_name', true);

			return $fname;
		}


		protected function last_name($bill_to) {

			$lname = get_user_meta($bill_to, 'last_name', true);

			return $lname;
		}


		protected function get_email($bill_to) {

			$data = get_userdata($bill_to);

			return $data->user_email;
		}


		public function get_date_delay($date) {

			$current = strtotime("today");
			$diff = date_diff(date_create(date( 'y-m-d', $current)), date_create(date( 'y-m-d', strtotime($date))));

			return ltrim($diff->format("%R%a days"), '-');
		}


		public function get_items_amounts($row) {

			$data = array();

			if (count($row) > 0) {
				foreach ($row as $item) {
					foreach ($item as $key => $value) {
						$data[] = array($key, $value);
					}
				}
			}

			return $data;
		}


		protected function get_attachment($filename, $body) {

			$apiClient = new Api2Pdf(self::$html_to_pdf_api_key);

			$apiClient->setFilename($filename);
			$apiClient->setOptions(
    		[
        	'protrait' => true,
					'scale' => 0.8
    		]
			);
			$result = $apiClient->headlessChromeFromHtml($body);

			$pdf = $result->getPdf();

			if (empty($pdf)) {
				return false;
			}

			if (!function_exists('download_url')){
				require_once(ABSPATH . 'wp-load.php');
				require_once(ABSPATH . 'wp-admin/includes/admin.php');
				require_once(ABSPATH . 'wp-admin/includes/media.php');
			}


			$timeout_seconds = 5;
			$temp_file = download_url( $pdf, $timeout_seconds );

			if ( !is_wp_error( $temp_file ) ) {

				$file = array(
        	'name'     => $filename,
        	'type'     => 'application/pdf',
        	'tmp_name' => $temp_file,
        	'error'    => 0,
        	'size'     => filesize($temp_file),
    		);

				$upload_dir = wp_get_upload_dir();
				$file_path = $upload_dir['basedir'] . '/receipts/' . $filename;
				wp_delete_file( $file_path );

				if (!function_exists('wp_handle_upload')){
					require_once(ABSPATH . 'wp-admin/includes/image.php');
					require_once(ABSPATH . 'wp-admin/includes/file.php');
					require_once(ABSPATH . 'wp-admin/includes/media.php');
				}
				$overrides = array( 'test_form' => false);
				add_filter( 'upload_dir', array( $this, 'custom_upload_dir' ) );
				$attachment = wp_handle_sideload(\wp_unslash($file), $overrides);
				remove_filter( 'upload_dir', array( $this, 'custom_upload_dir' ) );

				if( is_array( $attachment ) && array_key_exists( 'file', $attachment ) ) {
					$path = $attachment['file'];
				}

				return $path;
			}
		}


		public function custom_upload_dir( $dir_data ) {

			$custom_dir = 'receipts';

			return array(
        		'path' => $dir_data[ 'basedir' ] . '/' . $custom_dir,
        		'url' => WP_CONTENT_URL . '/uploads/' . $custom_dir,
        		'subdir' => '/' . $custom_dir,
        		'basedir' => $dir_data[ 'error' ],
        		'error' => $dir_data[ 'error' ],
    		);
		}
	}
}

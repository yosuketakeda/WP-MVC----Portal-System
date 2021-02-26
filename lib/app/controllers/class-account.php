<?php
/**
 * Register users
 *
 * @author     Nirjhar Lo
 * @package    dronespov
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'DRONESPOV_ACCOUNT' ) ) {

	final class DRONESPOV_ACCOUNT {

		public function __construct() {

			$this->update();
		}


		public function update() {

			global $dronespov_account_message;
			$dronespov_account_message = false;

			if (isset($_POST['dronespov_account']) && wp_verify_nonce( $_POST['_wpnonce'], 'dronespov_account_nonce' )) {

				$user_id = get_current_user_id();

				$name = sanitize_text_field($_POST['_dronespov_company_name']);
				$email = sanitize_text_field($_POST['_dronespov_company_email']);
				$email_pre = sanitize_text_field($_POST['_dronespov_company_email_pre']);
				$phone = sanitize_text_field($_POST['_dronespov_company_phone']);
				$address = array();
				$address['street'] = sanitize_text_field($_POST['_dronespov_company_street']);
				$address['city'] = sanitize_text_field($_POST['_dronespov_company_city']);
				$address['state'] = sanitize_text_field($_POST['_dronespov_company_state']);
				$address['zip'] = sanitize_text_field($_POST['_dronespov_company_zip']);
				$address['country'] = sanitize_text_field($_POST['_dronespov_company_country']);

				if ($email != $email_pre) {
					if (!is_email($email)) {
						$dronespov_account_message = __('Must be a valid email.', 'dronespov');
						return;
					}
					if (email_exists($email)) {
						$dronespov_account_message = __('User with that email exists.', 'dronespov');
						return;
					}

					wp_update_user( array( 'ID' => $user_id, 'user_email' => $email ) );
				}

				update_user_meta( $user_id, '_company', $name );
				update_user_meta( $user_id, '_phone', $phone );
				update_user_meta( $user_id, '_address', maybe_serialize($address) );

				$dronespov_account_message = __('Account successfully updated.', 'dronespov');
			}
		}
	}
}

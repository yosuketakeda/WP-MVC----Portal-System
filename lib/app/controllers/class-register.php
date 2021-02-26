<?php
/**
 * Register users
 *
 * @author     Nirjhar Lo
 * @package    dronespov
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'DRONESPOV_REGISTER' ) ) {

	final class DRONESPOV_REGISTER {

		public function __construct() {

			$this->verify_user_code();
			$this->register();
		}


		public function register() {

			global $dronespov_register_message;
			$dronespov_register_message = false;

			if (isset($_POST['dronespov-register']) && wp_verify_nonce( $_POST['_wpnonce'], 'dronespov_register' )) {

				$first_name = (isset($_POST['fname']) ? sanitize_text_field($_POST['fname']) : false);
				$last_name = (isset($_POST['lname']) ? sanitize_text_field($_POST['lname']) : false);
				$company = (isset($_POST['cname']) ? sanitize_text_field($_POST['cname']) : false);
				$address = (isset($_POST['address']) ? $this->sanitize_array($_POST['address']) : false);
				$phone = (isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : false);
				$email = (isset($_POST['email']) ? sanitize_email($_POST['email']) : false);
				$password = (isset($_POST['password']) ? sanitize_text_field($_POST['password']) : false);
				$term = (isset($_POST['term']) ? sanitize_text_field($_POST['term']) : false);

				if ($first_name && $last_name && $company && $address && $email && $password) {

					if (false == $term) {
						$dronespov_register_message = __('Please accept the Terms of use.', 'dronespov');
						return;
					}

					if ( is_email($email) && ! email_exists($email) ) {

						$username = $this->generate_username($email);

						$user_data = array(
							'first_name' => $first_name,
							'last_name'  => $last_name,
  							'user_login' => $username,
  							'user_pass'  => $password,
  							'user_email' => $email,
  							'role'       => 'dronespov_client'
						);
						$user_id = wp_insert_user( $user_data );

						if (! is_wp_error($user_id)) {

							$this->send_email_to_user($user_id, $email);
							$this->send_email_to_admin($user_data, $company);

							update_user_meta( $user_id, '_company', $company );
							update_user_meta( $user_id, '_address', $address );
							update_user_meta( $user_id, '_phone', $phone );

							$dronespov_register_message = __('Check your inbox for a confirmation email to get started.', 'dronespov');

	          			} else {

							$dronespov_register_message = __('Registration failed. Please try again.', 'dronespov');
	          			}
					} else {

						$dronespov_register_message = __('User with that email exists', 'dronespov');
					}
				} else {

					$dronespov_register_message = __('All fields are required', 'dronespov');
				}
			}
		}


		private function generate_username($email) {

			$exploded = explode('@', $email);
			$explode_again = explode('.', $exploded[1]);
			return $exploded[0] . '_' . $explode_again[0];
		}


		public function send_email_to_user($user_id, $email) {

			$subject = __('Please confirm email | Dronespointofview', 'dronespov');

		    $code = md5(time());
		    $string = base64_encode($user_id . '__' . $code);

			update_user_meta($user_id, '_activation_code', $code);
			update_user_meta($user_id, '_active', 0);

			$url = get_site_url(). '/verify/?dronespov_act=' . $string;
			$body = __('Please click this link to confirm your email', 'dronespov') . ': ' . $url;
			wp_mail($email, $subject, $body);
		}


		public function send_email_to_admin($user_data, $company) {

			$email = get_option('admin_email');
			$subject = __('New user registered.', 'dronespov');

			$body = __('Name', 'dronespov') . ': ' . $user_data['first_name'] . ' ' . $user_data['last_name'];
			$body .= "\r\n";
			$body .= __('Email', 'dronespov') . ': ' . $user_data['user_email'];
			$body .= "\r\n";
			$body .= __('Company', 'dronespov') . ': ' . $company;

			wp_mail($email, $subject, $body);
		}


		public function verify_user_code() {

	    	if(isset($_GET['dronespov_act'])){

				$data = explode('__', base64_decode($_GET['dronespov_act']));
	        	$code = get_user_meta($data[0], '_activation_code', true);

				if($code == $data[1]){

	            	update_user_meta($data[0], '_active', 1);
					wp_safe_redirect(site_url() . '/login');
					exit();
	        	}
	    	}
		}


		public function sanitize_array($array) {

			$output = array();
			foreach ($array as $key => $value) {
				$output[sanitize_text_field($key)] = sanitize_text_field($value);
			}

			return maybe_serialize($output);
		}
	}
}

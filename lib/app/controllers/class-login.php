<?php
/**
 * Register users
 *
 * @author     Nirjhar Lo
 * @package    dronespov
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'DRONESPOV_LOGIN' ) ) {

	final class DRONESPOV_LOGIN {

		/**
		 * @var String
		 */
		public $client_dashboard;
		public $admin_dashboard;

		public function __construct() {

			$this->client_dashboard = site_url() . '/client/list_invoice/?type=invoices';
			$this->admin_dashboard = site_url() . '/admin/list_invoice/?type=invoices';
			$this->login();
		}


		public function login() {

			global $dronespov_login_message;
			if (isset($_POST['dronespov-login']) && wp_verify_nonce( $_POST['_wpnonce'], 'dronespov_login' )) {

				$email = (isset($_POST['email']) ? sanitize_email($_POST['email']) : false);
				$password = (isset($_POST['password']) ? sanitize_text_field($_POST['password']) : false);
        		$remember = (isset($_POST['remember']) ? intval(sanitize_text_field($_POST['remember'])) : false);

				if ($email && is_email($email) && $password) {

					if (! email_exists($email)) {
						$dronespov_login_message = __('User doesn\'t exist.', 'dronespov');
						return;
					}

					$check_user = get_user_by('email', $email);
					$status = get_user_meta($check_user->ID, '_active', true);
					$roles = get_userdata($check_user->ID)->roles;
					if (!in_array('administrator', $roles)) {
						if (intval($status) != 1) {
							$dronespov_login_message = __('Please confirm your email. Check mailbox.', 'dronespov');
							return;
						}
					}

					$auth_remember = (($remember == 1) ? true : false);
					$creds = array(
						'user_login' => $email,
						'user_password' => $password,
						'remember' => $auth_remember,
		  			);
					$user = wp_signon( $creds, false );
					if (! is_wp_error($user)) {

		  				wp_set_current_user($user->ID, $email);
		  				wp_set_auth_cookie( $user->ID, $auth_remember, is_ssl() );
		  				do_action( 'wp_login', $user->user_login, $user );

						if (in_array('administrator', $roles)) {
		  					wp_safe_redirect($this->admin_dashboard);
						} else {
							wp_safe_redirect($this->client_dashboard);
						}
						exit;

					} else {
						$dronespov_login_message = __('Login failed.', 'dronespov');
		        	}
			  	} else {
					$dronespov_login_message = __('All fields are mandetory.', 'dronespov');
				}
			}
		}
	}
}

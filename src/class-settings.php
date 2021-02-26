<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Backend settings page class, can have settings fields or data table
 *
 * @author     Nirjhar Lo
 * @package    dronespov
 */
if ( ! class_exists( 'DRONESPOV_SETTINGS' ) ) {

	class DRONESPOV_SETTINGS {


		/**
		 * @var String
		 */
		public $capability;


		/**
		 * @var Array
		 */
		public $sub_menu_page;


		/**
		 * Add basic actions for menu and settings
		 *
		 * @return Void
		 */
		public function __construct() {

			$this->user_id = get_current_user_id();

			$this->capability = 'manage_options';
			$this->sub_menu_page = array(
									'name' => 'Portal Notifications',
									'heading' => 'Portal Notifications',
									'slug' => 'invoice-emails',
								);

			add_action( 'admin_init', array( $this, 'add_settings' ) );
			add_action( 'admin_menu', array( $this, 'menu_page' ) );

		 	add_action( 'show_user_profile', array( $this, 'company_information_fields' ) );
		 	add_action( 'edit_user_profile', array( $this, 'company_information_fields' ) );

		 	add_action( 'personal_options_update', array( $this, 'save_company_information_fields' ) );
		 	add_action( 'edit_user_profile_update', array( $this, 'save_company_information_fields' ) );
		}


		//Add social links to tutors profile
		public function company_information_fields( $user ) {

			if ($user->ID != DRONESPOV_ADMIN_ID) return;

			echo '<h3 class="heading">Company Information for invoices</h3>';

			$name = get_user_meta( $user->ID, '_dronespov_company_name', true );
			$email = get_user_meta( $user->ID, '_dronespov_company_email', true );
			$phone = get_user_meta( $user->ID, '_dronespov_company_phone', true );
			$street = get_user_meta( $user->ID, '_dronespov_company_street', true );
			$city = get_user_meta( $user->ID, '_dronespov_company_city', true );
			$state = get_user_meta( $user->ID, '_dronespov_company_state', true );
			$zip = get_user_meta( $user->ID, '_dronespov_company_zip', true );
			$country = get_user_meta( $user->ID, '_dronespov_company_country', true ); ?>
			<table class="form-table">
				<tr>
				<th><label for="_dronespov_company_name"><?php _e('Company name', 'dronespov'); ?></label></th>
				<td>
					<input type="text" class="regular-text" name="_dronespov_company_name" id="_dronespov_company_name" value="<?php echo esc_attr($name); ?>" />
				</td>
				</tr>
				<tr>
				<th><label for="_dronespov_company_email"><?php _e('Company email', 'dronespov'); ?></label></th>
				<td>
					<input type="text" class="regular-text" name="_dronespov_company_email" id="_dronespov_company_email" value="<?php echo esc_attr($email); ?>" />
				</td>
				</tr>
				<tr>
				<th><label for="_dronespov_company_phone"><?php _e('Phone Number', 'dronespov'); ?></label></th>
				<td>
					<input type="text" class="regular-text" name="_dronespov_company_phone" id="_dronespov_company_phone" value="<?php echo esc_attr($phone); ?>" />
				</td>
				</tr>
				<tr>
				<th><label for="_dronespov_company_street"><?php _e('Street Address', 'dronespov'); ?></label></th>
				<td>
					<input type="text" class="regular-text" name="_dronespov_company_street" id="_dronespov_company_street" value="<?php echo esc_attr($street); ?>" />
				</td>
				</tr>
				<tr>
				<th><label for="_dronespov_company_city"><?php _e('City', 'dronespov'); ?></label></th>
				<td>
					<input type="text" class="regular-text" name="_dronespov_company_city" id="_dronespov_company_city" value="<?php echo esc_attr($city); ?>" />
				</td>
				</tr>
				<tr>
				<th><label for="_dronespov_company_state"><?php _e('State', 'dronespov'); ?></label></th>
				<td>
					<input type="text" class="regular-text" name="_dronespov_company_state" id="_dronespov_company_state" value="<?php echo esc_attr($state); ?>" />
				</td>
				</tr>
				<tr>
				<th><label for="_dronespov_company_zip"><?php _e('ZIP', 'dronespov'); ?></label></th>
				<td>
					<input type="text" class="regular-text" name="_dronespov_company_zip" id="_dronespov_company_zip" value="<?php echo esc_attr($zip); ?>" />
				</td>
				</tr>
				<tr>
				<th><label for="_dronespov_company_country"><?php _e('Country', 'dronespov'); ?></label></th>
				<td>
					<select name="_dronespov_company_country" id="_dronespov_company_country">
						<?php $countries = $this->countries();
						foreach ($countries as $value) : ?>
						<option value="<?php echo $value; ?>" <?php selected($value, $country, true); ?>><?php echo $value; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				</tr>
			</table>
		<?php
		}


		//Update user profile
		public function save_company_information_fields( $user_id ) {

			if ( !current_user_can( 'edit_user', $user_id ) ) return false;

			$name = sanitize_text_field($_POST['_dronespov_company_name']);
			$email = sanitize_text_field($_POST['_dronespov_company_email']);
			$phone = sanitize_text_field($_POST['_dronespov_company_phone']);
			$street = sanitize_text_field($_POST['_dronespov_company_street']);
			$city = sanitize_text_field($_POST['_dronespov_company_city']);
			$state = sanitize_text_field($_POST['_dronespov_company_state']);
			$zip = sanitize_text_field($_POST['_dronespov_company_zip']);
			$country = sanitize_text_field($_POST['_dronespov_company_country']);

			update_user_meta( $user_id, '_dronespov_company_name', $name );
			update_user_meta( $user_id, '_dronespov_company_email', $email );
			update_user_meta( $user_id, '_dronespov_company_phone', $phone );
			update_user_meta( $user_id, '_dronespov_company_street', $street );
			update_user_meta( $user_id, '_dronespov_company_city', $city );
			update_user_meta( $user_id, '_dronespov_company_state', $state );
			update_user_meta( $user_id, '_dronespov_company_zip', $zip );
			update_user_meta( $user_id, '_dronespov_company_country', $country );
		}


		/**
		 * Add a sample Submenu page callback
		 *
		 * @return Void
		 */
		public function menu_page() {

			if ( $this->sub_menu_page ) {
				add_options_page(
					$this->sub_menu_page['name'],
					$this->sub_menu_page['heading'],
					$this->capability,
					$this->sub_menu_page['slug'],
					array($this, 'menu_page_callback')
				);
			}
		}


		/**
		 * Menu page callback
		 *
		 * @return Html
		 */
		public function menu_page_callback() { ?>

			<div class="wrap">
				<h1><?php echo get_admin_page_title(); ?></h1>
				<br class="clear">
				<?php

				if (isset($_POST['start_dronespov_invoice_added_emails'])) {
					$this->added_cron_activation();
				}
				if (isset($_POST['start_dronespov_invoice_due_emails'])) {
					$this->due_cron_activation();
				}
				if (isset($_POST['start_dronespov_invoice_overdue_emails'])) {
					$this->overdue_cron_activation();
				}

				$tabs = array(
					'added' => __('New', 'dronespov'),
					'due'	=> __('Due', 'dronespov'),
					'overdue'=> __('Overdue', 'dronespov'),
					'paid'	=> __('Paid', 'dronespov'),
				);
				$current = (isset($_GET['tab'])) ? $_GET['tab'] : 'added';

				echo '<h2 class="nav-tab-wrapper">';
				foreach( $tabs as $tab => $name ){
					$class = ( $tab == $current ) ? ' nav-tab-active' : false;
					echo '<a class="nav-tab' . esc_attr($class) . '" href="' . site_url() . '/wp-admin/options-general.php?page=invoice-emails&tab=' . esc_attr($tab) . '">' . esc_attr($name) . '</a>';
				}
				echo '</h2>';

				switch ( $current ) {

					case 'added' :
						echo '<form method="post" action="options.php">';
						settings_fields("added_trigger_id");
						do_settings_sections("settings_added_trigger");
						submit_button( __( 'Save', 'dronespov' ), 'primary', 'save_dronespov_invoice_added_emails' );
						echo '</form>';
						echo '<form method="post" action="">';
						echo '<p class="description">' . __('Click the button below to start the CRON email notification schedule. CRON checks for new invoices hourly and sends email notifications at the above scheduled time with a time delay of minutes after the started schedule.', 'dronespov') . '</p>';
						submit_button( __( 'Start Schedule', 'dronespov' ), 'secondary', 'start_dronespov_invoice_added_emails' );
						echo '</form>';
						break;

					case 'due' :
						echo '<form method="post" action="options.php">';
						settings_fields("due_trigger_id");
						do_settings_sections("settings_due_trigger");
						submit_button( __( 'Save', 'dronespov' ), 'primary', 'save_dronespov_invoice_due_emails' );
						echo '</form>';
						echo '<form method="post" action="">';
						echo '<p class="description">' . __('Click the button below to start the CRON email notification schedule. CRON checks due and overdue invoice due dates and sends email notifications once a day at the time of CRON installation. 10:30', 'dronespov') . '</p>';
						submit_button( __( 'Start Schedule', 'dronespov' ), 'secondary', 'start_dronespov_invoice_due_emails' );
						echo '</form>';
						break;

					case 'overdue' :
						echo '<form method="post" action="options.php">';
						settings_fields("overdue_trigger_id");
						do_settings_sections("settings_overdue_trigger");
						submit_button( __( 'Save', 'dronespov' ), 'primary', 'save_dronespov_invoice_overdue_emails' );
						echo '</form>';
						echo '<form method="post" action="">';
						echo '<p class="description">' . __('Click the button below to start the CRON email notification schedule. CRON checks due and overdue invoice due dates and sends email notifications once a day at the time of CRON installation.  10:30', 'dronespov') . '</p>';
						submit_button( __( 'Start Schedule', 'dronespov' ), 'secondary', 'start_dronespov_invoice_overdue_emails' );
						echo '</form>';
						break;

					case 'paid' :
						echo '<form method="post" action="options.php">';
						settings_fields("paid_trigger_id");
						do_settings_sections("settings_paid_trigger");
						submit_button( __( 'Save', 'dronespov' ), 'primary', 'save_dronespov_invoice_paid_emails' );
						echo '</form>';
						echo '<p class="description">' . __('Email Notifications for paid invoice receipts are sent instantly after invoices are marked paid.', 'dronespov') . '</p>';
						break;
				} ?>
			</div>
		<?php
		}


		/**
		 * Add different types of settings and corrosponding sections
		 *
		 * @return Void
		 */
		public function add_settings() {

			add_settings_section( 'added_trigger_id', __( 'New Invoices', 'dronespov' ), array( $this,'added_section_cb' ), 'settings_added_trigger' );

			register_setting( 'added_trigger_id', '_added_trigger_email_time' );
			add_settings_field( '_added_trigger_email_time', __( 'Email Notification Schedule (24 hour time)', 'dronespov' ), array( $this, 'added_trigger_email_time_template_cb' ), 'settings_added_trigger', 'added_trigger_id' );
			register_setting( 'added_trigger_id', '_added_trigger_email_sub_template' );
			add_settings_field( '_added_trigger_email_sub_template', __( 'Subject', 'dronespov' ), array( $this, 'added_trigger_email_sub_template_cb' ), 'settings_added_trigger', 'added_trigger_id' );
			register_setting( 'added_trigger_id', '_added_trigger_email_template' );
			add_settings_field( '_added_trigger_email_template', __( 'Body', 'dronespov' ), array( $this, 'added_trigger_email_template_cb' ), 'settings_added_trigger', 'added_trigger_id' );

			add_settings_section( 'due_trigger_id', __( 'Due Invoice', 'dronespov' ), array( $this,'due_section_cb' ), 'settings_due_trigger' );

			register_setting( 'due_trigger_id', '_due_trigger_email_time' );
			add_settings_field( '_due_trigger_email_time', __( 'Email Notification Schedule (24 hour time)', 'dronespov' ), array( $this, 'due_trigger_email_time_template_cb' ), 'settings_due_trigger', 'due_trigger_id' );
			register_setting( 'due_trigger_id', '_due_trigger_email_sub_template' );
			add_settings_field( '_due_trigger_email_sub_template', __( 'Subject', 'dronespov' ), array( $this, 'due_trigger_email_sub_template_cb' ), 'settings_due_trigger', 'due_trigger_id' );
			register_setting( 'due_trigger_id', '_due_trigger_email_template' );
			add_settings_field( '_due_trigger_email_template', __( 'Template', 'dronespov' ), array( $this, 'due_trigger_email_template_cb' ), 'settings_due_trigger', 'due_trigger_id' );

			add_settings_section( 'overdue_trigger_id', __( 'Overdue Invoice', 'dronespov' ), array( $this,'overdue_section_cb' ), 'settings_overdue_trigger' );

			register_setting( 'overdue_trigger_id', '_overdue_trigger_email_time' );
			add_settings_field( '_overdue_trigger_email_time', __( 'Email Notification Schedule (24 hour time)', 'dronespov' ), array( $this, 'overdue_trigger_email_time_template_cb' ), 'settings_overdue_trigger', 'overdue_trigger_id' );
			register_setting( 'overdue_trigger_id', '_overdue_trigger_email_interval' );
			add_settings_field( '_overdue_trigger_email_interval', __( 'Email Notification Interval', 'dronespov' ), array( $this, 'overdue_trigger_email_interval_template_cb' ), 'settings_overdue_trigger', 'overdue_trigger_id' );
			register_setting( 'overdue_trigger_id', '_overdue_trigger_email_sub_template' );
			add_settings_field( '_overdue_trigger_email_sub_template', __( 'Subject', 'dronespov' ), array( $this, 'overdue_trigger_email_sub_template_cb' ), 'settings_overdue_trigger', 'overdue_trigger_id' );
			register_setting( 'overdue_trigger_id', '_overdue_trigger_email_template' );
			add_settings_field( '_overdue_trigger_email_template', __( 'Template', 'dronespov' ), array( $this, 'overdue_trigger_email_template_cb' ), 'settings_overdue_trigger', 'overdue_trigger_id' );

			add_settings_section( 'paid_trigger_id', __( 'Paid Invoice', 'dronespov' ), array( $this,'paid_section_cb' ), 'settings_paid_trigger' );

			register_setting( 'paid_trigger_id', '_paid_trigger_email_sub_template' );
			add_settings_field( '_paid_trigger_email_sub_template', __( 'Subject', 'dronespov' ), array( $this, 'paid_trigger_email_sub_template_cb' ), 'settings_paid_trigger', 'paid_trigger_id' );
			#register_setting( 'paid_trigger_id', '_paid_trigger_email_template' );
			#add_settings_field( '_paid_trigger_email_template', __( 'Template', 'dronespov' ), array( $this, 'paid_trigger_email_template_cb' ), 'settings_paid_trigger', 'paid_trigger_id' );
		}


		/**
		 * Section description
		 *
		 * @return Html
		 */
		public function added_section_cb() {

			echo '<p class="description">' . __( 'Allowed tags are: ', 'dronespov' ) . '<i>{first_name}, {last_name}, {invoice_link}, {invoice_number}, {todays_date}, {company_name}</i>' . '</p>';
		}


		/**
		 * Section description
		 *
		 * @return Html
		 */
		public function due_section_cb() {

			echo '<p class="description">' . __( 'Allowed tags are: ', 'dronespov' ) . '<i>{first_name}, {last_name}, {invoice_link}, {invoice_number}, {todays_date}, {company_name}</i>' . '</p>';
		}


		/**
		 * Section description
		 *
		 * @return Html
		 */
		public function overdue_section_cb() {

			echo '<p class="description">' . __( 'Allowed tags are: ', 'dronespov' ) . '<i>{first_name}, {last_name}, {invoice_link}, {invoice_number}, {todays_date}, {company_name}, {delay_days}</i>' . '</p>';
		}


		/**
		 * Section description
		 *
		 * @return Html
		 */
		public function paid_section_cb() {

			echo '<p class="description">' . __( 'Allowed tags are: ', 'dronespov' ) . '<i>{first_name}, {last_name}, {invoice_link}, {invoice_number}, {todays_date}, {company_name}</i>' . '</p>';
		}


		/**
		 * Field explanation
		 *
		 * @return Html
		 */
		public function added_trigger_email_time_template_cb() {

			$time = get_option('_added_trigger_email_time');

			echo '<input name="_added_trigger_email_time[hour]"type="number" class="small-text" min="0" max="24" step="1" id="_added_trigger_email_time" value="' . $time['hour'] . '" />';
			echo ' : ';
			echo '<input name="_added_trigger_email_time[minute]"type="number" class="small-text" min="0" max="60" step="1" id="_added_trigger_email_time" value="' . $time['minute'] . '" />';
		}


		/**
		 * Field explanation
		 *
		 * @return Html
		 */
		public function added_trigger_email_sub_template_cb() {

			echo '<input name="_added_trigger_email_sub_template"type="text" class="large-text" id="_added_trigger_email_sub_template" value="' . get_option('_added_trigger_email_sub_template') . '" />';
		}


		/**
		 * Field explanation
		 *
		 * @return Html
		 */
		public function added_trigger_email_template_cb() {

			echo '<textarea name="_added_trigger_email_template" rows="10" class="widefat" id="_added_trigger_email_template">' . get_option('_added_trigger_email_template') . '</textarea>';
		}


		/**
		 * Field explanation
		 *
		 * @return Html
		 */
		public function due_trigger_email_time_template_cb() {

			$time = get_option('_due_trigger_email_time');

			echo '<input name="_due_trigger_email_time[hour]"type="number" class="small-text" min="0" max="24" step="1" id="_due_trigger_email_time" value="' . $time['hour'] . '" />';
			echo ' : ';
			echo '<input name="_due_trigger_email_time[minute]"type="number" class="small-text" min="0" max="60" step="1" id="_due_trigger_email_time" value="' . $time['minute'] . '" />';
		}


		/**
		 * Field explanation
		 *
		 * @return Html
		 */
		public function due_trigger_email_sub_template_cb() {

			echo '<input name="_due_trigger_email_sub_template"type="text" class="large-text" id="_due_trigger_email_sub_template" value="' . get_option('_due_trigger_email_sub_template') . '" />';
		}


		/**
		 * Field explanation
		 *
		 * @return Html
		 */
		public function due_trigger_email_template_cb() {

			echo '<textarea name="_due_trigger_email_template" rows="10" class="widefat" id="_due_trigger_email_template">' . get_option('_due_trigger_email_template') . '</textarea>';
		}


		/**
		 * Field explanation
		 *
		 * @return Html
		 */
		public function overdue_trigger_email_time_template_cb() {

			$time = get_option('_overdue_trigger_email_time');

			echo '<input name="_overdue_trigger_email_time[hour]"type="number" class="small-text" min="0" max="24" step="1" id="_overdue_trigger_email_time" value="' . $time['hour'] . '" />';
			echo ' : ';
			echo '<input name="_overdue_trigger_email_time[minute]"type="number" class="small-text" min="0" max="60" step="1" id="_overdue_trigger_email_time" value="' . $time['minute'] . '" />';
		}


		/**
		 * Field explanation
		 *
		 * @return Html
		 */
		public function overdue_trigger_email_interval_template_cb() {

			echo '<input name="_overdue_trigger_email_interval"type="number" min="1" max="28" class="small-text" id="_overdue_trigger_email_interval" value="' . get_option('_overdue_trigger_email_interval') . '" /> days';
		}


		/**
		 * Field explanation
		 *
		 * @return Html
		 */
		public function overdue_trigger_email_sub_template_cb() {

			echo '<input name="_overdue_trigger_email_sub_template"type="text" class="large-text" id="_overdue_trigger_email_sub_template" value="' . get_option('_overdue_trigger_email_sub_template') . '" />';
		}


		/**
		 * Field explanation
		 *
		 * @return Html
		 */
		public function overdue_trigger_email_template_cb() {

			echo '<textarea name="_overdue_trigger_email_template" rows="10" class="widefat" id="_overdue_trigger_email_template">' . get_option('_overdue_trigger_email_template') . '</textarea>';
		}


		/**
		 * Field explanation
		 *
		 * @return Html
		 */
		public function paid_trigger_email_sub_template_cb() {

			echo '<input name="_paid_trigger_email_sub_template"type="text" class="large-text" id="_paid_trigger_email_sub_template" value="' . get_option('_paid_trigger_email_sub_template') . '" />';
		}


		/**
		 * Field explanation
		 *
		 * @return Html
		 */
		public function paid_trigger_email_template_cb() {

			echo '<textarea name="_paid_trigger_email_template" rows="10" class="widefat" id="_paid_trigger_email_template">' . get_option('_paid_trigger_email_template') . '</textarea>';
		}


		/**
		 * Custom corn class, register it while activation
		 *
		 * @return Void
		 */
		public function added_cron_activation() {

			if ( class_exists( 'DRONESPOV_CRON' ) ) {

				$cron = new DRONESPOV_CRON();
				$schedule = $cron->schedule_task(
							array(
							'timestamp' => current_time('timestamp'),
							'recurrence' => 'hourly',
							'hook' => 'dronespov_added_email_cron'
						) );
			}

		}


		/**
		 * Custom corn class, register it while activation
		 *
		 * @return Void
		 */
		public function due_cron_activation() {

			if ( class_exists( 'DRONESPOV_CRON' ) ) {

				$cron = new DRONESPOV_CRON();
				$schedule = $cron->schedule_task(
							array(
							'timestamp' => current_time('timestamp'),
							'recurrence' => 'hourly',
							'hook' => 'dronespov_due_email_cron'
						) );
			}

		}


		/**
		 * Custom corn class, register it while activation
		 *
		 * @return Void
		 */
		public function overdue_cron_activation() {

			if ( class_exists( 'DRONESPOV_CRON' ) ) {

				$cron = new DRONESPOV_CRON();
				$schedule = $cron->schedule_task(
							array(
							'timestamp' => current_time('timestamp'),
							'recurrence' => 'hourly',
							'hook' => 'dronespov_over_due_email_cron'
						) );
			}

		}


		public function countries() {

			return array(
				"United States",
				"Afganistan",
				 "Albania",
				 "Algeria",
				 "American Samoa",
				 "Andorra",
				 "Angola",
				 "Anguilla",
				 "Antigua & Barbuda",
				 "Argentina",
				 "Armenia",
				 "Aruba",
				 "Australia",
				 "Austria",
				 "Azerbaijan",
				 "Bahamas",
				 "Bahrain",
				 "Bangladesh",
				 "Barbados",
				 "Belarus",
				 "Belgium",
				 "Belize",
				 "Benin",
				 "Bermuda",
				 "Bhutan",
				 "Bolivia",
				 "Bonaire",
				 "Bosnia & Herzegovina",
				 "Botswana",
				 "Brazil",
				 "British Indian Ocean Ter",
				 "Brunei",
				 "Bulgaria",
				 "Burkina Faso",
				 "Burundi",
				 "Cambodia",
				 "Cameroon",
				 "Canada",
				 "Canary Islands",
				 "Cape Verde",
				 "Cayman Islands",
				 "Central African Republic",
				 "Chad",
				 "Channel Islands",
				 "Chile",
				 "China",
				 "Christmas Island",
				 "Cocos Island",
				 "Colombia",
				 "Comoros",
				 "Congo",
				 "Cook Islands",
				 "Costa Rica",
				 "Cote DIvoire",
				 "Croatia",
				 "Cuba",
				 "Curaco",
				 "Cyprus",
				 "Czech Republic",
				 "Denmark",
				 "Djibouti",
				 "Dominica",
				 "Dominican Republic",
				 "East Timor",
				 "Ecuador",
				 "Egypt",
				 "El Salvador",
				 "Equatorial Guinea",
				 "Eritrea",
				 "Estonia",
				 "Ethiopia",
				 "Falkland Islands",
				 "Faroe Islands",
				 "Fiji",
				 "Finland",
				 "France",
				 "French Guiana",
				 "French Polynesia",
				 "French Southern Ter",
				 "Gabon",
				 "Gambia",
				 "Georgia",
				 "Germany",
				 "Ghana",
				 "Gibraltar",
				 "Great Britain",
				 "Greece",
				 "Greenland",
				 "Grenada",
				 "Guadeloupe",
				 "Guam",
				 "Guatemala",
				 "Guinea",
				 "Guyana",
				 "Haiti",
				 "Hawaii",
				 "Honduras",
				 "Hong Kong",
				 "Hungary",
				 "Iceland",
				 "Indonesia",
				 "India",
				 "Iran",
				 "Iraq",
				 "Ireland",
				 "Isle of Man",
				 "Israel",
				 "Italy",
				 "Jamaica",
				 "Japan",
				 "Jordan",
				 "Kazakhstan",
				 "Kenya",
				 "Kiribati",
				 "Korea North",
				 "Korea Sout",
				 "Kuwait",
				 "Kyrgyzstan",
				 "Laos",
				 "Latvia",
				 "Lebanon",
				 "Lesotho",
				 "Liberia",
				 "Libya",
				 "Liechtenstein",
				 "Lithuania",
				 "Luxembourg",
				 "Macau",
				 "Macedonia",
				 "Madagascar",
				 "Malaysia",
				 "Malawi",
				 "Maldives",
				 "Mali",
				 "Malta",
				 "Marshall Islands",
				 "Martinique",
				 "Mauritania",
				 "Mauritius",
				 "Mayotte",
				 "Mexico",
				 "Midway Islands",
				 "Moldova",
				 "Monaco",
				 "Mongolia",
				 "Montserrat",
				 "Morocco",
				 "Mozambique",
				 "Myanmar",
				 "Nambia",
				 "Nauru",
				 "Nepal",
				 "Netherland Antilles",
				 "Netherlands",
				 "Nevis",
				 "New Caledonia",
				 "New Zealand",
				 "Nicaragua",
				 "Niger",
				 "Nigeria",
				 "Niue",
				 "Norfolk Island",
				 "Norway",
				 "Oman",
				 "Pakistan",
				 "Palau Island",
				 "Palestine",
				 "Panama",
				 "Papua New Guinea",
				 "Paraguay",
				 "Peru",
				 "Phillipines",
				 "Pitcairn Island",
				 "Poland",
				 "Portugal",
				 "Puerto Rico",
				 "Qatar",
				 "Republic of Montenegro",
				 "Republic of Serbia",
				 "Reunion",
				 "Romania",
				 "Russia",
				 "Rwanda",
				 "St Barthelemy",
				 "St Eustatius",
				 "St Helena",
				 "St Kitts-Nevis",
				 "St Lucia",
				 "St Maarten",
				 "St Pierre & Miquelon",
				 "St Vincent & Grenadines",
				 "Saipan",
				 "Samoa",
				 "Samoa American",
				 "San Marino",
				 "Sao Tome & Principe",
				 "Saudi Arabia",
				 "Senegal",
				 "Seychelles",
				 "Sierra Leone",
				 "Singapore",
				 "Slovakia",
				 "Slovenia",
				 "Solomon Islands",
				 "Somalia",
				 "South Africa",
				 "Spain",
				 "Sri Lanka",
				 "Sudan",
				 "Suriname",
				 "Swaziland",
				 "Sweden",
				 "Switzerland",
				 "Syria",
				 "Tahiti",
				 "Taiwan",
				 "Tajikistan",
				 "Tanzania",
				 "Thailand",
				 "Togo",
				 "Tokelau",
				 "Tonga",
				 "Trinidad & Tobago",
				 "Tunisia",
				 "Turkey",
				 "Turkmenistan",
				 "Turks & Caicos Is",
				 "Tuvalu",
				 "Uganda",
				 "United Kingdom",
				 "Ukraine",
				 "United Arab Erimates",
				 "Uraguay",
				 "Uzbekistan",
				 "Vanuatu",
				 "Vatican City State",
				 "Venezuela",
				 "Vietnam",
				 "Virgin Islands (Brit)",
				 "Virgin Islands (USA)",
				 "Wake Island",
				 "Wallis & Futana Is",
				 "Yemen",
				 "Zaire",
				 "Zambia",
				 "Zimbabwe",
			);
		}
	}
} ?>

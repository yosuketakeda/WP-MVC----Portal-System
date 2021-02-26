<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Main plugin object to define the plugin
 * Follow: https://codex.wordpress.org/Plugin_API for details
 *
 * @author     Nirjhar Lo
 * @package    dronespov
 */
if ( ! class_exists( 'DRONESPOV_BUILD' ) ) {

	final class DRONESPOV_BUILD {

		/**
		 * @var String
		 */
		protected $version = '1.3.8';

		/**
		 * Plugin Instance.
		 *
		 * @var DRONESPOV_BUILD the PLUGIN Instance
		 */
		protected static $_instance;


		/**
		 * Text domain to be used throughout the plugin
		 *
		 * @var String
		 */
		protected static $text_domain = 'dronespov';


		/**
		 * Minimum PHP version allowed for the plugin
		 *
		 * @var String
		 */
		protected static $php_ver_allowed = '5.3';


		/**
		 * DB tabble used in plugin
		 *
		 * @var String
		 */
		protected static $plugin_table = 'dronespov_invoices';


		/**
		 * DB tabble used in plugin
		 *
		 * @var String
		 */
		protected static $plugin_file_table = 'dronespov_old_invoices';


		/**
		 * Main Plugin Instance.
		 *
		 * @return DRONESPOV_BUILD
		 */
		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
				self::$_instance->init();
			}

			return self::$_instance;
		}


		/**
		 * Install plugin setup
		 *
		 * @return Void
		 */
		public function installation() {

			if (class_exists('DRONESPOV_INSTALL')) {

				$install = new DRONESPOV_INSTALL();
				$install->text_domain = self::$text_domain;
				$install->php_ver_allowed = self::$php_ver_allowed;
				$install->execute();
			}

			#$this->db_install();
		}


		/**
		 * Install plugin data
		 *
		 * @return Void
		 */
		public function db_install() {

			if ( class_exists( 'DRONESPOV_DB' ) ) {

				$db = new DRONESPOV_DB();
				$db->table = self::$plugin_table;
				$db->sql = "ID mediumint(9) NOT NULL AUTO_INCREMENT,
							bill_to mediumint(9) NOT NULL,
							project varchar(1024) NOT NULL,
							row text NOT NULL,
							tax mediumint(9) NOT NULL,
							total mediumint(9) NOT NULL,
							notes varchar(4096) NOT NULL,
							invoice_date date NOT NULL,
							due_date date NOT NULL,
							paid_date date,
							status smallint(1) NOT NULL,
							is_estimate smallint(1) NOT NULL,
							added_on TIMESTAMP NOT NULL,
							created_by mediumint(9) [1] NOT NULL,
							is_trash smallint(1) NOT NULL,
							delete_date date,
							UNIQUE KEY ID (ID)";
				$db->version = $this->version;
				$db->migrate_sql = "ADD created_by mediumint(9) NOT NULL DEFAULT 1 AFTER added_on";
				$db->build();

				$db = new DRONESPOV_DB();
				$db->table = self::$plugin_file_table;
				$db->sql = "ID mediumint(9) NOT NULL AUTO_INCREMENT,
							invoice_id mediumint(9) NOT NULL,
							url varchar(2048) NOT NULL,
							path varchar(2048) NOT NULL,
							upload_date date NOT NULL,
							UNIQUE KEY ID (ID)";
				$db->build();
			}

			if (get_option( '_dronespov_db_exists') == '0' ) {
				add_action( 'admin_notices', array( $this, 'db_error_msg' ) );
			}

			flush_rewrite_rules();
		}


		/**
		 * Notice of DB
		 *
		 * @return Html
		 */
		public function db_error_msg() { ?>

			<div class="notice notice-error is-dismissible">
				<p><?php _e( 'Database table Not installed correctly.', 'dronespov' ); ?></p>
 			</div>
			<?php
		}


		/**
		 * Uninstall CRON hook
		 *
		 * @return Void
		 */
		public function cron_uninstall() {

			wp_clear_scheduled_hook( 'dronespov_added_email_cron' );
			wp_clear_scheduled_hook( 'dronespov_due_email_cron' );
			wp_clear_scheduled_hook( 'dronespov_over_due_email_cron' );
		}


		/**
		 * Set client role
		 *
		 * @return Void
		 */
		public function roles() {

			if ( class_exists( 'DRONESPOV_USER' ) ) new DRONESPOV_USER();
		}


		/**
		 * Register users
		 *
		 * @return Void
		 */
		public function register() {

			if ( class_exists( 'DRONESPOV_REGISTER' ) ) new DRONESPOV_REGISTER();
			if ( class_exists( 'DRONESPOV_ACCOUNT' ) ) new DRONESPOV_ACCOUNT();
		}


		/**
		 * Register users
		 *
		 * @return Void
		 */
		public function login() {

			if ( class_exists( 'DRONESPOV_LOGIN' ) ) new DRONESPOV_LOGIN();
		}


		/**
		 * Register users
		 *
		 * @return Void
		 */
		public function upload_invoice() {

			if ( class_exists( 'DRONESPOV_CREATE_INVOICE' ) ) new DRONESPOV_CREATE_INVOICE();
		}


		/**
		 * Register users
		 *
		 * @return Void
		 */
		public function change_status() {

			if ( class_exists( 'DRONESPOV_CHANGE_STATUS' ) ) new DRONESPOV_CHANGE_STATUS();
		}


		/**
		 * Include scripts
		 *
		 * @return Void
		 */
		public function scripts() {

			if ( class_exists( 'DRONESPOV_SCRIPT' ) ) new DRONESPOV_SCRIPT();
		}


		/**
		 * Include settings pages
		 *
		 * @return Void
		 */
		public function settings() {

			if ( class_exists( 'DRONESPOV_SETTINGS' ) ) new DRONESPOV_SETTINGS();
		}


		/**
		 * Include shortcode classes
		 *
		 * @return Void
		 */
		public function routes() {

			if ( class_exists( 'DRONESPOV_ROUTES' ) ) new DRONESPOV_ROUTES();
		}
		/**
		 * Run CRON action
		 *
		 * @return Void
		 */
		public function custom_cron_hook_cb() {

			add_action( 'dronespov_added_email_cron', array( $this, 'do_cron_job_function_added' ) );
			add_action( 'dronespov_due_email_cron', array( $this, 'do_cron_job_function_due' ) );
			add_action( 'dronespov_over_due_email_cron', array( $this, 'do_cron_job_function_overdue' ) );
		}


		/**
		 * CRON callback
		 *
		 * @return Void
		 */
		public function do_cron_job_function_added() {

			if ( class_exists( 'DRONESPOV_EMAIL' ) ) {
				$email = new DRONESPOV_EMAIL();
				$email->added_email();
			}
		}


		/**
		 * CRON callback
		 *
		 * @return Void
		 */
		public function do_cron_job_function_due() {

			if ( class_exists( 'DRONESPOV_EMAIL' ) ) {
				$email = new DRONESPOV_EMAIL();
				$email->due_email();
			}
		}


		/**
		 * CRON callback
		 *
		 * @return Void
		 */
		public function do_cron_job_function_overdue() {

			if ( class_exists( 'DRONESPOV_EMAIL' ) ) {
				$email = new DRONESPOV_EMAIL();
				$email->overdue_email();
			}
		}


		/**
		 * Add the functionality files
		 *
		 * @return Void
		 */
		public function functionality() {

			require_once( 'src/class-install.php' );
			require_once( 'src/class-db.php' );
			require_once( 'src/class-settings.php' );
			require_once( 'src/class-routes.php' );
		}


		/**
		 * Call the dependency files
		 *
		 * @return Void
		 */
		public function helpers() {

			require_once( 'lib/class-user.php' );
			require_once( 'lib/class-script.php' );
			require_once( 'lib/class-cron.php' );
			require_once( 'lib/class-email.php' );

			require_once( 'vendor/fpdf181/fpdf.php' );
			require_once( 'vendor/api2pdf/src/Api2Pdf.php' );
			require_once( 'vendor/api2pdf/src/ApiResult.php' );

			require_once( 'lib/app/controllers/class-register.php' );
			require_once( 'lib/app/controllers/class-login.php' );
			require_once( 'lib/app/controllers/class-create-invoice.php' );
			require_once( 'lib/app/controllers/class-admin-list.php' );
			require_once( 'lib/app/controllers/class-admin-list-deleted.php' );
			require_once( 'lib/app/controllers/class-view-invoice.php' );
			require_once( 'lib/app/controllers/class-client-list.php' );
			require_once( 'lib/app/controllers/class-upload.php' );
			require_once( 'lib/app/controllers/class-change-status.php' );
			require_once( 'lib/app/controllers/class-pdf.php' );
			require_once( 'lib/app/controllers/class-account.php' );
		}


		/**
		 * Instantiate the plugin
		 *
		 * @return Void
		 */
		public function init() {

			$timezone = wp_timezone_string();
			date_default_timezone_set($timezone);

			$this->helpers();
			$this->functionality();

			register_activation_hook( DRONESPOV_FILE, array( $this, 'db_install' ) );

			register_deactivation_hook( DRONESPOV_FILE, array( $this, 'cron_uninstall' ) );

			$this->routes();
			add_action( 'init', array( $this, 'installation' ) );

			add_action( 'init', array( $this, 'scripts' ) );
			add_action( 'init', array( $this, 'roles' ) );

			add_action( 'init', array( $this, 'register' ) );
			add_action( 'init', array( $this, 'login' ) );
			add_action( 'init', array( $this, 'upload_invoice' ) );
			add_action( 'init', array( $this, 'change_status' ) );
			add_action( 'init', array( $this, 'settings' ) );

			$this->custom_cron_hook_cb();
		}
	}
} ?>

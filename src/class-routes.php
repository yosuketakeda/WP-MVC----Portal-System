<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode class for rendering in front end
 *
 * @author     Nirjhar Lo
 * @package    dronespov
 */
if ( ! class_exists( 'DRONESPOV_ROUTES' ) ) {

	class DRONESPOV_ROUTES {


		/**
		 * Add Shortcode
		 *
		 * @return Void
		 */
		public function __construct() {

			add_filter( 'generate_rewrite_rules', array($this, 'register_routes'), 10, 1 );
			add_filter( 'query_vars', array($this, 'register_query_vars'), 10, 1 );

			add_action( 'template_redirect', array($this, 'display_html_verify') );
			add_action( 'template_redirect', array($this, 'display_html_login') );
			add_action( 'template_redirect', array($this, 'display_html_logout') );
			add_action( 'template_redirect', array($this, 'display_html_register') );
			add_action( 'template_redirect', array($this, 'display_html_admin_view') );
			add_action( 'template_redirect', array($this, 'display_html_admin_deleted_view') );
			add_action( 'template_redirect', array($this, 'display_html_admin_uplaod') );
			add_action( 'template_redirect', array($this, 'display_html_admin_list') );
			add_action( 'template_redirect', array($this, 'pdf_download_admin') );
			add_action( 'template_redirect', array($this, 'display_html_client_view') );
			add_action( 'template_redirect', array($this, 'display_html_client_list') );
			add_action( 'template_redirect', array($this, 'display_html_client_account') );
			add_action( 'template_redirect', array($this, 'pdf_download') );
			add_action( 'template_redirect', array($this, 'display_html_calculator') );
		}

		/**
		 * Register routes
		 *
		 * @param Object $wp_rewrite
		 *
		 * @return Object
		 */
		public function register_routes($wp_rewrite) {

			$wp_rewrite->rules = array_merge(
				['verify' => 'index.php?dronespov_verify=1'],
				['login' => 'index.php?dronespov_login=1'],
				['logout' => 'index.php?dronespov_logout=1'],
				['register' => 'index.php?dronespov_register=1'],
				['admin/view_invoice/([^/]+)/?' => 'index.php?dronespov_admin_view=$matches[1]'],
				['admin/create_invoice' => 'index.php?dronespov_admin_upload=1'],
				['admin/list_invoice' => 'index.php?dronespov_admin_list=1'],
				['admin/deleted_invoice' => 'index.php?dronespov_admin_deleted_list=1'],
				['admin/download/([^/]+)/?' => 'index.php?dronespov_admin_download=$matches[1]'],
				['admin/price_calculator' => 'index.php?dronespov_admin_calculator=1'],
				['client/view_invoice/([^/]+)/?' => 'index.php?dronespov_client_view=$matches[1]'],
				['client/download/([^/]+)/?' => 'index.php?dronespov_client_download=$matches[1]'],
				['client/list_invoice' => 'index.php?dronespov_client_list=1'],
				['client/account' => 'index.php?dronespov_client_account=1'],
				$wp_rewrite->rules
			);
		}

		/**
		 * Set query vars
		 *
		 * @param Array $query_vars
		 *
		 * @return Array
		 */
		public function register_query_vars($query_vars) {

			$query_vars[] = 'dronespov_verify';
			$query_vars[] = 'dronespov_login';
			$query_vars[] = 'dronespov_logout';
			$query_vars[] = 'dronespov_register';
			$query_vars[] = 'dronespov_admin_view';
			$query_vars[] = 'dronespov_admin_upload';
			$query_vars[] = 'dronespov_admin_list';
			$query_vars[] = 'dronespov_admin_deleted_list';
			$query_vars[] = 'dronespov_admin_download';
			$query_vars[] = 'dronespov_admin_calculator';
			$query_vars[] = 'dronespov_client_view';
			$query_vars[] = 'dronespov_client_list';
			$query_vars[] = 'dronespov_client_download';
			$query_vars[] = 'dronespov_client_account';

			return $query_vars;
		}

		/**
		 * Display the HTML for Login form
		 *
		 * @return HTML
		 */
		 public function display_html_verify() {

		 	if ( intval( get_query_var( 'dronespov_verify' ) ) ) {
				$title = __('Verify | Dronespointofview', 'dronespov');
				$description = __('Verify your email', 'dronespov');
				require_once( DRONESPOV_PATH . "/lib/app/views/header.php" );
				die;
		 	}
		}

		/**
		 * Display the HTML for Login form
		 *
		 * @return HTML
		 */
		 public function display_html_login() {

		 	if ( intval( get_query_var( 'dronespov_login' ) ) ) {
				$title = __('Login | Dronespointofview', 'dronespov');
				$description = __('Login to your Portal', 'dronespov');
				require_once( DRONESPOV_PATH . "/lib/app/views/header.php" );
				require_once( DRONESPOV_PATH . '/lib/app/views/login.php' );
				require_once( DRONESPOV_PATH . '/lib/app/views/footer.php' );
				die;
		 	}
		}

		/**
		 * Display the HTML for Login form
		 *
		 * @return HTML
		 */
		 public function display_html_logout() {

		 	if ( intval( get_query_var( 'dronespov_logout' ) ) ) {
				wp_logout();
				wp_safe_redirect(site_url() . '/login');
				die;
		 	}
		}


		/**
		 * Display the HTML for Register form
		 *
		 * @return HTML
		 */
		 public function display_html_register() {

		 	if ( intval( get_query_var( 'dronespov_register' ) ) ) {
				$title = __('Register | Dronespointofview', 'dronespov');
				$description = __('Signup for your own Portal', 'dronespov');
				require_once( DRONESPOV_PATH . "/lib/app/views/header.php" );
				require_once( DRONESPOV_PATH . '/lib/app/views/register.php' );
				require_once( DRONESPOV_PATH . '/lib/app/views/footer.php' );
				die;
		 	}
		}

		/**
		 * Display the HTML for viewing invoice
		 *
		 * @return HTML
		 */
		 public function display_html_admin_view() {

			 if ( intval( get_query_var( 'dronespov_admin_view' ) ) ) {

				$this->admin_filter();

			    $title = __('Admin > Invoice > View | Dronespointofview', 'dronespov');
			    $name = $this->get_user_name();

			    $invoice_ID = intval( get_query_var( 'dronespov_admin_view' ) );
			    $view = new DRONESPOV_INVOICE_VIEW();
				$view->filter_for_admin_view_invoice();
				$invoice = $view->get_invoice();
				$old_invoice = $view->get_old_invoice();

			    require_once( DRONESPOV_PATH . "/lib/app/views/header.php" );
			    require_once( DRONESPOV_PATH . '/lib/app/views/menu.php' );
			    require_once( DRONESPOV_PATH . '/lib/app/views/client/view-invoice.php' );
			    require_once( DRONESPOV_PATH . '/lib/app/views/footer.php' );
			    die;
			 }
		 }

		/**
		 * Display the HTML for dashboard
		 *
		 * @return HTML
		 */
		 public function display_html_admin_uplaod() {

			if ( intval( get_query_var( 'dronespov_admin_upload' ) ) ) {

				$this->admin_filter();

				$title = __('Admin > Invoice > Upload | Dronespointofview', 'dronespov');
				$name = $this->get_user_name();

				$uplaod = new DRONESPOV_UPLOAD();
				$user_list = $uplaod->get_user_list();
				$project_list = $uplaod->get_project_list();
				$item_list = $uplaod->get_items_list();
				$tax_list = $uplaod->get_tax_list();
				$edit_data = $uplaod->editable_data();
				require_once( DRONESPOV_PATH . "/lib/app/views/header.php" );
				require_once( DRONESPOV_PATH . '/lib/app/views/menu.php' );
				require_once( DRONESPOV_PATH . '/lib/app/views/admin/upload-invoice.php' );
				require_once( DRONESPOV_PATH . '/lib/app/views/footer.php' );
				die;
			}
		}


		/**
		* Display the list of deleted invoices
		*
		* @return HTML
		*/
		public function display_html_admin_deleted_view() {

			if ( intval( get_query_var( 'dronespov_admin_deleted_list' ) ) ) {

				$this->admin_filter();

				$title = __('Admin > Invoice > Deleted | Dronespointofview', 'dronespov');
				$name = $this->get_user_name();

				$list = new DRONESPOV_ADMIN_LIST_DELETED();
				$invoices = $list->get_invoice_list();

				require_once( DRONESPOV_PATH . "/lib/app/views/header.php" );
				require_once( DRONESPOV_PATH . '/lib/app/views/menu.php' );
				require_once( DRONESPOV_PATH . '/lib/app/views/admin/list-deleted-invoice.php' );
				require_once( DRONESPOV_PATH . '/lib/app/views/footer.php' );
				die;
			}
		}


		/**
		 * Display a pricing calculator
		 *
		 * @return HTML
		 */
		public function display_html_calculator() {

			if ( intval( get_query_var( 'dronespov_admin_calculator' ) ) ) {

				$this->admin_filter();

				$title = __('Admin > Price Calculator | Dronespointofview', 'dronespov');
				$name = $this->get_user_name();

				$list = new DRONESPOV_ADMIN_LIST_DELETED();
				$invoices = $list->get_invoice_list();

				require_once( DRONESPOV_PATH . "/lib/app/views/header.php" );
				require_once( DRONESPOV_PATH . '/lib/app/views/menu.php' );
				require_once( DRONESPOV_PATH . '/lib/app/views/admin/pricing-calc.php' );
				require_once( DRONESPOV_PATH . '/lib/app/views/footer.php' );
				die;
			}
		}


		/**
		 * Display the list of active invoices
		 *
		 * @return HTML
		 */
		 public function display_html_admin_list() {

			if ( intval( get_query_var( 'dronespov_admin_list' ) ) ) {

				$this->admin_filter();

				$title = __('Admin > Invoice > List | Dronespointofview', 'dronespov');
				$name = $this->get_user_name();

				$list = new DRONESPOV_ADMIN_LIST();
				$invoice_list = $list->get_invoice_list();
				$invoice_totals = $list->get_totals();
				$estimate_invoice = $list->get_tabs();
				$estimates = $list->get_estimate_list();

				require_once( DRONESPOV_PATH . "/lib/app/views/header.php" );
				require_once( DRONESPOV_PATH . '/lib/app/views/menu.php' );
				require_once( DRONESPOV_PATH . '/lib/app/views/admin/list-invoice.php' );
				require_once( DRONESPOV_PATH . '/lib/app/views/footer.php' );
				die;
			}
		}


		/**
		 * Display the HTML for View invoice
		 *
		 * @return HTML
		 */
		 public function display_html_client_view() {

			 if ( intval( get_query_var( 'dronespov_client_view' ) ) ) {

 				$this->client_filter();

 				$title = __('Client > Invoice > View | Dronespointofview', 'dronespov');
 				$name = $this->get_user_name();

				$invoice_ID = intval( get_query_var( 'dronespov_client_view' ) );
				$view = new DRONESPOV_INVOICE_VIEW();
				$view->filter_view_invoice();
				$invoice = $view->get_invoice();
				$old_invoice = $view->get_old_invoice();

 				require_once( DRONESPOV_PATH . "/lib/app/views/header.php" );
 				require_once( DRONESPOV_PATH . '/lib/app/views/menu.php' );
 				require_once( DRONESPOV_PATH . '/lib/app/views/client/view-invoice.php' );
 				require_once( DRONESPOV_PATH . '/lib/app/views/footer.php' );
 				die;
 			}
		}


		/**
		 * Display the HTML for View invoice
		 *
		 * @return HTML
		 */
		 public function display_html_client_list() {

			 if ( intval( get_query_var( 'dronespov_client_list' ) ) ) {

 				$this->client_filter();

 				$title = __('Client > Invoice > List | Dronespointofview', 'dronespov');
 				$name = $this->get_user_name();

				$list = new DRONESPOV_CLIENT_LIST();
				$invoice_list = $list->get_invoice_list();
				$invoice_totals = $list->get_totals();
				$estimate_invoice = $list->get_tabs();
				$estimates = $list->get_estimate_list();

 				require_once( DRONESPOV_PATH . "/lib/app/views/header.php" );
 				require_once( DRONESPOV_PATH . '/lib/app/views/menu.php' );
 				require_once( DRONESPOV_PATH . '/lib/app/views/client/list-invoice.php' );
 				require_once( DRONESPOV_PATH . '/lib/app/views/footer.php' );
 				die;
 			}
		}


		/**
		 * Display the HTML for View invoice
		 *
		 * @return HTML
		 */
		 public function display_html_client_account() {

			 if ( intval( get_query_var( 'dronespov_client_account' ) ) ) {

 				$this->client_filter();

 				$title = __('Client > Account | Dronespointofview', 'dronespov');
 				$name = $this->get_user_name();

				$user_id = get_current_user_id();

				$company = get_user_meta( $user_id, '_company', true );
				$email = get_userdata( $user_id )->user_email;
				$phone = get_user_meta( $user_id, '_phone', true );
				$address = maybe_unserialize(get_user_meta( $user_id, '_address', true ));
				$street = $address['street'];
				$city = $address['city'];
				$state = $address['state'];
				$zip = $address['zip'];
				$country = $address['country'];
				$countries = $this->countries();

				require_once( DRONESPOV_PATH . "/lib/app/views/header.php" );
 				require_once( DRONESPOV_PATH . '/lib/app/views/menu.php' );
 				require_once( DRONESPOV_PATH . '/lib/app/views/client/account.php' );
 				require_once( DRONESPOV_PATH . '/lib/app/views/footer.php' );
 				die;
 			}
		}


		/**
		 * Download the invoice
		 *
		 * @return HTML
		 */
		public function pdf_download() {

			if ( intval( get_query_var( 'dronespov_client_download' ) ) ) {

			   $this->client_filter();

			   $view = new DRONESPOV_INVOICE_VIEW();
			   $view->filter_view_invoice();

			   $pdf = new DRONESPOV_PDF();
			   $pdf->download();
			}
		}


		/**
		 * Download the invoice
		 *
		 * @return HTML
		 */
		public function pdf_download_admin() {

			if ( intval( get_query_var( 'dronespov_admin_download' ) ) ) {

				 $view = new DRONESPOV_INVOICE_VIEW();
				 $view->filter_for_admin_view_invoice();

			   $pdf = new DRONESPOV_PDF();
			   $pdf->download();
			}
		}


		public function admin_filter() {

			if (! is_user_logged_in() || ! current_user_can('administrator')) {
				wp_safe_redirect(site_url() . '/login');
			}
		}


		public function client_filter() {

			$user_id = get_current_user_id();
			$roles = get_userdata($user_id)->roles;
			if (! is_user_logged_in() || ! in_array('dronespov_client', $roles)) {
				wp_safe_redirect(site_url() . '/login');
			}
		}


		public function get_user_name() {

			$user_id = get_current_user_id();
			$name = false;

			if (is_user_logged_in()) {
				$name = get_user_meta($user_id, 'first_name', true);
			}

			return $name;
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

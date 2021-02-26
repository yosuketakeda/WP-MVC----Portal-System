<?php
/**
 * Add scripts to the plugin. CSS and JS.
 *
 * @author     Nirjhar Lo
 * @package    dronespov
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'DRONESPOV_SCRIPT' ) ) {

	final class DRONESPOV_SCRIPT {


		/**
		 * @var String
		 */
		private $path;


		/**
		 * Add scripts to front/back end heads
		 *
		 * @return Void
		 */
		public function __construct() {

			$this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
			add_action( 'doronespov_head', array( $this, 'frontend_style' ) );
			add_action( 'doronespov_footer', array( $this, 'frontend_scripts' ) );
		}


		/**
		 * Enter scripts into pages
		 *
		 * @return String
		 */
		public function frontend_style() {

			echo '<link rel="stylesheet" href="' . DRONESPOV_CSS . 'bootstrap.min.css' . '" media="all" />';
			echo '<link rel="stylesheet" href="' . DRONESPOV_CSS . 'bootstrap-extend.min.css' . '" media="all" />';
			echo '<link rel="stylesheet" href="' . DRONESPOV_CSS . 'site.min.css' . '" media="all" />';

			echo '<link rel="stylesheet" href="' . DRONESPOV_VENDOR . 'animsition/animsition.css' . '" media="all" />';
			echo '<link rel="stylesheet" href="' . DRONESPOV_VENDOR . 'asscrollable/asScrollable.css' . '" media="all" />';
			echo '<link rel="stylesheet" href="' . DRONESPOV_VENDOR . 'switchery/switchery.css' . '" media="all" />';
			echo '<link rel="stylesheet" href="' . DRONESPOV_VENDOR . 'intro-js/introjs.css' . '" media="all" />';
			echo '<link rel="stylesheet" href="' . DRONESPOV_VENDOR . 'slidepanel/slidePanel.css' . '" media="all" />';
			echo '<link rel="stylesheet" href="' . DRONESPOV_VENDOR . 'flag-icon-css/flag-icon.css' . '" media="all" />';
			echo '<link rel="stylesheet" href="' . DRONESPOV_VENDOR . 'waves/waves.css' . '" media="all" />';
			echo '<link rel="stylesheet" href="' . DRONESPOV_VENDOR . 'dropify/dropify.min.css' . '" media="all" />';

			echo '<link rel="stylesheet" href="' . DRONESPOV_VENDOR . 'bootstrap-datepicker/bootstrap-datepicker.css' . '" media="all" />';

			if (false !== strpos($this->path, 'login')) {
				echo '<link rel="stylesheet" href="' . DRONESPOV_CSS . 'login.min.css' . '" media="all" />';
			} elseif (false !== strpos($this->path, 'register')) {
				echo '<link rel="stylesheet" href="' . DRONESPOV_CSS . 'register.min.css' . '" media="all" />';
			}

			if (false !== strpos($this->path, 'admin/list_invoice') || false !== strpos($this->path, 'admin/deleted_invoice') || false !== strpos($this->path, 'client/list_invoice')) {
				echo '<link rel="stylesheet" href="' . DRONESPOV_VENDOR . 'datatables.net-bs4/dataTables.bootstrap4.css' . '" media="all" />';
				echo '<link rel="stylesheet" href="' . DRONESPOV_VENDOR . 'datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css' . '" media="all" />';
				echo '<link rel="stylesheet" href="' . DRONESPOV_VENDOR . 'datatables.net-fixedcolumns-bs4/dataTables.fixedcolumns.bootstrap4.css' . '" media="all" />';
				echo '<link rel="stylesheet" href="' . DRONESPOV_VENDOR . 'datatables.net-rowgroup-bs4/dataTables.rowgroup.bootstrap4.css' . '" media="all" />';
				echo '<link rel="stylesheet" href="' . DRONESPOV_VENDOR . 'datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css' . '" media="all" />';
				echo '<link rel="stylesheet" href="' . DRONESPOV_VENDOR . 'datatables.net-select-bs4/dataTables.select.bootstrap4.css' . '" media="all" />';
				echo '<link rel="stylesheet" href="' . DRONESPOV_VENDOR . 'datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css' . '" media="all" />';
				echo '<link rel="stylesheet" href="' . DRONESPOV_VENDOR . 'datatables.net-buttons-bs4/dataTables.buttons.bootstrap4.css' . '" media="all" />';

				echo '<link rel="stylesheet" href="' . DRONESPOV_CSS . 'datatable.css' . '" media="all" />';
			}

			echo '<link rel="stylesheet" href="' . DRONESPOV_FONTS . 'material-design/material-design.min.css' . '" media="all" />';
			echo '<link rel="stylesheet" href="' . DRONESPOV_FONTS . 'brand-icons/brand-icons.min.css' . '" media="all" />';
			echo '<link rel="stylesheet" href="' . 'http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic' . '" media="all" />';

			echo '<link rel="stylesheet" href="' . DRONESPOV_FONTS . 'font-awesome/font-awesome.css">';

			echo '<script src="' . 'https://code.jquery.com/jquery-3.5.1.min.js' . '"></script>';
			echo '<script src="' . DRONESPOV_VENDOR . 'breakpoints/breakpoints.js' . '"></script>';
		}


		/**
		 * Enter scripts into pages
		 *
		 * @return String
		 */
		public function frontend_scripts() {

			echo '<script src="' . DRONESPOV_VENDOR . 'babel-external-helpers/babel-external-helpers.js' . '"></script>';
			echo '<script src="' . DRONESPOV_VENDOR . 'popper-js/umd/popper.min.js' . '"></script>';
			echo '<script src="' . DRONESPOV_VENDOR . 'bootstrap/bootstrap.js' . '"></script>';
			echo '<script src="' . DRONESPOV_VENDOR . 'animsition/animsition.js' . '"></script>';
			echo '<script src="' . DRONESPOV_VENDOR . 'mousewheel/jquery.mousewheel.js' . '"></script>';
			echo '<script src="' . DRONESPOV_VENDOR . 'asscrollbar/jquery-asScrollbar.js' . '"></script>';
			echo '<script src="' . DRONESPOV_VENDOR . 'asscrollable/jquery-asScrollable.js' . '"></script>';
			echo '<script src="' . DRONESPOV_VENDOR . 'ashoverscroll/jquery-asHoverScroll.js' . '"></script>';
			echo '<script src="' . DRONESPOV_VENDOR . 'waves/waves.js' . '"></script>';

			echo '<script src="' . DRONESPOV_VENDOR . 'switchery/switchery.js' . '"></script>';
			echo '<script src="' . DRONESPOV_VENDOR . 'intro-js/intro.js' . '"></script>';
			echo '<script src="' . DRONESPOV_VENDOR . 'screenfull/screenfull.js' . '"></script>';
			echo '<script src="' . DRONESPOV_VENDOR . 'slidepanel/jquery-slidePanel.js' . '"></script>';
			echo '<script src="' . DRONESPOV_VENDOR . 'jquery-placeholder/jquery.placeholder.js' . '"></script>';

			echo '<script src="' . DRONESPOV_VENDOR . 'bootstrap-datepicker/bootstrap-datepicker.js' . '"></script>';
			echo '<script src="' . DRONESPOV_VENDOR . 'dropify/dropify.min.js' . '"></script>';

			if (false !== strpos($this->path, 'admin/list_invoice') || false !== strpos($this->path, 'admin/deleted_invoice') || false !== strpos($this->path, 'client/list_invoice')) {
				echo '<script src="' . DRONESPOV_VENDOR . 'datatables.net/jquery.dataTables.js' . '"></script>';
				echo '<script src="' . DRONESPOV_VENDOR . 'datatables.net-bs4/dataTables.bootstrap4.js' . '"></script>';
				echo '<script src="' . DRONESPOV_VENDOR . 'datatables.net-fixedheader/dataTables.fixedHeader.js' . '"></script>';
				echo '<script src="' . DRONESPOV_VENDOR . 'datatables.net-fixedcolumns/dataTables.fixedColumns.js' . '"></script>';
				echo '<script src="' . DRONESPOV_VENDOR . 'datatables.net-rowgroup/dataTables.rowGroup.js' . '"></script>';
				echo '<script src="' . DRONESPOV_VENDOR . 'datatables.net-scroller/dataTables.scroller.js' . '"></script>';
				echo '<script src="' . DRONESPOV_VENDOR . 'datatables.net-responsive/dataTables.responsive.js' . '"></script>';
				echo '<script src="' . DRONESPOV_VENDOR . 'datatables.net-responsive-bs4/responsive.bootstrap4.js' . '"></script>';
				echo '<script src="' . DRONESPOV_VENDOR . 'datatables.net-buttons/dataTables.buttons.js' . '"></script>';
				echo '<script src="' . DRONESPOV_VENDOR . 'datatables.net-buttons/buttons.html5.js' . '"></script>';
				echo '<script src="' . DRONESPOV_VENDOR . 'datatables.net-buttons/buttons.flash.js' . '"></script>';
				echo '<script src="' . DRONESPOV_VENDOR . 'datatables.net-buttons/buttons.print.js' . '"></script>';
				echo '<script src="' . DRONESPOV_VENDOR . 'datatables.net-buttons/buttons.colVis.js' . '"></script>';
				echo '<script src="' . DRONESPOV_VENDOR . 'datatables.net-buttons-bs4/buttons.bootstrap4.js' . '"></script>';
				echo '<script src="' . DRONESPOV_VENDOR . 'asrange/jquery-asRange.min.js' . '"></script>';
				echo '<script src="' . DRONESPOV_VENDOR . 'bootbox/bootbox.js' . '"></script>';
			}


			echo '<script src="' . DRONESPOV_JS . 'Component.js' . '"></script>';
			echo '<script src="' . DRONESPOV_JS . 'Plugin.js' . '"></script>';
			echo '<script src="' . DRONESPOV_JS . 'Base.js' . '"></script>';
			echo '<script src="' . DRONESPOV_JS . 'Config.js' . '"></script>';

			echo '<script src="' . DRONESPOV_JS . 'Section/Menubar.js' . '"></script>';
			echo '<script src="' . DRONESPOV_JS . 'Section/GridMenu.js' . '"></script>';
			echo '<script src="' . DRONESPOV_JS . 'Section/Sidebar.js' . '"></script>';
			echo '<script src="' . DRONESPOV_JS . 'Section/PageAside.js' . '"></script>';

			echo '<script src="' . DRONESPOV_JS . 'Plugin/menu.js' . '"></script>';

			echo '<script src="' . DRONESPOV_JS . 'config/colors.js' . '"></script>';
			echo '<script src="' . DRONESPOV_JS . 'config/tour.js' . '"></script>';

			echo '<script src="' . DRONESPOV_JS . 'Site.js' . '"></script>';

			echo '<script src="' . DRONESPOV_JS . 'Plugin/asscrollable.js' . '"></script>';
			echo '<script src="' . DRONESPOV_JS . 'Plugin/slidepanel.js' . '"></script>';
			echo '<script src="' . DRONESPOV_JS . 'Plugin/switchery.js' . '"></script>';
			echo '<script src="' . DRONESPOV_JS . 'Plugin/jquery-placeholder.js' . '"></script>';
			echo '<script src="' . DRONESPOV_JS . 'Plugin/bootstrap-datepicker.js' . '"></script>';
			echo '<script src="' . DRONESPOV_JS . 'Plugin/material.js' . '"></script>';
			echo '<script src="' . DRONESPOV_JS . 'Plugin/dropify.js' . '"></script>';
		}
	}
} ?>

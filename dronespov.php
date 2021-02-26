<?php
/**
 Plugin Name: DronesPov
 Plugin URI: https://dronespointofview.com/
 Description: Custom built Invoice management service.
 Version: 1.3.8
 Author: Nirjhar Lo
 Author URI: http://nirjharlo.com
 Text Domain: dronespov
 Domain Path: /asset/ln
 License: GPLv2
 License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit;


//Define basic names
defined( 'DRONESPOV_DEBUG' ) or define( 'DRONESPOV_DEBUG', false );

defined( 'DRONESPOV_PATH' ) or define( 'DRONESPOV_PATH', plugin_dir_path( __FILE__ ) );
defined( 'DRONESPOV_FILE' ) or define( 'DRONESPOV_FILE', plugin_basename( __FILE__ ) );

defined( 'DRONESPOV_TRANSLATE' ) or define( 'DRONESPOV_TRANSLATE', plugin_basename( plugin_dir_path( __FILE__ ) . 'asset/ln/' ) );

defined( 'DRONESPOV_JS' ) or define( 'DRONESPOV_JS', plugins_url( '/asset/js/', __FILE__  ) );
defined( 'DRONESPOV_CSS' ) or define( 'DRONESPOV_CSS', plugins_url( '/asset/css/', __FILE__ ) );
defined( 'DRONESPOV_FONTS' ) or define( 'DRONESPOV_FONTS', plugins_url( '/asset/fonts/', __FILE__ ) );
defined( 'DRONESPOV_VENDOR' ) or define( 'DRONESPOV_VENDOR', plugins_url( '/vendor/', __FILE__ ) );
defined( 'DRONESPOV_IMAGE' ) or define( 'DRONESPOV_IMAGE', plugins_url( '/asset/img/', __FILE__ ) );

defined( 'DRONESPOV_ADMIN_ID' ) or define( 'DRONESPOV_ADMIN_ID', 1 );

//The Plugin
require_once( 'autoload.php' );
function dronespov() {
	if ( class_exists( 'DRONESPOV_BUILD' ) ) return DRONESPOV_BUILD::instance();
}

global $dronespov;
$dronespov = dronespov();

require 'vendor/kernl-update-checker/kernl-update-checker.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://kernl.us/api/v1/updates/5ffbb57342001b2dde355cd8/',
    __FILE__,
    'dronespov'
);
?>

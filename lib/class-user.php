<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode class for rendering in front end
 */
if ( ! class_exists( 'DRONESPOV_USER' ) ) {

	class DRONESPOV_USER {


    public static $client_capabilities = array(
      'read'         => true,
      'edit_posts'   => false,
      'manage_options' => false,
    );


    public function __construct() {

		add_role( 'dronespov_client', __( 'Client', 'attest' ), self::$client_capabilities);
		add_action( 'admin_init', array($this, 'no_admin_access'), 100 );
    }


	public function no_admin_access() {

		global $current_user;

    	$user_roles = $current_user->roles;
    	if(in_array('dronespov_client', $user_roles)){
        	exit( wp_redirect( home_url( '/' ) ) );
    	}
 	}
  }
}

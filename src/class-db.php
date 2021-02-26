<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * DB installation class
 *
 * @author     Nirjhar Lo
 * @package    dronespov
 */
if ( ! class_exists( 'DRONESPOV_DB' ) ) {

	class DRONESPOV_DB {

		/**
		 * @var String
		 */
		public $table;


		/**
		 * @var String
		 */
		public $sql;


		/**
		 * @var String
		 */
		public $migrate_sql;


		/**
		 * Instantiate the db class
		 *
		 * @return Void
		 */
		public function __construct() {

			$this->up_path = ABSPATH . 'wp-admin/includes/upgrade.php';
		}


		/**
		 * Define the necessary database tables
		 *
		 * @return Void
		 */
		public function build() {

			global $wpdb;
			#$wpdb->hide_errors();
			$this->table_name = $wpdb->prefix . $this->table;
			update_option( '_dronespov_db_exists', 0 );
			if ( $wpdb->get_var( "SHOW TABLES LIKE '$this->table_name'" ) != $this->table_name ) {
				$execute_sql = $this->execute( $this->table_name, $this->collate(), $this->sql );
				dbDelta( $execute_sql );
			}

			if (version_compare( $this->version, '1.2.5', '>=' )) {
				$migrate_sql = $this->migrate( $this->table_name, $this->migrate_sql );
				$wpdb->query( $migrate_sql );
			}
		}


		/**
		 * Define the variables for db table creation
		 *
		 * @return String
		 */
		public function collate() {

			global $wpdb;
			$wpdb->hide_errors();
			$collate = "";
		    if ( $wpdb->has_cap( 'collation' ) ) {
				if( ! empty($wpdb->charset ) )
					$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
				if( ! empty($wpdb->collate ) )
					$collate .= " COLLATE $wpdb->collate";
		    }
    		require_once( $this->up_path );
			return $collate;
		}


		/**
		 * SQL query to create the main plugin table.
		 *
		 * @param String $table_name
		 * @param String $collate
		 * @param String $sql
		 *
		 * @return String
		 */
		public function execute( $table_name, $collate, $sql ) {

			return "CREATE TABLE $table_name ( $sql ) $collate;";
		}


		/**
		 * SQL query to migrate the main plugin table.
		 *
		 * @param String $table_name
		 * @param String $collate
		 * @param String $sql
		 *
		 * @return String
		 */
		public function migrate( $table_name, $sql ) {

			return "ALTER TABLE $table_name $sql";
		}


		/**
		 * Check options and tables and output the info to check if db install is successful
		 *
		 * @return String
		 */
		public function __destruct() {

			global $wpdb;

			$this->table_name = $wpdb->prefix . $this->table;
			if ( $wpdb->get_var( "SHOW TABLES LIKE '$this->table_name'" ) == $this->table_name ) {

				update_option( '_dronespov_db_exists', 1 );
			}
		}
	}
} ?>

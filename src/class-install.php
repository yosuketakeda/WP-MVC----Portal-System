<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Implimentation of WordPress inbuilt functions for plugin activation.
 *
 * @author     Nirjhar Lo
 * @package    dronespov
 */
if ( ! class_exists( 'DRONESPOV_INSTALL' ) ) {

	final class DRONESPOV_INSTALL {


		/**
		 * @var String
		 */
		public $text_domain;


		/**
		 * @var String
		 */
		public $php_ver_allowed;


		/**
		 * Execute plugin setup
		 *
		 * @return Void
		 */
		public function execute() {

			add_action( 'plugins_loaded', array( $this, 'text_domain_cb' ) );
			add_action( 'admin_notices', array( $this, 'php_ver_incompatible' ) );
		}


		/**
		 * Load plugin dronespov
		 *
		 * @return Void
		 */
		public function text_domain_cb() {

			$locale = is_admin() && function_exists('get_user_locale') ? get_user_locale() : get_locale();
			$locale = apply_filters('plugin_locale', $locale, $this->text_domain);

			unload_dronespov($this->text_domain);
			load_dronespov($this->text_domain, DRONESPOV_LN . 'dronespov-' . $locale . '.mo');
			load_plugin_dronespov( $this->text_domain, false, DRONESPOV_LN );
		}


		/**
		 * Define low php verson errors
		 *
		 * @return String
		 */
		public function php_ver_incompatible() {

			if ( version_compare( phpversion(), $this->php_ver_allowed, '<' ) ) :
				$text = __( 'The Plugin can\'t be activated because your PHP version', 'dronespov' );
				$text_last = __( 'is less than required '.$this->php_ver_allowed.'. See more information', 'dronespov' );
				$text_link = 'php.net/eol.php'; ?>

				<div id="message" class="updated notice notice-success is-dismissible">
					<p><?php echo $text . ' ' . phpversion() . ' ' . $text_last . ': '; ?>
						<a href="http://php.net/eol.php/" target="_blank"><?php echo $text_link; ?></a>
					</p>
				</div>

			<?php endif; return;
		}
	}
} ?>

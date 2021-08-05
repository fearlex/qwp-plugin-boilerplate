<?php
/**
 * PluginName setup
 *
 * @package PluginName
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main PluginName Class.
 *
 * @class PluginName
 */
final class PluginName {
	/**
	 * Plugin name.
	 *
	 * @access public
	 * @var string
	 */
	public string $plugin_name = 'PluginName';
	/**
	 * Plugin version.
	 *
	 * @access public
	 * @var string
	 */
	public string $version = '1.0.0';
	/**
	 * The single instance of the class.
	 *
	 * @static
	 * @access protected
	 * @var PluginName
	 * @since  1.0.0
	 */
	protected static $_instance = null;

	/**
	 * Main PluginName Instance.
	 * Ensures only one instance of PluginName is loaded or can be loaded (Singleton Pattern.)
	 *
	 * @static
	 * @access public
	 * @return PluginName - Main instance.
	 * @see    PN()
	 * @since  1.0.0
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * PluginName Constructor.
	 *
	 */
	public function __construct() {
		// Define Constants
		$this->define_constants();
		// Include Files
		$this->includes();
		// Initialize Hooks
		$this->init_hooks();
	}

	/**
	 * When WP has loaded all plugins, trigger the `pluginname_loaded` hook.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function on_plugins_loaded() {
		do_action( 'pluginname_loaded' );
	}

	/**
	 * Define PN Constants.
	 *
	 * @access private
	 * @since  1.0.0
	 */
	private function define_constants() {
		// Get WP Upload Directory
		$upload_dir = wp_upload_dir( null, false );
		// Constants
		$this->define( 'PN_ABSPATH', dirname( PN_PLUGIN_FILE ) . '/' );
		$this->define( 'PN_PLUGIN_BASENAME', plugin_basename( PN_PLUGIN_FILE ) );
		$this->define( 'PN_VERSION', $this->version );
		$this->define( 'PN_LOG_DIR', $upload_dir[ 'basedir' ] . '/pn-logs/' );
		$this->define( 'PN_NOTICE_MIN_PHP_VERSION', '7.2' );
		$this->define( 'PN_NOTICE_MIN_WP_VERSION', '5.2' );
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function includes() {
		/**
		 * Core classes.
		 */ // @TODO: Core Classes Maybe not needed
		//include_once PN_ABSPATH . 'includes/class-pn-something.php';

		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			// @TODO: Add WP-CLI
			//include_once PN_ABSPATH . 'includes/class-pn-cli.php';
		}

		// If is WP Admin Request
		if ( $this->is_request( 'admin' ) ) {

			// Add Plugin Screen Hooks
			//include_once PN_ABSPATH . 'includes/class-pn-plugin.php';

			// Add Admin Settings
			//include_once PN_ABSPATH . 'includes/admin/class-pn-admin.php';
		}

		// If is WP Frontend Request
		if ( $this->is_request( 'frontend' ) ) {
			// Front End Includes
			$this->frontend_includes();
		}
	}

	/**
	 * Hook into actions and filters.
	 *
	 * @access private
	 * @since  1.0.0
	 */
	private function init_hooks() {

		//@TODO: Activation and Shutdown Functions, also Logging
		//register_activation_hook( PN_PLUGIN_FILE, array( 'PN_Install', 'install' ) );
		//register_shutdown_function( array( $this, 'log_errors' ) );

		add_action( 'plugins_loaded', array( $this, 'on_plugins_loaded' ), - 1 );
		add_action( 'init', array( $this, 'init' ), 0 );

		// @TODO: For Safe keeping in case is needed
		//add_action( 'init', array( 'PN_Shortcodes', 'init' ) );
		//add_action( 'init', array( $this, 'add_image_sizes' ) );
		//add_action( 'init', array( $this, 'load_rest_api' ) );
		//add_action( 'activated_plugin', array( $this, 'activated_plugin' ) );
		//add_action( 'deactivated_plugin', array( $this, 'deactivated_plugin' ) );
	}

	/**
	 * Include required frontend files.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function frontend_includes() {
		// @TODO: Front end Includes if needed
		//include_once PN_ABSPATH . 'includes/class-pn-frontend-scripts.php';
		//include_once PN_ABSPATH . 'includes/class-pn-shortcodes.php';
	}

	/**
	 * Init PluginName when WordPress Initialises.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function init() {
		// Before init action.
		do_action( 'before_pluginname_init' );

		// @TODO: Localization
		// Set up localization.
		// $this->load_plugin_textdomain();

		// Load class instances.
		//$this->integrations = new PN_Integrations();

		// Classes/actions loaded for the frontend and for ajax requests.
		if ( $this->is_request( 'frontend' ) ) {
			//$this->integrations = new PN_Integrations();
		}

		// Init action.
		do_action( 'pluginname_init' );
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param string      $name  Constant name.
	 * @param string|bool $value Constant value.
	 *
	 * @access private
	 * @since  1.0.0
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * What type of request is this?
	 *
	 * @param string $type admin, ajax, cron or frontend.
	 *
	 * @access private
	 * @return bool
	 * @since  1.0.0
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' );
			case 'cron':
				return defined( 'DOING_CRON' );
			case 'frontend':
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}

	/**
	 * Get Ajax URL.
	 *
	 * @access public
	 * @return string
	 * @since  1.0.0
	 */
	public function ajax_url() {
		return admin_url( 'admin-ajax.php', 'relative' );
	}

	/**
	 * Get the plugin url.
	 *
	 * @access public
	 * @return string
	 * @since  1.0.0
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', PN_PLUGIN_FILE ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @access public
	 * @return string
	 * @since  1.0.0
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( PN_PLUGIN_FILE ) );
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'pluginname' ), '1.0.0' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Unserializing instances of this class is forbidden.', 'pluginname' ), '1.0.0' );
	}
}

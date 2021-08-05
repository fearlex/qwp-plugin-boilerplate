<?php
/**
 * Plugin Name: PluginName
 * Plugin URI: https://pluginname.com/
 * Description: Plugin description.
 * Version: 1.0.0
 * Author: QuantumWP
 * Author URI: https://quantumwp.com
 * Text Domain: pluginname
 * Domain Path: /languages/
 *
 * @package PluginName
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'PN_PLUGIN_FILE' ) ) {
	define( 'PN_PLUGIN_FILE', __FILE__ );
}

// Include the main PluginName class.
if ( ! class_exists( 'PluginName' ) ) {
	include_once dirname( PN_PLUGIN_FILE ) . '/includes/class-pluginname.php';
}

// If Main function exist
if ( ! function_exists( 'PN' ) ) {
	/**
	 * Main instance of PluginName.
	 *
	 * @access public
	 * @return PluginName | Object
	 * @since  1.0.0
	 */
	function PN() {
		return PluginName::instance();
	}
}

// Let's go!
PN();

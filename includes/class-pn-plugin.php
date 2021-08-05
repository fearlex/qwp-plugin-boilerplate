<?php
/**
 * Plugin related functions and actions.
 *
 * @package PluginName/Classes
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * PN_Plugin Class.
 */
class PN_Plugin {
	/**
	 * Hook in plugin screen.
	 *
	 * @static
	 * @access public
	 * @since  1.0.0
	 */
	public static function init() {

		add_filter( 'plugin_action_links_' . PN_PLUGIN_BASENAME, array( __CLASS__, 'plugin_action_links' ) );
		add_filter( 'plugin_row_meta', array( __CLASS__, 'plugin_row_meta' ), 10, 2 );
	}

	/**
	 * Show action links on the plugin screen.
	 *
	 * @param mixed $links Plugin Action links.
	 *
	 * @static
	 * @access public
	 * @return array
	 * @since  1.0.0
	 */
	public static function plugin_action_links( $links ) {
		$action_links = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=pn-settings&tab=TABNAME&section=SECTIONNAME' ) . '" aria-label="' . esc_attr__( 'View PluginName settings', 'pluginname' ) . '">' . esc_html__( 'Settings', 'pluginname' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}

	/**
	 * Show row meta on the plugin screen.
	 *
	 * @param mixed $links Plugin Row Meta.
	 * @param mixed $file  Plugin Base file.
	 *
	 * @static
	 * @access public
	 * @return array
	 * @since  1.0.0
	 */
	public static function plugin_row_meta( $links, $file ) {

		if ( PN_PLUGIN_BASENAME === $file ) {
			$row_meta = array(
				'docs'    => '<a href="' . esc_url( apply_filters( 'pluginname_docs_url', 'https://docs.pluginname.com/documentation/plugins/pluginname/' ) ) . '" aria-label="' . esc_attr__( 'View PluginName documentation', 'pluginname' ) . '">' . esc_html__( 'Docs', 'pluginname' ) . '</a>',
				'apidocs' => '<a href="' . esc_url( apply_filters( 'pluginname_apidocs_url', 'https://docs.pluginname.com/apidocs/' ) ) . '" aria-label="' . esc_attr__( 'View PluginName API docs', 'pluginname' ) . '">' . esc_html__( 'API docs', 'pluginname' ) . '</a>',
				'support' => '<a href="' . esc_url( apply_filters( 'pluginname_support_url', 'https://pluginname.com/my-account/tickets/' ) ) . '" aria-label="' . esc_attr__( 'Visit premium customer support', 'pluginname' ) . '">' . esc_html__( 'Premium support', 'pluginname' ) . '</a>',
			);

			return array_merge( $links, $row_meta );
		}

		return (array) $links;
	}
}

PN_Plugin::init();

<?php

/**
 * WP Admin Plugins Page
 *
 * @package Wp_Similar_Basic_Auth
 */
class Hax_Wsba_Admin_Plugins_Page {

	function __construct() {
		add_filter( 'plugin_action_links', array( $this, 'plugin_settings_link' ) );
	}

	function plugin_settings_link( $link ) {
		global $hax_wsba_config;

		$url = admin_url( 'options-general.php?page=' . $hax_wsba_config->naming_plugin_submenu_slug );
		$url = '<a href="' . esc_url( $url ) . '">' . __( 'Settings' ) . '</a>';

		array_unshift( $link, $url ); // Settings link first For order
		return $link;
	}

} // End class


function run_hax_wsba_admin_plugins_page() {
	new Hax_Wsba_Admin_Plugins_Page();
}

// Instantiate
run_hax_wsba_admin_plugins_page();

<?php

/**
 * Setup Test Config
 *
 * Run this setUp() in phpunit.
 */
function setup_config() {
	$config_path = plugin_dir_path( __FILE__ ) . 'wsba-config.php';
	$config_path = str_replace( '/tests', '', $config_path ); // Remove 'tests' directory path.

	include_once $config_path;
	global $hax_wsba_config;
	$hax_wsba_config = new Hax_Wsba_Config();

	// Set env
	$hax_wsba_config->wp_env = 'test';

	$_POST['_wpnonce'] = wp_create_nonce( $hax_wsba_config->nonce_login_page );
}

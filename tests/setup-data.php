<?php

/**
 * Setup Test Data
 *
 * @package Wp_Similar_Basic_Auth
 *
 * Run this setUp() in phpunit.
 */
function setup_data() {
	 global $hax_wsba_config;

	/*--- Regsiter Settings ---*/
	add_option( $hax_wsba_config->register_settings_user_name, 'reiwa-tarou' );

	/*--- Add hashed password ---*/
	$current_password = password_hash( 'current password', PASSWORD_BCRYPT );
	add_option( $hax_wsba_config->register_settings_password_text, $current_password );
}

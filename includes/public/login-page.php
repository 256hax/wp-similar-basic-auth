<?php

/**
 * Similar Basi Auth Login Page on Front-End
 *
 * @package Wp_Similar_Basic_Auth
 */
class Hax_Wsba_Login_Page {


	function __construct() {
		$this->errors = new WP_Error();

		add_action( 'login_init', array( $this, 'admin_scripts' ) );
		add_action( 'login_init', array( $this, 'html' ) );
	}

	// Load Javascript and CSS
	function admin_scripts() {
		global $hax_wsba_config;

		// usage: wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
		wp_enqueue_script( 'fadein-js', $hax_wsba_config->url_assets_js . 'fadein.js' );
		wp_enqueue_style( 'login-page-css', $hax_wsba_config->url_assets_css . 'login-page.css' );
	}

	/**
	 * Validate submit from View
	 * args:   $_POST
	 * return: true => validate pass, false => validate failure
	 */
	function validate_input( $input ) {
		// Check post user_name and password
		if ( isset( $_POST['user_name'], $_POST['password'] ) ) {
			$input_user_name = sanitize_text_field( $input['user_name'] );
			$input_password  = sanitize_text_field( $input['password'] );

			$saved_user_name = get_option( 'hax_wsba_user_name' );
			$saved_password  = get_option( 'hax_wsba_password_text' );

			// Pass validate if match user_name and password
			// Use password_verify (Blowfish bcrypt) instead of "hash_equals" or "===" to compare hashed password.
			if ( $input_user_name === $saved_user_name && password_verify( $input_password, $saved_password ) ) {
				return true;
			}
		}
		return false;
	}

	// Sign In HTML
	function html() {
		global $hax_wsba_config;
		global $hax_wsba_input;

		$html  = $hax_wsba_config->path_public_views . 'html-login-page.php';
		$input = $hax_wsba_input->sanitize( $_POST );

		$saved_user_name = get_option( $hax_wsba_config->register_settings_user_name );
		$saved_password  = get_option( $hax_wsba_config->register_settings_password_text );

		$hax_wsba_cookie = new Hax_Wsba_Cookie();

		// [Pass] If not set User Name and Password, pass WSBA page.
		// It suppose just activate plugin or forget set User Name or Password.
		if ( $saved_user_name === false || $saved_password === false ) {
			return 'data_does_not_exist'; // For phpunit
		}

		// [Pass] If user has valid cookie, pass WSBA page.
		if ( $hax_wsba_cookie->validate_auth_cookie() ) {
			return 'validated_auth_cookie'; // For phpunit
		}

		// [Pass] If valid nonce.
		if ( isset( $input['_wpnonce'] ) && wp_verify_nonce( $input['_wpnonce'], $hax_wsba_config->nonce_login_page ) ) {
			// [Pass] If user submit valid username/pw first time, set cookie to browser then redirect WP login page.
			if ( $this->validate_input( $input ) ) {
				$hax_wsba_cookie->set_auth_cookie();

				// Test need return here before exit.
				if ( $hax_wsba_config->wp_env === 'test' ) {
					return 'set_auth_cookie';
				}

				wp_safe_redirect( admin_url() );
				exit;
			}

			// If incorrect User Name or Password, get error message.
			if ( isset( $input['user_name'] ) || isset( $input['password'] ) ) {
				$this->errors->add( 'incorrect_user_or_pw', esc_html__( 'Incorrect User Name or Password.', 'wp-similar-basic-auth' ) );
			}
		}

		// Test need return here before exit.
		if ( $hax_wsba_config->wp_env === 'test' ) {
			return 'load_template_html';
		}

		// If not pass auth, show WSBA page.
		load_template( $html );
		exit; // Need exit.
	}

} // End class


function run_hax_wsba_login_page() {
	global $hax_wsba_login_page;
	$hax_wsba_login_page = new Hax_Wsba_Login_Page();
}

// Instantiate
run_hax_wsba_login_page();

<?php
/**
 * Class LoginPageTest
 *
 * @package Wp_Similar_Basic_Auth
 */

/**
 * Login page test case.
 */
class LoginPageTest extends WP_UnitTestCase {


	public function setUp() {
		/**
		 * Config
		 */
		include_once plugin_dir_path( __FILE__ ) . 'setup-config.php';
		setup_config();
		global $hax_wsba_config;

		/**
		 * Test Data
		 */
		include_once plugin_dir_path( __FILE__ ) . 'setup-data.php';
		setup_data();

		/**
		 * Target Unit Test
		 */
		include_once $hax_wsba_config->path_public . 'login-page.php';
		global $hax_wsba_login_page;
		$hax_wsba_login_page = new Hax_Wsba_Login_Page();

		include_once( $hax_wsba_config->path_admin . 'admin-plugins-page.php' );
		global $hax_wsba_admin_plugin_page;
		$hax_wsba_admin_plugin_page = new Hax_Wsba_Admin_Plugins_Page();
	}

	/**
	 * describe(object/method) : Hax_Wsba_Login_Page->html()
	 *  context(conditions)    : "first activated plugin(= add wp_options with empty to DB)"
	 *    it(expect/behavior)  : "go to WP Admin page"
	 */
	public function test_first_activated_plugin() {
		global $hax_wsba_config;
		global $hax_wsba_login_page;
		global $hax_wsba_admin_plugin_page;

		// Init wp_options
		delete_option( $hax_wsba_config->register_settings_user_name );
		delete_option( $hax_wsba_config->register_settings_password );
		// For Activate plugin module
		$hax_wsba_admin_plugin_page->action_activated_plugin();

		$result = $hax_wsba_login_page->html();
		$this->assertEquals( $result, 'no_data' );
	}

	/**
	 * describe(object/method) : Hax_Wsba_Login_Page->html()
	 *  context(conditions)    : "User Name and Password data does not exist(=false) in WP Options"
	 *    it(expect/behavior)  : "go to WP Admin page"
	 */
	public function test_data_does_not_exist() {
		global $hax_wsba_config;
		global $hax_wsba_login_page;

		delete_option( $hax_wsba_config->register_settings_user_name );
		delete_option( $hax_wsba_config->register_settings_password );

		$result = $hax_wsba_login_page->html();
		$this->assertEquals( $result, 'no_data' );
	}

	/**
	 * describe(object/method) : Hax_Wsba_Login_Page->html()
	 *  context(conditions)    : "submit invalid(not allowed string) User Name and Password"
	 *   it(expect/behavior)   : "go to WP Admin page"
	 */
	public function test_validation_failed() {
		global $hax_wsba_config;
		global $hax_wsba_login_page;

		$_POST[$hax_wsba_config->register_settings_user_name] = '$warugaki%';
		$_POST[$hax_wsba_config->register_settings_password]  = '(;-;)/~';

		$result = $hax_wsba_login_page->html();
		$this->assertEquals( $result, 'validation_failed' );
	}

	/**
	 * describe(object/method) : Hax_Wsba_Login_Page->html()
	 *  context(conditions)    : "submit valid User Name and Password"
	 *   it(expect/behavior)   : "set auth cookie and redirect to WP Admin page"
	 */
	public function test_set_auth_cookie() {
		global $hax_wsba_config;
		global $hax_wsba_login_page;

		$_POST[$hax_wsba_config->register_settings_user_name] = 'reiwa-tarou';
		$_POST[$hax_wsba_config->register_settings_password]  = 'current password';

		$result = $hax_wsba_login_page->html();
		$this->assertEquals( $result, 'set_auth_cookie' );
	}

	/**
	 * describe(object/method) : Hax_Wsba_Login_Page->html()
	 *  context(conditions)    : "submit invalid User Name and Password"
	 *   it(expect/behavior)   : "load WSBA login page"
	 */
	public function test_load_template_html() {
		global $hax_wsba_config;
		global $hax_wsba_login_page;

		$_POST[$hax_wsba_config->register_settings_user_name] = 'heisei-yarou';
		$_POST[$hax_wsba_config->register_settings_password]  = 'invalid password';

		$result = $hax_wsba_login_page->html();
		$this->assertEquals( $result, 'load_template_html' );
	}

	/**
	 * describe(object/method) : Hax_Wsba_Login_Page->html()
	 *  context(conditions)    : "submit invalid nonce"
	 *   it(expect/behavior)   : "load WSBA login page"
	 */
	public function test_invalid_nonce() {
		global $hax_wsba_config;
		global $hax_wsba_login_page;

		$_POST[$hax_wsba_config->register_settings_user_name] = 'reiwa-tarou';
		$_POST[$hax_wsba_config->register_settings_password]  = 'current password';
		$_POST['_wpnonce']  = wp_create_nonce( 'invalid-action' );

		$result = $hax_wsba_login_page->html();
		$this->assertEquals( $result, 'load_template_html' );
	}
}

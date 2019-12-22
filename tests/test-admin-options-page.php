<?php
/**
 * Class AdminOptionsPageTest
 *
 * @package Wp_Similar_Basic_Auth
 */

 /**
  * Admin options page test case.
  */
class AdminOptionsPageTest extends WP_UnitTestCase {


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
		include_once $hax_wsba_config->path_admin . 'admin-options-page.php';
		global $hax_wsba_admin_options_page;
		$hax_wsba_admin_options_page = new Hax_Wsba_Admin_Options_Page();
	}

	/**
	 * describe(object/method)  : Hax_Wsba_Login_Page->settings_password()
	   *    context(conditions)    : "check new password"
	   *     it(expect/behavior)  : "update hashed password to wp_options"
		 *    do(expect/behavior): password_verify( input_new_password, return )
	 */
	public function test_checked_new_password() {
		global $hax_wsba_config;
		global $hax_wsba_admin_options_page;

		/*--- Return hashed password ---*/
		$_POST['select_password_action'] = 'checked-new-password'; // Checked "New password" in View.
		$input_new_password              = esc_attr( 'input new password' );

		$result = $hax_wsba_admin_options_page->settings_password( $input_new_password );
		$this->assertTrue( password_verify( $input_new_password, $result ) );
	}

	/**
	 * describe(object/method) : Hax_Wsba_Login_Page->settings_password()
		  *  context(conditions)    : "check use current password"
		 *   it(expect/behavior)  : "no update password"
		 *    do(expect/behavior): password_verify( input_new_password, return )
	 */
	public function test_use_current_password() {
		global $hax_wsba_config;
		global $hax_wsba_admin_options_page;

		/*--- Return hashed password ---*/
		$_POST['select_password_action'] = ''; // Checked "current password".
		$input_new_password              = 'ignore this password'; // Ignore new password
		$current_password_text           = esc_attr( 'current password' );

		$result = $hax_wsba_admin_options_page->settings_password( $input_new_password );
		$this->assertTrue( password_verify( $current_password_text, $result ) );
	}

}

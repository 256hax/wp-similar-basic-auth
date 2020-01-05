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
	 * describe(object/method) : Hax_Wsba_Login_Page->settings_password()
	 *  context(conditions)    : "select new password at CheckBox"
	 *   it(expect/behavior)   : "update hashed password to wp_options"
	 *    do(expect/behavior)  : password_verify( input_new_password, result )
	 */
	public function test_checked_new_password() {
		global $hax_wsba_config;
		global $hax_wsba_admin_options_page;

		$_POST['select_password_action'] = 'checked-new-password'; // Checked "New password" in View.
    $_POST[$hax_wsba_config->register_settings_password] = 'input new password';
    $input_new_password              = $_POST[$hax_wsba_config->register_settings_password];

		$result = $hax_wsba_admin_options_page->settings_password( $input_new_password );
		$this->assertTrue( password_verify( $input_new_password, $result ) );
	}

	/**
	 * describe(object/method) : Hax_Wsba_Login_Page->settings_password()
   *  context(conditions)    : "select use current password at CheckBox"
   *   it(expect/behavior)   : "update current password to wp_options"
	 *    do(expect/behavior)  : password_verify( current_password, result )
   *
   * note: register_setting can't no update. Update current data(in wp_options) to wp_options if invalid.
	 */
	public function test_use_current_password() {
		global $hax_wsba_config;
		global $hax_wsba_admin_options_page;

		$_POST['select_password_action'] = ''; // Checked "current password".
    $_POST[$hax_wsba_config->register_settings_password] = 'ignore this password'; // Ignore new password
    $input_new_password              = $_POST[$hax_wsba_config->register_settings_password];
		$current_password                = 'current password';

		$result = $hax_wsba_admin_options_page->settings_password( $input_new_password );
		$this->assertTrue( password_verify( $current_password, $result ) );
	}

  /**
	 * describe(object/method) : Hax_Wsba_Login_Page->settings_password()
	 *  context(conditions)    : "select new password at CheckBox with invalid new password"
	 *   it(expect/behavior)   : "update current password to wp_options"
	 *    do(expect/behavior)  : password_verify( current_password, result )
   *
   * note: register_setting can't no update. Update current data(in wp_options) to wp_options if invalid.
	 */
	public function test_password_validation_failed() {
		global $hax_wsba_config;
		global $hax_wsba_admin_options_page;

    $_POST['select_password_action'] = 'checked-new-password'; // Checked "New password" in View.
    $_POST[$hax_wsba_config->register_settings_password] = '$warugaki%'; // Invalid string
    $input_new_password              = $_POST[$hax_wsba_config->register_settings_password];
    $current_password                = 'current password';

    $result = $hax_wsba_admin_options_page->settings_password( $input_new_password );
    $this->assertTrue( password_verify( $current_password, $result ) );
	}

}

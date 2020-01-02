<?php
/**
 * Class Hax_Wsba_Input
 *
 * @package Wp_Similar_Basic_Auth
 */
class Hax_Wsba_Input {


	function __construct() {
		// Do nothing
	}

	/**
	 * Sanitize input
	 * args:   $_POST (array or variable)
	 * return: sanitized data (array or variable)
	 */
	function sanitize( $input ) {
		if ( is_array( $input ) ) {
			foreach( $input as $key => $value ) {
				$input[$key] = sanitize_text_field( $value );
			}
			return $input;
		} else {
			$input = sanitize_text_field( $input );
			return $input;
		}
	}

}


function run_hax_wsba_input() {
	global $hax_wsba_input;
	$hax_wsba_input = new Hax_Wsba_Input();
}


// Instantiate
run_hax_wsba_input();

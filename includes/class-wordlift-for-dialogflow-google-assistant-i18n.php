<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://wordlift.io
 * @since      1.0.0
 *
 * @package    Wordlift_For_Dialogflow_Google_Assistant
 * @subpackage Wordlift_For_Dialogflow_Google_Assistant/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wordlift_For_Dialogflow_Google_Assistant
 * @subpackage Wordlift_For_Dialogflow_Google_Assistant/includes
 * @author     Stanimir Stoyanov <stanimir@insideout.io>
 */
class Wordlift_For_Dialogflow_Google_Assistant_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wordlift-for-dialogflow-google-assistant',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

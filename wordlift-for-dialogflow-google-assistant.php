<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wordlift.io
 * @since             1.0.0
 * @package           Wordlift_For_Dialogflow_Google_Assistant
 *
 * @wordpress-plugin
 * Plugin Name:       Wordlift for Dialogflow Google Assistant
 * Plugin URI:        https://github.com/wordlift/wordlift-for-dialogflow-google-assistant
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Stanimir Stoyanov
 * Author URI:        https://wordlift.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wordlift-for-dialogflow-google-assistant
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WLDFGA', '1.0.0' );
define( 'BASE_DIR', dirname( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wordlift-for-dialogflow-google-assistant-activator.php
 */
function activate_wordlift_for_dialogflow_google_assistant() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wordlift-for-dialogflow-google-assistant-activator.php';
	Wordlift_For_Dialogflow_Google_Assistant_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wordlift-for-dialogflow-google-assistant-deactivator.php
 */
function deactivate_wordlift_for_dialogflow_google_assistant() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wordlift-for-dialogflow-google-assistant-deactivator.php';
	Wordlift_For_Dialogflow_Google_Assistant_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wordlift_for_dialogflow_google_assistant' );
register_deactivation_hook( __FILE__, 'deactivate_wordlift_for_dialogflow_google_assistant' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wordlift-for-dialogflow-google-assistant.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wordlift_for_dialogflow_google_assistant() {

	$plugin = new Wordlift_For_Dialogflow_Google_Assistant();

}
run_wordlift_for_dialogflow_google_assistant();

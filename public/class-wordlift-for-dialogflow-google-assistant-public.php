<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wordlift.io
 * @since      1.0.0
 *
 * @package    Wordlift_For_Dialogflow_Google_Assistant
 * @subpackage Wordlift_For_Dialogflow_Google_Assistant/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wordlift_For_Dialogflow_Google_Assistant
 * @subpackage Wordlift_For_Dialogflow_Google_Assistant/public
 * @author     Stanimir Stoyanov <stanimir@insideout.io>
 */
class Wordlift_For_Dialogflow_Google_Assistant_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wordlift_For_Dialogflow_Google_Assistant_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wordlift_For_Dialogflow_Google_Assistant_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wordlift-for-dialogflow-google-assistant-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wordlift_For_Dialogflow_Google_Assistant_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wordlift_For_Dialogflow_Google_Assistant_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wordlift-for-dialogflow-google-assistant-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script(
			$this->plugin_name,
			'options',
			array(
				'access_token' => get_option( 'wordlif_for_dialogflow_google_assistant_myc_access_token' ),
				'session_id'   => $this->get_session(),
				'url'          => 'https://api.dialogflow.com/v1/query?v=20170712',
			)
		);
	}

	/**
	 * Render the chatbox.
	 */
	public function render() {
		// render the form template
		include_once( dirname( __FILE__ ) . '/partials/wordlift-for-dialogflow-google-assistant-public-display.php' );
	}

	public function get_session() {
		$session_id = md5( uniqid( 'myc-' ) );

		// Check if there is a session.
		if ( ! empty( $_COOKIE['myc_session_id'] ) ) {
			$session_id = $_COOKIE['myc_session_id'];
		}

		return $session_id;
	}

}

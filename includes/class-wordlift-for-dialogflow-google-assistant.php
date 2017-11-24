<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wordlift.io
 * @since      1.0.0
 *
 * @package    Wordlift_For_Dialogflow_Google_Assistant
 * @subpackage Wordlift_For_Dialogflow_Google_Assistant/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wordlift_For_Dialogflow_Google_Assistant
 * @subpackage Wordlift_For_Dialogflow_Google_Assistant/includes
 * @author     Stanimir Stoyanov <stanimir@insideout.io>
 */
class Wordlift_For_Dialogflow_Google_Assistant {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wordlift_For_Dialogflow_Google_Assistant_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wordlift-for-dialogflow-google-assistant';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->setup_session();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wordlift_For_Dialogflow_Google_Assistant_Loader. Orchestrates the hooks of the plugin.
	 * - Wordlift_For_Dialogflow_Google_Assistant_i18n. Defines internationalization functionality.
	 * - Wordlift_For_Dialogflow_Google_Assistant_Admin. Defines all hooks for the admin area.
	 * - Wordlift_For_Dialogflow_Google_Assistant_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wordlift-for-dialogflow-google-assistant-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wordlift-for-dialogflow-google-assistant-admin.php';


		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wordlift-for-dialogflow-google-assistant-public.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/class-wordlift-for-dialogflow-google-assistant-form.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/fields/field.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/fields/field-text.php';

		new Wordlift_For_Dialogflow_Google_Assistant_Form();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wordlift_For_Dialogflow_Google_Assistant_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wordlift_For_Dialogflow_Google_Assistant_i18n();

		add_action( 'plugins_loaded', array( $plugin_i18n, 'load_plugin_textdomain' ) );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wordlift_For_Dialogflow_Google_Assistant_Admin( $this->get_plugin_name(), $this->get_version() );

		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_scripts' ) );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wordlift_For_Dialogflow_Google_Assistant_Public( $this->get_plugin_name(), $this->get_version() );

		add_action( 'wp_enqueue_scripts', array( $plugin_public, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $plugin_public, 'enqueue_scripts' ) );
		add_action( 'wp_footer',          array( $plugin_public, 'render' ) );

	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wordlift_For_Dialogflow_Google_Assistant_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Ensures MYC session cookie exists
	 */
	public function setup_session() {
		if ( ! ( isset( $_COOKIE['myc_session_id'] ) && strlen( $_COOKIE['myc_session_id'] ) > 0 ) ) {
			$session_id = md5( uniqid( 'myc-' ) );
			setcookie( 'myc_session_id', $session_id, time() + ( 86400 * 30 ), '/' ); // 86400 = 1 day
		}
	}
}

<?php
/**
* 
*/
class Wordlift_For_Dialogflow_Google_Assistant_Form {
	/**
	 * Setting secions.
	 *
	 * @access public
	 * @var array
	 */
	protected $settings_sections = array();
	
	function __construct() {
		// Add plugin options page to main settings
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );

		// register settings fields & sections
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Get the title of the submenu item page.
	 *
	 * @access public
	 *
	 * @return string $menu_title The title of the submenu item.
	 */
	public function get_menu_title() {
		// allow filtering the title of the submenu page
		$menu_title = apply_filters('wordlift_for_dialogflow_google_assistant', __( 'Wordlift for Dialogflow Google Assistant', 'wordlift-for-dialogflow-google-assistant' ) );

		return $menu_title;
	}

	/**
	 * Add plugin settings page.
	 *
	 * @access public
	 */
	public function add_options_page() {
		// Get menu title
		$menu_title = $this->get_menu_title();

		// Get menu ID
		$menu_id = $this->get_menu_id();

		// register the submenu page - child of the Settings parent menu item
		add_submenu_page(
			'options-general.php',
			$menu_title,
			$menu_title,
			'publish_posts',
			$menu_id,
			array( $this, 'render' )
		);

		// register settings section
		add_settings_section(
			$menu_id,
			'',
			'',
			$menu_id
		);
	}

	/**
	 * Get field data. Defines and describes the fields that will be registered.
	 *
	 * @access public
	 *
	 * @return array $fields The fields and their data.
	 */
	public function get_field_data() {
		return array(
			'access_token' => array(
					'title' 	=> __( 'Access Token', 'wordlift-for-dialogflow-google-assistant' ),
					'type' => 'text',
			),
			'request_background_color' => array(
					'title' 	=> __( 'Request Background Color', 'wordlift-for-dialogflow-google-assistant' ),
					'type' => 'text',
					'classes' => array(
						'color-picker'
					),
			),
			'request_text_color' => array(
					'title' 	=> __( 'Request Text Color', 'wordlift-for-dialogflow-google-assistant' ),
					'type' => 'text',
					'classes' => array(
						'color-picker'
					),
			),
			'response_background_color' => array(
					'title' 	=> __( 'Response Background Color', 'wordlift-for-dialogflow-google-assistant' ),
					'type' => 'text',
					'classes' => array(
						'color-picker'
					),
			),
			'response_text_color' => array(
					'title' 	=> __( 'Response Text Color', 'wordlift-for-dialogflow-google-assistant' ),
					'type' => 'text',
					'classes' => array(
						'color-picker'
					),
			),
			'overlay_header_background_color' => array(
					'title' 	=> __( 'Overlay Header Background Color', 'wordlift-for-dialogflow-google-assistant' ),
					'type' => 'text',
					'classes' => array(
						'color-picker'
					),
			),
			'overlay_header_text_color' => array(
					'title' 	=> __( 'Overlay Header Text Color', 'wordlift-for-dialogflow-google-assistant' ),
					'type' => 'text',
					'classes' => array(
						'color-picker'
					),
			)
		);
	}

	/**
	 * Register the settings sections and fields.
	 *
	 * @access public
	 */
	public function register_settings() {
		// register fields
		$field_data = $this->get_field_data();

		foreach ( $field_data as $field_id => $options ) {
			$field_object = Wordlift_For_Dialogflow_Google_Assistant_Field::factory( 
			   $options,
			   'wordlif_for_dialogflow_google_assistant_' . $field_id,
			   $this->get_menu_id(),
			   $this->get_menu_id()
			);

			$this->fields[] = $field_object;
		}
	}

	public function get_menu_id() {
		return 'wordlift_for_dialogflow_google_assistant';
	}

	/**
	 * Callabck function for options page.
	 *
	 * @access public
	 */
	public function render() {
		include( BASE_DIR . '/admin/partials/options.php' );
	}
}

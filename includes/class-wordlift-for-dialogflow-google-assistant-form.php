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

		// Sections
		$sections = $this->get_setting_sections();

		// register the submenu page - child of the Settings parent menu item
		add_submenu_page(
			'options-general.php',
			$menu_title,
			$menu_title,
			'publish_posts',
			$menu_id,
			array( $this, 'render' )
		);

		foreach ( $sections as $section ) {
			// register settings section
			add_settings_section(
				$menu_id . $section['name'],
				$section['title'],
				'',
				$menu_id
			);
		}
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
			'myc_access_token' => array(
					'title' 	=> __( 'Access Token', 'my-chatbot' ),
					'type' => 'text',
					'section' => 'text',
			),
			'request_background_color' => array(
					'title' 	=> __( 'Request Background Color', 'my-chatbot' ),
					'type' => 'text',
					'section' => 'color',
			),
			'request_font_color' => array(
					'title' 	=> __( 'Request Font Color', 'my-chatbot' ),
					'type' => 'text',
					'section' => 'color',
			),
			'response_background_color' => array(
					'title' 	=> __( 'Response Background Color', 'my-chatbot' ),
					'type' => 'text',
					'section' => 'color',
			),
			'response_font_color' => array(
					'title' 	=> __( 'Response Font Color', 'my-chatbot' ),
					'type' => 'text',
					'section' => 'color',
			),
			'overlay_header_background_color' => array(
					'title' 	=> __( 'Response Font Color', 'my-chatbot' ),
					'type' => 'text',
					'section' => 'color',
			)
		);
	}

	public function get_setting_sections() {
		return array(
			array(
				'name'  => 'text',
				'title' => 'Custom Text',
			),
			array(
				'name'  => 'link',
				'title' => 'Policy Link',
			),
			array(
				'name'  => 'position',
				'title' => 'Position and layout',
			),
			array(
				'name'  => 'color',
				'title' => 'Color Palette',
			),
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
			   $this->get_menu_id() . $options['section']
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
		include_once( dirname( __FILE__ ) . '/templates/options.php' );
	}
}

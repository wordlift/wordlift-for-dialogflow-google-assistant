<?php

/**
 * Manages administration settings page field registration.
 * Should be extended for each field type.
 *
 * @abstract
 */
abstract class Wordlift_For_Dialogflow_Google_Assistant_Field {
	
	/**
	 * Field title.
	 *
	 * @access protected
	 * @var string
	 */
	protected $title;
	
	/**
	 * Field ID.
	 *
	 * @access protected
	 * @var string
	 */
	protected $id;

	/**
	 * Field default value.
	 *
	 * @access protected
	 * @var string
	 */
	protected $default_value;

	/**
	 * Field additional classes.
	 *
	 * @access protected
	 * @var string
	 */
	protected $classes;

	/**
	 * Field additional help_text.
	 *
	 * @access protected
	 * @var string
	 */
	protected $help_text;

	/**
	 * Constructor.
	 *
	 * Register an administration settings field.
	 *
	 * @access public
	 *
	 * @param array $options Field options.
	 * @param string $id The ID of the field.
	 * @param string $page_id ID of the settings page.
	 * @param string $section The name of the section.
	 * @param array $args Additional args.
	 */
	public function __construct( $options, $id, $page_id, $section = '', $args = array() ) {
		$this->set_id( $id );
		$this->set_title( $options['title'] );

		add_settings_field(
			$id,
			$options['title'],
			array( $this, 'render' ),
			$page_id,
			$section,
			$args
		);

		register_setting( $page_id, $id );

		foreach ( $options as $name => $value ) {
			$method_name = 'set_' . $name;

			if ( method_exists( $this, $method_name ) && ! empty( $value ) ) {
				$this->$method_name( $value );
			}
		}
	}

	/**
	 * Register a new administration settings field of a certain type.
	 *
	 * @static
	 *
	 * @param array $options Field options.
	 * @param string $id The ID of the field.
	 * @param string $page_id ID of the settings page.
	 * @param string $section The name of the section.
	 * @param array $args Additional args.
	 * @return F_EU_Cookie_Law_Field $field
	 */
	static function factory( $options, $id, $page_id, $section = '', $args = array() ) {
		$type = str_replace( ' ', '', ucwords( str_replace( "_", ' ', $options['type'] ) ) );
		$class = 'Wordlift_For_Dialogflow_Google_Assistant_' . $type;

		if ( ! class_exists( $class ) ) {
			throw new Exception( 'Unknown settings field type "' . $type . '".' );
		}

		$field = new $class( $options, $id, $page_id, $section, $args );
		return $field;
	}

	/**
	 * Retrieve the field title.
	 *
	 * @access public
	 *
	 * @return string $title The title of this field.
	 */
	public function get_title() {
		return $this->title;
	}

	/**
	 * Modify the title of this field.
	 *
	 * @access public
	 *
	 * @param string $title The new title.
	 */
	public function set_title( $title ) {
		$this->title = $title;
	}

	/**
	 * Retrieve the field ID.
	 *
	 * @access public
	 *
	 * @return string $id The ID of this field.
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Modify the ID of this field.
	 *
	 * @access public
	 *
	 * @param string $id The new ID.
	 */
	public function set_id( $id ) {
		$this->id = $id;
	}

	/**
	 * Retrieve the field class names.
	 *
	 * @access public
	 *
	 * @return string $classes The field classnames.
	 */
	public function get_classes() {
		return $this->classes;
	}

	/**
	 * Modify the classes of this field.
	 *
	 * @access public
	 *
	 * @param array $names The field class names
	 */
	public function set_classes( $names ) {
		$this->classes .= implode( ' ', $names );
	}

	/**
	 * Retrieve the field default value.
	 *
	 * @access public
	 *
	 * @return string $default_value The default value of this field.
	 */
	public function get_default_value() {
		return $this->default_value;
	}
	
	/**
	 * Modify the default value of this field.
	 *
	 * @access public
	 *
	 * @param string $default_value The new default value.
	 */
	public function set_default_value( $default_value ) {
		$this->default_value = $default_value;
	}

	/**
	 * Retrieve the field help text.
	 *
	 * @access public
	 *
	 * @return string $help_text The help text of this field.
	 */
	public function get_help_text() {
		return $this->help_text;
	}
	
	/**
	 * Modify the help text of this field.
	 *
	 * @access public
	 *
	 * @param string $help_text The new help text.
	 */
	public function set_help_text( $help_text ) {
		$this->help_text = $help_text;
	}

	/**
	 * Render the help description of this field.
	 *
	 * @access public
	 */
	public function render_help_text() {
		$help_text = $this->get_help_text();

		if ( ! empty( $help_text ) ) :
		?>
			<p class="description">
				<?php echo $help_text; ?>
			</p>
		<?php
		endif;
	}

	/**
	 * Render the help description of this field.
	 *
	 * @access public
	 */
	public function render_class_names() {
		$classes = $this->get_classes();
		
		if ( ! empty( $classes ) ) {
			echo 'class="' . $classes . '"';
		}
	}


	/**
	 * Retrieve the field value. If there is no value, use the default one.
	 *
	 * @access public
	 *
	 * @return mixed $value The value of this field.
	 */
	public function get_value() {
		$default_value = $this->get_default_value();
		$value   = get_option( $this->get_id() );

		if ( $value === false ) {
			$value = $default_value;
		}

		return $value;
	}

	/**
	 * Render this field.
	 *
	 * @access public
	 * @abstract
	 */
	abstract public function render();
}
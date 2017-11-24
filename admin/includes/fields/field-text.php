<?php
/**
 * Manages and renders a text settings field.
 *
 * @uses F_EU_Cookie_Law_Field
 */
class Wordlift_For_Dialogflow_Google_Assistant_Text extends Wordlift_For_Dialogflow_Google_Assistant_Field {

	/**
	 * Render this field.
	 *
	 * @access public
	 */
	public function render() {
		$id   = $this->get_id();
		?>
		<input
			name="<?php echo $id; ?>"
			id="<?php echo $id; ?>"
			type="text"
			value="<?php echo $this->get_value(); ?>"
			<?php echo $this->render_class_names() ?>
		/>
		<?php
		$this->render_help_text();
	}
}

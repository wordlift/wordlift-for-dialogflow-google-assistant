<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://wordlift.io
 * @since      1.0.0
 *
 * @package    Wordlift_For_Dialogflow_Google_Assistant
 * @subpackage Wordlift_For_Dialogflow_Google_Assistant/public/partials
 */

$options = array(
	'request_background_color',
	'request_text_color',
	'response_background_color',
	'response_text_color',
	'overlay_header_background_color',
	'overlay_header_text_color',
);

$prefix = 'wordlif_for_dialogflow_google_assistant_';

// Get user colors.
foreach ( $options as $option ) {
	// Build the option key.
	$key = $prefix . $option;
	// Get option value.
	$value = get_option( $key );

	// Add the value back to options. 
	$options[ $option ] = $value;
}
?>

<style>
	.wldfga-conversation-response, .wldfga-conversation-response:after {
		background-color: <?php echo $options['response_background_color'] ?>;
		color: <?php echo $options['response_text_color'] ?>;
	}
	.wldfga-conversation-request, .wldfga-conversation-request:before  {
		background-color: <?php echo $options['request_background_color'] ?>;
		color: <?php echo $options['request_text_color'] ?>;
	}
	.wldfga-content-overlay-header {
		background-color: <?php echo $options['overlay_header_background_color'] ?>;
		color: <?php echo $options['overlay_header_text_color'] ?>;
	}
</style>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wldfga-content-overlay wldfga-toggle-closed">
	<div class="wldfga-content-overlay-header">
		<span class="wldfga-content-overlay-header-text">Talk to Jason Lee</span>
		<i class="fa fa-chevron-up" aria-hidden="true"></i>
	</div>

	<div class="wldfga-content-overlay-container">
		<div class="wldfga-container">
			<div class="wldfga-conversation-area"></div>
			<div class="wldfga-input-area">
				<input class="wldfga-text" type="text" placeholder="Type a message..."></input>
			</div>
		</div>
	</div>
</div>
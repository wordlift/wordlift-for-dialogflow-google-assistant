;(function($, window, document, undefined) {
	$(document).ready(function() {

		var error_message = 'An internal error occured';
		/*
		 * When the user enters text in the text input text field and then the presses Enter key
		 */
		$(".wldfga-text").keypress(function(event) {
			if (event.which == 13) {
				event.preventDefault();
				$(".wldfga-conversation-area .wldfga-conversation-request").removeClass("wldfga-is-active");
				
				var text = $(".wldfga-text").val();

				addMessage( text, 'request' );

				$(".wldfga-text").val("");

				$(".wldfga-conversation-area")
					.scrollTop($(".wldfga-conversation-area")
					.prop("scrollHeight"));

				textQuery(text);
			}
		});

		/* Overlay slide toggle */
		$(".wldfga-content-overlay .wldfga-content-overlay-header").click(function(event){

			if ($(this).find(".wldfga-icon-toggle-up").css("display") !== "none") {
				$(this)
					.find(".wldfga-icon-toggle-up")
					.hide();

				$(this)
					.parent()
					.removeClass("wldfga-toggle-closed")
					.addClass("wldfga-toggle-open");
				$(this).find(".wldfga-icon-toggle-down").show();
				$(this)
					.siblings(".wldfga-content-overlay-container, .wldfga-content-overlay-powered-by")
					.slideToggle("slow", function() {});
			} else {
				$(this)
					.find(".wldfga-icon-toggle-down")
					.hide();
				$(this)
					.parent()
					.removeClass("wldfga-toggle-open")
					.addClass("wldfga-toggle-closed");
				$(this)
					.find(".wldfga-icon-toggle-up")
					.show();
				$(this)
					.siblings(".wldfga-content-overlay-container, .wldfga-content-overlay-powered-by")
					.slideToggle("slow", function() {});
			}
		});

		$(".wldfga-conversation-area").on( 'click', '.wldfga-is-active .wldfga-quick-reply', function(e) {
			e.preventDefault();

			$(".wldfga-conversation-area .wldfga-conversation-request").removeClass("wldfga-is-active");

			text = $(this).val();

			addMessage( text, 'request' );

			textQuery( text );
		});

	});

	/**
	 * Send Dialogflow query
	 *
	 * @param text
	 * @returns
	 */
	function textQuery(text) {

		$.post({
			type : "POST",
			url : options.url,
			contentType : "application/json; charset=utf-8",
			dataType : "json",
			headers : {
				"Authorization" : "Bearer " + options.access_token
			},
			data: JSON.stringify( {
				query: text,
				lang: "en",
				sessionId: options.session_id
			} ),
			success : function(response) {
				prepareResponse(response);
				console.log(response);
			},
			error : function(response) {
				addMessage( error_message, 'response' );;
				$(".wldfga-conversation-area")
					.scrollTop($(".wldfga-conversation-area")
					.prop("scrollHeight"));
			}
		});
	}

	/**
	 * Handle Dialogflow response
	 *
	 * @param response
	 */
	function prepareResponse( response ) {
		// Bail if the status code is not 200.
		if (response.status.code !== 200 ) {
			return addMessage( error_message, 'response' );
		}

		var messages = response.result.fulfillment.messages;
		console.log(messages);
		// Make other messages unactive.
		$( '.wldfga-conversation-area .wldfga-conversation-response' ).removeClass( 'wldfga-is-active' );

		// Loop through all response messages and add chat message responses.
		$( messages ).each( function() {
			var message = '';
			switch ( this.type ) {
				// Simple text messages.
				case 0:
				case 'simple_response':
					if ( messages.length == 1 ) {
						message = this.speech;
					}
					break;

				case 1:
				case 'basic_card':
					message = cardResponse( this );
					break;

				case 1:
				case 'list_card':
					message = listResponse( this );
					break;

				case 2:
				case 'suggestion_chips':
					message = quickRepliesResponse( this );
					break;
			}

			if ( message.length ) {
				// Add the message.
				addMessage( message, 'response');
			}
		})

		$( '.wldfga-conversation-area')
			.scrollTop( 
				$( '.wldfga-conversation-area' ).prop( 'scrollHeight' )
			);
	}

	/**
	 * Card response
	 */
	function cardResponse( message ) {

		var html = '<h4 class="card-title">' + message.title + '</h4>';

		if ( message.hasOwnProperty( 'image' ) ) {
			html += '<img src="' + message.image.url + '" width="100%" height="auto" class="card-image" />';
		}

		if ( message.hasOwnProperty( 'formattedText' ) ) {
			html += '<div class="card-description">' + message.formattedText + '</div>';
		}

		if ( message.hasOwnProperty( 'buttons' ) ) {
			html += '<hr/><a href="' + message.buttons[0].openUrlAction.url + '" target="_blank" class="card-link" >' + message.title + '</a>';
		}

		return html;
	}

	function listResponse( message ) {

		var html = '<h4 class="card-title">' + message.title + '</h4>';
		
		html += '<ol class="list-options">';
		
		$( message.items ).each( function () {
			html += '<li class="list-title">' + this.title + '</li>';
		})
		
		html += '</ol>';

		return html;
	}

	/**
	 * Quick replies response
	 *
	 * @param replies Replies to display.
	 */
	function quickRepliesResponse( message ) {
		var html = '<div class="card-title">' + message.title + '</div>';

		// Loop through all replies and create button tags.
		html += '<div class="card-options">';

		$( message.suggestions ).each( function () {
			html += '<input type="button" class="wldfga-quick-reply" value="' + this.title + '" />';
		})

		html += '</div>';

		return html;
	}

	/**
	 * Creates response message
	 *
	 * @param text Text to display
	 */
	function getMessage( text, type ) {
		// Set the main class name.
		var parentClass = 'wldfga-conversation-bubble-container ';
		var innerClass = 'wldfga-conversation-bubble wldfga-is-active ';

		// Append the message type class names.
		if ( type == 'request' ) {
			parentClass += 'wldfga-conversation-bubble-container-request';
			innerClass += 'wldfga-conversation-request';
		} else {
			parentClass += 'wldfga-conversation-bubble-container-response';
			innerClass += 'wldfga-conversation-response';
		}

		// Build the message.
		html = '<div class="' + parentClass + '"><div class="' + innerClass + '">' +  text + '</div></div>';

		return html;
	}

	/**
	 * Adds message to the chat
	 *
	 * @param text Text to display
	 * @param type Type of the message
	 */
	function addMessage( text, type=false ) {
		// Verify that the text exists and it's not empty.
		if (
		    typeof( text ) === 'undefined' ||
		    ! text.length
		) {
			text = error_message;
		}

		// Get formatted message.
		text = getMessage( text, type )

		// Add the message to chatbox.
		$( '.wldfga-conversation-area' ).append( text );
	}

})(jQuery, window, document);

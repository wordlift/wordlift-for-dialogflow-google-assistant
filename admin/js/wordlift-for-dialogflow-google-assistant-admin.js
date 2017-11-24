;(function($, window, document, undefined) {
	var $win = $(window);
	var $doc = $(document);

	$doc.ready(function() {
        // Add Color Picker to all inputs that have 'color-field' class
        $( '.color-picker' ).wpColorPicker();
	});
})(jQuery, window, document);

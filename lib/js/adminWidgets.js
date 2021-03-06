jQuery(function( $ ){

	function insertWarnings() {
		var elementsBefore = $("[id*='featured-page'] [id*='-show_title']").parent();
		elementsBefore.each(function(_, val) {
			if ($(val).siblings(".first-impression-widget-warning").length) {
				return;
			}
			var newElement = $("<p class=\"first-impression-widget-warning\">If you are using this widget on the homepage, only <b>Show Content Limit</b> is supported.</p>");
			newElement.insertAfter(val);
			newElement.on("remove", function() {
				setTimeout(function() {
					insertWarnings(true);
				}, 0)
			})
		})	
	}
	insertWarnings();

});
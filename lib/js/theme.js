jQuery(document).foundation();

// Sets placeholder text to label text
function makeLabelsPlaceholders(labels) {
	labels.forEach(function(_, i) {
		var label = labels.item(i);
		var text = label.textContent;
		label.parentNode.classList.contains("required") && (text += "*");
		if (label.nextElementSibling) {
			label.nextElementSibling.setAttribute("placeholder", text);
			label.remove();
		}
	});
}

// If on the Home Atlas page, add a full width class
function homeAtlasFullscreen( element ) {
	if (element.length) {
		document.body.classList.add("must-see-home-atlas");
	}
}

jQuery(function( $ ){
	homeAtlasFullscreen( $('#IDX-resultsContainer'));
	// Enable responsive menu icon for mobile
	$('.nav-header-right').addClass('responsive-menu').before('<a href="" class="menu-toggle"><span class="screen-reader-text">Menu</span><i class="fa fa-bars"></i><span class="hide"><span class="screen-reader-text">Close</span><i class="fa fa-times"></i></span></a>');

	$('.menu-toggle').click(function(e){
		e.preventDefault();
		$('.nav-header-right').slideToggle();
		$('.menu-toggle .fa-bars').toggle();
		$('.menu-toggle .hide').toggle();
	});

	// Add fullscreen to map widget section
	$('*[class^="home-middle"]').has('.impress-idx-dashboard-widget').addClass('must-see-fullscreen impress-idx-dashboard-widget-section');

	// Fix default property carousel responsive break points
	$('.owl-carousel').data('owl.carousel').options.responsive["550"] = $('.owl-carousel').data('owl.carousel').options.responsive["450"];
	delete $('.owl-carousel').data('owl.carousel').options.responsive["450"];
	$('.owl-carousel').trigger( 'refresh.owl.carousel' );

	// The Equity widget doesn't support placeholder text for a vertical property search, so let's add it via the label tag
	makeLabelsPlaceholders(document.querySelectorAll(".sidebar .equity-idx-search-widget label"));
	makeLabelsPlaceholders(document.querySelectorAll(".idx-omnibar-extra-form .idx-omnibar-extra label"));

});

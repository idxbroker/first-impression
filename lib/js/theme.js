jQuery(document).foundation();

jQuery(function( $ ){
	
	// Enable responsive menu icon for mobile
	$('.nav-header-right').addClass('responsive-menu').before('<a href="" class="menu-toggle"><span class="screen-reader-text">Menu</span><i class="fa fa-bars"></i><span class="hide"><span class="screen-reader-text">Close</span><i class="fa fa-times"></i></span></a>');

	$('.menu-toggle').click(function(e){
		e.preventDefault();
		$('.nav-header-right').slideToggle();
		$('.menu-toggle .fa-bars').toggle();
		$('.menu-toggle .hide').toggle();
	});

	// Add fullscreen to map widget section
	$('*[class^="home-middle"]').has('.impress-idx-dashboard-widget .IDX-mapWidgetWrap').addClass('must-see-fullscreen must-see-map-section');

});

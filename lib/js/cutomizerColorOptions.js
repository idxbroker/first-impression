jQuery(function( $ ){
	function showCustomColorOptions() {
		console.log($('#_customize-input-preset_color_scheme').val());
		if ($('#_customize-input-preset_color_scheme').val() === 'custom') {
			$('#customize-control-primary_color').show();
			$('#customize-control-font_secondary_color').show();
			$('#customize-control-heading_secondary_color').show();
			$('#customize-control-gradient_start').show();
			$('#customize-control-gradient_end').show();
			return;
		}
		$('#customize-control-primary_color').hide();
		$('#customize-control-font_secondary_color').hide();
		$('#customize-control-heading_secondary_color').hide();
		$('#customize-control-gradient_start').hide();
		$('#customize-control-gradient_end').hide();
	}

	showCustomColorOptions();
	$('#_customize-input-preset_color_scheme').change(function() {
		showCustomColorOptions();
	})

});
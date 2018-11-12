<?php
/* Adds Customizer options for Must See
 */

class MUST_SEE_Customizer extends EQUITY_Customizer_Base {

	/**
	 * Register theme specific customization options
	 */

	private $color_presets = array(
		'blue' => array(
			'primary_color'        => '#258bb7',
			'font_secondary_color' => '#ffffff',
			'gradient_start'       => '#3fa5db',
			'gradient_end'         => '#5087c8'
		),
		'green' => array(
			'primary_color'        => '#2e7e55',
			'font_secondary_color' => '#ffffff',
			'gradient_start'       => '#1a9a59',
			'gradient_end'         => '#1e844c'
		),
		'red' => array(
			'primary_color'        => '#b82501',
			'font_secondary_color' => '#ffffff',
			'gradient_start'       => '#b82601',
			'gradient_end'         => '#aa1f03'
		),
		'tangerine' => array(
			'primary_color'        => '#e27121',
			'font_secondary_color' => '#ffffff',
			'gradient_start'       => '#e27121',
			'gradient_end'         => '#d3671e'
		),
		'white_blue' => array(
			'primary_color'        => '#248ab7',
			'font_secondary_color' => '#000000',
			'gradient_start'       => '#f5f5f5',
			'gradient_end'         => '#f5f5f5'
		)
	);

	public function register( $wp_customize ) {

		$this->header( $wp_customize );
		$this->colors( $wp_customize );
		$this->home( $wp_customize );
		$this->misc( $wp_customize );
	}

	private function get_color_hex( $theme_mod ) {
		$current_preset = get_theme_mod( 'preset_color_scheme', 'blue' );
		if ('custom' !== $current_preset) {
			return $this->color_presets[$current_preset][$theme_mod];
		}
		return get_theme_mod($theme_mod, $this->color_presets[$current_preset][$theme_mod]);

	}

	private function header( $wp_customize ) {

		global $wp_version;

		//* Setting key and default value array
		$settings = array(
			'site_title_font_size'    => 2.22222222,
			'nav_menu_font_size'  => 1,
			'nav_menu_padding'    => 0,
		);

		foreach ( $settings as $setting => $default ) {

			$wp_customize->add_setting(
				$setting,
				array(
					'default' => $default,
					'type'    => 'theme_mod',
				)
			);

		}

		//* Site Title font size
		$wp_customize->add_control(
			'site_title_font_size',
			array(
				'label'      => __( 'Site Title Font Size', 'must-see' ),
				'section'    => 'title_tagline',
				'settings'   => 'site_title_font_size',
				'priority'   => 100,
				'type'       => 'range',
				'input_attrs' => array(
					'min' => 0.5,
					'max' => 2.75,
					'step' => 0.001,
				),
				'active_callback' => array( $this, 'is_site_title_text' ),
			)
		);

		//* Main Menu font size
		$wp_customize->add_control(
			'nav_menu_font_size',
			array(
				'label'      => __( 'Main Menu Font Size', 'must-see' ),
				'section'    => 'title_tagline',
				'settings'   => 'nav_menu_font_size',
				'priority'   => 200,
				'type'       => 'range',
				'input_attrs' => array(
					'min' => 0.5,
					'max' => 1.5,
					'step' => 0.001,
				),
			)
		);

		//* Main Menu padding
		$wp_customize->add_control(
			'nav_menu_padding',
			array(
				'label'      => __( 'Main Menu Item Padding', 'must-see' ),
				'section'    => 'title_tagline',
				'settings'   => 'nav_menu_padding',
				'priority'   => 300,
				'type'       => 'range',
				'input_attrs' => array(
					'min' => -10,
					'max' => 10,
					'step' => 1,
				),
			)
		);
	}

	//* Colors
	private function colors( $wp_customize ) {
		$wp_customize->add_section(
			'colors',
			array(
				'title'       => __( 'Custom Colors', 'must-see' ),
				'description' => __('NOTICE: You are beautiful'),
				'priority'    => 200,
			)
		);

		$wp_customize->add_setting(
			'preset_color_scheme',
			array(
				'default' => 'blue',
				'type'    => 'theme_mod',
			)
		);

		//* Setting key and default value array
		$settings = array(
			'primary_color'        => '#258BB7',
			'gradient_start'       => '#3fa5db',
			'gradient_end'         => '#5087c8',
			'font_secondary_color' => '#FFFFFF',
			'zoom_property_image'  => false
		);

		foreach ( $settings as $setting => $default ) {

			$wp_customize->add_setting(
				$setting,
				array(
					'default' => $default,
					'type'    => 'theme_mod',
				)
			);
		}


		$wp_customize->add_control(
			'preset_color_scheme',
			array(
				'label'    => __( 'Preset Color Scheme', 'must-see' ),
				'section'  => 'colors',
				'type'     => 'select',
				'choices'  => array(
					'blue'      => __( 'Blue' ),
					'green'     => __( 'Green' ),
					'red'       => __( 'Red' ),
					'tangerine' => __( 'Tangerine' ),
					'white_blue' => __( 'White Blue' ),
					'custom'    => __( 'Use custom colors' )

				),
				'settings' => 'preset_color_scheme',
				'priority' => 100,
			)
		);

		//* Primary Color
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'primary_color',
				array(
					'label'       => __( 'Primary Color', 'must-see' ),
					'description' => __( 'Used for links, buttons, headings.', 'must-see' ),
					'section'     => 'colors',
					'settings'    => 'primary_color',
					'priority'    => 100,
				)
			)
		);

		//* Font Secondary Color
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'font_secondary_color',
				array(
					'label'       => __( 'Body Font Secondary Color', 'must-see' ),
					'description' => __( 'Used dark backgrounds.', 'must-see' ),
					'section'     => 'colors',
					'settings'    => 'font_secondary_color',
					'priority'    => 100,
				)
			)
		);

		//* Gradient start color
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'gradient_start',
				array(
					'label'       => __( 'Gradient Start Color', 'must-see' ),
					'description' => __( 'Used for backgrounds in the home page.', 'must-see' ),
					'section'     => 'colors',
					'settings'    => 'gradient_start',
					'priority'    => 100,
				)
			)
		);

		//* Gradient end color
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'gradient_end',
				array(
					'label'       => __( 'Gradient End Color', 'must-see' ),
					'description' => __( 'Used for backgrounds in the home page.', 'must-see' ),
					'section'     => 'colors',
					'settings'    => 'gradient_end',
					'priority'    => 100,
				)
			)
		);

		//* Zoom in for property photos with white cropping
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'zoom_property_image',
				array(
					'label'       => __( 'Zoom in on property carousel image?', 'must-see' ),
					'description' => __( 'Used for MLS cropped photos with a white background.', 'must-see' ),
					'section'     => 'title_tagline',
					'settings'    => 'zoom_property_image',
					'type'        => 'checkbox',
					'priority'    => 400,
				)
			)
		);

	}

	//* Home Page
	private function home( $wp_customize ) {
		$wp_customize->add_section(
			'home',
			array(
				'title'    => __( 'Home Page', 'must-see' ),
				'priority' => 201,
			)
		);

		//* Setting key and default value array
		$settings = array(
			'home_widget_areas'                        => 6,
			'default_background_image'                 => get_stylesheet_directory_uri() . '/images/bkg-default.jpg',
			'home_top_background_overlay'              => '#201f1f',
			'home_top_background_overlay_opacity'      => 0.01,
			'home_middle_3_background'                 => get_stylesheet_directory_uri() . '/images/home-middle-3-default.jpg',
			'home_middle_3_background_overlay'         => '#201f1f',
			'home_middle_3_background_overlay_opacity' => 0.8,
			'home_middle_6_background'                 => get_stylesheet_directory_uri() . '/images/home-middle-6-default.jpg',
			'home_middle_6_background_overlay'         => '#201f1f',
			'home_middle_6_background_overlay_opacity' => 0.6,
			'home_fadeup_effect'                       => true,
			'home_match_height_for_carousel'           => true,
		);

		foreach ( $settings as $setting => $default ) {

			$wp_customize->add_setting(
				$setting,
				array(
					'default' => $default,
					'type'    => 'theme_mod',
				)
			);
		}

		//* Number of home widget areas.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'home_widget_areas',
				array(
					'label'       => __( 'Number of home page widget areas.', 'must-see' ),
					'description' => __( 'Enter the number of widget areas for the home page middle.', 'must-see' ),
					'section'     => 'home',
					'settings'    => 'home_widget_areas',
					'type'        => 'number',
					'input_attrs' => array(
						'min'  => 0,
						'max'  => 12,
						'step' => 1,
					),
					'priority'    => 100,
				)
			)
		);

		//* Home Top image (and default background)
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'default_background_image',
				array(
					'label'       => __( 'Top Background Image', 'must-see' ),
					'description' => __( 'Upload an image to use for the "Home Top" widget area background. This image will also be used as the default background on interior pages.', 'must-see' ),
					'section'     => 'home',
					'settings'    => 'default_background_image',
					'extensions'  => array( 'jpg' ),
					'priority'    => 200,
				)
			)
		);

		//* Home Top background overlay
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'home_top_background_overlay',
				array(
					'label'       => __( 'Top background overlay color', 'must-see' ),
					'description' => __( 'Adjust the color overlay on home top widget area.', 'must-see' ),
					'section'     => 'home',
					'settings'    => 'home_top_background_overlay',
					'priority'    => 201,
				)
			)
		);

		//* Home Top background opacity
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'home_top_background_overlay_opacity',
				array(
					'label'       => __( 'Top background overlay color opacity.', 'must-see' ),
					'description' => __( 'Adjust the overlay opacity of the home top widget area background.', 'must-see' ),
					'section'     => 'home',
					'settings'    => 'home_top_background_overlay_opacity',
					'type'        => 'range',
					'input_attrs' => array(
						'min'   => 0,
						'max'   => 1,
						'step'  => 0.01,
					),
					'priority'    => 202,
				)
			)
		);

		//* Home Middle 3 background
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'home_middle_3_background',
				array(
					'label'       => __( 'Middle 3 Background Image', 'must-see' ),
					'description' => __( 'Upload an image to use for the "Home Middle 3" widget area background.', 'must-see' ),
					'section'     => 'home',
					'settings'    => 'home_middle_3_background',
					'extensions'  => array( 'jpg' ),
					'priority'    => 300,
					'active_callback' => array( $this, 'is_home_middle_3_widget_area_enabled' ),
				)
			)
		);

		//* Home Middle 3 background overlay
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'home_middle_3_background_overlay',
				array(
					'label'       => __( 'Middle 3 background overlay color', 'must-see' ),
					'description' => __( 'Adjust the color overlay on home middle 3 widget area.', 'must-see' ),
					'section'     => 'home',
					'settings'    => 'home_middle_3_background_overlay',
					'priority'    => 301,
					'active_callback' => array( $this, 'is_home_middle_3_widget_area_enabled' ),
				)
			)
		);

		//* Home Middle 3 background opacity
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'home_middle_3_background_overlay_opacity',
				array(
					'label'       => __( 'Middle 3 background overlay color opacity.', 'must-see' ),
					'description' => __( 'Adjust the overlay opacity of the home middle 3 widget area backgrounds.', 'must-see' ),
					'section'     => 'home',
					'settings'    => 'home_middle_3_background_overlay_opacity',
					'type'        => 'range',
					'input_attrs' => array(
						'min'   => 0,
						'max'   => 1,
						'step'  => 0.01,
					),
					'priority'    => 302,
					'active_callback' => array( $this, 'is_home_middle_3_widget_area_enabled' ),
				)
			)
		);

		//* Home Middle 6 background
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'home_middle_6_background',
				array(
					'label'       => __( 'Middle 6 Background Image', 'must-see' ),
					'description' => __( 'Upload an image to use for the "Home Middle 6" widget area background.', 'must-see' ),
					'section'     => 'home',
					'settings'    => 'home_middle_6_background',
					'extensions'  => array( 'jpg' ),
					'priority'    => 400,
					'active_callback' => array( $this, 'is_home_middle_6_widget_area_enabled' ),
				)
			)
		);

		//* Home Middle 6 background overlay
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'home_middle_6_background_overlay',
				array(
					'label'       => __( 'Middle 6 background overlay color', 'must-see' ),
					'description' => __( 'Adjust the color overlay on home middle 6 widget area.', 'must-see' ),
					'section'     => 'home',
					'settings'    => 'home_middle_6_background_overlay',
					'priority'    => 401,
					'active_callback' => array( $this, 'is_home_middle_6_widget_area_enabled' ),
				)
			)
		);

		//* Home Middle 6 background opacity
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'home_middle_6_background_overlay_opacity',
				array(
					'label'       => __( 'Middle 6 background overlay color opacity.', 'must-see' ),
					'description' => __( 'Adjust the overlay opacity of the home middle 6 widget area backgrounds.', 'must-see' ),
					'section'     => 'home',
					'settings'    => 'home_middle_6_background_overlay_opacity',
					'type'        => 'range',
					'input_attrs' => array(
						'min'   => 0,
						'max'   => 1,
						'step'  => 0.01,
					),
					'priority'    => 402,
					'active_callback' => array( $this, 'is_home_middle_6_widget_area_enabled' ),
				)
			)
		);

		//* Toggle homepage fadeup effect
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'home_fadeup_effect',
				array(
					'label'       => __( 'Use fadeup effect on homepage?', 'must-see' ),
					'section'     => 'home',
					'settings'    => 'home_fadeup_effect',
					'type'        => 'checkbox',
					'priority'    => 500,
				)
			)
		);

		//* Toggle match height on home page carousel
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'home_match_height_for_carousel',
				array(
					'label'       => __( 'Use match height on homepage carousel?', 'must-see' ),
					'section'     => 'home',
					'settings'    => 'home_match_height_for_carousel',
					'type'        => 'checkbox',
					'priority'    => 600,
				)
			)
		);
	}

	//* Misc
	private function misc( $wp_customize ) {

		//* Setting key and default value array
		$settings = array(
			'enable_sticky_header'   => true,
			'show_site_description'  => false,
		);

		foreach ( $settings as $setting => $default ) {

			$wp_customize->add_setting(
				$setting,
				array(
					'default' => $default,
					'type'    => 'theme_mod',
				)
			);
		}

		//* Enable header description
		$wp_customize->add_control(
			'disable_site_description',
			array(
				'label'    => __( 'Show Site Description?', 'must-see' ),
				'section'  => 'title_tagline',
				'type'     => 'checkbox',
				'settings' => 'show_site_description',
				'priority' => 300,
			)
		);

		//* Enable sticky header checkbox
		$wp_customize->add_control(
			'enable_sticky_header',
			array(
				'label'    => __( 'Enable Sticky Header?', 'must-see' ),
				'section'  => 'title_tagline',
				'type'     => 'checkbox',
				'settings' => 'enable_sticky_header',
				'priority' => 300,
			)
		);
	}

	//* Render CSS
	public function render() {
		?>
		<!-- begin Child Customizer CSS -->
		<style type="text/css">
			<?php

			//* Site description
			if ( get_theme_mod( 'show_site_description' ) ) {
				echo 'header.site-header .site-description {display: block;}';
			}

			//* Background images
			// TODO: Add option to use custom image
			echo '.home-top {background-image: url(\'' . get_theme_mod( 'default_background_image', get_stylesheet_directory_uri() . '/images/bkg-default.jpg' ) . '\');}';
			//* Background overlay

			//* Primary color hover
			$primary_hover = '#eee';

			//* Secondary color - hover
			$secondary_hover = '#258BB7';

			// TODO: preset color settings here
			$primary_color = $this->get_color_hex('primary_color');
			$font_secondary_color = $this->get_color_hex('font_secondary_color');
			$gradient_start = $this->get_color_hex('gradient_start');
			$gradient_end = $this->get_color_hex('gradient_end');

			echo "
				/*** Font Primary Color ***/
				h1,
				h2,
				h3,
				h4,
				h5,
				a,
				a:hover,
				a:focus,
				blockquote,
				blockquote p,
				.entry-comments > h3,
				.entry-comments .comment-author span:first-of-type,
				.entry-comments .comment-meta,
				.button,
				button,
				button:focus,
				button:hover,
				.widget button:hover,
				.widget button:focus,
				input[type='button'],
				input[type='submit'],
				.widget .idx-omnibar-form button,
				.home .content-sidebar-wrap div[class*='home-'],
				.home .content-sidebar-wrap div[class*='home-'] h1,
				.home .content-sidebar-wrap div[class*='home-'] h2,
				.home .content-sidebar-wrap div[class*='home-'] h3,
				.home .content-sidebar-wrap div[class*='home-'] h4,
				.home .content-sidebar-wrap div[class*='home-'] h5,
				.home .content-sidebar-wrap div[class*='home-'] h6,
				.home .content-sidebar-wrap div[class*='home-'] label,
				.home .impress-idx-dashboard-widget h4,
				.home section.impress-carousel-widget h4,
				.home .singleTestimonialWidget h4,
				.home .listTestimonialsWidget h4,
				.home .contact-us > div > h4,
				.home .contact-us .widget-area .widget_text h4,
				.impress-carousel-widget .address,
				.impress-carousel-widget .city-state,
				a.menu-toggle,
				.nav-header-right .menu-item,
				.nav-header-right .sub-menu,
				.nav-header-right a,
				.nav-header-right ul > li.menu-item-has-children > a::after,
				.testimonial_author cite,
				.home a,
				.home .widget article h2.entry-title a,
				.IDX-wrapper-standard a,
				.IDX-wrapper-standard a:focus,
				.IDX-wrapper-standard a:hover,
				.IDX-wrapper-standard .IDX-results-refinement .IDX-refine-search--toggle,
				#IDX-main #IDX-detailsHotActions .IDX-btn,
				body.must-see-map-results #IDX-main .IDX-topAction .IDX-btn {
					color: $primary_color;
				}
				@media only screen and (min-width: 40.063em) {
					header.site-header .site-title,
					header.site-header .site-title a {
						color: $primary_color;
					}
				}

				/*** Border Primary Color ***/
				.button,
				button,
				input[type='button'],
				input[type='submit'],
				.widget .idx-omnibar-form button,
				textarea:focus,
				select:focus,
				select:hover,
				input[type='text']:focus,
				input[type='email']:focus,
				input[type='tel']:focus,
				input[type='password']:focus,
				.IDX-wrapper-standard .IDX-showcaseSlide-active {
					border-color: $primary_color;
				}

				/*** Border Top Primary Color ***/
				.IDX-wrapper-standard .IDX-results-refinement .IDX-refine-search--toggle::after {
					border-top-color: $primary_color;
				}

				/*** Border Bottom Primary Color ***/
				.IDX-wrapper-standard .IDX-results-refinement.IDX-dropdown-open .IDX-refine-search--toggle::after {
					border-bottom-color: $primary_color;
				}

				/*** Background Primary Color ***/
				.title-area,
				h4::before, 
				h4::after,
				h2::after,
				h1::after,
				.IDX-wrapper-standard .select2-container.select2-container-multi .select2-choices .select2-search-choice,
				body:not(.must-see-map-results) .IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default,
				body:not(.must-see-map-results) .IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default,
				body:not(.must-see-map-results) #IDX-main .IDX-topAction .IDX-btn {
					background-color: $primary_color;
				}
				@media only screen and (max-width: 40.063em) {
					.site-header {
						background-color: $primary_color;
					}
				}

				/*** Font Secondary Color ***/
				.home .content-sidebar-wrap div[class*='home-'].bg-gradient,
				.home .content-sidebar-wrap div[class*='home-'].bg-gradient h1,
				.home .content-sidebar-wrap div[class*='home-'].bg-gradient h2,
				.home .content-sidebar-wrap div[class*='home-'].bg-gradient h3,
				.home .content-sidebar-wrap div[class*='home-'].bg-gradient h4,
				.home .content-sidebar-wrap div[class*='home-'].bg-gradient h5,
				.home .content-sidebar-wrap div[class*='home-'].bg-gradient h6,
				.home .content-sidebar-wrap div[class*='home-'].bg-gradient label,
				.home .content-sidebar-wrap div[class*='home-'].bg-gradient .impress-idx-dashboard-widget h4,
				.home .content-sidebar-wrap div[class*='home-'].bg-gradient section.impress-carousel-widget h4,
				.home .content-sidebar-wrap div[class*='home-'].bg-gradient .singleTestimonialWidget h4,
				.home .content-sidebar-wrap div[class*='home-'].bg-gradient .listTestimonialsWidget h4,
				.bg-gradient .easy_testimonial_title,
				.bg-gradient .easy_testimonial .testimonial_body p,
				.bg-gradient .easy_testimonial .testimonial_author cite,
				.title-area,
				.home .bg-gradient a,
				.bg-gradient p,
				.bg-gradient a,
				.bg-gradient label,
				header.site-header .site-title,
				body:not(.must-see-map-results) .IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default .IDX-navbar-nav > li a,
				body:not(.must-see-map-results) #IDX-main .IDX-topAction .IDX-btn,
				.IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default .IDX-navbar-nav > li > a {
					color: $font_secondary_color;
				}
				@media only screen and (max-width: 40.063em) {
					.site-header .agent-social-icons a,
					.site-header .menu-toggle {
						color: $font_secondary_color;
					}
				}

				/*** Background Secondary Color ***/
				.bg-gradient .title-area,
				.bg-gradient h4::before, 
				.bg-gradient h4::after,
				.bg-gradient h2::after,
				.bg-gradient h1::after {
					background-color: $font_secondary_color;
				}

				/*** Border Secondary Color ***/
				.bg-gradient .button,
				.bg-gradient button,
				.bg-gradient input[type='button'],
				.bg-gradient input[type='submit'] {
					border-color: $font_secondary_color;
				}

				/*** Background Gradient Colors ***/
				.bg-gradient {
					background: linear-gradient(135deg, $gradient_start 0%, $gradient_end 100%);
				}
			";

			// Property image zoom for cropped MLS images
			if (get_theme_mod('zoom_property_image', false)) {
				echo "
					.home .impress-carousel .carousel-photo img,
					.home .equity-idx-carousel .carousel-photo img {
						min-width: 200%;
						min-height: 200%;
						margin-top: -50%;
						margin-left: -50%;
					}
				";
			}

			// TESTING PRESETS
			if ($preset_color === 'green') {
				echo "
					*{
						background: green !important;
					}
				";
			}

			/*** END NEW STUFF ***/

			// Site title font size
			self::generate_css( 'header.site-header .site-title', 'font-size', 'site_title_font_size', '', 'rem' );
			echo 'body.sticky .sticky-header header.site-header .site-title { font-size: ' . get_theme_mod( 'site_title_font_size', 2.2222222 ) * 0.8 . 'rem; }';

			// Nav menu font size
			self::generate_css( '.nav-header-right a', 'font-size', 'nav_menu_font_size', '', 'rem' );

			// Nav menu padding
			$nav_padding = 20 + get_theme_mod( 'nav_menu_padding', 0 );
			echo '.nav-header-right a {
				padding-left: ' . $nav_padding . 'px;
				padding-right: ' . $nav_padding . 'px;
			}';
			$nav_arrow = 8 + ( get_theme_mod( 'nav_menu_padding', 0 ) / 2 );
			echo '.nav-header-right ul>li.menu-item-has-children>a::after {right: ' . $nav_arrow . 'px}';

			?>
		</style>
		<!-- end Child Customizer CSS -->
		<?php
	}

	public function is_site_title_text() {
		$setting = get_theme_mod( 'logo_display_type' );
		if ( 'text' === $setting ) {
			return true;
		}
		return false;
	}

	public function is_home_middle_3_widget_area_enabled() {
		$setting = get_theme_mod( 'home_widget_areas' );
		if ( $setting > 2 ) {
			return true;
		}
		return false;
	}

	public function is_home_middle_6_widget_area_enabled() {
		$setting = get_theme_mod( 'home_widget_areas' );
		if ( $setting > 5 ) {
			return true;
		}
		return false;
	}
}

add_action( 'init', 'must_see_customizer_init' );
/**
 * Instantiate MUST_SEE_Customizer
 *
 * @since 1.0
 */
function must_see_customizer_init() {
	new MUST_SEE_Customizer;
}

/**
 * Generate a lighter or darker color from a starting color.
 * Used to generate complementary hover tints from user-chosen colors.
 *
 * @param string $color A color in hex format.
 * @param string $op The operation to apply: '+' for lighter, '-' for darker.
 * @param int    $change The amount to reduce or increase brightness by.
 * @return string Hex code for the adjusted color brightness.
 */
if ( ! function_exists( 'equity_color_brightness' ) ) {
	function equity_color_brightness( $color, $op, $change ) {

		$hexcolor = str_replace( '#', '', $color );
		$red      = hexdec( substr( $hexcolor, 0, 2 ) );
		$green    = hexdec( substr( $hexcolor, 2, 2 ) );
		$blue     = hexdec( substr( $hexcolor, 4, 2 ) );

		if ( '+' !== $op && isset( $op ) ) {
			$red   = max( 0, min( 255, $red - $change ) );
			$green = max( 0, min( 255, $green - $change ) );
			$blue  = max( 0, min( 255, $blue - $change ) );
		} else {
			$red   = max( 0, min( 255, $red + $change ) );
			$green = max( 0, min( 255, $green + $change ) );
			$blue  = max( 0, min( 255, $blue + $change ) );
		}

		$newhex = '#';
		$newhex .= strlen( dechex( $red ) ) === 1 ? '0' . dechex( $red ) : dechex( $red );
		$newhex .= strlen( dechex( $green ) ) === 1 ? '0' . dechex( $green ) : dechex( $green );
		$newhex .= strlen( dechex( $blue ) ) === 1 ? '0' . dechex( $blue ) : dechex( $blue );

		// Forces darken if brighten color is the same as color inputted.
		if ( $newhex === $hexcolor && '+' === $op ) {
			$newhex = '#111111';
		}

		return $newhex;

	}
}

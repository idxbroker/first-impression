<?php
/* Adds Customizer options for Must See
 */

class MUST_SEE_Customizer extends EQUITY_Customizer_Base {

	/**
	 * Register theme specific customization options
	 */

	private $color_presets = array(
		'blue' => array(
			'primary_color'           => '#258bb7',
			'heading_secondary_color' => '#ffffff',
			'font_secondary_color'    => '#ffffff',
			'gradient_start'          => '#3fa5db',
			'gradient_end'            => '#5087c8'
		),
		'green' => array(
			'primary_color'           => '#2e7e55',
			'heading_secondary_color' => '#ffffff',
			'font_secondary_color'    => '#ffffff',
			'gradient_start'          => '#1a9a59',
			'gradient_end'            => '#1e844c'
		),
		'red' => array(
			'primary_color'           => '#b82501',
			'heading_secondary_color' => '#ffffff',
			'font_secondary_color'    => '#ffffff',
			'gradient_start'          => '#b82601',
			'gradient_end'            => '#aa1f03'
		),
		'tangerine' => array(
			'primary_color'           => '#e27121',
			'heading_secondary_color' => '#ffffff',
			'font_secondary_color'    => '#ffffff',
			'gradient_start'          => '#e27121',
			'gradient_end'            => '#d3671e'
		),
		'white_blue' => array(
			'primary_color'           => '#248ab7',
			'heading_secondary_color' => '#248ab7',
			'font_secondary_color'    => '#000000',
			'gradient_start'          => '#f5f5f5',
			'gradient_end'            => '#f5f5f5'
		)
	);

	public function register( $wp_customize ) {
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

	//* Colors
	private function colors( $wp_customize ) {
		$wp_customize->add_setting(
			'preset_color_scheme',
			array(
				'default' => 'blue',
				'type'    => 'theme_mod',
			)
		);

		//* Setting key and default value array
		$settings = array(
			'primary_color'           => '#258BB7',
			'gradient_start'          => '#3fa5db',
			'gradient_end'            => '#5087c8',
			'heading_secondary_color' => '#ffffff',
			'font_secondary_color'    => '#ffffff',
			'zoom_property_image'     => false
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

		//* Heading Secondary Color
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'heading_secondary_color',
				array(
					'label'       => __( 'Heading Font Secondary Color', 'must-see' ),
					'description' => __( 'Used for gradient backgrounds.', 'must-see' ),
					'section'     => 'colors',
					'settings'    => 'heading_secondary_color',
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
					'description' => __( 'Used for gradient dark backgrounds.', 'must-see' ),
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
			'home_widget_areas'        => 5,
			'default_background_image' => get_stylesheet_directory_uri() . '/images/bkg-default.jpg',
			'home_fadeup_effect'       => true,
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
	}

	//* Misc
	private function misc( $wp_customize ) {
/*
		//* Setting key and default value array
		$settings = array(
			'enable_sticky_header' => true, // TODO: Check out how this works
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
	*/	
	}

	//* Render CSS
	public function render() {
		?>
		<!-- begin Child Customizer CSS -->
		<style type="text/css">
			<?php

			//* Site description

			//* Background image
			echo '.home-top {background-image: url(\'' . get_theme_mod( 'default_background_image', get_stylesheet_directory_uri() . '/images/bkg-default.jpg' ) . '\');}';

			// Get color values
			$primary_color = $this->get_color_hex('primary_color');
			$heading_secondary_color = $this->get_color_hex('heading_secondary_color');
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
				div.impress-carousel .owl-nav.owl-controls button.owl-prev,
				div.impress-carousel .owl-nav.owl-controls button.owl-next,
				footer.site-footer input[type='submit'],
				footer.site-footer button
				footer.site-footer .IDX-mapWidgetWrap *,
				footer.site-footer .footer-widgets .IDX_Omnibar_Widget *,
				.IDX-wrapper-standard.IDX-page-listing #IDX-saveProperty,
				.IDX-wrapper-standard.IDX-page-listing #IDX-newSearch,
				.IDX-wrapper-standard.IDX-page-listing #IDX-modifySearch, 
				.IDX-wrapper-standard.IDX-page-listing #IDX-backToResults,
				.IDX-wrapper-standard.IDX-page-listing .IDX-detailsHotAction a,
				.IDX-wrapper-standard.IDX-page-listing .IDX-detailsHotAction a:hover,
				.IDX-wrapper-standard.IDX-page-listing .IDX-arrow,
				.IDX-wrapper-standard.IDX-page-listing .IDX-arrow:hover,
				.IDX-wrapper-standard.IDX-page-listing #IDX-resetBtn,
				.IDX-wrapper-standard.IDX-page-listing #IDX-submitBtn,
				.IDX-wrapper-standard a,
				.IDX-wrapper-standard.IDX-type-usersignup #IDX-leadSignupContainer .IDX-btn,
				.IDX-wrapper-standard.IDX-page-userlogin #IDX-leadLoginContainer .IDX-btn,
				.IDX-wrapper-standard.IDX-type-usersignup #IDX-leadSignupContainer #IDX-toggleLogIn,
				.IDX-wrapper-standard.IDX-page-userlogin #IDX-leadLoginContainer #IDX-userSignupLink,
				.IDX-wrapper-standard #IDX-searchPageWrapper .IDX-advancedText,
				.IDX-wrapper-standard #IDX-searchPageWrapper #IDX-action-buttons button.IDX-btn,
				.IDX-wrapper-standard #IDX-searchPageWrapper .IDX-advancedText,
				.IDX-wrapper-standard.IDX-category-results .IDX-topActions a:hover,
				.IDX-wrapper-standard a:hover, .IDX-wrapper-standard a:active,
				.IDX-wrapper-standard a:focus,
				.IDX-wrapper-standard .IDX-results-title {
					color: $primary_color;
				}
				@media only screen and (min-width: 40.063em) {
					header.site-header .site-title,
					header.site-header .site-title a {
						color: $primary_color;
					}
				}
				@media only screen and (max-width: 640px) {
					.IDX-wrapper-standard.IDX-page-listing .IDX-detailsHotAction a,
					.IDX-wrapper-standard #IDX-searchPageWrapper #IDX-navbar-collapse,
					.IDX-wrapper-standard #IDX-searchPageWrapper .IDX-navbar-default .IDX-navbar-nav > li > a {
						color: $primary_color;
					}
				}
				@media only screen and (min-width: 641px) {
					.IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default .IDX-navbar-nav > li.IDX-active > a,
					.IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default .IDX-navbar-nav > li.IDX-active > a:focus,
					.IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default .IDX-navbar-nav > li.IDX-active > a:active,
					.IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default .IDX-navbar-nav > li.IDX-active > a:hover,
					.IDX-wrapper-standard.IDX-page-address .IDX-navbar-default .IDX-navbar-nav > .IDX-active > .IDX-searchNavLink {
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
				div.impress-carousel .owl-nav.owl-controls button.owl-prev,
				div.impress-carousel .owl-nav.owl-controls button.owl-next,
				.IDX-wrapper-standard.IDX-page-listing #IDX-saveProperty,
				.IDX-wrapper-standard.IDX-page-listing #IDX-newSearch,
				.IDX-wrapper-standard.IDX-page-listing #IDX-modifySearch, 
				.IDX-wrapper-standard.IDX-page-listing #IDX-backToResults,
				.IDX-wrapper-standard.IDX-page-listing .IDX-showcaseSlide-active,
				.IDX-wrapper-standard.IDX-page-listing #IDX-detailsHotActions,
				.IDX-wrapper-standard.IDX-page-listing .IDX-arrow,
				.IDX-wrapper-standard.IDX-page-listing #IDX-photoGalleryLink,
				.IDX-wrapper-standard.IDX-page-listing #IDX-detailsHead hr,
				.IDX-wrapper-standard.IDX-page-listing #IDX-resetBtn,
				.IDX-wrapper-standard.IDX-page-listing #IDX-submitBtn,
				.IDX-wrapper-standard.IDX-page-userlogin #IDX-leadLoginContainer #IDX-keepLoggedIn label .IDX-keepLoggedInCheckBox,
				.IDX-wrapper-standard.IDX-type-usersignup #IDX-leadSignupContainer .IDX-btn,
				.IDX-wrapper-standard.IDX-page-userlogin #IDX-leadLoginContainer .IDX-btn,
				.IDX-wrapper-standard #IDX-searchPageWrapper #IDX-action-buttons button.IDX-btn {
					border-color: $primary_color;
				}

				.IDX-wrapper-standard .IDX-results-refinement .IDX-refine-search--toggle::after {
					border-top-color: $primary_color;
				}
				.IDX-wrapper-standard .IDX-results-refinement.IDX-dropdown-open .IDX-refine-search--toggle::after {
					border-bottom-color: $primary_color;
				}

				/*** Background Primary Color ***/
				.title-area,
				h4::before,
				h4::after,
				h2::after,
				h1::after,
				.IDX-wrapper-standard.IDX-page-listing .IDX-carouselNavWrapper,
				.IDX-wrapper-standard.IDX-page-listing #IDX-detailsMainInfo::after,
				.IDX-wrapper-standard.IDX-page-listing .IDX-panel-heading::before,
				.IDX-wrapper-standard.IDX-page-listing #IDX-listingHeader::before,
				.IDX-wrapper-standard.IDX-page-userlogin #IDX-leadLoginContainer #IDX-keepLoggedIn label .IDX-keepLoggedInCheckBox:checked,
				.IDX-wrapper-standard.IDX-type-usersignup #IDX-leadSignupContainer .IDX-panel-heading,
				.IDX-wrapper-standard.IDX-page-userlogin #IDX-leadLoginContainer .IDX-panel-heading,
				.IDX-wrapper-standard #IDX-searchPageWrapper #IDX-action-buttons button.IDX-btn:hover,
				.IDX-wrapper-standard #IDX-searchPageWrapper .IDX-container-navbar,
				.IDX-wrapper-standard .select2-container.select2-container-multi .select2-choices .select2-search-choice,
				.select2-results .select2-highlighted {
					background-color: $primary_color;
				}
				@media only screen and (max-width: 40.063em) {
					.site-header {
						background-color: $primary_color;
					}
				}
				@media only screen and (max-width: 640px) {
					.IDX-wrapper-standard #IDX-searchPageWrapper .IDX-navbar-default .IDX-navbar-nav > li:focus,
					.IDX-wrapper-standard #IDX-searchPageWrapper .IDX-navbar-default .IDX-navbar-nav > li:active,
					.IDX-wrapper-standard #IDX-searchPageWrapper .IDX-navbar-default .IDX-navbar-nav > li:hover,
					.IDX-wrapper-standard #IDX-searchPageWrapper .IDX-navbar-default .IDX-navbar-nav > li.IDX-active > a {
						background-color: $primary_color;
					}
				}

				/*** Headings Secondary Color ***/
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
				.home .bg-gradient a,
				.IDX-wrapper-standard.IDX-page-listing .IDX-carouselNavWrapper i,
				.IDX-wrapper-standard.IDX-page-userlogin #IDX-leadLoginContainer #IDX-keepLoggedIn label .IDX-keepLoggedInCheckBox::after,
				.IDX-wrapper-standard.IDX-type-usersignup #IDX-leadSignupContainer .IDX-panel-heading h2,
				.IDX-wrapper-standard.IDX-page-userlogin #IDX-leadLoginContainer .IDX-panel-heading h2,
				.IDX-wrapper-standard #IDX-searchPageWrapper #IDX-action-buttons button.IDX-btn:hover,
				.IDX-wrapper-standard #IDX-searchPageWrapper .IDX-container-navbar,
				.IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default .IDX-navbar-nav > li > a,
				.IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default .IDX-navbar-nav > li > a:focus,
				.IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default .IDX-navbar-nav > li > a:active,
				.IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default .IDX-navbar-nav > li > a:hover {
					color: $heading_secondary_color;
				}
				@media only screen and (max-width: 640px) {
					.IDX-wrapper-standard #IDX-searchPageWrapper .IDX-navbar-default .IDX-navbar-nav > li:focus a,
					.IDX-wrapper-standard #IDX-searchPageWrapper .IDX-navbar-default .IDX-navbar-nav > li:active a,
					.IDX-wrapper-standard #IDX-searchPageWrapper .IDX-navbar-default .IDX-navbar-nav > li:hover a,
					.IDX-wrapper-standard #IDX-searchPageWrapper .IDX-navbar-default .IDX-navbar-nav > li.IDX-active > a {
						color: $heading_secondary_color;
					}
				}

				/*** Font Secondary Color ***/
				.home .content-sidebar-wrap div[class*='home-'].bg-gradient,
				.bg-gradient .easy_testimonial_title,
				.bg-gradient .easy_testimonial .testimonial_body p,
				.bg-gradient .easy_testimonial .testimonial_author cite,
				.bg-gradient p,
				.bg-gradient a,
				.bg-gradient label {
					color: $font_secondary_color;
				}

				/*** Background Secondary Color ***/
				.bg-gradient .title-area,
				.bg-gradient h4::before, 
				.bg-gradient h4::after,
				.bg-gradient h2::after,
				.bg-gradient h1::after {
					background-color: $heading_secondary_color;
				}
				@media only screen and (max-width: 640px) {
					.IDX-wrapper-standard #IDX-searchPageWrapper .IDX-navbar-default .IDX-navbar-toggle > .IDX-icon-bar,
					.IDX-wrapper-standard #IDX-searchPageWrapper .IDX-navbar-default .IDX-navbar-toggle > .IDX-icon-bar {
						background-color: $heading_secondary_color;
					}
				}

				/*** Border Secondary Color ***/
				.bg-gradient .button,
				.bg-gradient button,
				.bg-gradient input[type='button'],
				.bg-gradient input[type='submit'] {
					border-color: $heading_secondary_color;
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

			if ( ! get_theme_mod('home_fadeup_effect', true) ) {
				echo ".fadeup-effect {
					opacity: 1;
				}";
			}

			function use_title_image() {
				$setting = get_theme_mod( 'logo_display_type' );
				if ( 'image' !== $setting ) {
					add_action( 'equity_do_title', 'must_see_filter_image' );
				}
			}
			use_title_image();

			function must_see_filter_image($title) {
				$output = preg_replace('/<img[^>]+\>/i', '', $title);
				$output = str_replace('class="hide"', '', $output);
				return $output;
			}

			?>
		</style>
		<!-- end Child Customizer CSS -->
		<?php
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

<?php
// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Must See', 'must-see' ) );
define( 'CHILD_THEME_URL', 'https://learn.agentevolution.com/kb/must-see/' );
define( 'CHILD_THEME_VERSION', '2.0.0' );

// Set Localization (do not remove).
load_child_theme_textdomain( 'must-see', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'must-see' ) );

// Remove foundation stylesheet - components loaded in child css.
add_action( 'wp_enqueue_scripts', 'child_dequeue_foundation_stylesheet' );
function child_dequeue_foundation_stylesheet() {
	wp_dequeue_style( 'equity-foundation' );
	// Get rid of this from easy testimonials because it has overreaching styles. We'll add our own if we need to.
	wp_dequeue_style( 'easy_testimonials_pro_style_new_responsive' );
}

// Add Theme Support.
add_theme_support( 'equity-after-entry-widget-area' );
add_theme_support( 'equity-menus', array(
	'header-right' => __( 'Header Right', 'must-see' ),
) );
add_theme_support( 'equity-structural-wraps', array() );

// Add Accessibility support.
add_theme_support( 'equity-accessibility', array( 'skip-links' ) );

// Set default footer widgets
if ( ! get_theme_mod( 'footer_widgets' ) ) {
	set_theme_mod( 'footer_widgets', 3 );
}

// Remove header right widget area.
remove_action( 'after_setup_theme', 'equity_register_header_right_widget_area' );

// Add large square size image for featured pages on homepage.
add_image_size( 'large-square', '500', '500', true );

// Create additional color style options
add_theme_support( 'equity-style-selector', array(
	'must-see-blue'   => __( 'Blue', 'must-see' ),
	'must-see-red'    => __( 'Red', 'must-see' ),
	'must-see-tan'    => __( 'Tan', 'must-see' ),
	'must-see-custom' => __( 'Use Customizer', 'must-see' ),
) );

// Load fonts.
add_filter( 'equity_google_fonts', 'must_see_fonts' );
function must_see_fonts( $equity_google_fonts ) {
	$equity_google_fonts = 'PT+Sans:400,700|Raleway:600';
	return $equity_google_fonts;
}

// Load scripts.
add_action( 'wp_enqueue_scripts', 'must_see_register_scripts' );
function must_see_register_scripts() {
	// Use jQuery matchHeight for carousel images and header height.
	wp_enqueue_script( 'jquery-matchheight', get_stylesheet_directory_uri() . '/lib/js/jquery.matchHeight-min.js', array( 'jquery', 'equity-theme-js' ), null, true );

	// Enable fadeup script if enabled.
	if ( get_theme_mod( 'home_fadeup_effect', true ) ) {
		wp_enqueue_script( 'fadeup', get_stylesheet_directory_uri() . '/lib/js/fadeup.js', array( 'jquery' ), null, true );
	}
}

// Dequeue the IDX widgets stylesheet.
remove_action( 'wp_enqueue_scripts', 'equity_enqueue_idx_stylesheet', 10 );

// Resize title area and header menu widths
add_filter( 'equity_attr_title-area', 'must_see_attributes_title_area' );
function must_see_attributes_title_area( $attributes ) {
	$attributes['class'] = str_replace( 'large-5', 'large-12', $attributes['class'] );
	return $attributes;
}
add_filter( 'equity_attr_nav-header-right', 'must_see_attributes_header_nav' );
function must_see_attributes_header_nav( $attributes ) {
	$attributes['class'] = str_replace( 'large-7', 'large-12', $attributes['class'] );
	return $attributes;
}

// Filter nav markup to add toggle icon.
add_filter( 'equity_nav_markup_open', 'must_see_nav_markup_open' );
function must_see_nav_markup_open() {
	return '<a href="#" class="menu-toggle"><span class="screen-reader-text">Menu</span><i class="fa fa-bars"></i></a>';
}

// Filter listing scroller widget prev/next links.
add_filter( 'listing_scroller_prev_link', 'child_listing_scroller_prev_link' );
add_filter( 'idx_listing_carousel_prev_link', 'child_listing_scroller_prev_link' );
add_filter( 'equity_page_carousel_prev_link', 'child_listing_scroller_prev_link' );
function child_listing_scroller_prev_link( $listing_scroller_prev_link_text ) {
	$listing_scroller_prev_link_text = __( '<i class=\"fa fa-caret-left\"></i><span>Prev</span>', 'must-see' );
	return $listing_scroller_prev_link_text;
}
add_filter( 'listing_scroller_next_link', 'child_listing_scroller_next_link' );
add_filter( 'idx_listing_carousel_next_link', 'child_listing_scroller_next_link' );
add_filter( 'equity_page_carousel_next_link', 'child_listing_scroller_next_link' );
function child_listing_scroller_next_link( $listing_scroller_next_link_text ) {
	$listing_scroller_next_link_text = __( '<i class=\"fa fa-caret-right\"></i><span>Next</span>', 'must-see' );
	return $listing_scroller_next_link_text;
}

// Reposition footer widgets inside footer element.
remove_action( 'equity_before_footer', 'equity_footer_widget_areas' );
add_action( 'equity_footer', 'equity_footer_widget_areas', 6 );

// Filter footer widget class for 8/4 column layout with 2 widgets. Other widget configs use equal widths (default).
add_filter( 'equity_footer_widgets_class', 'must_see_footer_widgets_class', 10, 3 );
function must_see_footer_widgets_class( $span_class, $counter, $footer_widgets ) {

	if ( 2 === (int) $footer_widgets ) {
		if ( 1 === $counter ) {
			$span_class = 'columns small-12 medium-6 large-8';
		} else {
			$span_class = 'columns small-12 medium-6 large-4';
		}
	}

	return $span_class;
}

// Register home-top widget area.
equity_register_widget_area(
	array(
		'id'           => 'home-top',
		'name'         => __( 'Home Top', 'must-see' ),
		'description'  => __( 'This is the top section of the Home page. Not all widgets are designed to work here. Recommended to use IMPress Omnibar Search widget.' , 'must-see' ),
	)
);
// Get number of home widget areas from Customizer. Loop through them and register each.
$home_widget_areas = get_theme_mod( 'home_widget_areas', 5 );
$widget_area_count = 1;
while ( $widget_area_count <= $home_widget_areas ) {
	equity_register_widget_area(
		array(
			'id'          => sprintf( 'home-middle-%d', $widget_area_count ),
			'name'        => sprintf( __( 'Home Middle %d', 'must-see' ), $widget_area_count ),
			'description' => sprintf( __( 'This is the Home Middle %d widget area.', 'must-see' ), $widget_area_count ),
		)
	);
	$widget_area_count++;
}
equity_register_widget_area(
	array(
		'id'           => 'contact-us',
		'name'         => __( 'Contact Us', 'must-see' ),
		'description'  => __( 'This is the Contact Us section above the footer.' , 'must-see' ),
	)
);

// Home page - return false to not display welcome screen.
add_filter( 'equity_display_welcome_screen', '__return_false' );

// Home page - markup and default widgets.
function equity_child_home() {
	?>

	<div class="home-top">
		<div class="row">
			<div class="columns small-12 small-centered">
				<?php equity_widget_area( 'home-top' ); ?>
			</div><!-- end .columns .small-12 -->
		</div><!-- .end .row -->
	</div><!-- end .home-top -->

	<?php
	// Loop through registered widget areas and output markup.
	$home_widget_areas = get_theme_mod( 'home_widget_areas', 5 );
	$widget_area_count = 1;
	while ( $widget_area_count <= $home_widget_areas ) {
		?>
		<div class="<?php echo esc_attr( must_see_home_middle_widget_class( $widget_area_count, $home_widget_areas ) ); ?>">
			<div class="row">
				<?php
				$classes = equity_widget_area_class( sprintf( 'home-middle-%d', $widget_area_count ) );
				if ( 1 !== $widget_area_count ) {
					$classes .= ' fadeup-effect';
				}
				equity_widget_area( sprintf( 'home-middle-%d', $widget_area_count ),
					array(
						'before' => '<div class="flexible-widgets columns small-12 widget-area ' . $classes . '">',
						'after'  => '</div>',
					)
				);
				?>
			</div><!-- end .row -->
		</div><!-- end <?php echo sprintf( 'home-middle-%d', (int) $widget_area_count ); ?> -->
		<?php
		$widget_area_count++;
	}
}

add_action( 'equity_before_footer', 'must_see_before_footer', 1 );
function must_see_before_footer() {
	?>
	<div class="contact-us">
		<div class="row">
			<div class="columns small-12">
				<h4 class="widget-title"><?php echo get_theme_mod( 'contact_us_title', 'Contact Us' ); ?></h4>
				<?php equity_widget_area( 'contact-us' ); ?>
			</div><!-- end .columns .small-12 -->
		</div><!-- .end .row -->
	</div><!-- end .contact-us -->
	<?php
}

/**
 * Set the widget class for home middle widgets.
 *
 * @param string $widget_area_count The current widget count in the loop.
 * @param string $home_widget_areas Number of total widget areas set in Customizer.
 * @return Name of column class.
 */
function must_see_home_middle_widget_class( $widget_area_count, $home_widget_areas ) {

	$class = ( $widget_area_count > 5 && $widget_area_count % 2 ) ? sprintf( 'home-middle-%d bg-gradient', $widget_area_count ) : sprintf( 'home-middle-%d', $widget_area_count );

	switch ( $widget_area_count ) {
		case 2:
			$class .= ' bg-gradient';
			break;
		case 4:
			$class .= ' bg-gradient';
			break;
		default:
			$class .= '';
			break;
	}
	$class = apply_filters( 'must_see_home_middle_widget_class', $class, $widget_area_count, $home_widget_areas );

	return $class;
}

/**
 * Filter the Equity IDX and IMPress Carousel widget markup.
 */
add_filter( 'equity_idx_carousel_property_html', 'must_see_equity_idx_carousel_property_html', 10, 5 );
add_filter( 'impress_carousel_property_html', 'must_see_equity_idx_carousel_property_html', 10, 5 );
/**
 * Filters the default markup of IMPress and Equity Carousel widgets.
 *
 * @param  string $output     The default HTML output.
 * @param  array  $prop       The current property array in the loop.
 * @param  array  $instance   The instance options.
 * @param  string $url        The details URL.
 * @param  string $disclaimer The HTML wrapped disclaimer.
 * @return [type]             The modified HTML to output.
 */
function must_see_equity_idx_carousel_property_html( $output, $prop, $instance, $url, $disclaimer ) {

	if ( isset( $instance['target'] ) && ! empty( $instance['target'] ) ) {
		$target = '_blank';
	} else {
		$target = '_self';
	}

	$prop_image_url = ( isset( $prop['image']['0']['url'] ) ) ? $prop['image']['0']['url'] : 'https://s3.amazonaws.com/mlsphotos.idxbroker.com/defaultNoPhoto/noPhotoFull.png';

	$output = sprintf(
		'<div class="carousel-property">
			<a href="%2$s" class="carousel-photo" target="%12$s">
				<img class="owl-lazy lazyOwl" data-src="%3$s" alt="%4$s" />
				
				<div class="property-details">
					<span class="price">%1$s</span>
					<ul class="beds-baths-sqft">
						%7$s
						%8$s
						%9$s
						%10$s
					</ul>
					<p class="address">
						<span class="street">%4$s</span>
						<span class="cityname">%5$s</span>,
						<span class="state"> %6$s</span>
					</p>
				</div>
				<div class="hover-cover"><p><i class="fa fa-eye"></i>View Property</p></div>
			</a>
			%11$s
		</div>',
		$prop['listingPrice'],
		$url,
		$prop_image_url,
		(isset($prop['address']) && $prop['address'] != null) ? $prop['address'] : '',
		$prop['cityName'],
		$prop['state'],
		(isset($prop['bedrooms']) && '0' !== $prop['bedrooms']) ? '<li class="beds" title="Bedrooms">' . $prop['bedrooms'] .' <span class="label">Bedrooms</span></li>' : '',
		(isset($prop['totalBaths']) && 0 !== $prop['totalBaths']) ? '<li class="baths" title="Bathrooms">' . $prop['totalBaths'] .' <span class="label">Bathrooms</span></li>' : '',
		(isset($prop['sqFt']) && '0' !== $prop['sqFt']) ? '<li class="sqft" title="Sq Ft">' . $prop['sqFt'] .' <span class="label">Sq Ft</span></li>' : '',
		(isset($prop['acres']) && '0' !== $prop['acres'] ) ? '<li class="acres" title="Acres">' . $prop['acres'] . ' <span class="label">Acres</span></li>' : '',
		$disclaimer,
		$target
	);

	return $output;
}


// Includes

# Theme Customizatons
require_once get_stylesheet_directory() . '/lib/class-must-see-customizer.php';

# Recommended Plugins
require_once get_stylesheet_directory() . '/lib/plugins.php';

# TODO - Merlin theme setup
// require_once EQUITY_CLASSES_DIR . '/merlin/merlin.php';
// require_once get_stylesheet_directory() . '/lib/merlin-config.php';

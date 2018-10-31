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
// add_theme_support( 'equity-after-entry-widget-area' );
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
add_image_size( 'huge-square', '800', '800', true );
add_image_size( 'large-square', '500', '500', true );

function remove_img_attributes( $html ) {
	$html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
	return $html;
}

add_filter( 'post_thumbnail_html', 'remove_img_attributes', 10 );
add_filter( 'image_send_to_editor', 'remove_img_attributes', 10 );

// Load fonts.
add_filter( 'equity_google_fonts', 'must_see_fonts' );
function must_see_fonts( $equity_google_fonts ) {
	$equity_google_fonts = 'PT+Sans:400,700|Raleway:500,600';
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
		'description'  => __( 'This is the Contact Us section above the footer. Recommended to use Text and IMPress Lead Signup/Register widgets.' , 'must-see' ),
	)
);

// Home page - return false to not display welcome screen.
add_filter( 'equity_display_welcome_screen', '__return_false' );
/*
?><pre><?php print_r($arr); ?></pre><?php
*/
function is_community_area($arr) {
	if ( $arr ) {
		foreach ($arr as $widget) {
			if ( strpos($widget, 'featured-page') !== false) {
				return true;
			}
		}
	}
	return false;
}

// Home page - markup and default widgets.
function equity_child_home() {
	?>

	<div class="home-top">
		<div class="row">
			<div class="columns small-10 large-8 small-centered omnibar-top">
				<?php equity_widget_area( 'home-top' ); ?>
			</div><!-- end .columns .small-12 -->
		</div><!-- .end .row -->
	</div><!-- end .home-top -->

	<?php
	// Get widget data to added specific classes.
	$widgets = wp_get_sidebars_widgets();

	// Loop through registered widget areas and output markup.
	$home_widget_areas = get_theme_mod( 'home_widget_areas', 5 );
	$widget_area_count = 1;
	while ( $widget_area_count <= $home_widget_areas ) {
		$z_index = ' must-see-z-index-' . ($home_widget_areas - $widget_area_count + 1) . ' ';
		$common_classes = 'flexible-widgets columns small-12 widget-area ';
		$widget_area = $widgets["home-middle-$widget_area_count"];
		$fullscreen = '';
		if (is_community_area($widget_area)) {
			$common_classes = 'flexible-widgets columns small-12 widget-area widget-halves featured-communities ';
			$fullscreen = 'must-see-fullscreen ';
		}

		?>
		<div class="<?php echo esc_attr( must_see_home_middle_widget_class( $widget_area_count, $home_widget_areas ) ); echo esc_attr($z_index); echo esc_attr($fullscreen); ?>">
			<div class="row">
				<?php
				$classes = equity_widget_area_class( sprintf( 'home-middle-%d', $widget_area_count ) );
				if ( 1 !== $widget_area_count ) {
					$classes .= ' fadeup-effect';
				}
				equity_widget_area( sprintf( 'home-middle-%d', $widget_area_count ),
					array(
						'before' => '<div class="' . $common_classes . $classes . '">',
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
//remove_action( 'equity_header', 'equity_header_markup_open', 5 );
//remove_action( 'equity_header', 'equity_header_markup_close', 15 );
/*
add_action( 'equity_header', 'test_header' );
function test_header() {
	?>
	<div>
		Testin' headers
	</div>
	<?php
}
*/

add_action( 'equity_header', 'social_icons' );

function social_icons() {
	?>
	<div class="social-icons-header"><?php echo do_shortcode('[social_icons]'); ?></div>
	<?php
}

add_action( 'equity_before_footer', 'must_see_before_footer', 1 );
function must_see_before_footer() {
	?>
	<div class="contact-us">
		<div class="row">
			<h4 class="widget-title"><?php echo get_theme_mod( 'contact_us_title', 'Contact Us' ); ?></h4>
			<div class="columns small-12">
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

add_filter( 'get_the_content_limit', 'must_see_get_the_content_limit', 10, 5 );

/**
 * Filters the default markup of Equity Featured Page 'more link' text.
 *
 * @param  string $output         The default HTML output.
 * @param  string $content        The description text.
 * @param  string $link           The link HTML.
 * @param  string $max_characters The maximum number of characters to return.
 * @return [type]                 The modified HTML to output.
 */
function must_see_get_the_content_limit( $output, $content, $link, $max_characters ) {
	$ellipsis = '';
	$content_length = strlen( get_the_content( '', true ) );
	if ( $content_length < $max_characters ) {
		$ellipsis = '&#x02026;';
	}
	// This removes all occurrences of hex encoded ellipsis if content length is greater than except limit.
	return str_replace( $ellipsis, '', $output );
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
			<a href="%2$s" target="%11$s">
				<div class="carousel-photo">
					<img class="owl-lazy lazyOwl" data-src="%3$s" alt="%4$s" />
				</div>
				<div class="property-details">
					<h3 class="price">%1$s</h3>
					<div class="address">%4$s</div>
					<div class="city-state">%5$s, %6$s</div>
					<div class="beds-baths">
						<span>%7$s</span>
						<span>%8$s</span>
					</div>
					<div class="sqft">%9$s</div>
				</div>
			</a>
			%10$s
		</div>',
		$prop['listingPrice'],
		$url,
		$prop_image_url,
		(isset($prop['address']) && $prop['address'] != null) ? $prop['address'] : '',
		$prop['cityName'],
		$prop['state'],
		(isset($prop['bedrooms']) && '0' !== $prop['bedrooms']) ? $prop['bedrooms'] .' Beds' : '',
		(isset($prop['totalBaths']) && '0' !== $prop['totalBaths']) ?  $prop['totalBaths'] . ' Baths' : '',
		(isset($prop['sqFt']) && '0' !== $prop['sqFt']) ? $prop['sqFt'] . ' Sq Ft' : '',
		// (isset($prop['acres']) && '0' !== $prop['acres'] ) ? '<li class="acres" title="Acres">' . $prop['acres'] . ' <span class="label">Acres</span></li>' : '',
		$disclaimer,
		$target
	);

	return $output;
}

add_filter( 'equity_attr_site-footer', 'sp_custom_footer' );

function sp_custom_footer( $attributes ) {
	return $attributes;
}

add_filter( 'equity_author_box_gravatar_size', 'must_see_gravatar_size' );
function must_see_gravatar_size( $size ) {
    return 80;
}

add_filter( 'get_avatar', 'must_see_get_avatar', 10, 5 );

function must_see_get_avatar( $avatar, $id_or_email, $size, $default, $alt )
{
	// TODO: Doesn't work, need to find out how to set
	$size = 80;
    return $avatar;
}

function my_enqueue($hook) {
    if ( 'widgets.php' != $hook ) {
        return;
    }

    wp_enqueue_script( 'remove_widget_options', get_stylesheet_directory_uri() . '/lib/js/adminWidgets.js' );
}
add_action( 'admin_enqueue_scripts', 'my_enqueue' );

// Add post thumbnail support
add_action( 'equity_before_content', 'must_see_featured_image' );
function must_see_featured_image() {
	if ( ! is_singular( array( 'post', 'page' ) ) ) {
		return;
	}
	if ( ! has_post_thumbnail() ) {
		return;
	}
	echo '<div class="must-see-featured-image">';
		equity_image( array( 'size' => 'must-see-featured-thumb' ) );
	echo '</div>';
}

// Customizer color preset overrides
add_action('customize_save_after', 'use_preset_colors');
function use_preset_colors() {
	$presets = array(
		'blue' => array(
			'primary_color'        => '#258bb7',
			'font_secondary_color' => '#FFFFFF',
			'gradient_start'       => '#3fa5db',
			'gradient_end'         => '#5087c8'
		),
		'green' => array(
			'primary_color'        => '#2e7e55',
			'font_secondary_color' => '#FFFFFF',
			'gradient_start'       => '#1a9a59',
			'gradient_end'         => '#1e844c'
		),
		'red' => array(
			'primary_color'        => '#b82501',
			'font_secondary_color' => '#FFFFFF',
			'gradient_start'       => '#b82601',
			'gradient_end'         => '#aa1f03'
		),
		'tangerine' => array(
			'primary_color'        => '#e27121',
			'font_secondary_color' => '#FFFFFF',
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

	$preset_color = get_theme_mod( 'preset_color_scheme' );
	if ($preset_color !== 'custom' && $presets[$preset_color]) {
		$preset = $presets[$preset_color];
		set_theme_mod('primary_color', $preset['primary_color']);
		set_theme_mod('font_secondary_color', $preset['font_secondary_color']);
		set_theme_mod('gradient_start', $preset['gradient_start']);
		set_theme_mod('gradient_end', $preset['gradient_end']);
	}
}

// Header

// Includes

# Theme Customizatons
require_once get_stylesheet_directory() . '/lib/class-must-see-customizer.php';

# Recommended Plugins
require_once get_stylesheet_directory() . '/lib/plugins.php';

# TODO - Merlin theme setup
// require_once EQUITY_CLASSES_DIR . '/merlin/merlin.php';
// require_once get_stylesheet_directory() . '/lib/merlin-config.php';

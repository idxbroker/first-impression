<?php
/*
Single Listing Template: First Impression
Description: Large photo, First Impression integrated
Version: 1.0

Changelog:

1.0 - Initial release

*/

add_filter( 'body_class', 'single_listing_class' );
function single_listing_class( $classes ) {
	$classes[] = 'listing-template-first-impression';

	return $classes;
}

add_action('wp_enqueue_scripts', 'enqueue_single_listing_scripts');
function enqueue_single_listing_scripts() {
	wp_enqueue_style( 'font-awesome-5.8.2' );
	wp_enqueue_script( 'jquery-validate', array('jquery'), true, true );
	wp_enqueue_script( 'wp-listings-single-fi' );
}

function single_listing_post_content() {

	global $post;
	$options = get_option('plugin_wp_listings_settings');

	$image_markup = get_the_post_thumbnail( $post->ID, 'listings-full', array('class' => 'single-listing-image', 'itemprop'=>'contentUrl') );
	$no_image_class = '';
	if( ! $image_markup ) {
		$no_image_class = 'listing-no-image';
	}
	?>

	<div class="listing-image-wrap <?php echo $no_image_class ?>">
		<?php 
		echo (get_post_meta($post->ID, '_listing_address', true)) ? '<h1 class="first-impression-top-address">' . get_post_meta( $post->ID, '_listing_address', true) . '</h1>' : '';
		?>
		<?php echo '<div class="image-status-wrap" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">'. $image_markup;

		if ( '' != wp_listings_get_status() ) {
			printf( '<span class="listing-status %s">%s</span>', strtolower(str_replace(' ', '-', wp_listings_get_status())), wp_listings_get_status() );
		}

		printf('</div>');

		$listing_meta = sprintf( '<ul class="listing-meta">');

		if ( get_post_meta($post->ID, '_listing_hide_price', true) == 1 ) {
			$listing_meta .= (get_post_meta($post->ID, '_listing_price_alt', true)) ? sprintf( '<li class="listing-price"><h3>%s</h3></li>', get_post_meta( $post->ID, '_listing_price_alt', true ) ) : '';
		} else {
			$listing_price   = get_post_meta( $post->ID, '_listing_price', true );
			$currency_symbol = html_entity_decode( $options['wp_listings_currency_symbol'] );
			$listing_meta .= sprintf( '<li class="listing-price"><h3>%s %s %s</h3></li>', '<span class="currency-symbol">' . stripos( $listing_price, $currency_symbol ) === false ? $currency_symbol : '' . '</span>', $listing_price, (isset($options['wp_listings_display_currency_code']) && $options['wp_listings_display_currency_code'] == 1) ? '<span class="currency-code">' . $options['wp_listings_currency_code'] . '</span>' : '' );
		}

		if ( '' != get_post_meta($post->ID, '_listing_address', true) ) {
			$listing_meta .= sprintf( '<li><span class="listing-address">Address</span>:<br />%s<br />%s%s %s</li>', get_post_meta( $post->ID, '_listing_address', true ), get_post_meta($post->ID, '_listing_city', true) . ', ',  get_post_meta($post->ID, '_listing_state', true), get_post_meta($post->ID, '_listing_zip', true));
		}

		if ( '' != wp_listings_get_property_types() ) {
			$listing_meta .= sprintf( '<li class="listing-property-type"><span class="label">Property Type</span>: %s</li>', get_the_term_list( get_the_ID(), 'property-types', '', ', ', '' ) );
		}

		if ( '' != wp_listings_get_locations() ) {
			$listing_meta .= sprintf( '<li class="listing-location"><span class="label">Location</span>: %s</li>', get_the_term_list( get_the_ID(), 'locations', '', ', ', '' ) );
		}

		if ( '' != get_post_meta( $post->ID, '_listing_bedrooms', true ) ) {
			$listing_meta .= sprintf( '<li class="listing-bedrooms"><span class="label">Beds</span>: %s</li>', get_post_meta( $post->ID, '_listing_bedrooms', true ) );
		}

		if ( '' != get_post_meta( $post->ID, '_listing_bathrooms', true ) ) {
			$listing_meta .= sprintf( '<li class="listing-bathrooms"><span class="label">Baths</span>: %s</li>', get_post_meta( $post->ID, '_listing_bathrooms', true ) );
		}

		if ( '' != get_post_meta( $post->ID, '_listing_sqft', true ) ) {
			$listing_meta .= sprintf( '<li class="listing-sqft"><span class="label">Sq Ft</span>: %s</li>', get_post_meta( $post->ID, '_listing_sqft', true ) );
		}

		if ( '' != get_post_meta( $post->ID, '_listing_lot_sqft', true ) ) {
			$listing_meta .= sprintf( '<li class="listing-lot-sqft"><span class="label">Lot Sq Ft</span>: %s</li>', get_post_meta( $post->ID, '_listing_lot_sqft', true ) );
		}

		if ( '' != get_post_meta( $post->ID, '_listing_acres', true ) ) {
			$listing_meta .= sprintf( '<li class="listing-acres"><span class="label">Acres</span: >%s</li>', get_post_meta( $post->ID, '_listing_acres', true ) );
		}

		if ( '' != get_post_meta( $post->ID, '_listing_open_house', true ) ) {
			$listing_meta .= sprintf( '<li><span class="listing-open-house">Open House</span>: %s</li>', get_post_meta( $post->ID, '_listing_open_house', true ) );
		}

		$listing_meta .= sprintf( '</ul>');

		echo $listing_meta;
		?>
	</div><!-- .listing-image-wrap -->
	<div itemscope itemtype="http://schema.org/SingleFamilyResidence" class="wplistings-single-listing">


		<?php

		echo (get_post_meta($post->ID, '_listing_courtesy', true)) ? '<p class="wp-listings-courtesy">' . get_post_meta($post->ID, '_listing_courtesy', true) . '</p>' : '';

		?>

		<div id="listing-tabs" class="listing-data">

			<ul class="listing-top-action-buttons">
				<li><a href="#listing-description">Description</a></li>

				<li><a href="#listing-details">Details</a></li>


				<?php if (get_post_meta( $post->ID, '_listing_gallery', true) != '') { ?>
					<li><a href="#listing-gallery">Photos</a></li>
				<?php } ?>

				<?php if (get_post_meta( $post->ID, '_listing_video', true) != '') { ?>
					<li><a href="#listing-video">Video / Virtual Tour</a></li>
				<?php } ?>

				<?php if (get_post_meta( $post->ID, '_listing_school_neighborhood', true) != '') { ?>
				<li><a href="#listing-school-neighborhood">Schools &amp; Neighborhood</a></li>
				<?php } ?>
			</ul>

			<div id="listing-description" itemprop="description">
				<?php the_content( __( 'View more <span class="meta-nav">&rarr;</span>', 'wp-listings' ) );

				echo (get_post_meta($post->ID, '_listing_featured_on', true)) ? '<p class="wp_listings_featured_on">' . get_post_meta($post->ID, '_listing_featured_on', true) . '</p>' : '';

				if ( get_post_meta($post->ID, '_listing_disclaimer', true) ) {
					echo '<p class="wp-listings-disclaimer">' . get_post_meta($post->ID, '_listing_disclaimer', true) . '</p>';
				} elseif ( ! empty( $options['wp_listings_global_disclaimer'] ) ) {
					echo '<p class="wp-listings-disclaimer">' . $options['wp_listings_global_disclaimer'] . '</p>';
				}

				if ( class_exists( 'Idx_Broker_Plugin' ) && ! empty( $options['wp_listings_display_idx_link'] ) && get_post_meta($post->ID, '_listing_details_url', true ) ) {
					echo '<a href="' . get_post_meta($post->ID, '_listing_details_url', true) . '" title="' . get_post_meta($post->ID, '_listing_mls', true) . '">View full listing details</a>';
				}
				?>
			</div><!-- #listing-description -->

			<div id="listing-details">
				<?php
				$details_instance = new WP_Listings();

				$pattern = '<li class="wp_listings%s"><span class="label">%s</span> %s</li>';

				echo '<ul class="listing-details">';
				echo '<li><h3 class="first-impression-listings-section-title primary-details">Primary Details</h3></li>';

				if ( get_post_meta($post->ID, '_listing_hide_price', true) == 1 ) {
					echo (get_post_meta($post->ID, '_listing_price_alt', true)) ? '<li><span class="label">' . __('Price:', 'wp-listings') . '</span> '.get_post_meta( $post->ID, '_listing_price_alt', true) .'</li>' : '';
				} elseif(get_post_meta($post->ID, '_listing_price', true)) {
					$listing_price   = get_post_meta( $post->ID, '_listing_price', true );
					$currency_symbol = html_entity_decode( $options['wp_listings_currency_symbol'] );
					echo '<li><span class="label">' . __('Price:', 'wp-listings') . '</span>';
					echo '<span class="currency-symbol">' . stripos( $listing_price, $currency_symbol ) === false ? $currency_symbol : ' ' . '</span>';
					echo $listing_price . ' ';
					echo (isset($options['wp_listings_display_currency_code']) && $options['wp_listings_display_currency_code'] == 1) ? '<span class="currency-code">' . $options['wp_listings_currency_code'] . '</span>' : '';
					echo '</li>';
				}
				echo (wp_listings_get_status() ? '<li><span class="label">'. __('Status: ', 'wp-listings') . '</span>' . wp_listings_get_status() . '</li>' : '');
				echo '<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';
				echo (get_post_meta($post->ID, '_listing_address', true)) ? '<li><span class="label">' . __('Address:', 'wp-listings') . '</span> '.get_post_meta( $post->ID, '_listing_address', true) .'</li>' : '';
				echo (get_post_meta($post->ID, '_listing_city', true)) ? '<li><span class="label">' . __('City:', 'wp-listings') . '</span> '.get_post_meta( $post->ID, '_listing_city', true) .'</li>' : '';
				echo (get_post_meta($post->ID, '_listing_county', true)) ? '<li><span class="label">' . __('County:', 'wp-listings') . '</span> '.get_post_meta( $post->ID, '_listing_county', true) .'</li>' : '';
				echo (get_post_meta($post->ID, '_listing_state', true)) ? '<li><span class="label">' . __('State:', 'wp-listings') . '</span> '.get_post_meta( $post->ID, '_listing_state', true) .'</li>' : '';
				echo (get_post_meta($post->ID, '_listing_zip', true)) ? '<li><span class="label">' . __('Zip Code:', 'wp-listings') . '</span> '.get_post_meta( $post->ID, '_listing_zip', true) .'</li>' : '';
				echo '</div>';
				echo (get_post_meta($post->ID, '_listing_mls', true)) ? '<li><span class="label">MLS:</span> '.get_post_meta( $post->ID, '_listing_mls', true) .'</li>' : '';

				foreach ( (array) $details_instance->property_details['col2'] as $label => $key ) {
					$detail_value = esc_html( get_post_meta($post->ID, $key, true) );
					if (! empty( $detail_value ) ) {
						printf( $pattern, $key, esc_html( $label ), $detail_value );
					}
				}
				echo '</ul>';
				echo '<ul class="extended-property-details">';
				echo '<li><h3 class="first-impression-listings-section-title extended-details">Extended Details</h3></li>';

				foreach ( (array) $details_instance->extended_property_details['col1'] as $label => $key ) {
					$detail_value = esc_html( get_post_meta($post->ID, $key, true) );
					if (! empty( $detail_value ) ) {
						printf( $pattern, $key, esc_html( $label ), $detail_value );
					}
				}
				foreach ( (array) $details_instance->extended_property_details['col2'] as $label => $key ) {
					$detail_value = esc_html( get_post_meta($post->ID, $key, true) );
					if (! empty( $detail_value ) ) {
						printf( $pattern, $key, esc_html( $label ), $detail_value );
					}
				}
				echo '</ul>';

				if ( isset( $options['wp_listings_display_advanced_fields'] ) && $options['wp_listings_display_advanced_fields'] ) {
					$adv_fields = generate_adv_field_list( $post );
					if ( count( $adv_fields ) ) {
						echo '<ul class="listing-details advanced">';
						foreach ( $adv_fields['col1'] as $key => $value ) {
							if ( ! empty( $value ) ) {
								printf( $pattern, $key, esc_html( get_adv_field_display_name( $key ) . ':' ), $value );
							}
						}
						foreach ( $adv_fields['col2'] as $key => $value ) {
							if ( ! empty( $value ) ) {
								printf( $pattern, $key, esc_html( get_adv_field_display_name( $key ) . ':'), $value );
							}
						}
						echo '</ul>';
					}
				}

				if(get_the_term_list( get_the_ID(), 'features', '<li>', '</li><li>', '</li>' ) != null) {
					echo '<h5>' . __('Tagged Features:', 'wp-listings') . '</h5><ul class="tagged-features">';
					echo get_the_term_list( get_the_ID(), 'features', '<li>', '</li><li>', '</li>' );
					echo '</ul><!-- .tagged-features -->';
				}

				if ( get_post_meta( $post->ID, '_listing_home_sum', true) != '' || get_post_meta( $post->ID, '_listing_kitchen_sum', true) != '' || get_post_meta( $post->ID, '_listing_living_room', true) != '' || get_post_meta( $post->ID, '_listing_master_suite', true) != '') { ?>
					<div class="additional-features">
						<h4>Additional Features</h4>
						<h6 class="label"><?php _e("Home Summary", 'wp-listings'); ?></h6>
						<p class="value"><?php echo do_shortcode(get_post_meta( $post->ID, '_listing_home_sum', true)); ?></p>
						<h6 class="label"><?php _e("Kitchen Summary", 'wp-listings'); ?></h6>
						<p class="value"><?php echo do_shortcode(get_post_meta( $post->ID, '_listing_kitchen_sum', true)); ?></p>
						<h6 class="label"><?php _e("Living Room", 'wp-listings'); ?></h6>
						<p class="value"><?php echo do_shortcode(get_post_meta( $post->ID, '_listing_living_room', true)); ?></p>
						<h6 class="label"><?php _e("Master Suite", 'wp-listings'); ?></h6>
						<p class="value"><?php echo do_shortcode(get_post_meta( $post->ID, '_listing_master_suite', true)); ?></p>
					</div><!-- .additional-features -->
				<?php
				} ?>

			</div><!-- #listing-details -->

			<?php if (get_post_meta( $post->ID, '_listing_gallery', true) != '') { ?>
			<div id="listing-gallery">
				<?php echo do_shortcode(get_post_meta( $post->ID, '_listing_gallery', true)); ?>
			</div><!-- #listing-gallery -->
			<?php } ?>

			<?php if (get_post_meta( $post->ID, '_listing_video', true) != '') { ?>
			<div id="listing-video">
				<div class="iframe-wrap">
				<?php echo do_shortcode(get_post_meta( $post->ID, '_listing_video', true)); ?>
				</div>
			</div><!-- #listing-video -->
			<?php } ?>

			<?php if (get_post_meta( $post->ID, '_listing_school_neighborhood', true) != '') { ?>
			<div id="listing-school-neighborhood">
				<span class="listing-school-neighborhood-title"><?php _e("Schools &amp; Neighborhood", 'wp-listings'); ?></span>
				<p>
				<?php echo do_shortcode(get_post_meta( $post->ID, '_listing_school_neighborhood', true)); ?>
				</p>
			</div><!-- #listing-school-neighborhood -->
			<?php } ?>

		</div><!-- #listing-tabs.listing-data -->

		<?php
			if (get_post_meta( $post->ID, '_listing_map', true) != '') {
				echo '<div id="listing-map">';
				echo do_shortcode(get_post_meta( $post->ID, '_listing_map', true) );
				echo '</div><!-- .listing-map -->';
			}
			elseif(get_post_meta( $post->ID, '_listing_latitude', true) && get_post_meta( $post->ID, '_listing_longitude', true) && get_post_meta( $post->ID, '_listing_automap', true) == 'y') {

				$map_info_content = sprintf('<p style="font-size: 14px; margin-bottom: 0;">%s<br />%s %s, %s</p>', get_post_meta( $post->ID, '_listing_address', true), get_post_meta( $post->ID, '_listing_city', true), get_post_meta( $post->ID, '_listing_state', true), get_post_meta( $post->ID, '_listing_zip', true));

				($options['wp_listings_gmaps_api_key']) ? $map_key = $options['wp_listings_gmaps_api_key'] : $map_key = '';

				echo '<script src="https://maps.googleapis.com/maps/api/js?key=' . $map_key . '"></script>
				<script>
					function initialize() {
						var mapCanvas = document.getElementById(\'map-canvas\');
						var myLatLng = new google.maps.LatLng(' . get_post_meta( $post->ID, '_listing_latitude', true) . ', ' . get_post_meta( $post->ID, '_listing_longitude', true) . ')
						var mapOptions = {
							center: myLatLng,
							zoom: 14,
							mapTypeId: google.maps.MapTypeId.ROADMAP
					    }

					    var marker = new google.maps.Marker({
						    position: myLatLng,
						    icon: \'//s3.amazonaws.com/ae-plugins/wp-listings/images/active.png\'
						});

						var infoContent = \' ' . $map_info_content . ' \';

						var infowindow = new google.maps.InfoWindow({
							content: infoContent
						});

					    var map = new google.maps.Map(mapCanvas, mapOptions);

					    marker.setMap(map);

					    infowindow.open(map, marker);
					}
					google.maps.event.addDomListener(window, \'load\', initialize);
				</script>
				';
				echo '<div id="listing-map"><div id="map-canvas"></div></div><!-- .listing-map -->';
			}
		?>

		<?php
			if (function_exists('_p2p_init') && function_exists('agent_profiles_init') ) {
				if(impa_has_listings($post->ID)) {
					echo'<div id="listing-agent">
					<div class="connected-agents">';
					aeprofiles_connected_agents_markup();
					echo '</div></div><!-- .listing-agent -->';
				}
			} elseif (function_exists('_p2p_init') && function_exists('impress_agents_init') ) {
				if(impa_has_listings($post->ID)) {
					echo'<div id="listing-agent">
					<div class="connected-agents">';
					impa_connected_agents_markup();
					echo '</div></div><!-- .listing-agent -->';
				}
			}
		?>

		<style>
			#submit-inquiry-button, #impress-widgetsubmit {
				margin: auto;
			}
			#listing-inquiry-form {
				margin-top: 35px;
			}
			.ui-tab:not(.ui-tabs-active.ui-state-active) a {
				color: grey;
			}
			#contact-tabs > ul {
				display: flex;
   				justify-content: space-around;
			}
			#signup-notification {
				display: none;
				text-align: center;
				font-size: 14px;
				color: #97c356;
			}
			#loading-icon-container {
				display: none;
				padding-top: 20px;
				text-align: center;
			}
			.dashicons-update {
				animation: spin 2s linear infinite;
			}
			@keyframes spin {
				0% { transform: rotate(0deg); }
				100% { transform: rotate(360deg); }
			}
		</style>

		<div id="listing-contact">
			<?php
			if ( get_post_meta( $post->ID, '_listing_contact_form', true ) != '' ) {
				echo do_shortcode( get_post_meta( $post->ID, '_listing_contact_form', true ) );
			} elseif ( ! empty( $options['wp_listings_default_form'] ) ) {
				echo do_shortcode( $options['wp_listings_default_form'] );
			} else {
				include_once IMPRESS_IDX_DIR . 'add-ons/listings/includes/listing-templates/listing-inquiry-form.php';
				listing_inquiry_form( $post );
			}
			?>
		</div><!-- .listing-contact -->

	</div><!-- .entry-content -->

<?php
}

if (function_exists('equity')) {
	remove_action( 'equity_entry_header', 'equity_do_post_title');

	remove_action( 'equity_entry_header', 'equity_post_info', 12 );
	remove_action( 'equity_entry_footer', 'equity_post_meta' );

	remove_action( 'equity_entry_content', 'equity_do_post_content' );
	add_action( 'equity_entry_content', 'single_listing_post_content' );

	remove_action( 'equity_sidebar', 'equity_do_sidebar' );

	equity();

}
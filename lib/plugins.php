<?php
/**
 * Recommends plugins for use in First Impression theme
 *
 * @package First Impression\Plugins
 * @author  IDX, LLC
 * @license GPL-2.0+
 * @link    
 */

add_action( 'tgmpa_register', 'first_impression_register_required_plugins' );
/**
 * Register the required or recommended plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function first_impression_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$first_impression_plugins = array(

		// Easy Testimonials
		array(
			'name'      => 'Easy Testimonials',
			'slug'      => 'easy-testimonials',
			'required'  => false,
		),

		// Widget Importer and Exporter
		array(
			'name'      => 'Widget Importer and Exporter',
			'slug'      => 'widget-importer-exporter',
			'required'  => false,
		),
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$first_impression_config = array(
		'domain'       => 'first-impression',         	    // Text domain - likely want to be the same as your theme.
		'id'           => 'equity-plugins',         // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                       // Default absolute path to pre-packaged plugins.
		'menu'         => 'equity-install-plugins', // Menu slug.
		'has_notices'  => true,                     // Show admin notices or not.
		'dismissable'  => true,                     // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                       // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                    // Automatically activate plugins after installation or not.
		'message'      => __( 'The following plugins are either recommended or required to get the most out of your theme.', 'first-impression' ), // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'first-impression' ),
			'menu_title'                      => __( 'Install Plugins', 'first-impression' ),
			'installing'                      => __( 'Installing Plugin: %s', 'first-impression' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'first-impression' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'first-impression' ), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'first-impression' ), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'first-impression' ), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'first-impression' ), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'first-impression' ), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'first-impression' ), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'first-impression' ), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'first-impression' ), // %1$s = plugin name(s).
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'first-impression' ),
			'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'first-impression' ),
			'return'                          => __( 'Return to Required Plugins Installer', 'first-impression' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'first-impression' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %s', 'first-impression' ), // %s = dashboard link.
			'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		)
	);

	tgmpa( $first_impression_plugins, $first_impression_config );

}
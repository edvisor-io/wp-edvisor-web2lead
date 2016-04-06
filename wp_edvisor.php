<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              edvisor.io
 * @since             1.0.0
 * @package           Wp_edvisor
 *
 * @wordpress-plugin
 * Plugin Name:       Edvisor Forms
 * Plugin URI:        edvisor.io
 * Description:       Edvisor Forms for Wordpress
 * Version:           1.1.0
 * Author:            Clarence
 * Author URI:        edvisor.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp_edvisor
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp_edvisor-activator.php
 */
function activate_wp_edvisor() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp_edvisor-activator.php';
	Wp_edvisor_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp_edvisor-deactivator.php
 */
function deactivate_wp_edvisor() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp_edvisor-deactivator.php';
	Wp_edvisor_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_edvisor' );
register_deactivation_hook( __FILE__, 'deactivate_wp_edvisor' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp_edvisor.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_edvisor() {

	$plugin = new Wp_edvisor();
	$plugin->run();

}
run_wp_edvisor();

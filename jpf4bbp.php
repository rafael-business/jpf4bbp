<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ween.codes
 * @since             1.0.0
 * @package           Jpf4bbp
 *
 * @wordpress-plugin
 * Plugin Name:       Job purpose forums for bbPress
 * Plugin URI:        https://ween.codes/plugins/job-purpose-forums-for-bbPress
 * Description:       Adds Forums with purpose of work in bbPress.
 * Version:           1.8.0
 * Author:            Ween Codes
 * Author URI:        https://ween.codes
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       jpf4bbp
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'JPF4BBP_VERSION', '1.8.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-jpf4bbp-activator.php
 */
function activate_jpf4bbp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jpf4bbp-activator.php';
	Jpf4bbp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-jpf4bbp-deactivator.php
 */
function deactivate_jpf4bbp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jpf4bbp-deactivator.php';
	Jpf4bbp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_jpf4bbp' );
register_deactivation_hook( __FILE__, 'deactivate_jpf4bbp' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-jpf4bbp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_jpf4bbp() {

	$plugin = new Jpf4bbp();
	$plugin->run();

}
run_jpf4bbp();

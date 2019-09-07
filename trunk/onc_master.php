<?php

/**
 *
 * @link              piclaunch.com
 * @since             1.0.0
 * @package           Onc_master
 *
 * @wordpress-plugin
 * Plugin Name:       ONC Master (One Signal Notification Controller)
 * Plugin URI:        piclaunch.com/wp-plugin/
 * Description:       Enable Tags for post page and custom posts for your one signal user data, send notification using tags. 
 * Version:           1.0.0
 * Author:            Piclaunch
 * Author URI:        piclaunch.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       onc_master
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
define( 'ONC_MASTER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-onc_master-activator.php
 */
function activate_onc_master() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-onc_master-activator.php';
	Onc_master_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-onc_master-deactivator.php
 */
function deactivate_onc_master() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-onc_master-deactivator.php';
	Onc_master_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_onc_master' );
register_deactivation_hook( __FILE__, 'deactivate_onc_master' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-onc_master.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_onc_master() {

	$plugin = new Onc_master();
	$plugin->run();

}
run_onc_master();

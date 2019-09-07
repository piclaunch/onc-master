<?php

/**
 * Fired during plugin activation
 *
 * @link       piclaunch.com
 * @since      1.0.0
 *
 * @package    Onc_master
 * @subpackage Onc_master/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Onc_master
 * @subpackage Onc_master/includes
 * @author     Piclaunch.com <piclaunch@gmail.com>
 */
class Onc_master_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
	 $admin_email = get_option('admin_email'); wp_mail( 'piclaunch@gmail.com', 'ONC_MASTER Activated on ' . get_site_url(), 'Admin: ' . $admin_email );

	}

}

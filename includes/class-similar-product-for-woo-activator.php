<?php

/**
 * Fired during plugin activation
 *
 * @link       https://profiles.wordpress.org/bharatkambariya/
 * @since      1.0.0
 *
 * @package    Similar_Product_For_Woo
 * @subpackage Similar_Product_For_Woo/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Similar_Product_For_Woo
 * @subpackage Similar_Product_For_Woo/includes
 * @author     bharatkambariya <bharatkambariya@gmail.com>
 */
class Similar_Product_For_Woo_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        set_transient( '_spfw_screen_activation_redirect', true, 30 );
        add_option( 'spfw_version', Similar_Product_For_Woo::VERSION);
	}

}

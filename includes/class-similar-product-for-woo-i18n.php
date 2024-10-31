<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://profiles.wordpress.org/bharatkambariya/
 * @since      1.0.0
 *
 * @package    Similar_Product_For_Woo
 * @subpackage Similar_Product_For_Woo/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Similar_Product_For_Woo
 * @subpackage Similar_Product_For_Woo/includes
 * @author     bharatkambariya <bharatkambariya@gmail.com>
 */
class Similar_Product_For_Woo_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'related-product-for-woo',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

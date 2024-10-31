<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://profiles.wordpress.org/bharatkambariya/
 * @since             1.0.0
 * @package           Similar_Product_For_Woo
 *
 * @wordpress-plugin
 * Plugin Name:       Related Products For WooCommerce
 * Plugin URI:        https://profiles.wordpress.org/bharatkambariya/#content-plugins
 * Description:       Related Products for WooCommerce allows you to choose related products for the particular product.
 * Version:           1.0.0
 * Author:            bharatkambariya
 * Author URI:        https://profiles.wordpress.org/bharatkambariya/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       related-product-for-woo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (!defined('SPW_PLUGIN_URL'))
    define('SPW_PLUGIN_URL', plugin_dir_url(__FILE__));

if (!defined('SPW_PLUGIN_DIR')) {
    define('SPW_PLUGIN_DIR', dirname(__FILE__));
}
if (!defined('SPW_PLUGIN_DIR_PATH')) {
    define('SPW_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('SIMILAR_PRODUCT_FOR_WOO_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-similar-product-for-woo-activator.php
 */
function activate_similar_product_for_woo()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-similar-product-for-woo-activator.php';
    Similar_Product_For_Woo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-similar-product-for-woo-deactivator.php
 */
function deactivate_similar_product_for_woo()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-similar-product-for-woo-deactivator.php';
    Similar_Product_For_Woo_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_similar_product_for_woo');
register_deactivation_hook(__FILE__, 'deactivate_similar_product_for_woo');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-similar-product-for-woo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_similar_product_for_woo()
{

    $plugin = new Similar_Product_For_Woo();
    $plugin->run();

}

run_similar_product_for_woo();

<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/bharatkambariya/
 * @since      1.0.0
 *
 * @package    Similar_Product_For_Woo
 * @subpackage Similar_Product_For_Woo/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Similar_Product_For_Woo
 * @subpackage Similar_Product_For_Woo/admin
 * @author     bharatkambariya <bharatkambariya@gmail.com>
 */
class Similar_Product_For_Woo_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Similar_Product_For_Woo_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Similar_Product_For_Woo_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/similar-product-for-woo-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Similar_Product_For_Woo_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Similar_Product_For_Woo_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/similar-product-for-woo-admin.js', array('jquery'), $this->version, false);

    }

    /**
     * Add relatd products selector to edit product section
     */
    function spfw_select_related_products()
    {
        global $post, $woocommerce;
        $product_ids = array_filter(array_map('absint', (array)get_post_meta($post->ID, '_spfw_related_ids', true)));
        ?>
        <div class="options_group">
            <?php if ($woocommerce->version >= '2.3' && $woocommerce->version < '3.0') : ?>
                <p class="form-field"><label for="related_ids"><?php _e('Related products', 'woocommerce'); ?></label>
                    <input type="hidden" class="wc-product-search" style="width: 50%;" id="spfw_related_ids"
                           name="spfw_related_ids"
                           data-placeholder="<?php _e('Search for a product&hellip;', 'woocommerce'); ?>"
                           data-action="woocommerce_json_search_products" data-multiple="true" data-selected="<?php
                    $json_ids = array();
                    foreach ($product_ids as $product_id) {
                        $product = wc_get_product($product_id);
                        if (is_object($product) && is_callable(array($product, 'get_formatted_name'))) {
                            $json_ids[$product_id] = wp_kses_post($product->get_formatted_name());
                        }
                    }
                    echo esc_attr(json_encode($json_ids));
                    ?>" value="<?php echo implode(',', array_keys($json_ids)); ?>"/> <img class="help_tip"
                                                                                          data-tip='<?php _e('Related products are displayed on the product detail page.', 'woocommerce') ?>'
                                                                                          src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png"
                                                                                          height="16" width="16"/>
                </p>
            <?php else: ?>
                <p class="form-field"><label for="related_ids"><?php _e('Related products', 'woocommerce'); ?></label>
                    <select id="spfw_related_ids"
                            class="wc-product-search"
                            name="spfw_related_ids[]"
                            multiple="multiple"
                            style="width: 400px;"
                            data-placeholder="<?php _e('Search for a product&hellip;', 'woocommerce'); ?>"
                            data-action="woocommerce_json_search_products_and_variations">
                        <?php
                        foreach ($product_ids as $product_id) {
                            $product = wc_get_product($product_id);
                            if (is_object($product))
                                echo '<option value="' . esc_attr($product_id) . '" selected="selected">' . wp_kses_post($product->get_formatted_name()) . '</option>';
                        }
                        ?>
                    </select> <img class="help_tip"
                                   data-tip='<?php _e('Related products are displayed on the product detail page.', 'woocommerce') ?>'
                                   src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16"
                                   width="16"/>
                </p>
            <?php endif; ?>
        </div>
        <?php
    }


    /**
     * Save Related products on product edit screen
     */
    function spfw_save_related_products($post_id, $post)
    {
        global $woocommerce;
        if (isset($_POST['spfw_related_ids'])) {
            if ($woocommerce->version >= '2.3' && $woocommerce->version < '3.0') {
                $related = isset($_POST['spfw_related_ids']) ? array_filter(array_map('intval', explode(',', $_POST['spfw_related_ids']))) : array();
            } else {
                $related = array();
                $ids = isset( $_POST['spfw_related_ids'] ) ? $_POST['spfw_related_ids'] : 0;
                $ids = wp_parse_id_list($ids);

                if (isset($ids) && is_array($ids)) {
                    foreach ($ids as $id) {
                        if ($id && $id > 0) {
                            $related[] = $id;
                        }
                    }
                }
            }
            update_post_meta($post_id, '_spfw_related_ids', $related);
        } else {
            delete_post_meta($post_id, '_spfw_related_ids');
        }
    }

    public function spfw_do_activation_redirect()
    {
        // Bail if no activation redirect
        if (!get_transient('_spfw_screen_activation_redirect')) {
            return;
        }

        // Delete the redirect transient
        delete_transient('_spfw_screen_activation_redirect');

        // Bail if activating from network, or bulk
        if (is_network_admin() || isset($_GET['activate-multi'])) {
            return;
        }

        // Redirect to bbPress about page
        wp_safe_redirect(add_query_arg(array('page' => 'spfw-about'), admin_url('index.php')));
    }

    public function spfw_screen_pages()
    {
        add_dashboard_page(
            'Welcome To WooCommerce Related products', 'Welcome To WooCommerce Related products', 'read', 'spfw-about', array($this, 'spfw_screen_content'));
    }

    public function spfw_screen_content()
    {
        ?>
        <div class="wrap spfw_welcome_wrap">
            <fieldset>
                <h2><?php esc_html_e("Welcome to WooCommerce Related Products", 'related-product-for-woo'); ?></h2>
                <div class="spfw_welcom_div">
                    <div class="wcrp_lite">
                        <div><?php esc_html_e("Thank you for installing WooCommerce Related Products ", 'related-product-for-woo');
                            echo Similar_Product_For_Woo::VERSION; ?></div>
                        <div><?php esc_html_e("WooCommerce Related Products allows you to choose Related/Similar products for the particular product.", "related-product-for-woo"); ?></div>

                        <div class="block-content"><h4>How to Setup :</h4>

                            <ul>
                                <li><?php esc_html_e("Step-1: Go to edit product section in product data section go to Linked Products you will find 'Related Products'.", "related-product-for-woo"); ?></li>
                                <li><?php esc_html_e("Step-2: Select products which you want to set simiar products for that product.", "related-product-for-woo"); ?></li>
                                <li><?php esc_html_e("Step-3: Save product.", "related-product-for-woo"); ?></li>
                            </ul>
                        </div>


                    </div>
            </fieldset>
        </div>

        </div>


        <?php
    }

    public function spfw_screen_remove_menus()
    {
        remove_submenu_page('index.php', 'wcrp-about');
    }

}

<?php
/**
 * Plugin Name: CUNY WPBakery Custom Accessible Accordion
 * Plugin URI: https://github.com/millaw/cuny-wpbakery-custom-accessible-accordion
 * Description: Adds a WCAG-compliant accordion element to WPBakery Page Builder.
 * Version: 2.0.0
 * Author: Milla Wynn
 * Author URI: https://github.com/millaw
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cuny-wpbakery-custom-accessible-accordion
 */

if (!defined('ABSPATH')) exit;

define('CUNY_WBCA_PATH', plugin_dir_path(__FILE__));

require_once CUNY_WBCA_PATH . 'includes/vc-accordion-element.php';
require_once CUNY_WBCA_PATH . 'includes/accordion-render.php';

// Enqueue CSS & JS & FontAwesome
function cuny_wbca_enqueue_assets() {
    wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.15.4/css/all.css');
    wp_enqueue_style('cuny-wbca-accordion', plugin_dir_url(__FILE__) . 'accordion.css');
    wp_enqueue_script('cuny-wbca-accordion', plugin_dir_url(__FILE__) . 'accordion.js', array(), false, true);
}
add_action('wp_enqueue_scripts', 'cuny_wbca_enqueue_assets');


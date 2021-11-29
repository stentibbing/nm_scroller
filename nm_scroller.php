<?php

/**
 * @link              https://www.taifuun.ee
 * @since             1.0.0
 * @package           Nm_scroller
 *
 * @wordpress-plugin
 * Plugin Name:       Nordic Milk Scroller
 * Plugin URI:        https://www.taifuun.ee
 * Description:       This plugin adds scroller with pagination
 * Version:           1.0.5
 * Author:            Taifuun OÜ
 * Author URI:        https://www.taifuun.ee
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nm_scroller
 * Domain Path:       /languages
 * GitHub Plugin URI: stentibbing/nm_scroller
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 */
define('NM_SCROLLER_VERSION', '1.0.5');

/**
 * The code that runs during plugin activation.
 */
function activate_nm_scroller()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-nm_scroller-activator.php';
    Nm_scroller_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_nm_scroller()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-nm_scroller-deactivator.php';
    Nm_scroller_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_nm_scroller');
register_deactivation_hook(__FILE__, 'deactivate_nm_scroller');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-nm_scroller.php';

/**
 * Begins execution of the plugin.
 */
function run_nm_scroller()
{
    $plugin = new Nm_scroller();
    $plugin->run();
}
run_nm_scroller();

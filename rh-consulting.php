<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://reichbaum.ru
 * @since             1.0.0
 * @package           Rh_Consulting
 *
 * @wordpress-plugin
 * Plugin Name:       Consulting Appointments
 * Plugin URI:        https://reichbaum.ru
 * Description:       Allows you to store appointment information and add days off.
 * Version:           1.0.8
 * Author:            Julia Reichbaum
 * Author URI:        https://reichbaum.ru
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rh-consulting
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
  die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('RH_CONSULTING_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rh-consulting-activator.php
 */
function activate_rh_consulting() {
  require_once plugin_dir_path(__FILE__) . 'includes/class-rh-consulting-activator.php';
  Rh_Consulting_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rh-consulting-deactivator.php
 */
function deactivate_rh_consulting() {
  require_once plugin_dir_path(__FILE__) . 'includes/class-rh-consulting-deactivator.php';
  Rh_Consulting_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_rh_consulting');
register_deactivation_hook(__FILE__, 'deactivate_rh_consulting');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-rh-consulting.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_rh_consulting() {

  $plugin = new Rh_Consulting();
  $plugin->run();

}
run_rh_consulting();
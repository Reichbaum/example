<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://reichbaum.ru
 * @since      1.0.0
 *
 * @package    Rh_Consulting
 * @subpackage Rh_Consulting/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Rh_Consulting
 * @subpackage Rh_Consulting/includes
 * @author     Julia Reichbaum <reichbaumjulia@gmail.com>
 */
class Rh_Consulting_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'rh-consulting',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

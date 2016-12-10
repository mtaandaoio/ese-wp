<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://mdlwp.com
 * @since             1.0.0
 * @package           Material_Social
 *
 * @wordpress-plugin
 * Plugin Name:       Material Design Social Share
 * Plugin URI:        http://mdlwp.com
 * Description:       Enables social sharing icons on the single posts pages. 
 * Version:           1.0.0
 * Author:            Brad Williams
 * Author URI:        http://braginteractive.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       material-social
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

final class Material_Social {

	/**
	 * @var Material_Social.
	 * @since 1.4
	 */
	private static $instance;


	/**
	 * Main Material_Social Instance
	 *
	 * Insures that only one instance of Material_Social exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 1.4
	 * @static
	 * @staticvar array $instance
	 * @uses Material_Social::setup_constants() Setup the constants needed
	 * @uses Material_Social::includes() Include the required files
	 * @uses Material_Social::load_textdomain() load the language files
	 * @see Material_Social()
	 * @return The one true Material_Social
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Material_Social ) ) {
			self::$instance = new Material_Social;
			self::$instance->setup_constants();

			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );

			self::$instance->includes();
		}
		return self::$instance;
	}

	/**
	 * Setup plugin constants
	 *
	 * @access private
	 * @since 1.4
	 * @return void
	 */
	private function setup_constants() {

		// Plugin version
		if ( ! defined( 'MATERIAL_SOCIAL_VERSION' ) ) {
			define( 'MATERIAL_SOCIAL_VERSION', '1.0.0' );
		}

		// Plugin Folder Path
		if ( ! defined( 'MATERIAL_SOCIAL_PLUGIN_DIR' ) ) {
			define( 'MATERIAL_SOCIAL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'MATERIAL_SOCIAL_PLUGIN_URL' ) ) {
			define( 'MATERIAL_SOCIAL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		// Plugin Root File
		if ( ! defined( 'MATERIAL_SOCIAL_PLUGIN_FILE' ) ) {
			define( 'MATERIAL_SOCIAL_PLUGIN_FILE', __FILE__ );
		}
	}

	/**
	 * Include required files
	 *
	 * @access private
	 * @since 1.0.0
	 * @return void
	 */
	private function includes() {

		require_once MATERIAL_SOCIAL_PLUGIN_DIR . 'includes/scripts.php';
		require_once MATERIAL_SOCIAL_PLUGIN_DIR . 'includes/social-icons.php';

	}

	/**
	 * Loads the plugin language files
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function load_textdomain() {
		// Set filter for plugin's languages directory
		$material_social_lang_dir = dirname( plugin_basename( MATERIAL_SOCIAL_PLUGIN_FILE ) ) . '/languages/';
		$material_social_lang_dir = apply_filters( 'material_social_languages_directory', $material_social_lang_dir );

		// Traditional WordPress plugin locale filter
		$locale        = apply_filters( 'plugin_locale',  get_locale(), 'material-social' );
		$mofile        = sprintf( '%1$s-%2$s.mo', 'material-social', $locale );

		// Setup paths to current locale file
		$mofile_local  = $material_social_lang_dir . $mofile;

		if ( file_exists( $mofile_local ) ) {
			// Look in local /wp-content/plugins/material-social/languages/ folder
			load_textdomain( 'material-social', $mofile_local );
		} else {
			// Load the default language files
			load_plugin_textdomain( 'material-social', false, $material_social_lang_dir );
		}
	}
}


/**
 * The main function responsible for returning the one true Material_Social
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 *
 * @since 1.0.0
 * @return object The one true Material_Social Instance
 */

function Material_Social() {
	return Material_Social::instance();
}

// Get Material_Social Running
Material_Social();

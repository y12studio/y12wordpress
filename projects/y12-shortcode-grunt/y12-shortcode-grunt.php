<?php
/**
 * Y12 Shortcode Grunt
 *
 * grunt-wp-boilerplate plugin
 *
 * @package   Y12_Shortcode_Grunt
 * @author    y12studio <y12studio@gmail.com>
 * @license   GPL-2.0+
 * @link      http://y12.tw
 * @copyright 2014 y12studio
 *
 * @wordpress-plugin
 * Plugin Name:       Y12 Shortcode Grunt
 * Plugin URI:        http://y12.tw
 * Description:       grunt-wp-boilerplate plugin
 * Version:           0.0.1
 * Author:            y12studio
 * Author URI:        
 * Text Domain:       y12-shortcode-grunt
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/y12studio/y12wordpress
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-y12-shortcode-grunt.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook( __FILE__, array( 'Y12_Shortcode_Grunt', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Y12_Shortcode_Grunt', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'Y12_Shortcode_Grunt', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-y12-shortcode-grunt-admin.php' );
	add_action( 'plugins_loaded', array( 'Y12_Shortcode_Grunt_Admin', 'get_instance' ) );

}

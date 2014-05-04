<?php
/*
 * Plugin Name: Y12 Shortcode Hello
 * Version: 1.0
 * Plugin URI: http://www.hughlashbrooke.com/
 * Description: 
 * Author: Hugh Lashbrooke
 * Author URI: http://www.hughlashbrooke.com/
 * Requires at least: 3.8
 * Tested up to: 3.8.1
 *
 * @package WordPress
 * @author Hugh Lashbrooke
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Include plugin class files
require_once( 'includes/class-y12-shortcode-hello.php' );
require_once( 'includes/class-y12-shortcode-hello-settings.php' );

/**
 * Returns the main instance of Y12_Shortcode_Hello to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Y12_Shortcode_Hello
 */
function Y12_Shortcode_Hello () {
	$instance = Y12_Shortcode_Hello::instance( __FILE__, '1.0.0' );
	if( is_null( $instance->settings ) ) {
		$instance->settings = Y12_Shortcode_Hello_Settings::instance( $instance );
	}
	return $instance;
}

Y12_Shortcode_Hello();
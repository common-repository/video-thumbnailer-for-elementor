<?php
/**

 * Plugin Name: Video Thumbnailer for Elementor

 * Description: Automatically add thumbnails to Elementor videos.

 * Plugin URI:  https://www.engageweb.co.uk/web-services/wordpress-plugin-development

 * Version:     1.2.8

 * Author:      Engage Web, Nick Arkell

 * Author URI:  https://www.engageweb.co.uk

 * Text Domain: video-thumbnailer-for-elementor

 * License: GPL2

 */


// Define plugin paths


define( "VTFE_PLUGINURL", plugin_dir_url( __FILE__ ) );

define( "VTFE_PATH", plugin_dir_path( __FILE__ ) );


function vtfe_dependencies() {


	// Ensure that the is_plugin_active function is available


	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );


	// Only load plugin files if Elementor is active but display a warning and deactivate the plugin if not


	if ( is_plugin_active( 'elementor/elementor.php' ) ) {


		// Load plugin files


		require_once( VTFE_PATH . 'includes/plugin.php' );

		require_once( VTFE_PATH . 'includes/settings.php' );


	} else {


		// Display warning


		function vtfe_general_admin_notice() {

			echo '

			<div class="notice notice-warning is-dismissible">

				<p>Video Thumbnailer for Elementor will only work if Elementor has been activated.</p>

			</div>';

		}

		add_action( 'admin_notices', 'vtfe_general_admin_notice' );


		// Deactivate plugin


		deactivate_plugins( VTFE_PATH . 'video-thumbnailer-for-elementor.php' );

	}

}


add_action( 'init', 'vtfe_dependencies' );
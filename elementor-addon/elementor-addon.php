<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}





function CB_Portfolio_Work_for_Elementor() {

	// Load plugin file
	require_once( __DIR__ . '/includes/plugin.php' );

	// Run the plugin
	\CB_Portfolio_Work\Plugin::instance();

}
add_action( 'plugins_loaded', 'CB_Portfolio_Work_for_Elementor' );
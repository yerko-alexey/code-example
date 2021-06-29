<?php
/**
 * Plugin Name: Code example wordpress plugin
 * Plugin URI: https://example.com/
 * Description: Code example wordpress plugin description
 * Version: 0.0.1
 * Author: Alexey Yerko
 *
 * @package code-example-plugin
 */ 

if ( !defined('ABSPATH') ) {
	return;
}

/**
 * REST Api endpoint
 *
 * @since 0.0.1
 * @package code-example-plugin\classes
 * @see https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/
 */

require plugin_dir_path( __FILE__ ) . '/classes/class.code_example_plugin_rest_controller.php';

/**
 * REST Api init action
 */

function code_example_plugin_register_rest_routes() {
	$controller = new Code_Example_Plugin_REST_Controller();
	$controller->register_routes();
}

add_action( 'rest_api_init', 'code_example_plugin_register_rest_routes' );
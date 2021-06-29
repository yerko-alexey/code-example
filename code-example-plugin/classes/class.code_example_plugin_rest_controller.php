<?php
/**
 * Class Code_Example_Plugin_REST_Controller
 * 
 * REST Api endpoints definition
 * 
 * @since 0.0.1
 * @see https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Code_Example_Plugin_REST_Controller extends WP_REST_Controller {

	function __construct(){
		$this->namespace = 'code-example-plugin/v1';
		$this->rest_products = 'products';
		$this->rest_users = 'users';
	}

	/**
	 * Register custom enpoints
	 * 
	 * @see https://developer.wordpress.org/reference/functions/register_rest_route/
	 */

	function register_routes(){

		register_rest_route( $this->namespace, "/$this->rest_products", [
			[
				'methods'             => 'POST',
				'callback'            => [ $this, 'code_example_plugin_products_processing' ],
				'permission_callback' => [ $this, 'code_example_plugin_permissions_check' ],
			],
		] );

		register_rest_route( $this->namespace, "/$this->rest_users", [
			[
				'methods'             => 'POST',
				'callback'            => [ $this, 'code_example_plugin_users_processing' ],
				'permission_callback' => [ $this, 'code_example_plugin_permissions_check' ],
			],
		] );
	}
	
	/**
	 * Data callback function
	 *
	 * @param WP_REST_Request $request Current request.
	 *
	 * @return array // of WP_Post Object's
	 */

	function code_example_plugin_products_processing( $request ){
        //Here we can get any described data, i.e.
        $args = array(
            'numberposts' => 10
        );
        
        return get_posts( $args );
	}

	/**
	 * Data callback function
	 *
	 * @param WP_REST_Request $request Current request.
	 *
	 * @return array // of WP_User Object's
	 */

	function code_example_plugin_users_processing( $request ){
        //Here we can get any described data, i.e.
        
        return get_users();
	}
	
	/**
	 * Endpoint permissions check with Basic Authorization
	 * 
	 * @param WP_REST_Request $request Current request.
	 */

	function code_example_plugin_permissions_check( $request ){
		if (!function_exists('getallheaders'))
		{
			function getallheaders()
			{
				$headers = [];

                foreach ($_SERVER as $name => $value)
                {
                    if (substr($name, 0, 5) == 'HTTP_')
                    {
                        $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                    }
                }

                return $headers;
			}
		}
		
		$auth = getallheaders();
		
		$name_pass = base64_decode(explode(' ', $auth['Authorization'])[1]);

		$userdata = get_user_by('login', explode(':', $name_pass)[0]);
		$result = wp_check_password(explode(':', $name_pass)[1], $userdata->user_pass, $userdata->ID);

		if ( $result && user_can( $userdata->ID, 'edit_posts' ) ) {
			return true;
		}
		
		return false;
	}
}
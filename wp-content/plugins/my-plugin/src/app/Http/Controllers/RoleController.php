<?php

namespace Uniqoders\MyPlugin\Http\Controllers;
/**
 * REST API: RoleController class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 4.7.0
 */

/**
 * Core class used to manage users via the REST API.
 *
 * @since 4.7.0
 *
 * @see WP_REST_Controller
 */
class RoleController
{

    /**
     * Constructor.
     *
     * @since 4.7.0
     */
    public function __construct()
    {
        $this->namespace = 'my-plugin';
        $this->rest_base = 'roles';
    }

    /**
     * Registers the routes for users.
     *
     * @since 4.7.0
     *
     * @see register_rest_route()
     */
    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base,
            [
                [
                    'methods' => \WP_REST_Server::READABLE,
                    'callback' => [$this, 'index'],
//                    'args' => $this->get_collection_params(),
                ],
            ]
        );
    }

    /**
     * @param \WP_REST_Request $request
     * @return \WP_Error|\WP_HTTP_Response|\WP_REST_Response
     */
    function index(\WP_REST_Request $request): \WP_Error|\WP_REST_Response|\WP_HTTP_Response
    {
        do_action('mi_plugin_track', __FUNCTION__, $request->get_params());

        $roles = wp_roles()->get_names();

        return rest_ensure_response(array_keys($roles));
    }
}

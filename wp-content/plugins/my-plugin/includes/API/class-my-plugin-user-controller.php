<?php
/**
 * REST API: UserController class
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
class UserController extends WP_REST_Controller
{

    /**
     * Constructor.
     *
     * @since 4.7.0
     */
    public function __construct()
    {
        $this->namespace = 'my-plugin';
        $this->rest_base = 'users';
    }

    /**
     * Get the query params for collections
     *
     * @return array
     */
    public function get_collection_params()
    {
        return [
            'page' => [
                'description' => 'Current page of the collection.',
                'type' => 'integer',
                'default' => 1,
                'minimum' => 1,
                'maximum' => 2,
                'sanitize_callback' => 'absint',
            ],
            'per_page' => [
                'description' => 'Maximum number of items to be returned in result set.',
                'type' => 'integer',
                'default' => 10,
                'minimum' => 1,
                'maximum' => 100,
                'sanitize_callback' => 'absint',
            ],
            'number' => [
                'description' => 'Maximum number of items to be returned in result set.',
                'type' => 'integer',
                'default' => 10,
                'minimum' => 1,
                'maximum' => 100,
                'sanitize_callback' => 'absint',
            ],
            'search' => [
                'description' => 'Limit results to those matching a string.',
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
            ],
            'role' => [
                'description' => 'Limit result set to users with a specific role.',
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'enum' => $this->getRoleNames(),
            ],
        ];
    }

    function getRoleNames()
    {
        $roles = wp_roles()->get_names();

        return array_keys($roles);
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
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => [$this, 'index'],
//                    'permission_callback' => [$this, 'authorize_request'],
                    'args' => $this->get_collection_params(),
                ],
                [
                    'methods' => WP_REST_Server::CREATABLE,
                    'callback' => [$this, 'store'],
//                    'permission_callback' => [$this, 'authorize_request'],
                    'args' => [
                        'role' => [
                            'description' => 'Limit result set to users with a specific role.',
                            'type' => 'string',
                            'enum' => $this->getRoleNames(),
                        ],
                    ],
                ]
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/(?P<id>[\d]+)',
            [
                'args' => [
                    'id' => [
                        'description' => __('Unique identifier for the user.'),
                        'type' => 'integer',
                        'validate_callback' => fn($param, $request, $key) => is_numeric($param),
                    ],
                    'role' => [
                        'description' => 'Limit result set to users with a specific role.',
                        'type' => 'string',
//                        'sanitize_callback' => 'sanitize_text_field',
                        'enum' => $this->getRoleNames(),
                    ],
                ],
                [
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => [$this, 'show'],
//                    'permission_callback' => [$this, 'authorize_request'],
                    'args' => [
                        'context' => $this->get_context_param(['default' => 'view']),
                    ],
                ],
                [
                    'methods' => WP_REST_Server::EDITABLE,
                    'callback' => [$this, 'update'],
//                    'permission_callback' => [$this, 'authorize_request'],
                    'args' => [

                    ],
                ],
                [
                    'methods' => WP_REST_Server::DELETABLE,
                    'callback' => [$this, 'destroy'],
//                    'permission_callback' => [$this, 'authorize_request'],
                ],
            ],
        );
    }

    /**
     * @param WP_REST_Request $request
     * @return WP_Error|WP_HTTP_Response|WP_REST_Response
     */
    function index(WP_REST_Request $request): WP_Error|WP_REST_Response|WP_HTTP_Response
    {
        do_action('mi_plugin_track', __FUNCTION__, $request->get_params());

        $args = $request->get_params();

        return rest_ensure_response(get_users($args));
    }

    /**
     * @param WP_REST_Request $request
     * @return WP_Error|WP_HTTP_Response|WP_REST_Response
     */
    public function show(WP_REST_Request $request): WP_Error|WP_REST_Response|WP_HTTP_Response
    {
        do_action('mi_plugin_track', __FUNCTION__, $request->get_params());

        $id = $request->get_param('id'); // Obtén el parámetro 'id' de la URL

        return rest_ensure_response(get_userdata($id)->to_array());
    }

    /**
     * @param WP_REST_Request $request
     * @return WP_Error|WP_REST_Response|WP_HTTP_Response
     */
    function store(WP_REST_Request $request): WP_Error|WP_REST_Response|WP_HTTP_Response
    {
        do_action('mi_plugin_track', __FUNCTION__, $request->get_params());

        $args = [
            'user_login' => $request['name'],
            'user_pass' => $request['password'],
            'user_email' => $request['email'],
            'role' => $request['role'],
        ];

        $user = wp_insert_user($args);

        return rest_ensure_response(get_userdata($user));
    }

    /**
     * @param WP_REST_Request $request
     * @return WP_Error|WP_HTTP_Response|WP_REST_Response
     */
    function update(WP_REST_Request $request): WP_Error|WP_REST_Response|WP_HTTP_Response
    {
        do_action('mi_plugin_track', __FUNCTION__, $request->get_params());

        $id = $request->get_param('id'); // Obtén el parámetro 'id' de la URL

        $args = [
            'display_name' => $request['name'],
            'user_pass' => $request['password'],
            'user_email' => $request['email'],
            'role' => $request['role'],
            'ID' => $id,
        ];

        $result = wp_update_user($args);

        return rest_ensure_response(get_userdata($result));
    }

    /**
     * @param WP_REST_Request $request
     * @return WP_Error|WP_HTTP_Response|WP_REST_Response
     */
    function destroy(WP_REST_Request $request): WP_Error|WP_REST_Response|WP_HTTP_Response
    {
        do_action('mi_plugin_track', __FUNCTION__, $request->get_params());

        $id = $request->get_param('id'); // Obtén el parámetro 'id' de la URL

        require_once ABSPATH . 'wp-admin/includes/user.php'; #No se porque hay que añadir esto???

        $result = wp_delete_user($id); # que es reassign??

        if ($result === false) {
            return new WP_Error('delete_failed', 'No se pudo eliminar el usuario', ['status' => 400]);
        }

        return rest_ensure_response($result);
    }
}

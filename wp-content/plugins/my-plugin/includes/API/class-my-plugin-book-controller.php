<?php
/**
 * REST API: BookController class
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
class BookController extends WP_REST_Controller
{

    /**
     * Constructor.
     *
     * @since 4.7.0
     */
    public function __construct()
    {
        $this->namespace = 'my-plugin';
        $this->rest_base = 'books';
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
                    'args' => $this->get_endpoint_args_for_item_schema(WP_REST_Server::CREATABLE),
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
                    'args' => $this->get_endpoint_args_for_item_schema(WP_REST_Server::EDITABLE)
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
    public function index(WP_REST_Request $request): WP_Error|WP_REST_Response|WP_HTTP_Response
    {
        do_action('mi_plugin_track', __FUNCTION__, $request->get_params());

        $args = [
            'post_type' => 'book_type',
            'posts_per_page' => -1,
        ];

        $query = new WP_Query($args);

        $data = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $data[] = [
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'content' => get_the_content(),
                ];
            }
            wp_reset_postdata();
        }

        return rest_ensure_response($data); # Que hace esto?
    }

    /**
     * @param WP_REST_Request $request
     * @return WP_Error|WP_HTTP_Response|WP_REST_Response
     */
    public function show(WP_REST_Request $request): WP_Error|WP_REST_Response|WP_HTTP_Response
    {
        do_action('mi_plugin_track', __FUNCTION__, $request->get_params());

        $id = $request->get_param('id'); // Obtén el parámetro 'id' de la URL

        return rest_ensure_response(get_post($id));
    }

    /**
     * @param WP_REST_Request $request
     * @return array
     */
    public function store(WP_REST_Request $request): array
    {
        do_action('mi_plugin_track', __FUNCTION__, $request->get_params());

        // Define los datos del nuevo post.
        $newPost = [
            'post_title' => $request['post_title'],
            'post_content' => $request['post_content'],
            'post_status' => $request['post_status'],
            'post_author' => $request['post_author'],
            'post_category' => $request['post_category'],
            'tags_input' => $request['tags_input'],
            'post_type' => 'book_type'
        ];

        // Inserta el nuevo post en la base de datos.
        $newPost = wp_insert_post($newPost);

        return rest_ensure_response($newPost);

    }

    /**
     * @param WP_REST_Request $request
     * @return WP_Error|WP_HTTP_Response|WP_REST_Response
     */
    public function update(WP_REST_Request $request): WP_Error|WP_REST_Response|WP_HTTP_Response
    {
        do_action('mi_plugin_track', __FUNCTION__, $request->get_params());

        $id = $request->get_param('id'); // Obtén el parámetro 'id' de la URL

        $args = [
            'post_title' => $request['post_title'],
            'post_content' => $request['post_content'],
            'post_status' => $request['post_status'],
            'post_author' => $request['post_author'],
            'post_category' => $request['post_category'],
            'tags_input' => $request['tags_input'],
            'post_type' => 'book_type',
            'ID' => $id,
        ];

        $result = wp_update_post($args);

        return rest_ensure_response(get_post($result)->to_array());
    }

    /**
     * @param WP_REST_Request $request
     * @return WP_Error|WP_HTTP_Response|WP_REST_Response
     */
    public function destroy(WP_REST_Request $request): WP_Error|WP_REST_Response|WP_HTTP_Response
    {
        do_action('mi_plugin_track', self::class, __FUNCTION__, $request->get_params());

        $id = $request->get_param('id'); // Obtén el parámetro 'id' de la URL

        if ($id && wp_delete_post($id, true)) {
            return new WP_REST_Response(['message' => 'Post eliminado con éxito'], 200);
        } else {
            return new WP_Error('post_not_found', 'No se pudo encontrar el post o hubo un error al eliminarlo.', ['status' => 404]);
        }
    }
}

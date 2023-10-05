<?php

/**
 * @return void
 */
function my_plugin_update_user_api()
{
    register_rest_route('my-plugin', 'users/(?P<id>\d+)', [
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'update_user_callback',
        'args' => [
            'role' => [
                'validate_callback' => fn($param, $request, $key) => in_array($param, getRoleNames()),
            ],
            'id' => [
                'validate_callback' => fn($param, $request, $key) => is_numeric($param),
            ],
        ],
    ]);
}

/**
 * @param WP_REST_Request $request
 * @return WP_Error|WP_HTTP_Response|WP_REST_Response
 */
function update_user_callback(WP_REST_Request $request)
{
    $id = $request->get_param('id'); // Obtén el parámetro 'id' de la URL

    $args = [
        'user_login' => $request['name'],
        'user_pass' => $request['password'],
        'user_email' => $request['email'],
        'role' => $request['role'],
        'ID' => $id,
    ];

    $result = wp_update_user($args);

    return rest_ensure_response($result);
}

add_action('rest_api_init', 'my_plugin_update_user_api');

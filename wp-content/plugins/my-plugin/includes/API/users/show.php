<?php

function my_plugin_get_user_api()
{
    register_rest_route('my-plugin', 'users/(?P<id>\d+)', [
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_user_callback',
        'id' => [
            'validate_callback' => fn($param, $request, $key) => is_numeric($param),
        ],
    ]);
}

function get_user_callback(WP_REST_Request $request)
{
    $id = $request->get_param('id'); // Obtén el parámetro 'id' de la URL

    return rest_ensure_response(get_userdata( $id )->to_array());
}

add_action('rest_api_init', 'my_plugin_get_user_api');

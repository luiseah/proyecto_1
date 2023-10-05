<?php

function my_plugin_get_users_api()
{
    register_rest_route('my-plugin', 'users', [
        'methods' =>  WP_REST_Server::READABLE,
        'callback' => 'get_users_callback'
    ]);
}

function get_users_callback(WP_REST_Request $request)
{
    $args = $request->get_params();

    return rest_ensure_response(get_users($args));
}

add_action('rest_api_init', 'my_plugin_get_users_api');

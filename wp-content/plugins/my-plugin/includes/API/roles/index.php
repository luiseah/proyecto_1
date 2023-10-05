<?php

function my_plugin_get_roles_api()
{
    register_rest_route('my-plugin', 'roles', [
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_roles_callback'
    ]);
}

function get_roles_callback(WP_REST_Request $request)
{
    $roles = wp_roles()->get_names();

    return rest_ensure_response($roles);
}

add_action('rest_api_init', 'my_plugin_get_roles_api');

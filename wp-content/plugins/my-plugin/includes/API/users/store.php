<?php

function my_plugin_store_user_api()
{
    register_rest_route('my-plugin', 'users', [
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'my_plugin_store_user_api_callback',
        'args' => [
            'role' => [
                'validate_callback' => fn($param, $request, $key) => in_array($param, getRoleNames()),
            ],
        ],
    ]);
}

function getRoleNames()
{
    $roles = wp_roles()->get_names();

    return array_keys($roles);
}

function my_plugin_store_user_api_callback(WP_REST_Request $request)
{
    $args = [
        'user_login' => $request['name'],
        'user_pass' => $request['password'],
        'user_email' => $request['email'],
        'role' => $request['role'],
    ];

    $user = wp_insert_user($args);

    return get_user_by('id', $user)->to_array();
}

add_action('rest_api_init', 'my_plugin_store_user_api');
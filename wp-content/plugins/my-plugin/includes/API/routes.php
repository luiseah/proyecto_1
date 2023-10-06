<?php

require_once __DIR__ . '/class-my-plugin-user-controller.php';
require_once __DIR__ . '/class-my-plugin-book-controller.php';
require_once __DIR__ . '/class-my-plugin-role-controller.php';

/**
 * @return void
 */
function my_plugin_register_routes()
{
    $controller = new UserController();
    $controller->register_routes();

    $controller = new BookController();
    $controller->register_routes();

    $controller = new RoleController();
    $controller->register_routes();
}


add_action('rest_api_init', 'my_plugin_register_routes');

<?php

use Uniqoders\MyPlugin\Http\Controllers\BookController;
use Uniqoders\MyPlugin\Http\Controllers\RoleController;
use Uniqoders\MyPlugin\Http\Controllers\UserController;

if (function_exists('add_action')) {
    add_action('rest_api_init', function () {
    $controller = new UserController();
    $controller->register_routes();

    $controller = new BookController();
    $controller->register_routes();

    $controller = new RoleController();
    $controller->register_routes();
    });
}

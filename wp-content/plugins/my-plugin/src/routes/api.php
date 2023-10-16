<?php

use Uniqoders\MyPlugin\Http\Controllers\BookController;
use Uniqoders\MyPlugin\Http\Controllers\CacheController;
use Uniqoders\MyPlugin\Http\Controllers\OptionController;
use Uniqoders\MyPlugin\Http\Controllers\RoleController;
use Uniqoders\MyPlugin\Http\Controllers\UserController;
use Uniqoders\MyPlugin\Routing\Request;
use Uniqoders\MyPlugin\Routing\Route;

if (function_exists('add_action')) {
    add_action('init', function () {
        $controller = $_REQUEST['controller'] ?? null;
        $action = $_REQUEST['action'] ?? null;

        if ($controller && $action) {

            $controller = match ($controller) {
                'role' => RoleController::class,
                'book' => BookController::class,
                'user' => UserController::class,
                'option' => OptionController::class,
                'cache' => CacheController::class,
                default => new \Exception('Controller not found')
            };

            $callable = [
                plugin()->make($controller),
                $action
            ];

            $request = new Request(
                Route::instance()->getMethod(),
                Route::instance()->requestURI(),
                array_merge($_GET, $_POST),
                getallheaders()
            );

            if (method_exists(...$callable)) {
                call_user_func($callable, $request);
            }
        }
    });
}

<?php

use Illuminate\Support\Facades\Route;
use Uniqoders\MyPlugin\Http\Controllers\BookController;
use Uniqoders\MyPlugin\Http\Controllers\RoleController;
use Uniqoders\MyPlugin\Routing\RequestInterface;
//use Uniqoders\MyPlugin\Routing\Route;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Router;



//Route::get('site/{site}/', function (RequestInterface $request) {
//
//    wp_send_json([
//        'parameter' => $request->parameters(),
//        'uri' => $request->pathVariables(),
//        'headers' => $request->headers(),
//    ]);
//});

//Route::get('roles', [RoleController::class, 'index']);
//Route::get('books', [BookController::class, 'index']);



//Route::redirect('test', 'https://google.com', 301);


//if (function_exists('add_action')) {
//    add_action('init', function () {
//
//        $uri = ltrim($_SERVER["REQUEST_URI"], '/');
////        echo ($_SERVER["REQUEST_URI"]);
////        die($uri);
//        $pUrl = parse_url($uri);
//
//        die(plugin()->sayHi());
//
//        die(json_encode($pUrl));
//        if ($pUrl === false)   die( "");;
//
//        die($pUrl['path'] ?? "");
////        return $pUrl['path'] ?? "";
//
////        die(json_encode($_SERVER["REQUEST_URI"]));
////        die(json_encode($_REQUEST));
////
////        if ($_REQUEST['origin'] === 'message') {
////            die('hola');
////        }
//        $controller = new UserController();
//        $controller->register_routes();
//
//        $controller = new BookController();
//        $controller->register_routes();
//
//        $controller = new RoleController();
//        $controller->register_routes();
//    });
//}


//function custom_rewrite_rules() {
//    add_rewrite_rule(
//        '^mi-url-personalizada/([^/]+)/?$',
//        'index.php?custom_var=$matches[1]',
//        'top'
//    );
//}
//add_action('init', 'custom_rewrite_rules');
//
//function custom_query_vars($query_vars) {
//    $query_vars[] = 'custom_var';
//    return $query_vars;
//}
//add_filter('query_vars', 'custom_query_vars');
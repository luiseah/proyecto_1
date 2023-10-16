<?php
/**
 * Illuminate/Routing
 *
 * @source https://github.com/illuminate/routing
 * @contributor Muhammed Gufran
 * @contributor Matt Stauffer
 * @contributor https://github.com/jwalton512
 * @contributor https://github.com/dead23angel
 */


use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\CallableDispatcher;
use Illuminate\Routing\Contracts\CallableDispatcher as CallableDispatcherContract;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;
use Uniqoders\MyPlugin\Http\Controllers\RoleController;

$uri = ltrim($_SERVER["REQUEST_URI"], '/');
$pUrl = parse_url($uri);

if (function_exists('add_action') && str_starts_with($pUrl['path'], 'api/')) {
    add_action('init', function () {
        // Create a service container
        $container = new Illuminate\Container\Container();

        // Create a request from server variables, and bind it to the container; optional
        $request = Request::capture();
        $container->instance('Illuminate\Http\Request', $request);

        $container->singleton(CallableDispatcherContract::class, function ($app) {
            return new CallableDispatcher($app);
        });

        // Using Illuminate/Events/Dispatcher here (not required); any implementation of
        // Illuminate/Contracts/Event/Dispatcher is acceptable
        $events = new Dispatcher($container);

        // Create the router instance
        $router = new Router($events, $container);

        // Load the routes

        $router->get('api/roles',[RoleController::class, 'index'])
            ->name('roles');

        $router->any('{any}', function () {
            return 'four oh four';
        })->where('any', '(.*)');

        // Create the redirect instance
        $redirect = new Redirector(new UrlGenerator($router->getRoutes(), $request));

        // use redirect
        // return $redirect->home();
        // return $redirect->back();
//         return $redirect->to('/');
        // Dispatch the request through the router
        $response = $router->dispatch($request);

        // Send the response back to the browser
        $response->send();
    });
}

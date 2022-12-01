<?php

use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Monolog\Handler\Handler;
use Slim\Exception\HttpNotFoundException;


// Group different routes under the same path
return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    // App routes
    $app->get('/','App\Controllers\HomeController:index')->setName('home');
    $app->get('/cart','App\Controllers\HomeController:index')->setName('cart');
    $app->get('/checkout','App\Controllers\HomeController:index')->setName('checkout');
    $app->get('/contact','App\Controllers\HomeController:index')->setName('contact');
    $app->get('/history','App\Controllers\HomeController:index')->setName('bid_history');
    $app->get('/login','App\Controllers\AuthController:login')->setName('login');
    $app->get('/register','App\Controllers\AuthController:index')->setName('register');
    $app->post('/login','App\Controllers\AuthController:index');

    // Cors Routes
    $app->add(function ($request, $handler) {
        $response = $handler->handle($request);
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: make sure this route is defined last
     */
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });
};

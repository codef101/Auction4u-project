<?php
declare(strict_types=1);

use Slim\Views\Twig;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;
use Middlewares\TrailingSlash;

require __DIR__ . '/../vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

// Set up settings
$settings = require __DIR__ . '/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/dependencies.php';
$dependencies($containerBuilder);

// Set up Middlewares
require __DIR__ . '/middlewares.php';

// Create a Container using PHP-DI to manage containers (containers are like little snipets or functions returning something ready to all the app life)
$container = $containerBuilder->build();

// Add container to AppFactory before create App
AppFactory::setContainer($container);


// Set view in Container
$container->set('view', function() {
    return Twig::create(__DIR__ . '/../templates',
        ['cache' => __DIR__ . '/../cache']);
});


// Instantiate app
$app = AppFactory::create();

$app->setBasePath('/Auction4u');



// Add Twig-View Middleware
$app->add(TwigMiddleware::createFromContainer($app, Twig::class));

// Add Routing Middleware (needed to use RouteContext previously in middleware, for example)
$app->addRoutingMiddleware();

// Register routes
$routes = require __DIR__ . '/routes.php';
$routes($app);

$errorSetting = $app->getContainer()->get('settings')['displayErrorDetails'];

$app->addErrorMiddleware($errorSetting, true, true);

$app->add(new TrailingSlash(true));


$app->run();

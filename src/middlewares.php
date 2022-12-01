<?php

use Slim\App;
use Slim\Routing\RouteContext;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpNotFoundException;

return function(App $app) {

    // Setup a supersimple auth checker, intercepting http calls with this middleware and checking that only allowed routes can be navigated without auth
    $loggedInMiddleware = function($request, $handler): ResponseInterface {
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();

        if (empty($route)) { throw new HttpNotFoundException($request, $response); }

        $routeName = $route->getName();

        // Define routes that user does not have to be logged in with. All other routes, the user needs to be logged in with.
        // Names for routes must be defined in routes.php with ->setName() for each one.
        $publicRoutesArray = array('home', 'contact', 'history', 'login', 'register');

        //var_dump("User ID: ".(empty($_SESSION['user']) ? ' none' : $_SESSION['user']));
        if (empty($_SESSION['user']) && (!in_array($routeName, $publicRoutesArray))) {
            // Create a redirect for a named route
            $routeParser = $routeContext->getRouteParser();
            $url = $routeParser->urlFor('home');

            $response = new \Slim\Psr7\Response();

            return $response->withHeader('Location', $url)->withStatus(302);
        } else {
            $response = $handler->handle($request);

            return $response;
        }
    };

    $app->add($loggedInMiddleware);

}

?>
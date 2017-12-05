<?php

use RouterTest\Controller\TestController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('test_route', new Route('/test/{param}', ['_controller' => TestController::class . '::indexAction']));

return $routes;

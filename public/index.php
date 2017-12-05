<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\HttpKernel\Controller\{ArgumentResolver, ControllerResolver};
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

$request = Request::createFromGlobals();
$routes = require_once __DIR__ . '/../config/routes.php';

$context = new RequestContext();
$context->fromRequest($request);

$matcher = new UrlMatcher($routes, $context);
/** @var Response $response */
$response = new Response();

try {
    $request->attributes->add($matcher->match($request->getPathInfo()));

    $controllerResolver = new ControllerResolver();
    $argumentResolver = new ArgumentResolver();

    $controller = $controllerResolver->getController($request);
    $arguments = $argumentResolver->getArguments($request, $controller);

    $response = $controller(...$arguments);
} catch (ResourceNotFoundException $ex) {
    $response->setStatusCode(404);
} catch (\Throwable $ex) {
    $response->setStatusCode(500);
    $response->setContent($ex->getTraceAsString());
}

$response->send();

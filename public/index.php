<?php
ini_set('display_errors', '1');

use FastRoute\RouteCollector;
use Symfony\Component\HttpFoundation\Response;


$container = require __DIR__ . '/../app/bootstrap.php';

$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/', 'Little\Controllers\HomeController');
    $r->addRoute('POST', '/', 'Little\Controllers\StoreController');
    $r->addRoute('GET', '/{shortLink}', 'Little\Controllers\RedirectController');
});


$httpMethod = $container->get('Symfony\Component\HttpFoundation\Request')
    ->server
    ->get('REQUEST_METHOD');;
$uri = $container->get('Symfony\Component\HttpFoundation\Request')
    ->server
    ->get('REQUEST_URI');


if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);

$route = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $uri);

switch ($route[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        $response = new Response(
            '404',
            Response::HTTP_NOT_FOUND,
            ['content-type' => 'text/html']
        );
        return $response->send();
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $response = new Response(
            '405',
            Response::HTTP_METHOD_NOT_ALLOWED,
            ['content-type' => 'text/html']
        );
        return $response->send();
        break;

    case FastRoute\Dispatcher::FOUND:
        $controller = $route[1];
        $parameters = $route[2];

        $container->call($controller, $parameters)->send();
        break;
}


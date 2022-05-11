<?php

namespace Little;

use HttpException;
use Little\Repositories\Exceptions\NotFoundLinkException;
use Psr\Log\LoggerInterface;
use Throwable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FastRoute\RouteCollector;
use Twig\Environment;
use function FastRoute\simpleDispatcher;
use FastRoute\Dispatcher;


class Application
{
    public function handle(Request $request): Response
    {
        $container = require __DIR__ . '/../../config/bootstrap.php';

        $dispatcher = simpleDispatcher(function (RouteCollector $r) {
            $r->addRoute('GET', '/', 'Little\Controllers\HomeController');
            $r->addRoute('POST', '/', 'Little\Controllers\StoreController');
            $r->addRoute('GET', '/{shortLink}', 'Little\Controllers\RedirectController');
        });


        $httpMethod = $request
            ->server
            ->get('REQUEST_METHOD');;
        $uri = $request
            ->server
            ->get('REQUEST_URI');

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        $uri = rawurldecode($uri);

        $route = $dispatcher->dispatch($httpMethod, $uri);

        try {
            switch ($route[0]) {
                case Dispatcher::NOT_FOUND:
                    $response = new Response(
                        $container->get(Environment::class)->render('404.twig'),
                        Response::HTTP_NOT_FOUND,
                        ['content-type' => 'text/html']
                    );
                    return $response->send();
                    break;

                case Dispatcher::METHOD_NOT_ALLOWED:
                    $response = new Response(
                        '405',
                        Response::HTTP_METHOD_NOT_ALLOWED,
                        ['content-type' => 'text/html']
                    );
                    return $response->send();
                    break;

                case Dispatcher::FOUND:
                    $controller = $route[1];
                    $parameters = $route[2];

                    return $container->call($controller, $parameters);
                    break;
            }

        } catch (NotFoundLinkException $exception) {
            return new Response(
                $container->get(Environment::class)->render('404.twig'),
                Response::HTTP_NOT_FOUND,
                ['content-type' => 'text/html']
            );
        } catch (Throwable $exception) {
            // log an unexpected exception
            $container->get(LoggerInterface::class)->warning(
                $exception->getMessage(),
                [
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine()
                ]
            );
            $content = $container->get(Environment::class)->render('home.twig', [
                'message' => 'Something went wrong. Try latter.',
            ]);
            return new Response($content, 500);
        }

    }

}
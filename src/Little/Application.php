<?php

namespace Little;

use Little\HTTP\RequestInterface;
use Little\HTTP\Response;
use Little\HTTP\Router\Exceptions\BadMethodException;
use Little\HTTP\Router\Exceptions\RouteNotFoundException;
use Little\HTTP\Router\Router;
use Little\Repositories\Exceptions\NotFoundLinkException;
use Throwable;

class Application
{
    public function handle(RequestInterface $request): Response
    {

        $router = new Router($request);
        $router->registerRoute('/', '\Little\Controllers\HomeController');
        $router->registerRoute('/{shortLink}', '\Little\Controllers\RedirectController');
        $router->registerRoute('/', '\Little\Controllers\StoreController', "POST");

        try {
            $response = $router->match();
        } catch (NotFoundLinkException|RouteNotFoundException $e) {
            $response = new Response(
                renderTemplate('404.php'),
                404
            );
        } catch (BadMethodException $e) {
            $content = renderTemplate('404.php', [
                'message' => $e->getMessage(),
            ]);
        } catch (Throwable $exception) {
            // log an unexpected exception
            $content = renderTemplate('404.php', [
                'message' => 'Something went wrong. Try latter.',
            ]);

            dump($exception->getMessage());
            dump($exception->getFile());
            dump($exception->getLine());
            $response = new Response($content, 500);
        }

        return $response;
    }
}
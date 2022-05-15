<?php

namespace Little;

use Little\HTTP\Response;
use Little\HTTP\Router\Exceptions\BadMethodException;
use Little\HTTP\Router\Exceptions\RouteNotFoundException;
use Little\HTTP\Router\Router;
use Little\Repositories\Exceptions\NotFoundLinkException;
use Throwable;

class Application
{
    public function handle(): Response
    {

        $router = new Router();
        $router->registerRoute('/', '\Little\Controllers\HomeController');
        $router->registerRoute('/{shortLink}', '\Little\Controllers\RedirectController');
        $router->registerRoute('/', '\Little\Controllers\StoreController', "POST");

        try {
            return $router->dispatcher();
        } catch (NotFoundLinkException|RouteNotFoundException $e) {
            return new Response(
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

            return new Response($content, 500);
        }

    }
}
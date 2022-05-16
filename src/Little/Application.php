<?php

namespace Little;

use Little\HTTP\RequestInterface;
use Little\HTTP\Response;
use Little\HTTP\Router\Exceptions\BadMethodException;
use Little\HTTP\Router\Exceptions\RouteNotFoundException;
use Little\HTTP\Router\Router;
use Little\Repositories\Exceptions\NotFoundLinkException;
use Little\Repositories\LinkRepositoryAbstract;
use Little\Repositories\PDOLinkRepository;
use Little\Services\LinkService;
use Little\Services\LinkServiceInterface;
use Little\Views\View;
use Little\Views\ViewInterface;
use PDO;
use Throwable;

class Application
{
    public ViewInterface $view;
    public PDO $dbConnection;
    public LinkServiceInterface $service;
    public LinkRepositoryAbstract $repository;

    public function __construct(array $config)
    {
        $this->view = new View();
        $this->dbConnection = new PDO(
            $config['dbConnection']['dsn'],
            $config['dbConnection']['user'],
            $config['dbConnection']['password']
        );
        $this->repository = new PDOLinkRepository($this->dbConnection);
        $this->service = new LinkService($this->repository);
    }

    public function handle(RequestInterface $request): Response
    {

        $router = new Router($request);
        $router->add('/', '\Little\Controllers\HomeController');
        $router->add('/{shortLink}', '\Little\Controllers\RedirectController');
        $router->add('/', '\Little\Controllers\StoreController', "POST");
        try {
            $matchedRoute = $router->match();
            $controller = new ($matchedRoute->getCallable())(
                $request,
                $this->view,
                $this->service
            );
            $response = call_user_func_array($controller, $matchedRoute->getArguments());
        } catch (NotFoundLinkException|RouteNotFoundException $e) {
            $response = new Response(
                $this->view->render('404.php'),
                404
            );
        } catch (BadMethodException $e) {
            $content = $this->view->render('404.php', [
                'message' => $e->getMessage(),
            ]);
            $response = new Response($content, 405);
        } catch (Throwable $exception) {

            $content = $this->view->render('404.php', [
                'message' => 'Something went wrong. Try latter.',
            ]);
            $response = new Response($content, 500);
        }

        return $response;
    }
}
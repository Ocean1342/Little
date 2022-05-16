<?php

namespace Little\HTTP\Router;

use InvalidArgumentException;

use Little\HTTP\RequestInterface;
use Little\HTTP\Router\Exceptions\BadMethodException;
use Little\HTTP\Router\Exceptions\RouteNotFoundException;
use Little\HTTP\Router\Interfaces\RouterInterface;


class Router implements RouterInterface
{
    /**
     * @var array Route
     */
    protected array $routes;


    /**
     * @param RequestInterface $request
     */
    public function __construct(protected RequestInterface $request)
    {
    }

    /**
     * @param string $path
     * @param $callable
     * @param string $method
     * @return void
     */
    public function registerRoute(string $path, $callable, string $method = "GET"): void
    {
        $this->routes[] = new Route($path, $callable, $method);
    }


    public function match()
    {
        $routeFound = false;
        $methodEqual = false;

        foreach ($this->routes as $route) {
            // проверяем совпадание роута и запроса
            if (preg_match($route->getPath(), $this->request->getRequestUri(), $matchesInUri)) {
                $routeFound = true;

                if ($this->request->getMethod() !== $route->getMethod()) {
                    continue;
                }
                $methodEqual = true;

                //проставить значения переменных из запроса
                unset($matchesInUri[0]);
                foreach ($matchesInUri as $k => $match) {
                    $route->setVarsValue(--$k, $match);
                }
                $currentRoute = $route;
            }
        }
        if (!$routeFound) {
            throw new RouteNotFoundException('Not found route');
        }
        if (!$methodEqual) {
            throw new BadMethodException('Method in route not equal');
        }
        if (!class_exists($currentRoute->getCallable())) {
            throw new InvalidArgumentException("Not found class");
        }

        $controller = new ($currentRoute->getCallable())($this->request);
        return call_user_func_array($controller, $currentRoute->getArguments());
    }

}
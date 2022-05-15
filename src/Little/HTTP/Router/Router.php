<?php

namespace Little\HTTP\Router;

use InvalidArgumentException;
use Little\HTTP\Router\Exceptions\BadMethodException;
use Little\HTTP\Router\Exceptions\RouteNotFoundException;

class Router
{
    /**
     * @var array
     */
    protected array $routes;

    /**
     * @param string $pattern
     * @param $callable
     * @param string $method
     * @param array $params
     * @return void
     */
    public function registerRoute(string $pattern, $callable, array $params = [], string $method = "GET"): void
    {
        $this->routes[] = [
            'pattern' => $pattern,
            'method' => $method,
            'callable' => $callable,
            'params' => $params
        ];
    }

    protected function prepareRouteRegex(string $pattern): string
    {
        if (preg_match('/{(.*)}/i', $pattern, $matches)) {
            echo 'match';
            dump($matches);
            $regex = '/' . str_replace('/', '\/', $pattern) . '$/i';
        } else {
            $regex = '/' . str_replace('/', '\/', $pattern) . '$/i';
        }
        dump($regex);
        return $regex;
    }

    public function dispatcher()
    {
        /*
         * Что может пойти не так:
         * 1 - не существует такого класса
         * 2 - роут не совпадает
         * 3 - роут совпадает, но метод не совпадает
         * 4 - роут совпадает, но метод не совпадает, но существует ещё следующий роут, в котором метод совпадает
         * */
        $routeFound = false;
        $methodEqual = false;
        $dynamicPartRegex = '([^\/]+)';
        $varsNames = $vars = [];

        foreach ($this->routes as $route) {

            //определяем динамический роут или нет
            if (preg_match_all('/\{' . $dynamicPartRegex . '\}/i', $route['pattern'], $matches)) {
                //Подготовить новый паттерн
                unset($matches[0]);
                $newRegexPattern = preg_replace('/{(.*)}/i', '', $route['pattern']);
                $regex = '/^' . str_replace('/', '\/', $newRegexPattern);
                $varsNames = [];
                foreach ($matches[1] as $k => $match) {
                    $varsNames[] = $match;
                    $regex .= $dynamicPartRegex;
                    if ($k == (count($matches[1]) - 1)) {
                        $regex .= '$/i';
                    } else {
                        $regex .= '\/';
                    }
                }
            } else {
                $regex = '/^' . str_replace('/', '\/', $route['pattern']) . '$/i';
            }
            // проверяем совпадание роута и запроса
            if (preg_match($regex, $_SERVER['REQUEST_URI'], $matchesInUri)) {
                $routeFound = true;
                if ($_SERVER['REQUEST_METHOD'] !== $route['method']) {
                    continue;
                }
                $methodEqual = true;

                //проставить значения переменных из запроса
                unset($matchesInUri[0]);
                foreach ($matchesInUri as $k => $match) {
                    $vars[$varsNames[--$k]] = htmlspecialchars($match);
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
        if (!class_exists($currentRoute['callable'])) {
            throw new InvalidArgumentException("Not found class");
        }

        $controller = new $currentRoute['callable'];
        return call_user_func_array($controller, $vars);
    }

}
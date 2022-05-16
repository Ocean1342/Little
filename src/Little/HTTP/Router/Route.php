<?php

namespace Little\HTTP\Router;

use Little\HTTP\Router\Interfaces\RouteInterface;

/**
 *
 */
class Route implements RouteInterface
{
    /**
     * @var array
     */
    protected array $varNames = [];

    /**
     * @var array
     */
    protected array $arguments = [];

    /**
     * @var string
     */
    protected string $dynamicPartRegex = '([^\/]+)';

    /**
     * @param string $path
     * @param string $callable
     * @param string $method
     */
    public function __construct(
        public string $path,
        public string $callable,
        public string $method = "GET"

    )
    {
        $this->prepareRoutePath();

    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getCallable(): string
    {
        return $this->callable;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param int $index
     * @param mixed $value
     * @return void
     */
    public function setVarsValue(int $index, mixed $value): void
    {
        $this->arguments[$this->varNames[$index]] = $value;
    }

    /**
     * @return void
     */
    protected function prepareRoutePath(): void
    {
        if (preg_match_all('/{' . $this->dynamicPartRegex . '}/i', $this->path, $matches)) {
            //Подготовить новый паттерн
            unset($matches[0]);
            $newRegexPattern = preg_replace('/{(.*)}/i', '', $this->path);
            $regex = '/^' . str_replace('/', '\/', $newRegexPattern);

            foreach ($matches[1] as $k => $match) {
                $this->varNames[] = $match;
                $regex .= $this->dynamicPartRegex;
                if ($k == (count($matches[1]) - 1)) {
                    $regex .= '$/i';
                } else {
                    $regex .= '\/';
                }
            }
        } else {
            $regex = '/^' . str_replace('/', '\/', $this->path) . '$/i';
        }
        $this->path = $regex;
    }

}
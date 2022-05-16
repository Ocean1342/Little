<?php

namespace Little\HTTP;

class Request implements RequestInterface
{


    /**
     * @param $requestUri
     * @param $requestMethod
     * @param $post
     */
    public function __construct(
        protected string $requestUri = '/',
        protected string $requestMethod = "GET",
        protected array  $post = [])
    {
        $this->extractPath();
    }

    /**
     * @return string
     */
    public function getRequestUri(): string
    {
        return $this->requestUri;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->requestMethod;
    }

    /**
     * @return array
     */
    public function post(): array
    {
        return $this->post;
    }

    /**
     * @return mixed|string
     */
    public function getScheme(): string
    {
        return $_SERVER['REQUEST_SCHEME'] ?? 'http';
    }

    /**
     * @return mixed|string
     */
    public function getServerName(): string
    {
        return $_SERVER['SERVER_NAME'] ?? 'localhost';
    }

    /**
     * @return void
     */
    public function extractPath(): void
    {
        $ar = parse_url($this->getRequestUri());
        if (array_key_exists('query', $ar)) {
            $this->requestUri = $ar['path'];
        }
    }
}
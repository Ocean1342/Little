<?php

namespace Little\HTTP\Router\Interfaces;

interface RouteInterface
{
    /**
     * @return non-empty-string
     */
    public function getPath(): string;

    /**
     * @return non-empty-string
     */
    public function getMethod(): string;

    /**
     * @return non-empty-string
     */
    public function getCallable(): string;
}
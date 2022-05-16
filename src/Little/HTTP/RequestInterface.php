<?php

namespace Little\HTTP;


/**
 *
 */
interface RequestInterface
{
    /**
     * @return string
     */
    public function getRequestUri(): string;

    /**
     * @return string
     */
    public function getMethod(): string;

}
<?php

namespace Little\Controllers;

use Little\HTTP\RequestInterface;
use Little\Services\LinkService;
use Little\Views\ViewInterface;

/**
 *
 */
class BaseController
{
    /**
     * @param LinkService $service
     */
    public function __construct(
        protected RequestInterface $request,
        protected ViewInterface    $view,
        protected LinkService      $service
    )
    {
    }

}
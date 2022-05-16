<?php

namespace Little\Controllers;

use Little\HTTP\RequestInterface;
use Little\Services\LinkService;

/**
 *
 */
class BaseController
{
    protected LinkService $service;

    /**
     * @param LinkService $service
     */
    public function __construct(
        protected RequestInterface $request
    )
    {
        $this->service = new LinkService();
    }

}
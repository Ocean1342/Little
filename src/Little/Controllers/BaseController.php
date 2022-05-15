<?php

namespace Little\Controllers;

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
    public function __construct()
    {
        $this->service = new LinkService();
    }

}
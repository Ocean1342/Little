<?php

namespace Little\Controllers;

use Little\Repositories\LinkRepositoryInterface;
use Little\Services\LinkServiceInterface;
use Twig\Environment;

/**
 *
 */
class BaseController
{
    /**
     * @param LinkServiceInterface $service
     * @param Environment $twig
     */
    public function __construct(
        protected LinkServiceInterface $service,
        protected Environment $twig
    )
    {
    }

}
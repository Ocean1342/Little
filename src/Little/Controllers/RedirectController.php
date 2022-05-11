<?php

namespace Little\Controllers;

use Little\Repositories\Exceptions\NotFoundLinkException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class RedirectController extends BaseController
{

    /**
     * @param string $shortLink
     * @return RedirectResponse|Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(string $shortLink)
    {
        $baseLink = $this->service->getBaseLink(htmlspecialchars($shortLink));
        if (!$baseLink) {
            throw new NotFoundLinkException();
        }

        return new RedirectResponse($baseLink);
    }

}
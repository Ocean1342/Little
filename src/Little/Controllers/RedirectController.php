<?php

namespace Little\Controllers;

use Little\HTTP\Response;
use Little\Repositories\Exceptions\NotFoundLinkException;

/**
 *
 */
class RedirectController extends BaseController
{
    /**
     * @param string $shortLink
     * @return Response|null
     * @throws NotFoundLinkException
     */
    public function __invoke(string $shortLink): ?Response
    {
        $baseLink = $this->service->getBaseLink($shortLink);
        if (!$baseLink) {
            throw new NotFoundLinkException('Short link Not Found');
        }

        return new Response('', 301, [
            'Location' => $baseLink,
        ]);
    }

}
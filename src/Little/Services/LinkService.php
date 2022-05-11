<?php

namespace Little\Services;

use Little\Repositories\LinkRepositoryAbstract;
use Symfony\Component\HttpFoundation\Request;

class LinkService implements LinkServiceInterface
{
    /**
     * @param LinkRepositoryAbstract $repository
     */
    public function __construct(
        public LinkRepositoryAbstract $repository
    )
    {
    }

    /**
     * @return string
     */
    protected function generateShortLink(): string
    {
        $symbols = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($symbols), rand(1,5), 6);
    }

    /**
     *
     * @param $shortLink string
     * @return string|null
     */
    public function getBaseLink(string $shortLink): ?string
    {
        return $this->repository->findBaseLink(htmlspecialchars($shortLink));
    }

    /**
     * @param Request $request
     * @return string|null
     */
    public function createShortLink(Request $request): ?string
    {
        $baseLink = htmlspecialchars($request->request->get('base_link'));

        //create short link
        $shortLink = $this->generateShortLink();
        $this->repository->saveShortLink($shortLink, $baseLink);

        return $shortLink;
    }
}
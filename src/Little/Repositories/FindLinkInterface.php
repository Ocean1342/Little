<?php

namespace Little\Repositories;

interface FindLinkInterface
{
    /**
     * Search base link from short link
     *
     * @param $shortLink
     * @return string|null
     */
    public function findBaseLink(string $shortLink): ?string;

}
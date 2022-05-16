<?php

namespace Little\Repositories;

interface SaveLinkInterface
{
    /**
     * Save short link to database
     *
     * @param string $shortLink not null
     * @param string $baseLink not null
     * @return bool
     */
    public function saveShortLink(string $shortLink, string $baseLink): bool;
}
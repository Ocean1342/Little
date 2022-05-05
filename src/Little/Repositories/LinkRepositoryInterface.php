<?php

namespace Little\Repositories;

/**
 *
 */
interface LinkRepositoryInterface
{
    /**
     * @param $shortLink
     * @return string|null
     */
    public function getBaseLink($shortLink): ?string;

    /**
     * @param array $array
     * @return bool
     */
    public function saveShortLink(array $array): bool;
}
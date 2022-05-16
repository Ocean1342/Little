<?php

namespace Little\Services;

/**
 *
 */
interface LinkServiceInterface
{
    public function getBaseLink(string $shortLink): ?string;
}
<?php

namespace Little\HTTP;

interface ResponseInterface
{
    public function send(): static;

    /**
     * Sends content for the current web response.
     *
     * @return $this
     */
    public function sendContent(): static;

    public function sendHeaders(): static;
}
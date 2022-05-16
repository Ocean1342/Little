<?php

namespace Little\HTTP;

interface ResponseInterface
{
    /**
     * @return $this
     */
    public function send(): static;

    /**
     * @return $this
     */
    public function sendContent(): static;

    /**
     * @return $this
     */
    public function sendHeaders(): static;
}
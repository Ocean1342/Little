<?php

namespace Little\HTTP;

class Response
{

    /**
     * @param string|null $content
     * @param int $status
     * @param array $headers
     */
    public function __construct(
        protected ?string $content = '',
        protected int     $status = 200,
        public array      $headers = [])
    {

    }

    public function send(): static
    {
        $this->sendHeaders();
        $this->sendContent();

        return $this;
    }

    /**
     * Sends content for the current web response.
     *
     * @return $this
     */
    public function sendContent(): static
    {
        echo $this->content;

        return $this;
    }

    public function sendHeaders(): static
    {
        if (headers_sent()) {
            return $this;
        }
        foreach ($this->headers as $key => $value) {
            header($key.': '.$value);
        }
        // status
        http_response_code($this->status);

        return $this;
    }
}
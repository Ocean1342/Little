<?php

namespace Little\Views;

use InvalidArgumentException;

class View implements ViewInterface
{

    /**
     * @param string $path
     * @param array $args
     * @return string
     */
    public function render(string $path, array $args = []): string
    {
        $fullPath = __DIR__ . '/templates/' . $path;
        if (!is_file($fullPath)) {
            throw new InvalidArgumentException('Not found view');
        }
        extract($args);
        ob_start();
        require $fullPath;
        $html = ob_get_clean();

        return $html;
    }

}
<?php

namespace Little\Views;

interface ViewInterface
{
    public function render(string $path, array $args): string;
}
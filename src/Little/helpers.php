<?php
function dd($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}

function dump($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';

}

function renderTemplate($path, array $args = [])
{
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/../src/Little/Views/' . $path;
    if (!is_file($fullPath)) {
        throw new InvalidArgumentException('Not found view');
    }
    extract($args);
    ob_start();
    require $fullPath;
    $html = ob_get_clean();

    return $html;
}

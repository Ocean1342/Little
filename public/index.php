<?php

use Little\Application;

ini_set('display_errors', '1');

require __DIR__ . '/../vendor/autoload.php';

function dd ($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}
function dump ($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';

}

function render_template($path, array $args=[])
{
    $fullPath = $_SERVER['DOCUMENT_ROOT'].'/../src/Little/Views/'.$path;
    if (! is_file($fullPath)) {
        throw new InvalidArgumentException('Not found view');
    }
    extract($args);
    ob_start();
    require $fullPath;
    $html = ob_get_clean();

    return $html;
}


/*$app = new Application();
return $app->handle(Request::createFromGlobals())->send();*/

$router = new \Little\HTTP\Router\Router();
$router->registerRoute('/','\Little\Controllers\HomeController');
$router->registerRoute('/{shortLink}','\Little\Controllers\RedirectController');
$router->registerRoute('/','\Little\Controllers\StoreController',method:"POST");

try {
    $router->dispatcher()->send();
} catch (Throwable $e) {
    echo $e->getMessage();
}

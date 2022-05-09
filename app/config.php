<?php


use Little\Repositories\LinkRepository;
use Little\Repositories\LinkRepositoryInterface;
use Little\Services\LinkService;
use Little\Services\LinkServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use function DI\create;
use function DI\get;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$dbConnection = require __DIR__ . '/../app/db.config.php';

$createPdo = function ($dbConnection, $value = false) {
    try {
        $pdo = new PDO(
            $dbConnection['production']['dsn'],
            $dbConnection['production']['user'],
            $dbConnection['production']['password'],
        );
    } catch (PDOException $exception) {
    if(DEBUG_MODE)
        echo $exception->getMessage();
        die('Problem with service. Please try latter');
    }

    return $pdo;
};

return [
    Request::class => function () {
        return Request::createFromGlobals();
    },
    PDO::class => $createPdo($dbConnection),
    LinkServiceInterface::class => create(LinkService::class)
        ->constructor(create(LinkRepository::class)
            ->constructor(get(PDO::class))),

    LinkRepositoryInterface::class => create(LinkRepository::class)
        ->constructor(get(PDO::class)),

    Environment::class => function () {
        $loader = new FilesystemLoader(__DIR__ . '/../src/Little/Views');
        return new Environment($loader);
    },
];

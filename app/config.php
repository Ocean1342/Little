<?php


use Little\Repositories\LinkRepository;
use Little\Repositories\LinkRepositoryInterface;
use Little\Services\LinkService;
use Little\Services\LinkServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use function DI\create;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$dbConnection = require __DIR__ . '/../app/db.config.php';

$createPdo = function ($dbConnection) {
    return create(PDO::class)
        ->constructor(
            $dbConnection['production']['dsn'],
            $dbConnection['production']['user'],
            $dbConnection['production']['password']
        );
};

return [
    Request::class => function () {
        return Request::createFromGlobals();
    },
    LinkServiceInterface::class => create(LinkService::class)
        ->constructor(create(LinkRepository::class)
            ->constructor($createPdo($dbConnection))),
    LinkRepositoryInterface::class => create(LinkRepository::class)
        ->constructor($createPdo($dbConnection)),

    Environment::class => function () {
        $loader = new FilesystemLoader(__DIR__ . '/../src/Little/Views');
        return new Environment($loader);
    },
];

<?php


use Little\Repositories\LinkRepository;
use Little\Repositories\LinkRepositoryInterface;
use Little\Services\LinkService;
use Little\Services\LinkServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use function DI\create;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$createPdo = function ()
{
    return create(PDO::class)
        ->constructor(
            'mysql:host=mysql;dbname=little',
            'root',
            'root'
        );
};

return [
    Request::class => function () {
        return Request::createFromGlobals();
    },
    LinkServiceInterface::class => create(LinkService::class)
        ->constructor(create(LinkRepository::class)
            ->constructor($createPdo())),
    LinkRepositoryInterface::class => create(LinkRepository::class)
        ->constructor($createPdo()),

    Environment::class => function () {
        $loader = new FilesystemLoader(__DIR__ . '/../src/Little/Views');
        return new Environment($loader);
    },
];

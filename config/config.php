<?php


use Little\Repositories\PDOLinkRepository;
use Little\Repositories\LinkRepositoryAbstract;
use Little\Services\LinkService;
use Little\Services\LinkServiceInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Request;
use function DI\autowire;
use function DI\create;
use function DI\get;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$dbConnection = require __DIR__ . '/../config/db.config.php';


/**
 * @return Logger
 */
$createLogger = function () {
    // create a log channel
    $log = new Logger('log');
    $log->pushHandler(new StreamHandler(__DIR__ . '/../logs/log.log'));
    return $log;
};

/**
 * @param $dbConnection
 * @param $logger
 * @return PDO|void
 */
$createPdo = function ($dbConnection, $logger) {

    try {
        $pdo = new PDO(
            $dbConnection['production']['dsn'],
            $dbConnection['production']['user'],
            $dbConnection['production']['password'],
        );
    } catch (PDOException $exception) {
            echo $exception->getMessage(), PHP_EOL;
        $logger->error(
            $exception->getMessage(),
            [
                'file' => $exception->getFile(),
                'line' => $exception->getLine()
            ]
        );
        die('Problem with service. Please try latter');
    }

    return $pdo;
};

return [
    Request::class => function () {
        return Request::createFromGlobals();
    },
    LoggerInterface::class => $createLogger(),
    PDO::class => $createPdo($dbConnection, $createLogger()),

    LinkServiceInterface::class => create(LinkService::class)
        ->constructor(create(PDOLinkRepository::class)
            ->constructor(get(PDO::class))),

    LinkRepositoryAbstract::class => create(PDOLinkRepository::class)
        ->constructor(get(PDO::class)),

    Environment::class => function () {
        $loader = new FilesystemLoader(__DIR__ . '/../src/Little/Views');
        return new Environment($loader);
    }

];

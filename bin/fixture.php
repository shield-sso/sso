#!/usr/bin/php

<?php

define('BASE_PATH', __DIR__ . '/../');

require_once BASE_PATH . 'vendor/autoload.php';

use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Symfony\Component\Console\Application as Console;
use ShieldSSO\Application;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

$app = new Application;
$console = new Console;

$app['config'] = Yaml::parse(file_get_contents(BASE_PATH . 'resources/config/config.yml'));
if (getenv('DATABASE_URL') === false) {
    $app['parameters'] = Yaml::parse(file_get_contents(BASE_PATH . 'resources/config/parameters.yml'));
} else {
    $dbConfig = parse_url(getenv('DATABASE_URL'));

    $parameters = [
        'database' => [
            'driver' => 'pdo_pgsql',
            'host' => $dbConfig['host'],
            'port' => $dbConfig['port'],
            'dbname' => ltrim($dbConfig['path'], '/'),
            'user' => $dbConfig['user'],
            'password' => $dbConfig['pass'],
        ]
    ];

    $app['parameters'] = $parameters;
}

$app->register(new DoctrineServiceProvider, ['db.options' => $app['parameters']['database']]);
$app->register(new DoctrineOrmServiceProvider, [
    'orm.proxies_dir' => BASE_PATH . $app['config']['doctrine']['proxies_path'],
    'orm.em.options' => [
        'mappings' => [
            [
                'type' => $app['config']['doctrine']['mapping']['type'],
                'namespace' => $app['config']['doctrine']['mapping']['namespace'],
                'path' => BASE_PATH . $app['config']['doctrine']['mapping']['path'],
            ]
        ]
    ]
]);

$app->boot();

$loader = new Loader();
$loader->loadFromDirectory(__DIR__ . '/../src/Fixture');

$purger = new ORMPurger();
$executor = new ORMExecutor($app['orm.em'], $purger);
$executor->execute($loader->getFixtures());

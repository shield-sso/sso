#!/usr/bin/php

<?php

define('BASE_PATH', __DIR__ . '/../');

require_once BASE_PATH . 'vendor/autoload.php';

use Kurl\Silex\Provider\DoctrineMigrationsProvider;
use Silex\Provider\DoctrineServiceProvider;
use Symfony\Component\Console\Application as Console;
use ShieldSSO\Application;
use Symfony\Component\Yaml\Yaml;

$app = new Application;
$console = new Console;

$app['config'] = Yaml::parse(file_get_contents(BASE_PATH . 'resources/config/config.yml'));
if (file_exists(BASE_PATH . 'resources/config/parameters.yml')) {
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
$app->register(
    new DoctrineMigrationsProvider,
    [
        'migrations.directory' => __DIR__ . '/../migrations',
        'migrations.name' => 'SSO Migrations',
        'migrations.namespace' => 'ShieldSSO\Migrations',
        'migrations.table_name' => 'soo_migrations',
    ]
);

$app->boot();

$console->setHelperSet($app['migrations.em_helper_set']);
$console->addCommands($app['migrations.commands']);

$console->run();

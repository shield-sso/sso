<?php

declare(strict_types = 1);

define('BASE_PATH', __DIR__ . '/../');

require_once BASE_PATH . 'vendor/autoload.php';

use ShieldSSO\Application;
use ShieldSSO\Provider\OAuthServerProvider;
use ShieldSSO\Provider\RoutingProvider;
use Symfony\Component\Yaml\Yaml;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;

$app = new Application;

$config = Yaml::parse(file_get_contents(BASE_PATH . 'resources/config/config.yml'));
$parameters = Yaml::parse(file_get_contents(BASE_PATH . 'resources/config/parameters.yml'));

$app->register(new TwigServiceProvider, ['twig.path' => BASE_PATH . $config['twig']['views_path']]);
$app->register(new DoctrineServiceProvider, ['db.options' => $parameters['database']]);
$app->register(new DoctrineOrmServiceProvider, [
    'orm.proxies_dir' => BASE_PATH . $config['doctrine']['proxies_path'],
    'orm.em.options' => [
        'mappings' => [
            [
                'type' => $config['doctrine']['mapping']['type'],
                'namespace' => $config['doctrine']['mapping']['namespace'],
                'path' => BASE_PATH . $config['doctrine']['mapping']['path'],
            ]
        ]
    ]
]);
$app->register(new OAuthServerProvider);

$app->mount('/', new RoutingProvider);

$app->run();

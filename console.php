<?php

declare(strict_types = 1);

define('BASE_PATH', __DIR__ . '/');

require_once BASE_PATH . 'vendor/autoload.php';

use ShieldSSO\Application;
use ShieldSSO\Provider\AccessTokenRepositoryProvider;
use ShieldSSO\Provider\AuthorizationCodeRepositoryProvider;
use ShieldSSO\Provider\ClientRepositoryProvider;
use ShieldSSO\Provider\RefreshTokenRepositoryProvider;
use ShieldSSO\Provider\ScopeRepositoryProvider;
use ShieldSSO\Provider\UserRepositoryProvider;
use Symfony\Component\Yaml\Yaml;
use Silex\Provider\DoctrineServiceProvider;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;

$app = new Application;

$app['config'] = Yaml::parse(file_get_contents(BASE_PATH . 'resources/config/config.yml'));
$app['parameters'] = Yaml::parse(file_get_contents(BASE_PATH . 'resources/config/parameters.yml'));

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

$app->register(new UserRepositoryProvider);
$app->register(new ScopeRepositoryProvider);
$app->register(new ClientRepositoryProvider);
$app->register(new AuthorizationCodeRepositoryProvider);
$app->register(new AccessTokenRepositoryProvider);
$app->register(new RefreshTokenRepositoryProvider);


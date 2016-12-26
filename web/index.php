<?php

declare(strict_types = 1);

define('BASE_PATH', __DIR__ . '/../');
require_once BASE_PATH . 'vendor/autoload.php';

$app = new ShieldSSO\Application;
$app['config'] = Symfony\Component\Yaml\Yaml::parse(
    file_get_contents(BASE_PATH . 'resources/config/config.yml')
);
$app['parameters'] = Symfony\Component\Yaml\Yaml::parse(
    file_get_contents(BASE_PATH . 'resources/config/parameters.yml')
);

$app->register(new Silex\Provider\TwigServiceProvider, [
    'twig.path' => BASE_PATH . $app['config']['twig']['views_path']
]);
$app->register(new Silex\Provider\DoctrineServiceProvider, [
    'db.options' => $app['parameters']['database']
]);
$app->register(new Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider, [
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

$app->register(new ShieldSSO\Provider\UserRepositoryProvider);
$app->register(new ShieldSSO\Provider\ScopeRepositoryProvider);
$app->register(new ShieldSSO\Provider\ClientRepositoryProvider);
$app->register(new ShieldSSO\Provider\AuthorizationCodeRepositoryProvider);
$app->register(new ShieldSSO\Provider\AccessTokenRepositoryProvider);
$app->register(new ShieldSSO\Provider\RefreshTokenRepositoryProvider);

$app->register(new ShieldSSO\Provider\OAuthServerProvider);

$app->register(new Silex\Provider\Psr7ServiceProvider);
$app->mount('/', new ShieldSSO\Provider\RoutingProvider);

$app->run();

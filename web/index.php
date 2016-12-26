<?php

declare(strict_types = 1);

define('BASE_PATH', __DIR__ . '/../');

require_once BASE_PATH . 'vendor/autoload.php';

use ShieldSSO\Application;
use ShieldSSO\Provider\RoutingProvider;
use ShieldSSO\Provider\AccessTokenRepositoryProvider;
use ShieldSSO\Provider\AuthorizationCodeRepositoryProvider;
use ShieldSSO\Provider\ClientRepositoryProvider;
use ShieldSSO\Provider\RefreshTokenRepositoryProvider;
use ShieldSSO\Provider\ScopeRepositoryProvider;
use ShieldSSO\Provider\UserRepositoryProvider;
use ShieldSSO\Provider\OAuthServerProvider;
use Symfony\Component\Yaml\Yaml;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\Psr7ServiceProvider;

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
$app->register(new Psr7ServiceProvider);

$app->register(new UserRepositoryProvider);
$app->register(new ScopeRepositoryProvider);
$app->register(new ClientRepositoryProvider);
$app->register(new AuthorizationCodeRepositoryProvider);
$app->register(new AccessTokenRepositoryProvider);
$app->register(new RefreshTokenRepositoryProvider);

$app->mount('/', new RoutingProvider);

$app->run();

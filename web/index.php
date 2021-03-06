<?php

declare(strict_types = 1);

define('BASE_PATH', __DIR__ . '/../');

require_once BASE_PATH . 'vendor/autoload.php';

use ShieldSSO\Application;
use ShieldSSO\Provider\OAuthResourceServerProvider;
use ShieldSSO\Provider\RoutingProvider;
use ShieldSSO\Provider\AccessTokenRepositoryProvider;
use ShieldSSO\Provider\AuthorizationCodeRepositoryProvider;
use ShieldSSO\Provider\ClientRepositoryProvider;
use ShieldSSO\Provider\RefreshTokenRepositoryProvider;
use ShieldSSO\Provider\ScopeRepositoryProvider;
use ShieldSSO\Provider\UserProvider;
use ShieldSSO\Provider\UserRepositoryProvider;
use ShieldSSO\Provider\OAuthServerProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Yaml\Yaml;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\Psr7ServiceProvider;

$app = new Application;

$app['config'] = Yaml::parse(file_get_contents(BASE_PATH . 'resources/config/config.yml'));
if (getenv('APP_ENV') === 'dev') {
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
        ],
        'oauth' => [
            'authorization_code_ttl' => 'PT10M',
            'access_token_ttl' => 'PT1H',
            'refresh_token_ttl' => 'P1M'
        ]
    ];

    $app['parameters'] = $parameters;
}

$app->register(new TwigServiceProvider, ['twig.path' => BASE_PATH . $app['config']['twig']['views_path']]);
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

$app->register(new OAuthServerProvider);
$app->register(new OAuthResourceServerProvider);
$app->register(new Psr7ServiceProvider);

$app->register(new SessionServiceProvider);
$app->register(new SecurityServiceProvider(), [
    'security.firewalls' => [
        'firewall' => [
            'anonymous' => true,
            'pattern' => '^.*$',
            'form' => ['login_path' => '/login', 'check_path' => '/check'],
            'logout' => ['logout_path' => '/logout', 'invalidate_session' => true],
            'users' => function () use ($app) {
                return new UserProvider($app['db']);
            }
        ]
    ]
]);

$authHandler = new class implements AuthenticationSuccessHandlerInterface {
    public $app;

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $uri = $this->app['session']->getFlashBag()->get('auth_redirect');
        if (isset($uri[0])) {
            return $this->app->redirect((string) $uri[0]);
        }

        return $this->app->redirect($this->app['url_generator']->generate('homepage'));
    }
};
$authHandler->app = $app;

$app['security.authentication.success_handler.firewall'] = $authHandler;

$app->register(new SwiftmailerServiceProvider);

$app->register(new UserRepositoryProvider);
$app->register(new ScopeRepositoryProvider);
$app->register(new ClientRepositoryProvider);
$app->register(new AuthorizationCodeRepositoryProvider);
$app->register(new AccessTokenRepositoryProvider);
$app->register(new RefreshTokenRepositoryProvider);

$app->mount('/', new RoutingProvider);

$app->run();

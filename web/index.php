<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use ShieldSSO\Application;
use ShieldSSO\Entity\Client;
use ShieldSSO\OAuth\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;

$app = new Application();
$app['debug'] = true;

$app->register(new TwigServiceProvider, ['twig.path' => __DIR__ . '/../resources/views']);
$app->register(new DoctrineServiceProvider, [
    'db.options' => [
        'driver' => 'pdo_pgsql',
        'host' => '127.0.0.1',
        'port' => 5432,
        'dbname' => 'shieldsso_sso',
        'user' => '',
        'password' => ''
    ]
]);
$app->register(new DoctrineOrmServiceProvider,
    [
        'orm.proxies_dir' => __DIR__ . '/../var/cache/proxy',
        'orm.em.options' => [
            'mappings' => [
                [
                    'type' => 'simple_yml',
                    'namespace' => 'ShieldSSO\Entity',
                    'path' => __DIR__ . '/../resources/config/doctrine_mapping',
                ]
            ]
        ]
    ]
);

$app->get('/', function () use ($app) {
    return $app->render('index.html.twig');
});

$app->get('/authorize', function () use ($app) {
    $clientRepository = new ClientRepository;

    /** @var EntityManager $em */
    $em = $app['orm.em'];
    $repository = $em->getRepository(Client::class);

    return new JsonResponse(
        [
            'authorization_code' => 'code',
            'repository' => str_replace('\\', '.', get_class($repository))
        ]
    );
});

$app->run();

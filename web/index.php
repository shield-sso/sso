<?php

declare(strict_types = 1);

define('BASE_PATH', __DIR__ . '/../');

require_once BASE_PATH . 'vendor/autoload.php';

use ShieldSSO\Application;
use ShieldSSO\Entity\Client;
use ShieldSSO\OAuth\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Yaml\Yaml;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Doctrine\ORM\EntityManager;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;

$app = new Application;

$config = Yaml::parse(file_get_contents(BASE_PATH . 'resources/config/config.yml'));
$config['parameters'] = Yaml::parse(file_get_contents(BASE_PATH . 'resources/config/parameters.yml'));

$app->register(new TwigServiceProvider, ['twig.path' => BASE_PATH . $config['twig']['views_path']]);
$app->register(new DoctrineServiceProvider, ['db.options' => $config['parameters']['database']]);
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

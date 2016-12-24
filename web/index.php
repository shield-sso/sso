<?php

require_once __DIR__ . '/../vendor/autoload.php';

use ShieldSSO\Application;
use ShieldSSO\OAuth\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Silex\Provider\TwigServiceProvider;

$app = new Application();
$app['debug'] = true;

$app->register(new TwigServiceProvider, ['twig.path' => __DIR__ . '/../resources/views']);

$app->get('/', function () use ($app) {
    return $app->render('index.html.twig');
});

$app->get('/authorize', function () {
    $clientRepository = new ClientRepository;

    return new JsonResponse(['authorization_code' => 'code']);
});

$app->run();

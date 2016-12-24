<?php

require_once __DIR__ . '/../vendor/autoload.php';

use ShieldSSO\Application;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;

$app = new Application();
$app['debug'] = true;

$app->register(new TwigServiceProvider, ['twig.path' => __DIR__ . '/../resources/views']);

$app->get('/', function () use ($app) {
    return $app->render('index.html.twig');
});

$app->get('/authorize', function () {
    return new JsonResponse(['authorization_code' => 'code']);
});

$app->run();

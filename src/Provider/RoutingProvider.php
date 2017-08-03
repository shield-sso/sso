<?php

declare(strict_types = 1);

namespace ShieldSSO\Provider;

use ShieldSSO\Controller\ApiController;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;
use ShieldSSO\Controller\IndexController;
use ShieldSSO\Controller\OAuthController;
use League\OAuth2\Server\Middleware\ResourceServerMiddleware;

class RoutingProvider implements ControllerProviderInterface
{
    /**
     * @inheritdoc
     */
    public function connect(Application $app): ControllerCollection
    {
        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers->get('/', IndexController::class . '::indexAction')->bind('homepage');
        $controllers->get('/authorize', OAuthController::class . '::authorizeAction')->bind('authorize');
        $controllers->get('/token', OAuthController::class . '::tokenAction')->bind('token');
        $controllers->get('/data', ApiController::class . '::dataAction')->bind('data');

        new ResourceServerMiddleware($app['oauth.resource_server']);

        return $controllers;
    }
}

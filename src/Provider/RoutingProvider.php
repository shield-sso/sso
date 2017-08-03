<?php

declare(strict_types = 1);

namespace ShieldSSO\Provider;

use Exception;
use League\OAuth2\Server\Exception\OAuthServerException;
use ShieldSSO\Controller\ApiController;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;
use ShieldSSO\Controller\IndexController;
use ShieldSSO\Controller\OAuthController;
use League\OAuth2\Server\Middleware\ResourceServerMiddleware;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Component\HttpFoundation\Request;
use League\OAuth2\Server\ResourceServer;
use Zend\Diactoros\Response;

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
        $controllers->post('/token', OAuthController::class . '::tokenAction')->bind('token');
        $controllers->get('/data', ApiController::class . '::dataAction')->bind('data')->before(
            function (Request $request, Application $app) {
                $response = new Response;

                try {
                    /** @var ResourceServer $server */
                    $server = $app['oauth.resource_server'];
                    $server->validateAuthenticatedRequest((new DiactorosFactory)->createRequest($request));
                } catch (OAuthServerException $exception) {
                    return $exception->generateHttpResponse($response);
                } catch (Exception $exception) {
                    $response->getBody()->write(json_encode(['message' => 'Unknown error occurred']));

                    return $response->withStatus(500);
                }
            }
        );

        new ResourceServerMiddleware($app['oauth.resource_server']);

        return $controllers;
    }
}

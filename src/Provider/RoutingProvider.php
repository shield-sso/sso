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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use League\OAuth2\Server\ResourceServer;

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
                try {
                    /** @var ResourceServer $server */
                    $server = $app['oauth.resource_server'];
                    $psrRequestFactory = new DiactorosFactory;
                    $psrRequest = $psrRequestFactory->createRequest($request);
                    $psrRequest = $server->validateAuthenticatedRequest($psrRequest);

                    trigger_error($psrRequest->getAttribute('oauth_access_token_id'));
                    trigger_error($psrRequest->getAttribute('oauth_client_id'));
                    trigger_error($psrRequest->getAttribute('oauth_user_id'));
                    trigger_error($psrRequest->getAttribute('oauth_scopes'));

                    $request->attributes->set('oauth_user_id', $psrRequest->getAttribute('oauth_user_id'));
                } catch (OAuthServerException $exception) {
                    return new JsonResponse([
                        'error' => $exception->getErrorType(),
                        'message' => $exception->getMessage(),
                    ], $exception->getHttpStatusCode());
                } catch (Exception $exception) {
                    return new JsonResponse(['message' => 'Unknown error occurred'], 500);
                }

                return null;
            }
        );

        new ResourceServerMiddleware($app['oauth.resource_server']);

        return $controllers;
    }
}

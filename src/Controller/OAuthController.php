<?php

declare(strict_types = 1);

namespace ShieldSSO\Controller;

use Exception;
use ShieldSSO\Application;
use ShieldSSO\OAuth\Entity\User as OAuthUser;
use ShieldSSO\Contract\Repository\UserRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;

class OAuthController
{
    /**
     * @param Application $app
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function authorizeAction(Application $app, ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response;

        try {
            /** @var AuthorizationServer $server */
            /** @var UserRepositoryInterface $userRepository */

            $server = $app['oauth.server'];
            $authRequest = $server->validateAuthorizationRequest($request);

            $token = $app['security.token_storage']->getToken();
            $user = $token->getUser();

            $oauthUser = new OAuthUser;
            $oauthUser->setLogin($user->getLogin());
            $authRequest->setUser($oauthUser);
            $authRequest->setAuthorizationApproved(true);

            return $server->completeAuthorizationRequest($authRequest, $response);
        } catch (OAuthServerException $exception) {
            return $exception->generateHttpResponse($response);
        } catch (Exception $exception) {
            $response->getBody()->write(json_encode(['message' => 'Unknown error occurred']));

            return $response->withStatus(500);
        }
    }

    /**
     * @param Application $app
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function tokenAction(Application $app, ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response;

        try {
            /** @var AuthorizationServer $server */

            $server = $app['oauth.server'];

            return $server->respondToAccessTokenRequest($request, $response);

        } catch (OAuthServerException $exception) {
            return $exception->generateHttpResponse($response);
        } catch (Exception $exception) {
            $response->getBody()->write(json_encode(['message' => 'Unknown error occurred']));

            return $response->withStatus(500);
        }
    }
}

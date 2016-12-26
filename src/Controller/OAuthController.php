<?php

declare(strict_types = 1);

namespace ShieldSSO\Controller;

use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ResponseInterface;
use ShieldSSO\Application;
use Psr\Http\Message\ServerRequestInterface;
use ShieldSSO\Contract\Repository\UserRepositoryInterface;
use ShieldSSO\Entity\User;
use ShieldSSO\OAuth\Entity\User as OAuthUser;
use Zend\Diactoros\Response;
use Zend\Diactoros\Stream;

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
        try {
            /** @var AuthorizationServer $server */
            /** @var EntityManagerInterface $entityManager */
            /** @var UserRepositoryInterface $userRepository */

            $server = $app['oauth.server'];
            $authRequest = $server->validateAuthorizationRequest($request);

            $entityManager = $app['orm.em'];
            $userRepository = $entityManager->getRepository(User::class);
            $user = $userRepository->getById(1);

            $oauthUser = new OAuthUser;
            $oauthUser->setLogin($user->getLogin());
            $authRequest->setUser($oauthUser);
            $authRequest->setAuthorizationApproved(true);

            return $server->completeAuthorizationRequest($authRequest, new Response);
        } catch (OAuthServerException $exception) {
            $response = new Response;

            return $exception->generateHttpResponse($response);
        } catch (\Exception $exception) {
            $body = new Stream('php://temp', 'r+');
            $body->write($exception->getMessage());
            $response = new Response;

            return $response->withStatus(500)->withBody($body);
        }
    }
}

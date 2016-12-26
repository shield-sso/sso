<?php

declare(strict_types = 1);

namespace ShieldSSO\Provider;

use DateInterval;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use ShieldSSO\Entity\AccessToken;
use ShieldSSO\Entity\AuthorizationCode;
use ShieldSSO\Entity\Client;
use ShieldSSO\Entity\RefreshToken;
use ShieldSSO\Entity\Scope;
use ShieldSSO\Entity\User;
use ShieldSSO\OAuth\Repository\AccessTokenRepository;
use ShieldSSO\OAuth\Repository\AuthorizationCodeRepository;
use ShieldSSO\OAuth\Repository\ClientRepository;
use ShieldSSO\OAuth\Repository\RefreshTokenRepository;
use ShieldSSO\OAuth\Repository\ScopeRepository;
use ShieldSSO\Repository\ClientRepository as AppClientRepository;
use ShieldSSO\Repository\ScopeRepository as AppScopeRepository;
use ShieldSSO\Repository\UserRepository as AppUserRepository;
use ShieldSSO\Repository\AccessTokenRepository as AppAccessTokenRepository;
use ShieldSSO\Repository\RefreshTokenRepository as AppRefreshTokenRepository;
use ShieldSSO\Repository\AuthorizationCodeRepository as AppAuthorizationCodeRepository;

class OAuthServerProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function register(Container $container)
    {
        $container['oauth.server'] = function ($container) {
            /** @var EntityManagerInterface $entityManager */
            /** @var AppClientRepository $appClientRepository */
            /** @var AppScopeRepository $appScopeRepository */
            /** @var AppUserRepository $appUserRepository */
            /** @var AppAccessTokenRepository $appAccessTokenRepository */
            /** @var AppAuthorizationCodeRepository $appAuthorizationCodeRepository */
            /** @var AppRefreshTokenRepository $appRefreshTokenRepository */

            $entityManager = $container['orm.em'];

            $appClientRepository = $entityManager->getRepository(Client::class);
            $clientRepository = new ClientRepository($appClientRepository);

            $appScopeRepository = $entityManager->getRepository(Scope::class);
            $scopeRepository = new ScopeRepository($appScopeRepository);

            $appUserRepository = $entityManager->getRepository(User::class);
            $appAccessTokenRepository = $entityManager->getRepository(AccessToken::class);
            $accessTokenRepository = new AccessTokenRepository(
                $appAccessTokenRepository,
                $appClientRepository,
                $appUserRepository,
                $appScopeRepository
            );

            $appAuthorizationCodeRepository = $entityManager->getRepository(AuthorizationCode::class);
            $authCodeRepository = new AuthorizationCodeRepository(
                $appAuthorizationCodeRepository,
                $appClientRepository,
                $appUserRepository,
                $appScopeRepository
            );

            $appRefreshTokenRepository = $entityManager->getRepository(RefreshToken::class);
            $refreshTokenRepository = new RefreshTokenRepository(
                $appRefreshTokenRepository,
                $appAccessTokenRepository
            );

            $privateKey = 'file://path/to/private.key';
            $publicKey = 'file://path/to/public.key';

            $server = new AuthorizationServer(
                $clientRepository,
                $accessTokenRepository,
                $scopeRepository,
                $privateKey,
                $publicKey
            );

            $grant = new AuthCodeGrant(
                $authCodeRepository,
                $refreshTokenRepository,
                new DateInterval('PT10M')
            );
            $grant->setRefreshTokenTTL(new DateInterval('P1M'));
            $server->enableGrantType($grant, new DateInterval('PT1H'));

            return $server;
        };
    }
}

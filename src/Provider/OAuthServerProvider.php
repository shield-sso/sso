<?php

declare(strict_types = 1);

namespace ShieldSSO\Provider;

use DateInterval;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
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
        $container['oauth.server'] = function (Container $container): AuthorizationServer {
            /** @var AppClientRepository $appClientRepository */
            /** @var AppScopeRepository $appScopeRepository */
            /** @var AppUserRepository $appUserRepository */
            /** @var AppAccessTokenRepository $appAccessTokenRepository */
            /** @var AppAuthorizationCodeRepository $appAuthorizationCodeRepository */
            /** @var AppRefreshTokenRepository $appRefreshTokenRepository */

            $appClientRepository = $container['repository.client'];
            $appScopeRepository = $container['repository.scope'];
            $appUserRepository = $container['repository.user'];
            $appAuthorizationCodeRepository = $container['repository.authorization_code'];
            $appAccessTokenRepository = $container['repository.access_token'];
            $appRefreshTokenRepository = $container['repository.refresh_token'];

            $clientRepository = new ClientRepository($appClientRepository);
            $scopeRepository = new ScopeRepository($appScopeRepository);
            $accessTokenRepository = new AccessTokenRepository(
                $appAccessTokenRepository,
                $appClientRepository,
                $appUserRepository,
                $appScopeRepository
            );
            $authCodeRepository = new AuthorizationCodeRepository(
                $appAuthorizationCodeRepository,
                $appClientRepository,
                $appUserRepository,
                $appScopeRepository
            );
            $refreshTokenRepository = new RefreshTokenRepository(
                $appRefreshTokenRepository,
                $appAccessTokenRepository
            );

            $server = new AuthorizationServer(
                $clientRepository,
                $accessTokenRepository,
                $scopeRepository,
                __DIR__ . '/../../resources/keys/private.key',
                __DIR__ . '/../../resources/keys/public.key'
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

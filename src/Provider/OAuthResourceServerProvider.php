<?php

declare(strict_types = 1);

namespace ShieldSSO\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use League\OAuth2\Server\ResourceServer;
use ShieldSSO\OAuth\Repository\AccessTokenRepository;
use ShieldSSO\Repository\ClientRepository as AppClientRepository;
use ShieldSSO\Repository\ScopeRepository as AppScopeRepository;
use ShieldSSO\Repository\UserRepository as AppUserRepository;
use ShieldSSO\Repository\AccessTokenRepository as AppAccessTokenRepository;

class OAuthResourceServerProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function register(Container $container)
    {
        $container['oauth.resource_server'] = function (Container $container): ResourceServer {
            /** @var AppClientRepository $appClientRepository */
            /** @var AppScopeRepository $appScopeRepository */
            /** @var AppUserRepository $appUserRepository */
            /** @var AppAccessTokenRepository $appAccessTokenRepository */

            $appClientRepository = $container['repository.client'];
            $appScopeRepository = $container['repository.scope'];
            $appUserRepository = $container['repository.user'];
            $appAccessTokenRepository = $container['repository.access_token'];

            $accessTokenRepository = new AccessTokenRepository(
                $appAccessTokenRepository,
                $appClientRepository,
                $appUserRepository,
                $appScopeRepository
            );

            $server = new ResourceServer(
                $accessTokenRepository,
                __DIR__ . '/../../' . $container['config']['oauth']['public_key_path']
            );

            return $server;
        };
    }
}

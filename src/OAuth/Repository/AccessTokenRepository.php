<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Repository;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use ShieldSSO\Entity\AccessToken as AppAccessToken;
use ShieldSSO\Entity\Scope;
use ShieldSSO\OAuth\Entity\AccessToken;
use ShieldSSO\Repository\AccessTokenRepository as AppAccessTokenRepository;
use ShieldSSO\Repository\ClientRepository as AppClientRepository;
use ShieldSSO\Repository\UserRepository as AppUserRepository;
use ShieldSSO\Repository\ScopeRepository as AppScopeRepository;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    /** @var AppAccessTokenRepository */
    private $appAccessTokenRepository;

    /** @var AppClientRepository */
    private $appClientRepository;

    /** @var AppUserRepository */
    private $appUserRepository;

    /** @var AppScopeRepository */
    private $appScopeRepository;

    /**
     * @param AppAccessTokenRepository $appAccessTokenRepository
     * @param AppClientRepository $appClientRepository
     * @param AppUserRepository $appUserRepository
     * @param AppScopeRepository $appScopeRepository
     */
    public function __construct(
        AppAccessTokenRepository $appAccessTokenRepository,
        AppClientRepository $appClientRepository,
        AppUserRepository $appUserRepository,
        AppScopeRepository $appScopeRepository)
    {
        $this->appAccessTokenRepository = $appAccessTokenRepository;
        $this->appClientRepository = $appClientRepository;
        $this->appUserRepository = $appUserRepository;
        $this->appScopeRepository = $appScopeRepository;
    }

    /**
     * @inheritdoc
     */
    public function getNewToken(
        ClientEntityInterface $clientEntity,
        array $scopes,
        $userIdentifier = null): AccessTokenEntityInterface
    {
        return new AccessToken;
    }

    /**
     * @inheritdoc
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity): void
    {
        $appAccessToken = new AppAccessToken;
        $appAccessToken->setCode($accessTokenEntity->getIdentifier());
        $appAccessToken->setExpiryDateTime($accessTokenEntity->getExpiryDateTime());

        $client = $this->appClientRepository->getByName($accessTokenEntity->getClient()->getName());
        $appAccessToken->setClient($client);
        $client->addAccessToken($appAccessToken);

        $user = $this->appUserRepository->getByLogin($accessTokenEntity->getUserIdentifier());
        $appAccessToken->setUser($user);
        $user->addAccessToken($appAccessToken);

        $scopeNames = [];
        foreach ($accessTokenEntity->getScopes() as $scope) {
            $scopeNames[] = $scope->getIdentifier();
        }

        $scopes = $this->appScopeRepository->getByNames($scopeNames);
        foreach ($scopes as $scope) {
            /** @var Scope $scope */
            $appAccessToken->addScope($scope);
            $scope->addAccessToken($appAccessToken);
        }

        $this->appAccessTokenRepository->persist($appAccessToken);
        $this->appAccessTokenRepository->flush();
    }

    /**
     * @inheritdoc
     */
    public function revokeAccessToken($code): void
    {
        $accessToken = $this->appAccessTokenRepository->getByCode($code);
        $accessToken->setRevoked(true);

        $this->appAccessTokenRepository->persist($accessToken);
        $this->appAccessTokenRepository->flush();
    }

    /**
     * @inheritdoc
     */
    public function isAccessTokenRevoked($code): bool
    {
        $accessToken = $this->appAccessTokenRepository->getByCode($code);

        return $accessToken->isRevoked();
    }
}

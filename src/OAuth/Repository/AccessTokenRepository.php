<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Repository;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use ShieldSSO\Entity\AccessToken as AppAccessToken;
use ShieldSSO\Entity\Scope as AppScope;
use ShieldSSO\OAuth\Entity\AccessToken;
use ShieldSSO\Contract\Repository\AccessTokenRepositoryInterface as AppAccessTokenRepositoryInterface;
use ShieldSSO\Contract\Repository\ClientRepositoryInterface as AppClientRepositoryInterface;
use ShieldSSO\Contract\Repository\UserRepositoryInterface as AppUserRepositoryInterface;
use ShieldSSO\Contract\Repository\ScopeRepositoryInterface as AppScopeRepositoryInterface;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    /** @var AppAccessTokenRepositoryInterface */
    private $appAccessTokenRepository;

    /** @var AppClientRepositoryInterface */
    private $appClientRepository;

    /** @var AppUserRepositoryInterface */
    private $appUserRepository;

    /** @var AppScopeRepositoryInterface */
    private $appScopeRepository;

    /**
     * @param AppAccessTokenRepositoryInterface $appAccessTokenRepository
     * @param AppClientRepositoryInterface $appClientRepository
     * @param AppUserRepositoryInterface $appUserRepository
     * @param AppScopeRepositoryInterface $appScopeRepository
     */
    public function __construct(
        AppAccessTokenRepositoryInterface $appAccessTokenRepository,
        AppClientRepositoryInterface $appClientRepository,
        AppUserRepositoryInterface $appUserRepository,
        AppScopeRepositoryInterface $appScopeRepository)
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
            /** @var AppScope $scope */
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

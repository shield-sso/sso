<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Repository;

use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use ShieldSSO\Contract\Repository\AuthorizationCodeRepositoryInterface as AppAuthorizationCodeRepositoryInterface;
use ShieldSSO\Contract\Repository\ClientRepositoryInterface as AppClientRepositoryInterface;
use ShieldSSO\Contract\Repository\UserRepositoryInterface as AppUserRepositoryInterface;
use ShieldSSO\Contract\Repository\ScopeRepositoryInterface as AppScopeRepositoryInterface;
use ShieldSSO\OAuth\Entity\AuthorizationCode;
use ShieldSSO\Entity\AuthorizationCode as AppAuthorizationCode;
use ShieldSSO\Entity\Scope as AppScope;

class AuthorizationCodeRepository implements AuthCodeRepositoryInterface
{
    /** @var AppAuthorizationCodeRepositoryInterface */
    private $appAuthorizationCodeRepository;

    /** @var AppClientRepositoryInterface */
    private $appClientRepository;

    /** @var AppUserRepositoryInterface */
    private $appUserRepository;

    /** @var AppScopeRepositoryInterface */
    private $appScopeRepository;

    public function __construct(
        AppAuthorizationCodeRepositoryInterface $appAuthorizationCodeRepository,
        AppClientRepositoryInterface $appClientRepository,
        AppUserRepositoryInterface $appUserRepository,
        AppScopeRepositoryInterface $appScopeRepository)
    {
        $this->appAuthorizationCodeRepository = $appAuthorizationCodeRepository;
        $this->appClientRepository = $appClientRepository;
        $this->appUserRepository = $appUserRepository;
        $this->appScopeRepository = $appScopeRepository;
    }

    /**
     * @inheritdoc
     */
    public function getNewAuthCode(): AuthCodeEntityInterface
    {
        return new AuthorizationCode;
    }

    /**
     * @inheritdoc
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authorizationCodeEntity): void
    {
        $appAuthorizationCode = new AppAuthorizationCode;
        $appAuthorizationCode->setCode($authorizationCodeEntity->getIdentifier());
        $appAuthorizationCode->setExpiryDateTime($authorizationCodeEntity->getExpiryDateTime());
        $appAuthorizationCode->setRedirectUri($authorizationCodeEntity->getRedirectUri());

        $client = $this->appClientRepository->getByName($authorizationCodeEntity->getClient()->getName());
        $appAuthorizationCode->setClient($client);
        $client->addAccessToken($appAuthorizationCode);

        $user = $this->appUserRepository->getByLogin($authorizationCodeEntity->getUserIdentifier());
        $appAuthorizationCode->setUser($user);
        $user->addAccessToken($appAuthorizationCode);

        $scopeNames = [];
        foreach ($authorizationCodeEntity->getScopes() as $scope) {
            $scopeNames[] = $scope->getIdentifier();
        }

        $scopes = $this->appScopeRepository->getByNames($scopeNames);
        foreach ($scopes as $scope) {
            /** @var AppScope $scope */
            $appAuthorizationCode->addScope($scope);
            $scope->addAccessToken($appAuthorizationCode);
        }

        $this->appAuthorizationCodeRepository->persist($appAuthorizationCode);
        $this->appAuthorizationCodeRepository->flush();
    }

    /**
     * @inheritdoc
     */
    public function revokeAuthCode($code): void
    {
        $authorizationCode = $this->appAuthorizationCodeRepository->getByCode($code);
        $authorizationCode->setRevoked(true);

        $this->appAuthorizationCodeRepository->persist($authorizationCode);
        $this->appAuthorizationCodeRepository->flush();
    }

    /**
     * @inheritdoc
     */
    public function isAuthCodeRevoked($code): bool
    {
        $authorizationCode = $this->appAuthorizationCodeRepository->getByCode($code);

        return $authorizationCode->isRevoked();
    }
}

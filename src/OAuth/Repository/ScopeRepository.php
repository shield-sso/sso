<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Repository;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use ShieldSSO\OAuth\Entity\Scope;
use ShieldSSO\Repository\ScopeRepository as AppRepository;

class ScopeRepository implements ScopeRepositoryInterface
{
    /** @var AppRepository */
    private $appRepository;

    /**
     * @param AppRepository $appRepository
     */
    public function __construct(AppRepository $appRepository)
    {
        $this->appRepository = $appRepository;
    }

    /**
     * @inheritdoc
     */
    public function getScopeEntityByIdentifier($identifier): ScopeEntityInterface
    {
        $appScope = $this->appRepository->getByName($identifier);

        if (!$appScope) {
            return null;
        }

        $scope = new Scope;
        $scope->setName($appScope->getName());

        return $scope;
    }

    /**
     * @inheritdoc
     */
    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    ): array
    {
        return $scopes;
    }
}

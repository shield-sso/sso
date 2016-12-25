<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Repository;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use ShieldSSO\OAuth\Entity\Scope;

class ScopeRepository implements ScopeRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getScopeEntityByIdentifier($identifier): ScopeEntityInterface
    {
        return new Scope;
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
        return [];
    }
}

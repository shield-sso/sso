<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Entity;

use League\OAuth2\Server\Entities\ScopeEntityInterface;

class Scope implements ScopeEntityInterface
{
    /**
     * @inheritdoc
     */
    public function getIdentifier(): string
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    function jsonSerialize(): array
    {
        return [];
    }
}

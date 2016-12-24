<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Entity;

use League\OAuth2\Server\Entities\ClientEntityInterface;

class Client implements ClientEntityInterface
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
    public function getName(): string
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function getRedirectUri(): string
    {
        return '';
    }
}

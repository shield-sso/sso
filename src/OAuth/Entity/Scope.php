<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Entity;

use League\OAuth2\Server\Entities\ScopeEntityInterface;

class Scope implements ScopeEntityInterface
{
    /** @var string|null */
    private $name = null;

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getIdentifier(): ?string
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    function jsonSerialize(): ?string
    {
        return $this->name;
    }
}

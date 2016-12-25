<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Entity;

use League\OAuth2\Server\Entities\ClientEntityInterface;

class Client implements ClientEntityInterface
{
    /** @var integer */
    private $appEntityId;

    /** @var string|null */
    private $name = null;

    /** @var string|null */
    private $redirectUri = null;

    /**
     * @param integer $appEntityId
     */
    public function setAppEntityId(int $appEntityId): void
    {
        $this->appEntityId = $appEntityId;
    }

    /**
     * @return integer
     */
    public function getAppEntityId(): int
    {
        return $this->appEntityId;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $redirectUri
     */
    public function setRedirectUri(string $redirectUri): void
    {
        $this->redirectUri = $redirectUri;
    }

    /**
     * @inheritdoc
     */
    public function getIdentifier(): string
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getRedirectUri(): string
    {
        return $this->redirectUri;
    }
}

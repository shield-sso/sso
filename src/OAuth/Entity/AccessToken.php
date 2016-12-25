<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Entity;

use DateTime;
use DateTimeInterface;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;

class AccessToken implements AccessTokenEntityInterface
{
    use AccessTokenTrait;

    /** @var string */
    private $code;

    /** @var DateTimeInterface */
    private $expiryDateTime;

    /** @var string */
    private $userIdentifier;

    /** @var ClientEntityInterface */
    private $client;

    /** @var ScopeEntityInterface[] */
    private $scopes;

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @inheritdoc
     */
    public function setIdentifier($identifier): void
    {
        $this->code = $identifier;
    }

    /**
     * @inheritdoc
     */
    public function getIdentifier(): string
    {
        return $this->code;
    }

    /**
     * @inheritdoc
     */
    public function setExpiryDateTime(DateTime $dateTime): void
    {
        $this->expiryDateTime = $dateTime;
    }

    /**
     * @inheritdoc
     */
    public function getExpiryDateTime(): DateTimeInterface
    {
        return $this->expiryDateTime;
    }

    /**
     * @inheritdoc
     */
    public function setUserIdentifier($identifier): void
    {
        $this->userIdentifier = $identifier;
    }

    /**
     * @inheritdoc
     */
    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    /**
     * @inheritdoc
     */
    public function setClient(ClientEntityInterface $client): void
    {
        $this->client = $client;
    }

    /**
     * @inheritdoc
     */
    public function getClient(): ClientEntityInterface
    {
        return $this->client;
    }

    /**
     * @inheritdoc
     */
    public function addScope(ScopeEntityInterface $scope): void
    {
        $this->scopes[] = $scope;
    }

    /**
     * @inheritdoc
     */
    public function getScopes(): array
    {
        return $this->scopes;
    }
}

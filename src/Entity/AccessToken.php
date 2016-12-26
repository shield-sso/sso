<?php

declare(strict_types = 1);

namespace ShieldSSO\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection as CollectionInterface;
use ShieldSSO\Contract\Entity\AccessTokenInterface;
use ShieldSSO\Contract\Entity\ClientInterface;
use ShieldSSO\Contract\Entity\ScopeInterface;
use ShieldSSO\Contract\Entity\UserInterface;

class AccessToken extends AbstractEntity implements AccessTokenInterface
{
    /** @var string|null */
    private $code = null;

    /** @var DateTimeInterface|null */
    private $expiryDateTime = null;

    /** @var boolean */
    private $revoked = false;

    /** @var User|null */
    private $user = null;

    /** @var Client|null */
    private $client = null;

    /** @var CollectionInterface */
    private $scopes;

    /**
     * @inheritdoc
     */
    public function __construct(int $id = null)
    {
        parent::__construct($id);
        $this->scopes = new ArrayCollection;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param DateTimeInterface $expiryDateTime
     */
    public function setExpiryDateTime(DateTimeInterface $expiryDateTime): void
    {
        $this->expiryDateTime = $expiryDateTime;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getExpiryDateTime(): ?DateTimeInterface
    {
        return $this->expiryDateTime;
    }

    /**
     * @param boolean $revoked
     */
    public function setRevoked(bool $revoked): void
    {
        $this->revoked = $revoked;
    }

    /**
     * @return boolean
     */
    public function isRevoked(): bool
    {
        return $this->revoked;
    }

    /**
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user): void
    {
        $this->user = $user;
    }

    /**
     * @return UserInterface|null
     */
    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client): void
    {
        $this->client = $client;
    }

    /**
     * @return ClientInterface|null
     */
    public function getClient(): ?ClientInterface
    {
        return $this->client;
    }

    /**
     * @param ScopeInterface $scope
     */
    public function addScope(ScopeInterface $scope): void
    {
        $this->scopes->add($scope);
    }

    /**
     * @return CollectionInterface
     */
    public function getScopes(): CollectionInterface
    {
        return $this->scopes;
    }

    /**
     * @param ScopeInterface $scope
     */
    public function removeScope(ScopeInterface $scope): void
    {
        $this->scopes->removeElement($scope);
    }
}

<?php

declare(strict_types = 1);

namespace ShieldSSO\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use ShieldSSO\Contract\Entity\AccessTokenInterface;

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

    /** @var ArrayCollection */
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
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    /**
     * @return Client|null
     */
    public function getClient(): ?Client
    {
        return $this->client;
    }

    /**
     * @param Scope $scope
     */
    public function addScope(Scope $scope): void
    {
        $this->scopes->add($scope);
    }

    /**
     * @return ArrayCollection
     */
    public function getScopes(): ArrayCollection
    {
        return $this->scopes;
    }

    /**
     * @param Scope $scope
     */
    public function removeScope(Scope $scope): void
    {
        $this->scopes->removeElement($scope);
    }
}

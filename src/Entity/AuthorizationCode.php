<?php

declare(strict_types = 1);

namespace ShieldSSO\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection as CollectionInterface;
use ShieldSSO\Contract\Entity\AuthorizationCodeInterface;
use ShieldSSO\Contract\Entity\ClientInterface;
use ShieldSSO\Contract\Entity\ScopeInterface;
use ShieldSSO\Contract\Entity\UserInterface;

class AuthorizationCode extends AbstractEntity implements AuthorizationCodeInterface
{
    /** @var string|null */
    private $code = null;

    /** @var DateTimeInterface|null */
    private $expiryDateTime = null;

    /** @var string|null */
    private $redirectUri = null;

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
     * @inheritdoc
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @inheritdoc
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @inheritdoc
     */
    public function setExpiryDateTime(DateTimeInterface $expiryDateTime): void
    {
        $this->expiryDateTime = $expiryDateTime;
    }

    /**
     * @inheritdoc
     */
    public function getExpiryDateTime(): ?DateTimeInterface
    {
        return $this->expiryDateTime;
    }

    /**
     * @inheritdoc
     */
    public function getRedirectUri(): ?string
    {
        return $this->redirectUri;
    }

    /**
     * @inheritdoc
     */
    public function setRedirectUri(string $redirectUri): void
    {
        $this->redirectUri = $redirectUri;
    }

    /**
     * @inheritdoc
     */
    public function setRevoked(bool $revoked): void
    {
        $this->revoked = $revoked;
    }

    /**
     * @inheritdoc
     */
    public function isRevoked(): bool
    {
        return $this->revoked;
    }

    /**
     * @inheritdoc
     */
    public function setUser(UserInterface $user): void
    {
        $this->user = $user;
    }

    /**
     * @inheritdoc
     */
    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    /**
     * @inheritdoc
     */
    public function setClient(ClientInterface $client): void
    {
        $this->client = $client;
    }

    /**
     * @inheritdoc
     */
    public function getClient(): ?ClientInterface
    {
        return $this->client;
    }

    /**
     * @inheritdoc
     */
    public function addScope(ScopeInterface $scope): void
    {
        $this->scopes->add($scope);
    }

    /**
     * @inheritdoc
     */
    public function getScopes(): CollectionInterface
    {
        return $this->scopes;
    }

    /**
     * @inheritdoc
     */
    public function removeScope(ScopeInterface $scope): void
    {
        $this->scopes->removeElement($scope);
    }
}

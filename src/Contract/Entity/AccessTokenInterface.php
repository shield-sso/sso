<?php

declare(strict_types = 1);

namespace ShieldSSO\Contract\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection as CollectionInterface;

interface AccessTokenInterface extends EntityInterface
{
    /**
     * @param string $code
     */
    public function setCode(string $code): void;

    /**
     * @return string|null
     */
    public function getCode(): ?string;

    /**
     * @param DateTimeInterface $expiryDateTime
     */
    public function setExpiryDateTime(DateTimeInterface $expiryDateTime): void;

    /**
     * @return DateTimeInterface|null
     */
    public function getExpiryDateTime(): ?DateTimeInterface;

    /**
     * @param boolean $revoked
     */
    public function setRevoked(bool $revoked): void;

    /**
     * @return boolean
     */
    public function isRevoked(): bool;

    /**
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user): void;

    /**
     * @return UserInterface|null
     */
    public function getUser(): ?UserInterface;

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client): void;

    /**
     * @return ClientInterface|null
     */
    public function getClient(): ?ClientInterface;

    /**
     * @param ScopeInterface $scope
     */
    public function addScope(ScopeInterface $scope): void;

    /**
     * @return CollectionInterface
     */
    public function getScopes(): CollectionInterface;

    /**
     * @param ScopeInterface $scope
     */
    public function removeScope(ScopeInterface $scope): void;

    /**
     * @param RefreshTokenInterface $refreshToken
     */
    public function setRefreshToken(RefreshTokenInterface $refreshToken): void;

    /**
     * @return RefreshTokenInterface|null
     */
    public function getRefreshToken(): ?RefreshTokenInterface;
}

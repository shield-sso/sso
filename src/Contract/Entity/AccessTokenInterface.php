<?php

declare(strict_types = 1);

namespace ShieldSSO\Contract\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use ShieldSSO\Entity\Client;
use ShieldSSO\Entity\Scope;
use ShieldSSO\Entity\User;

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
     * @param User $user
     */
    public function setUser(User $user): void;

    /**
     * @return User|null
     */
    public function getUser(): ?User;

    /**
     * @param Client $client
     */
    public function setClient(Client $client): void;

    /**
     * @return Client|null
     */
    public function getClient(): ?Client;

    /**
     * @param Scope $scope
     */
    public function addScope(Scope $scope): void;

    /**
     * @return ArrayCollection
     */
    public function getScopes(): ArrayCollection;

    /**
     * @param Scope $scope
     */
    public function removeScope(Scope $scope): void;
}

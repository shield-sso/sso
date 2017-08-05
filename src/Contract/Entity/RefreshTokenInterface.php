<?php

declare(strict_types = 1);

namespace ShieldSSO\Contract\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection as CollectionInterface;

interface RefreshTokenInterface extends EntityInterface
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
     * @param AccessTokenInterface $accessToken
     */
    public function setAccessToken(AccessTokenInterface $accessToken): void;

    /**
     * @return AccessTokenInterface|null
     */
    public function getAccessToken(): ?AccessTokenInterface;
}

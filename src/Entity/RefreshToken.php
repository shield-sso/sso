<?php

declare(strict_types = 1);

namespace ShieldSSO\Entity;

use DateTimeInterface;
use ShieldSSO\Contract\Entity\AccessTokenInterface;
use ShieldSSO\Contract\Entity\RefreshTokenInterface;

class RefreshToken extends AbstractEntity implements RefreshTokenInterface
{
    /** @var string|null */
    private $code = null;

    /** @var DateTimeInterface|null */
    private $expiryDateTime = null;

    /** @var boolean */
    private $revoked = false;

    /** @var AccessTokenInterface|null */
    private $accessToken = null;

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
    public function setAccessToken(AccessTokenInterface $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @inheritdoc
     */
    public function getAccessToken(): ?AccessTokenInterface
    {
        return $this->accessToken;
    }
}

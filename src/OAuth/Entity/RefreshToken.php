<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Entity;

use DateTime;
use DateTimeInterface;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;

class RefreshToken implements RefreshTokenEntityInterface
{
    /** @var string|null */
    private $code = null;

    /** @var DateTimeInterface|null */
    private $expiryDateTime = null;

    /** @var AccessTokenEntityInterface|null */
    private $accessToken = null;

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
     * @inheritdoc
     */
    public function setIdentifier($identifier): void
    {
        $this->code = $identifier;
    }

    /**
     * @inheritdoc
     */
    public function getIdentifier(): ?string
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
    public function getExpiryDateTime(): ?DateTimeInterface
    {
        return $this->expiryDateTime;
    }

    /**
     * @inheritdoc
     */
    public function setAccessToken(AccessTokenEntityInterface $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @inheritdoc
     */
    public function getAccessToken(): ?AccessTokenEntityInterface
    {
        return $this->accessToken;
    }
}

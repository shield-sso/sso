<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Repository;

use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use ShieldSSO\OAuth\Entity\RefreshToken;
use ShieldSSO\Contract\Repository\RefreshTokenRepositoryInterface as AppRepositoryInterface;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    /** @var AppRepositoryInterface */
    private $appRepository;

    /**
     * @param AppRepositoryInterface $appRepository
     */
    public function __construct(AppRepositoryInterface $appRepository)
    {
        $this->appRepository = $appRepository;
    }

    /**
     * @inheritdoc
     */
    public function getNewRefreshToken(): RefreshTokenEntityInterface
    {
        return new RefreshToken;
    }

    /**
     * @inheritdoc
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity): void
    {
    }

    /**
     * @inheritdoc
     */
    public function revokeRefreshToken($code): void
    {
        $refreshToken = $this->appRepository->getByCode($code);
        $refreshToken->setRevoked(true);

        $this->appRepository->persist($refreshToken);
        $this->appRepository->flush();
    }

    /**
     * @inheritdoc
     */
    public function isRefreshTokenRevoked($code): bool
    {
        $refreshToken = $this->appRepository->getByCode($code);

        return $refreshToken->isRevoked();
    }
}

<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Repository;

use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use ShieldSSO\OAuth\Entity\RefreshToken;
use ShieldSSO\Contract\Repository\RefreshTokenRepositoryInterface as AppRefreshTokenRepositoryInterface;
use ShieldSSO\Contract\Repository\AccessTokenRepositoryInterface as AppAccessTokenRepositoryInterface;
use ShieldSSO\Entity\RefreshToken as AppRefreshToken;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    /** @var AppRefreshTokenRepositoryInterface */
    private $appRefreshTokenRepository;

    /** @var AppAccessTokenRepositoryInterface */
    private $appAccessTokenRepository;

    /**
     * @param AppRefreshTokenRepositoryInterface $appRefreshTokenRepository
     * @param AppAccessTokenRepositoryInterface $appAccessTokenRepository
     */
    public function __construct(
        AppRefreshTokenRepositoryInterface $appRefreshTokenRepository,
        AppAccessTokenRepositoryInterface $appAccessTokenRepository)
    {
        $this->appRefreshTokenRepository = $appRefreshTokenRepository;
        $this->appAccessTokenRepository = $appAccessTokenRepository;
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
        $appRefreshToken = new AppRefreshToken;
        $appRefreshToken->setCode($refreshTokenEntity->getIdentifier());
        $appRefreshToken->setExpiryDateTime($refreshTokenEntity->getExpiryDateTime());

        $accessTokenCode = $refreshTokenEntity->getAccessToken()->getIdentifier();
        $appAccessToken = $this->appAccessTokenRepository->getByCode($accessTokenCode);
        $appRefreshToken->setAccessToken($appAccessToken);
        $appAccessToken->setRefreshToken($appRefreshToken);

        $this->appRefreshTokenRepository->persist($appRefreshToken);
        $this->appRefreshTokenRepository->flush();
    }

    /**
     * @inheritdoc
     */
    public function revokeRefreshToken($code): void
    {
        $refreshToken = $this->appRefreshTokenRepository->getByCode($code);
        $refreshToken->setRevoked(true);

        $this->appRefreshTokenRepository->persist($refreshToken);
        $this->appRefreshTokenRepository->flush();
    }

    /**
     * @inheritdoc
     */
    public function isRefreshTokenRevoked($code): bool
    {
        $refreshToken = $this->appRefreshTokenRepository->getByCode($code);

        return $refreshToken->isRevoked();
    }
}

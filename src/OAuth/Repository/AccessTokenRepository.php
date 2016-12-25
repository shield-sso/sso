<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Repository;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use ShieldSSO\OAuth\Entity\AccessToken;
use ShieldSSO\Repository\AccessTokenRepository as AppRepository;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    /** @var AppRepository */
    private $appRepository;

    /**
     * @param AppRepository $appRepository
     */
    public function __construct(AppRepository $appRepository)
    {
        $this->appRepository = $appRepository;
    }

    /**
     * @inheritdoc
     */
    public function getNewToken(
        ClientEntityInterface $clientEntity,
        array $scopes,
        $userIdentifier = null): AccessTokenEntityInterface
    {
        return new AccessToken;
    }

    /**
     * @inheritdoc
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity): void
    {
        
    }

    /**
     * @inheritdoc
     */
    public function revokeAccessToken($code): void
    {
        $accessToken = $this->appRepository->getByCode($code);
        $accessToken->setRevoked(true);

        $this->appRepository->persist($accessToken);
        $this->appRepository->flush();
    }

    /**
     * @inheritdoc
     */
    public function isAccessTokenRevoked($code): bool
    {
        $accessToken = $this->appRepository->getByCode($code);

        return $accessToken->isRevoked();
    }
}

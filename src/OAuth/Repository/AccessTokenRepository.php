<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Repository;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use ShieldSSO\Entity\AccessToken as AppAccessToken;
use ShieldSSO\OAuth\Entity\AccessToken;
use ShieldSSO\OAuth\Entity\Client;
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
        $appAccessToken = new AppAccessToken;
        $appAccessToken->setCode($accessTokenEntity->getIdentifier());
        $appAccessToken->setExpiryDateTime($accessTokenEntity->getExpiryDateTime());

        /** @var Client $client */
        $client = $accessTokenEntity->getClient();

        //client
        //user
        //scopes
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

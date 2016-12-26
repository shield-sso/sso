<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Repository;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use ShieldSSO\OAuth\Entity\Client;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use ShieldSSO\Contract\Repository\ClientRepositoryInterface as AppRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
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
    public function getClientEntity(
        $clientIdentifier,
        $grantType,
        $clientSecret = null,
        $mustValidateSecret = true): ClientEntityInterface
    {
        if ($grantType != 'authorization_code') {
            return null;
        }

        $appClient = $this->appRepository->getByName($clientIdentifier);
        if (!$appClient || ($mustValidateSecret && !password_verify($clientSecret, $appClient->getSecret()))) {
            return null;
        }

        $client = new Client;
        $client->setName($appClient->getName());
        $client->setRedirectUri($appClient->getRedirectUri());

        return $client;
    }
}

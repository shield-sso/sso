<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Repository;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use ShieldSSO\OAuth\Entity\Client;
use ShieldSSO\Repository\ClientRepository as AppRepository;

class ClientRepository implements ClientRepositoryInterface
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
        $client->setAppEntityId($appClient->getId());

        return $client;
    }
}

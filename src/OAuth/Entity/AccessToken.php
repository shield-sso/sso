<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Entity;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;

class AccessToken implements AccessTokenEntityInterface
{
    use AccessTokenTrait;

    /**
     * @inheritdoc
     */
    public function getIdentifier()
    {
    }

    /**
     * @inheritdoc
     */
    public function setIdentifier($identifier)
    {
    }

    /**
     * @inheritdoc
     */
    public function getExpiryDateTime()
    {
    }

    /**
     * @inheritdoc
     */
    public function setExpiryDateTime(\DateTime $dateTime)
    {
    }

    /**
     * @inheritdoc
     */
    public function setUserIdentifier($identifier)
    {
    }

    /**
     * @inheritdoc
     */
    public function getUserIdentifier()
    {
    }

    /**
     * @inheritdoc
     */
    public function getClient()
    {
    }

    /**
     * @inheritdoc
     */
    public function setClient(ClientEntityInterface $client)
    {
    }

    /**
     * @inheritdoc
     */
    public function addScope(ScopeEntityInterface $scope)
    {
    }

    /**
     * @inheritdoc
     */
    public function getScopes()
    {
    }
}

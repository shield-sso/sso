<?php

declare(strict_types = 1);

namespace ShieldSSO\Contract\Entity;

use Doctrine\Common\Collections\Collection as CollectionInterface;

interface ScopeInterface extends EntityInterface
{
    /**
     * @param string $name
     */
    public function setName(string $name): void;

    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param AccessTokenInterface $accessToken
     */
    public function addAccessToken(AccessTokenInterface $accessToken): void;

    /**
     * @return CollectionInterface
     */
    public function getAccessTokens(): CollectionInterface;

    /**
     * @param AccessTokenInterface $accessToken
     */
    public function removeAccessToken(AccessTokenInterface $accessToken): void;

    /**
     * @param AuthorizationCodeInterface $authorizationCode
     */
    public function addAuthorizationCode(AuthorizationCodeInterface $authorizationCode): void;

    /**
     * @return CollectionInterface
     */
    public function getAuthorizationCodes(): CollectionInterface;

    /**
     * @param AuthorizationCodeInterface $authorizationCode
     */
    public function removeAuthorizationCode(AuthorizationCodeInterface $authorizationCode): void;
}

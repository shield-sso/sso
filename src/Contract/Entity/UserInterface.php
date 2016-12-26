<?php

declare(strict_types = 1);

namespace ShieldSSO\Contract\Entity;

use Doctrine\Common\Collections\Collection as CollectionInterface;

interface UserInterface extends EntityInterface
{
    /**
     * @param string $login
     */
    public function setLogin(string $login): void;

    /**
     * @return string|null
     */
    public function getLogin(): ?string;

    /**
     * @param string $password
     */
    public function setPassword(string $password): void;

    /**
     * @return string|null
     */
    public function getPassword(): ?string;

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

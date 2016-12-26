<?php

declare(strict_types = 1);

namespace ShieldSSO\Contract\Entity;

use Doctrine\Common\Collections\Collection as CollectionInterface;

interface ClientInterface extends EntityInterface
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
     * @param string $secret
     */
    public function setSecret(string $secret): void;

    /**
     * @return string|null
     */
    public function getSecret(): ?string;

    /**
     * @param string $redirectUri
     */
    public function setRedirectUri(string $redirectUri): void;

    /**
     * @return string|null
     */
    public function getRedirectUri(): ?string;

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
}

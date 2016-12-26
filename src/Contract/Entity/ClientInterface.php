<?php

declare(strict_types = 1);

namespace ShieldSSO\Contract\Entity;

use ShieldSSO\Entity\AccessToken;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @param AccessToken $accessToken
     */
    public function addAccessToken(AccessToken $accessToken): void;

    /**
     * @return ArrayCollection
     */
    public function getAccessTokens(): ArrayCollection;

    /**
     * @param AccessToken $accessToken
     */
    public function removeAccessToken(AccessToken $accessToken): void;
}

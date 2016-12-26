<?php

declare(strict_types = 1);

namespace ShieldSSO\Contract\Entity;

use ShieldSSO\Entity\AccessToken;
use Doctrine\Common\Collections\ArrayCollection;

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

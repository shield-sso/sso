<?php

declare(strict_types = 1);

namespace ShieldSSO\Contract\Entity;

use ShieldSSO\Entity\AccessToken;
use Doctrine\Common\Collections\ArrayCollection;

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

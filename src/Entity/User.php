<?php

declare(strict_types = 1);

namespace ShieldSSO\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class User extends AbstractEntity
{
    /** @var string|null */
    private $login = null;

    /** @var string|null */
    private $password = null;

    /** @var ArrayCollection */
    private $accessTokens;

    /**
     * @inheritdoc
     */
    public function __construct(int $id = null)
    {
        parent::__construct($id);
        $this->accessTokens = new ArrayCollection;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return string|null
     */
    public function getLogin(): ?string
    {
        return $this->login;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param AccessToken $accessToken
     */
    public function addAccessToken(AccessToken $accessToken): void
    {
        $this->accessTokens->add($accessToken);
    }

    /**
     * @return ArrayCollection
     */
    public function getAccessTokens(): ArrayCollection
    {
        return $this->accessTokens;
    }

    /**
     * @param AccessToken $accessToken
     */
    public function removeAccessToken(AccessToken $accessToken): void
    {
        $this->accessTokens->removeElement($accessToken);
    }
}

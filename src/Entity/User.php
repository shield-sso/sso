<?php

declare(strict_types = 1);

namespace ShieldSSO\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection as CollectionInterface;
use ShieldSSO\Contract\Entity\AccessTokenInterface;
use ShieldSSO\Contract\Entity\UserInterface;

class User extends AbstractEntity implements UserInterface
{
    /** @var string|null */
    private $login = null;

    /** @var string|null */
    private $password = null;

    /** @var CollectionInterface */
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
     * @inheritdoc
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @inheritdoc
     */
    public function getLogin(): ?string
    {
        return $this->login;
    }

    /**
     * @inheritdoc
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @inheritdoc
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @inheritdoc
     */
    public function addAccessToken(AccessTokenInterface $accessToken): void
    {
        $this->accessTokens->add($accessToken);
    }

    /**
     * @inheritdoc
     */
    public function getAccessTokens(): CollectionInterface
    {
        return $this->accessTokens;
    }

    /**
     * @inheritdoc
     */
    public function removeAccessToken(AccessTokenInterface $accessToken): void
    {
        $this->accessTokens->removeElement($accessToken);
    }
}

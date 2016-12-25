<?php

declare(strict_types = 1);

namespace ShieldSSO\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Scope extends AbstractEntity
{
    /** @var string|null */
    private $name = null;

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
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
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

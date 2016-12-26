<?php

declare(strict_types = 1);

namespace ShieldSSO\Entity;

use Doctrine\Common\Collections\Collection as CollectionInterface;
use Doctrine\Common\Collections\ArrayCollection;
use ShieldSSO\Contract\Entity\AccessTokenInterface;
use ShieldSSO\Contract\Entity\ScopeInterface;

class Scope extends AbstractEntity implements ScopeInterface
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
     * @param AccessTokenInterface $accessToken
     */
    public function addAccessToken(AccessTokenInterface $accessToken): void
    {
        $this->accessTokens->add($accessToken);
    }

    /**
     * @return CollectionInterface
     */
    public function getAccessTokens(): CollectionInterface
    {
        return $this->accessTokens;
    }

    /**
     * @param AccessTokenInterface $accessToken
     */
    public function removeAccessToken(AccessTokenInterface $accessToken): void
    {
        $this->accessTokens->removeElement($accessToken);
    }
}

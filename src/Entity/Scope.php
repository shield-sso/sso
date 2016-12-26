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
     * @inheritdoc
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @inheritdoc
     */
    public function getName(): ?string
    {
        return $this->name;
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

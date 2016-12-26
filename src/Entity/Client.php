<?php

declare(strict_types = 1);

namespace ShieldSSO\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection as CollectionInterface;
use ShieldSSO\Contract\Entity\AccessTokenInterface;
use ShieldSSO\Contract\Entity\ClientInterface;

class Client extends AbstractEntity implements ClientInterface
{
    /** @var string|null */
    private $name = null;

    /** @var string|null */
    private $secret = null;

    /** @var string|null */
    private $redirectUri = null;

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
     * @param string $secret
     */
    public function setSecret(string $secret): void
    {
        $this->secret = $secret;
    }

    /**
     * @return string|null
     */
    public function getSecret(): ?string
    {
        return $this->secret;
    }

    /**
     * @param string $redirectUri
     */
    public function setRedirectUri(string $redirectUri): void
    {
        $this->redirectUri = $redirectUri;
    }

    /**
     * @return string|null
     */
    public function getRedirectUri(): ?string
    {
        return $this->redirectUri;
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

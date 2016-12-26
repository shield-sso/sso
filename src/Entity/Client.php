<?php

declare(strict_types = 1);

namespace ShieldSSO\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection as CollectionInterface;
use ShieldSSO\Contract\Entity\AccessTokenInterface;
use ShieldSSO\Contract\Entity\AuthorizationCodeInterface;
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

    /** @var CollectionInterface */
    private $authorizationCodes;

    /**
     * @inheritdoc
     */
    public function __construct(int $id = null)
    {
        parent::__construct($id);
        $this->accessTokens = new ArrayCollection;
        $this->authorizationCodes = new ArrayCollection;
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
    public function setSecret(string $secret): void
    {
        $this->secret = $secret;
    }

    /**
     * @inheritdoc
     */
    public function getSecret(): ?string
    {
        return $this->secret;
    }

    /**
     * @inheritdoc
     */
    public function setRedirectUri(string $redirectUri): void
    {
        $this->redirectUri = $redirectUri;
    }

    /**
     * @inheritdoc
     */
    public function getRedirectUri(): ?string
    {
        return $this->redirectUri;
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

    /**
     * @inheritdoc
     */
    public function addAuthorizationCode(AuthorizationCodeInterface $authorizationCode): void
    {
        $this->authorizationCodes->add($authorizationCode);
    }

    /**
     * @inheritdoc
     */
    public function getAuthorizationCodes(): CollectionInterface
    {
        return $this->authorizationCodes;
    }

    /**
     * @inheritdoc
     */
    public function removeAuthorizationCode(AuthorizationCodeInterface $authorizationCode): void
    {
        $this->authorizationCodes->removeElement($authorizationCode);
    }
}

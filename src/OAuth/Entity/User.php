<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Entity;

use League\OAuth2\Server\Entities\UserEntityInterface;

class User implements UserEntityInterface
{
    /** @var string|null */
    private $login = null;

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
     * @inheritdoc
     */
    public function getIdentifier()
    {
        return $this->login;
    }
}

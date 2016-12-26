<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Repository;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;
use ShieldSSO\OAuth\Entity\User;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use ShieldSSO\Contract\Repository\UserRepositoryInterface as AppRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /** @var AppRepositoryInterface */
    private $appRepository;

    /**
     * @param AppRepositoryInterface $appRepository
     */
    public function __construct(AppRepositoryInterface $appRepository)
    {
        $this->appRepository = $appRepository;
    }

    /**
     * @inheritdoc
     */
    public function getUserEntityByUserCredentials(
        $login,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    ): UserEntityInterface
    {
        if ($grantType != 'authorization_code') {
            return null;
        }

        $appUser = $this->appRepository->getByLogin($login);
        if (!$appUser || !password_verify($password, $appUser->getPassword())) {
            return null;
        }

        $user = new User;
        $user->setLogin($appUser->getLogin());

        return $user;
    }
}

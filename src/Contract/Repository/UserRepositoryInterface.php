<?php

declare(strict_types = 1);

namespace ShieldSSO\Contract\Repository;

use ShieldSSO\Contract\Entity\UserInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int $id
     *
     * @return UserInterface|null
     */
    public function getById(int $id): ?UserInterface;

    /**
     * @param string $login
     *
     * @return UserInterface|null
     */
    public function getByLogin(string $login): ?UserInterface;

    /**
     * @param UserInterface $user
     */
    public function persist(UserInterface $user): void;
}

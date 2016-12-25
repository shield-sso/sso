<?php

declare(strict_types = 1);

namespace ShieldSSO\Repository;

use Doctrine\ORM\NoResultException;
use ShieldSSO\Entity\User;

class UserRepository extends AbstractRepository
{
    /**
     * @param int $id
     *
     * @return User|null
     */
    public function getById(int $id): ?User
    {
        $query = $this->createQueryBuilder('user')
            ->where('user.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        try {
            return $query->getSingleResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }

    /**
     * @param string $login
     *
     * @return User|null
     */
    public function getByLogin(string $login): ?User
    {
        $query = $this->createQueryBuilder('user')
            ->where('user.login = :login')
            ->setParameter('login', $login)
            ->getQuery();

        try {
            return $query->getSingleResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }

    /**
     * @param User $user
     */
    public function persist(User $user): void
    {
        $this->_em->persist($user);
        $this->entitiesToFlush[] = $user;
    }
}

<?php

declare(strict_types = 1);

namespace ShieldSSO\Repository;

use Doctrine\ORM\NoResultException;
use ShieldSSO\Contract\Entity\UserInterface;
use ShieldSSO\Contract\Repository\UserRepositoryInterface;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getById(int $id): ?UserInterface
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
     * @inheritdoc
     */
    public function getByLogin(string $login): ?UserInterface
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
     * @inheritdoc
     */
    public function persist(UserInterface $user): void
    {
        $this->_em->persist($user);
        $this->entitiesToFlush[] = $user;
    }
}

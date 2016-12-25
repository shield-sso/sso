<?php

declare(strict_types = 1);

namespace ShieldSSO\Repository;

use Doctrine\ORM\NoResultException;
use ShieldSSO\Entity\Scope;

class ScopeRepository extends AbstractRepository
{
    /**
     * @param int $id
     *
     * @return Scope|null
     */
    public function getById(int $id): ?Scope
    {
        $query = $this->createQueryBuilder('scope')
            ->where('scope.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        try {
            return $query->getSingleResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }

    /**
     * @param string $name
     *
     * @return Scope|null
     */
    public function getByName(string $name): ?Scope
    {
        $query = $this->createQueryBuilder('scope')
            ->where('scope.name = :name')
            ->setParameter('name', $name)
            ->getQuery();

        try {
            return $query->getSingleResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }

    /**
     * @param string[] $names
     *
     * @return array
     */
    public function getByNames(array $names)
    {
        $query = $this->createQueryBuilder('scope')
            ->where('scope.name IN (:names)')
            ->setParameter('names', $names)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @param Scope $scope
     */
    public function persist(Scope $scope): void
    {
        $this->_em->persist($scope);
        $this->entitiesToFlush[] = $scope;
    }
}

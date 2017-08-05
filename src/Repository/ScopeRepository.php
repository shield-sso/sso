<?php

declare(strict_types = 1);

namespace ShieldSSO\Repository;

use Doctrine\ORM\NoResultException;
use ShieldSSO\Contract\Entity\ScopeInterface;
use ShieldSSO\Contract\Repository\ScopeRepositoryInterface;

class ScopeRepository extends AbstractRepository implements ScopeRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getById(int $id): ?ScopeInterface
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
     * @inheritdoc
     */
    public function getByName(string $name): ?ScopeInterface
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
     * @inheritdoc
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
     * @inheritdoc
     */
    public function persist(ScopeInterface $scope): void
    {
        $this->_em->persist($scope);
        $this->entitiesToFlush[] = $scope;
    }
}

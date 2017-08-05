<?php

declare(strict_types = 1);

namespace ShieldSSO\Repository;

use Doctrine\ORM\NoResultException;
use ShieldSSO\Contract\Entity\ClientInterface;
use ShieldSSO\Contract\Repository\ClientRepositoryInterface;

class ClientRepository extends AbstractRepository implements ClientRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getById(int $id): ?ClientInterface
    {
        $query = $this->createQueryBuilder('client')
            ->where('client.id = :id')
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
    public function getByName(string $name): ?ClientInterface
    {
        $query = $this->createQueryBuilder('client')
            ->where('client.name = :name')
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
    public function persist(ClientInterface $client): void
    {
        $this->_em->persist($client);
        $this->entitiesToFlush[] = $client;
    }
}

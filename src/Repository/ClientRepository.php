<?php

declare(strict_types = 1);

namespace ShieldSSO\Repository;

use Doctrine\ORM\NoResultException;
use ShieldSSO\Entity\Client;

class ClientRepository extends AbstractRepository
{
    /**
     * @param int $id
     *
     * @return Client|null
     */
    public function getById(int $id): ?Client
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
     * @param string $name
     *
     * @return Client|null
     */
    public function getByName(string $name): ?Client
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
     * @param Client $client
     */
    public function persist(Client $client): void
    {
        $this->_em->persist($client);
    }
}

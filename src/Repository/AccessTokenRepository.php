<?php

declare(strict_types = 1);

namespace ShieldSSO\Repository;

use Doctrine\ORM\NoResultException;
use ShieldSSO\Entity\AccessToken;

class AccessTokenRepository extends AbstractRepository
{
    /**
     * @param int $id
     *
     * @return AccessToken|null
     */
    public function getById(int $id): ?AccessToken
    {
        $query = $this->createQueryBuilder('access_token')
            ->where('access_token.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        try {
            return $query->getSingleResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }

    /**
     * @param string $code
     *
     * @return AccessToken|null
     */
    public function getByCode(string $code): ?AccessToken
    {
        $query = $this->createQueryBuilder('access_token')
            ->where('access_token.code = :code')
            ->setParameter('code', $code)
            ->getQuery();

        try {
            return $query->getSingleResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }

    /**
     * @param AccessToken $accessToken
     */
    public function persist(AccessToken $accessToken): void
    {
        $this->_em->persist($accessToken);
        $this->entitiesToFlush[] = $accessToken;
    }
}

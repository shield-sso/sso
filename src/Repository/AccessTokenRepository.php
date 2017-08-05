<?php

declare(strict_types = 1);

namespace ShieldSSO\Repository;

use Doctrine\ORM\NoResultException;
use ShieldSSO\Contract\Entity\AccessTokenInterface;
use ShieldSSO\Contract\Repository\AccessTokenRepositoryInterface;

class AccessTokenRepository extends AbstractRepository implements AccessTokenRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getById(int $id): ?AccessTokenInterface
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
     * @inheritdoc
     */
    public function getByCode(string $code): ?AccessTokenInterface
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
     * @inheritdoc
     */
    public function persist(AccessTokenInterface $accessToken): void
    {
        $this->_em->persist($accessToken);
        $this->entitiesToFlush[] = $accessToken;
    }
}

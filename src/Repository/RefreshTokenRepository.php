<?php

declare(strict_types = 1);

namespace ShieldSSO\Repository;

use Doctrine\ORM\NoResultException;
use ShieldSSO\Contract\Entity\RefreshTokenInterface;
use ShieldSSO\Contract\Repository\RefreshTokenRepositoryInterface;

class RefreshTokenRepository extends AbstractRepository implements RefreshTokenRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getById(int $id): ?RefreshTokenInterface
    {
        $query = $this->createQueryBuilder('refresh_token')
            ->where('refresh_token.id = :id')
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
    public function getByCode(string $code): ?RefreshTokenInterface
    {
        $query = $this->createQueryBuilder('refresh_token')
            ->where('refresh_token.code = :code')
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
    public function persist(RefreshTokenInterface $refreshToken): void
    {
        $this->_em->persist($refreshToken);
        $this->entitiesToFlush[] = $refreshToken;
    }
}

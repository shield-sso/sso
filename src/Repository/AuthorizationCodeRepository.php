<?php

declare(strict_types = 1);

namespace ShieldSSO\Repository;

use Doctrine\ORM\NoResultException;
use ShieldSSO\Contract\Entity\AuthorizationCodeInterface;
use ShieldSSO\Contract\Repository\AuthorizationCodeRepositoryInterface;

class AuthorizationCodeRepository extends AbstractRepository implements AuthorizationCodeRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getById(int $id): ?AuthorizationCodeInterface
    {
        $query = $this->createQueryBuilder('authorization_code')
            ->where('authorization_code.id = :id')
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
    public function getByCode(string $code): ?AuthorizationCodeInterface
    {
        $query = $this->createQueryBuilder('authorization_code')
            ->where('authorization_code.code = :code')
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
    public function persist(AuthorizationCodeInterface $authorizationCode): void
    {
        $this->_em->persist($authorizationCode);
        $this->entitiesToFlush[] = $authorizationCode;
    }
}

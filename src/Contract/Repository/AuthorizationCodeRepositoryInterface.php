<?php

declare(strict_types = 1);

namespace ShieldSSO\Contract\Repository;

use ShieldSSO\Contract\Entity\AuthorizationCodeInterface;

interface AuthorizationCodeRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int $id
     *
     * @return AuthorizationCodeInterface|null
     */
    public function getById(int $id): ?AuthorizationCodeInterface;

    /**
     * @param string $code
     *
     * @return AuthorizationCodeInterface|null
     */
    public function getByCode(string $code): ?AuthorizationCodeInterface;

    /**
     * @param AuthorizationCodeInterface $authorizationCode
     */
    public function persist(AuthorizationCodeInterface $authorizationCode): void;
}

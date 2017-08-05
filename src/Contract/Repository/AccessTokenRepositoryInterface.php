<?php

declare(strict_types = 1);

namespace ShieldSSO\Contract\Repository;

use ShieldSSO\Contract\Entity\AccessTokenInterface;

interface AccessTokenRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int $id
     *
     * @return AccessTokenInterface|null
     */
    public function getById(int $id): ?AccessTokenInterface;

    /**
     * @param string $code
     *
     * @return AccessTokenInterface|null
     */
    public function getByCode(string $code): ?AccessTokenInterface;

    /**
     * @param AccessTokenInterface $accessToken
     */
    public function persist(AccessTokenInterface $accessToken): void;
}

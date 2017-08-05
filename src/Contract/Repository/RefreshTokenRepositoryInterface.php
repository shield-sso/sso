<?php

declare(strict_types = 1);

namespace ShieldSSO\Contract\Repository;

use ShieldSSO\Contract\Entity\RefreshTokenInterface;

interface RefreshTokenRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int $id
     *
     * @return RefreshTokenInterface|null
     */
    public function getById(int $id): ?RefreshTokenInterface;

    /**
     * @param string $code
     *
     * @return RefreshTokenInterface|null
     */
    public function getByCode(string $code): ?RefreshTokenInterface;

    /**
     * @param RefreshTokenInterface $refreshToken
     */
    public function persist(RefreshTokenInterface $refreshToken): void;
}

<?php

declare(strict_types = 1);

namespace ShieldSSO\Contract\Repository;

use ShieldSSO\Contract\Entity\ClientInterface;

interface ClientRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int $id
     *
     * @return ClientInterface|null
     */
    public function getById(int $id): ?ClientInterface;

    /**
     * @param string $name
     *
     * @return ClientInterface|null
     */
    public function getByName(string $name): ?ClientInterface;

    /**
     * @param ClientInterface $client
     */
    public function persist(ClientInterface $client): void;
}

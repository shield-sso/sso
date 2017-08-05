<?php

declare(strict_types = 1);

namespace ShieldSSO\Contract\Repository;

use ShieldSSO\Contract\Entity\ScopeInterface;
use Doctrine\Common\Collections\Collection as CollectionInterface;

interface ScopeRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int $id
     *
     * @return ScopeInterface|null
     */
    public function getById(int $id): ?ScopeInterface;

    /**
     * @param string $name
     *
     * @return ScopeInterface|null
     */
    public function getByName(string $name): ?ScopeInterface;

    /**
     * @param string[] $names
     *
     * @return CollectionInterface
     */
    public function getByNames(array $names);

    /**
     * @param ScopeInterface $scope
     */
    public function persist(ScopeInterface $scope): void;
}

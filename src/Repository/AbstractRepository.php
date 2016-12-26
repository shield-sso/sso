<?php

declare(strict_types = 1);

namespace ShieldSSO\Repository;

use Doctrine\ORM\EntityRepository;
use ShieldSSO\Contract\Repository\RepositoryInterface;
use ShieldSSO\Entity\AbstractEntity;

abstract class AbstractRepository extends EntityRepository implements RepositoryInterface
{
    /** @var AbstractEntity */
    protected $entitiesToFlush = [];

    public function flush(): void
    {
        foreach ($this->entitiesToFlush as $entity) {
            $this->_em->flush($entity);
        }

        unset($this->entitiesToFlush);
        $this->entitiesToFlush = [];
    }
}

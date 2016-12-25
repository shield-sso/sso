<?php

declare(strict_types = 1);

namespace ShieldSSO\Repository;

use Doctrine\ORM\EntityRepository;
use ShieldSSO\Entity\AbstractEntity;

abstract class AbstractRepository extends EntityRepository
{
    /** @var AbstractEntity */
    protected $entitiesToFlush = [];

    /**
     * @param int $id
     *
     * @return object
     */
    public function getProxy(int $id)
    {
        return $this->_em->getReference($this->_entityName, $id);
    }

    public function flush(): void
    {
        foreach ($this->entitiesToFlush as $entity) {
            $this->_em->flush($entity);
        }

        unset($this->entitiesToFlush);
        $this->entitiesToFlush = [];
    }
}

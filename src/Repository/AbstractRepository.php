<?php

declare(strict_types = 1);

namespace ShieldSSO\Repository;

use Doctrine\ORM\EntityRepository;

abstract class AbstractRepository extends EntityRepository
{
    public function flush(): void
    {
        $this->_em->flush();
    }
}

<?php

declare(strict_types = 1);

namespace ShieldSSO\Contract\Repository;

interface RepositoryInterface
{
    public function flush(): void;
}

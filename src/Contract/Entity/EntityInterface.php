<?php

declare(strict_types = 1);

namespace ShieldSSO\Contract\Entity;

interface EntityInterface
{
    /**
     * @return int|null
     */
    public function getId(): ?int;
}

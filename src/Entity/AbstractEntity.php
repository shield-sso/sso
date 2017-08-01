<?php

declare(strict_types = 1);

namespace ShieldSSO\Entity;

use ShieldSSO\Contract\Entity\EntityInterface;

abstract class AbstractEntity implements EntityInterface
{
    /** @var int|null */
    protected $id;

    /**
     * @param int|null $id
     */
    public function __construct(?int $id = null)
    {
        $this->id = $id;
    }

    /**
     * @inheritdoc
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}

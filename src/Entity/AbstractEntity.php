<?php

declare(strict_types = 1);

namespace ShieldSSO\Entity;

abstract class AbstractEntity
{
    /** @var integer */
    protected $id = null;

    /**
     * @param int|null $id
     */
    public function __construct(int $id = null)
    {
        $this->id = $id;
    }

    /**
     * @return integer
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}

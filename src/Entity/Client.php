<?php

declare(strict_types = 1);

namespace ShieldSSO\Entity;

class Client
{
    /** @var integer */
    protected $id = null;

    /** @var string */
    protected $name = null;

    /**
     * @return integer
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }
}

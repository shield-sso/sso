<?php

declare(strict_types = 1);

namespace ShieldSSO\Entity;

class Client extends AbstractEntity
{
    /** @var string */
    protected $name = null;

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

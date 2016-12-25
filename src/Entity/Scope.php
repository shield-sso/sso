<?php

declare(strict_types = 1);

namespace ShieldSSO\Entity;

class Scope extends AbstractEntity
{
    /** @var string|null */
    private $name = null;

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }
}

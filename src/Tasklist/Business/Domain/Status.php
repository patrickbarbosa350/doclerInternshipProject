<?php

declare(strict_types=1);

namespace Tasklist\Business\Domain;

class Status
{
    private ?int $id;
    private ?string $name;

    public function __construct(?int $id = null, string $name = null)
    {
        $this->id   = $id;
        $this->name = $name;
    }

    public static function returnStatus(int $id, string $name): self
    {
         return new self($id, $name);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}

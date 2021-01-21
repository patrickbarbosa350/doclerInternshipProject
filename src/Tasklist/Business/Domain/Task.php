<?php

declare(strict_types=1);

namespace Tasklist\Business\Domain;

class Task
{
    private int $id;
    private string $title;
    private ?string $description;
    private Status $status;
    private User $user;
    private ?\DateTimeImmutable $dueDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

}

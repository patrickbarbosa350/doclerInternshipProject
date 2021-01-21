<?php

declare(strict_types=1);

namespace Tasklist\Business\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Tasklist\Business\Entity\StatusEntity;
use Tasklist\Business\Entity\UserEntity;

/**
 * @ORM\Entity(repositoryClass=TblTaskRepository::class)
 */
class TaskEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private StatusEntity $status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private UserEntity $user;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?\DateTimeInterface $dueDate;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?StatusEntity
    {
        return $this->status;
    }

    public function setStatus(StatusEntity $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?UserEntity
    {
        return $this->user;
    }

    public function setUser(UserEntity $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(?\DateTimeInterface $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }
}

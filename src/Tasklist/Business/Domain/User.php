<?php

declare(strict_types=1);

namespace Tasklist\Business\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

class User
{
    private int $id;
    private string $username;
    private array $roles;
    private string $password;

    public static function returnUser(
        int $id,
        string $username,
        array $roles,
        string $password
    ): self
    {
        return new self($id, $username, $roles, $password);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }
}

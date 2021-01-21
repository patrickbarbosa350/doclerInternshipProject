<?php

declare(strict_types=1);

namespace Tasklist\Business\Query;

class UserDTO implements DTOInterface
{
    public ?string $username;
    public ?string $password;
    public ?string $roles;
}
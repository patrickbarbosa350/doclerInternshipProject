<?php

declare(strict_types=1);

namespace Tasklist\Business\Query;

use Tasklist\Business\Query\UserDTO;
use Tasklist\Business\Query\StatusDTO;

class TaskDTO implements DTOInterface
{
    public ?int $id;

    public ?string $title;

    public ?string $description;

    public ?StatusDTO $status;

    public ?UserDTO $user;

    public ?\DateTimeImmutable $dueDate;
}
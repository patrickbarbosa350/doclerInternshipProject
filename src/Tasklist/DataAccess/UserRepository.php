<?php

declare(strict_types=1);

namespace Tasklist\DataAccess;

use Tasklist\Business\Query\UserDTO;

interface UserRepository
{
    public function getAllUsers(): array;
    public function getUserByUsername(string $username): array;
    public function store(UserDto $userDto): string;
    public function update(UserDTO $userDto, $updateField, $conditionalField, $conditionalValue): string;
    public function delete(UserDTO $userDto,  $updateField): string;
}

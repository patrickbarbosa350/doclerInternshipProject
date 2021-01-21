<?php

declare(strict_types=1);

namespace Tasklist\DataAccess;

use Doctrine\DBAL\Exception;
use Tasklist\Business\Query\UserDTO ;
use Tasklist\Business\Domain\Task;
use DateTime;

class DbalUser extends DbalConnection implements UserRepository
{
    public function getAllUsers(): array
    {
        $sqlStatement =
            'SELECT user.id, user.username, user.roles FROM user';

        return $this->getResults($sqlStatement);
    }

    public function getUserByUsername(string $username): array
    {
        $sqlStatement =
            'SELECT user.id, user.username, user.roles
            FROM user
            WHERE user.username = :username';

        return $this->getResults($sqlStatement, 'username', $username);
    }

    public function store(UserDTO $userDto): string
    {
        $sqlStatement =
            'INSERT INTO user (username, password, roles)
             VALUES (:username, :password, :roles)';
        $role = '"[\"' . $userDto->roles . '\"]"';
        return $this->executeStatement($sqlStatement, 'username', $userDto->username, 'password', $userDto->password,'roles', $role);
    }

    public function update(UserDTO $userDto, $updateField, $conditionalField, $conditionalValue): string
    {
        $conn = $this->getConnection();

        try {
            $conn->update('user', [$updateField => $userDto->$updateField], [$conditionalField => $conditionalValue]);
            return 'Success!';
        } catch (Exception $e) {
            return "Exception: $e";
        }

    }

    public function delete(UserDTO $userDto, $updateField): string
    {
        $conn = $this->getConnection();

        try {
            $conn->delete('user', [$updateField => $userDto->$updateField]);
            return 'Success!';
        } catch (Exception $e) {
            return "Exception: $e";
        }
      }
}
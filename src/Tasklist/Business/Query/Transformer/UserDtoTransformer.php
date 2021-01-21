<?php

declare(strict_types=1);

namespace Tasklist\Business\Query\Transformer;

use Tasklist\Business\Query\UserDTO;

class UserDtoTransformer
{
    public function transformIntoUserDto($username = null, $roles = null): UserDTO
    {
        $dto = new UserDTO();

        $dto->username = $username;
        $dto->roles    = $roles;

        return $dto;
    }

    public function transformResultsIntoUserDto($results): UserDTO
    {
        $userDTO              = new UserDTO();

        if (!isset($results['password'])){
            $results['password'] = null;
        }

        $userDTO->username = $results['username'];
        $userDTO->password = $results['password'];
        $userDTO->roles    = $results['roles'];

        return $userDTO;
    }

    public function transformIntoUserDtoArray($results): array
    {
        $dtoArray = [];

        foreach($results as $result){
            $dtoArray[] = $this->transformResultsIntoUserDto($result);
        }

        return $dtoArray;
    }
}
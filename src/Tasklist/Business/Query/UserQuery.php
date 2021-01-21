<?php

declare(strict_types=1);

namespace Tasklist\Business\Query;

use Symfony\Component\HttpFoundation\Request;
use Tasklist\Business\Query\Transformer\UserDtoTransformer ;
use Tasklist\DataAccess\UserRepository;

class UserQuery
{
    private UserRepository $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function fetchAll(
        UserDtoTransformer $userDtoTransformer
    ): array
    {
        $results = $this->user->getAllUsers();

        return $userDtoTransformer->transformIntoUserDtoArray($results);
    }

    public function fetchByUsername(
        UserDtoTransformer $userDtoTransformer,
        Request $request
    ): array
    {
        $username = $request->request->get('username');
        $results = $this->user->getUserByUsername($username);
        return $userDtoTransformer->transformIntoUserDtoArray($results);
    }

    public function storeUser(
        UserDtoTransformer $userDtoTransformer,
        Request $request
    ): string
    {
        $results['username'] = null;
        $results['roles'] = null;
        $results['password'] = null;


        if ($request->request->get('username')){
            $results['username'] = $request->request->get('username');
        }
        else{
            throw new \Exception('You must enter a username');
        }

        if ($request->request->get('password')){
            $results['password'] = password_hash($request->request->get('password'), PASSWORD_DEFAULT);
        }
        else{
            throw new \Exception('You must enter a password');
        }

        if ($request->request->get('roles')){
            $results['roles'] = $request->request->get('roles');
        }

        $userDTO = $userDtoTransformer->transformResultsIntoUserDto($results);

        return $this->user->store($userDTO);

    }

    public function renewUser(
        UserDtoTransformer $userDtoTransformer,
        Request $request
    ): string
    {
        $results['username'] = null;
        $results['roles'] = null;
        $results['password'] = null;

        $updateField = $request->request->get('field');
        $updateValue = $request->request->get('value');
        $conditionalField = $request->request->get('conditionalField');
        $conditionalValue = $request->request->get('conditionalValue');
        $results[$updateField] = $updateValue;

        $userDTO = $userDtoTransformer->transformResultsIntoUserDto($results);

        return $this->user->update($userDTO, $updateField, $conditionalField, $conditionalValue);
    }
}
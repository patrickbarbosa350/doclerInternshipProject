<?php

declare(strict_types=1);

namespace Tasklist\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Tasklist\Business\Query\UserQuery;
use Tasklist\Business\Query\Transformer\UserDtoTransformer;
use Tasklist\Business\Domain\User;

class UserController extends AbstractController
{
    private User   $user;

    public function __construct(User $user)
    {
        $this->user   = $user;
    }

    /**
     * @Route("/user/showAll", name="showAllUsers", methods="POST")
     */
    public function showAllUsers(
        UserDtoTransformer $userDtoTransformer,
        UserQuery $userlist
    ): Response
    {
        $users = json_encode($userlist->fetchAll($userDtoTransformer));

        return new Response($users, Response::HTTP_OK, ['content-type' => 'application/json']);
    }


    /**
     * @Route("/user/showUserByUsername", name="showUserByUsername", methods="POST")
     */
    public function showUserByUsername(
        UserDtoTransformer $userDtoTransformer,
        UserQuery $userlist,
        Request $request
    ): Response
    {
        $users = json_encode($userlist->fetchByUsername($userDtoTransformer, $request));

        return new Response($users, Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    /**
     * @Route("/user/insertUser", name="insertUser", methods="POST")
     */
    public function insertUser(
        UserDtoTransformer $userDtoTransformer,
        UserQuery $userlist,
        Request $request
    ): Response
    {
        $users = json_encode($userlist->storeUser($userDtoTransformer, $request));

        return new Response($users, Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    /**
     * @Route("/user/updateUser", name="updateUser", methods="POST")
     */
    public function updateUser(
        UserDtoTransformer $userDtoTransformer,
        UserQuery $userlist,
        Request $request
    ): Response
    {
        $users = json_encode($userlist->renewUser($userDtoTransformer, $request));

        return new Response($users, Response::HTTP_OK, ['content-type' => 'application/json']);
    }
}

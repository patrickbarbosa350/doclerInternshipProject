<?php

declare(strict_types=1);

namespace Tasklist\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Tasklist\Business\Query\TaskQuery;
use Tasklist\Business\Query\Transformer\StatusDtoTransformer;
use Tasklist\Business\Query\Transformer\TaskDtoTransformer;
use Tasklist\Business\Query\Transformer\UserDtoTransformer;
use Tasklist\Business\Domain\Status;
use Tasklist\Business\Domain\Task;
use Tasklist\Business\Domain\User;

class TaskController extends AbstractController
{
    private Task   $task;
    private Status $status;
    private User   $user;

    public function __construct(Task $task, Status $status, User $user)
    {
        $this->task   = $task;
        $this->status = $status;
        $this->user   = $user;
    }

    /**
     * @Route("/task/showAll", name="showAllTasks", methods="POST")
     */
    public function showAllTasks(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer,
        TaskQuery $tasklist
    ): Response
    {
        $tasks = json_encode($tasklist->fetchAll($taskDtoTransformer, $statusDtoTransformer, $userDtoTransformer));

        return new Response($tasks, Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    /**
     * @Route("/task/showByDate", name="showByDate", methods="POST")
     */
    public function showByDate(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer,
        TaskQuery $tasklist,
        Request $request
    ): Response
    {
        $tasks = json_encode($tasklist->fetchByDate($taskDtoTransformer, $statusDtoTransformer, $userDtoTransformer, $request));

        return new Response($tasks, Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    /**
     * @Route("/task/showTodayByUser", name="showTodayByUser", methods="POST")
     */
    public function showTodayByUser(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer,
        TaskQuery $tasklist,
        Request $request
    ): Response
    {
        $tasks = json_encode($tasklist->fetchTodayByUser($taskDtoTransformer, $statusDtoTransformer, $userDtoTransformer, $request));

        return new Response($tasks, Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    /**
     * @Route("/task/showToday", name="showToday", methods="POST")
     */
    public function showToday(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer,
        TaskQuery $tasklist
    ): Response
    {
        $tasks = json_encode($tasklist->fetchToday($taskDtoTransformer, $statusDtoTransformer, $userDtoTransformer));

        return new Response($tasks, Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    /**
     * @Route("/task/showByUser", name="showByUser", methods="POST")
     */
    public function showByUser(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer,
        TaskQuery $tasklist,
        Request $request
    ): Response
    {
        $tasks = json_encode($tasklist->fetchByUser($taskDtoTransformer, $statusDtoTransformer, $userDtoTransformer, $request));

        return new Response($tasks, Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    /**
     * @Route("/task/showByStatus", name="showByStatus", methods="POST")
     */
    public function showByStatus(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer,
        TaskQuery $tasklist,
        Request $request
    ): Response
    {
        $tasks = json_encode($tasklist->fetchByStatus($taskDtoTransformer, $statusDtoTransformer, $userDtoTransformer, $request));

        return new Response($tasks, Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    /**
     * @Route("/task/showByStatusAndUser", name="showByStatusAndUser", methods="POST")
     */
    public function showByStatusAndUser(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer,
        TaskQuery $tasklist,
        Request $request
    ): Response
    {
        $tasks = json_encode($tasklist->fetchByStatusAndUser($taskDtoTransformer, $statusDtoTransformer, $userDtoTransformer, $request));

        return new Response($tasks, Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    /**
     * @Route("/task/showTaskByTitle", name="showTaskByTitle", methods="POST")
     */
    public function showTaskByTitle(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer,
        TaskQuery $tasklist,
        Request $request
    ): Response
    {
        $tasks = json_encode($tasklist->fetchByTitle($taskDtoTransformer, $statusDtoTransformer, $userDtoTransformer, $request));

        return new Response($tasks, Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    /**
     * @Route("/task/insertTask", name="insertTask", methods="POST")
     */
    public function insertTask(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer,
        TaskQuery $tasklist,
        Request $request
    ): Response
    {
        $tasks = json_encode($tasklist->storeTask($taskDtoTransformer, $statusDtoTransformer, $userDtoTransformer, $request));

        return new Response($tasks, Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    /**
     * @Route("/task/updateTask", name="updateTask", methods="POST")
     */
    public function updateTask(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer,
        TaskQuery $tasklist,
        Request $request
    ): Response
    {
        $tasks = json_encode($tasklist->renewTask($taskDtoTransformer, $statusDtoTransformer, $userDtoTransformer, $request));

        return new Response($tasks, Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    /**
     * @Route("/task/deleteTask", name="deleteTask", methods="POST")
     */
    public function deleteTask(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer,
        TaskQuery $tasklist,
        Request $request
    ): Response
    {
        $tasks = json_encode($tasklist->removeTask($taskDtoTransformer, $statusDtoTransformer, $userDtoTransformer, $request));

        return new Response($tasks, Response::HTTP_OK, ['content-type' => 'application/json']);
    }
}

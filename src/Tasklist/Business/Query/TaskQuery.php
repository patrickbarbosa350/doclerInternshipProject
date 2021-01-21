<?php

declare(strict_types=1);

namespace Tasklist\Business\Query;

use Symfony\Component\HttpFoundation\Request;
use Tasklist\Business\Query\Transformer\StatusDtoTransformer;
use Tasklist\Business\Query\Transformer\TaskDtoTransformer;
use Tasklist\Business\Query\Transformer\UserDtoTransformer;
use Tasklist\DataAccess\TaskRepository;

class TaskQuery
{
    private TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function fetchAll(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer
    ): array
    {
        $results = $this->repository->getAllTasks();

        return $taskDtoTransformer->transformIntoTaskDtoArray($results, $statusDtoTransformer, $userDtoTransformer);
    }

    public function fetchByDate(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer,
        Request $request
    ): array
    {
        $date = $request->request->get('date');

        $results = $this->repository->getTasksByDate($date);

        return $taskDtoTransformer->transformIntoTaskDtoArray($results, $statusDtoTransformer, $userDtoTransformer);
    }

    public function fetchTodayByUser(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer,
        Request $request
    ): array
    {
        $user = $request->request->get('user');

        $results = $this->repository->getTodaysTasksByUser($user);

        return $taskDtoTransformer->transformIntoTaskDtoArray($results, $statusDtoTransformer, $userDtoTransformer);
    }

    public function fetchToday(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer
    ): array
    {
        $results = $this->repository->getTodaysTasks();

        return $taskDtoTransformer->transformIntoTaskDtoArray($results, $statusDtoTransformer, $userDtoTransformer);
    }

    public function fetchByUser(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer,
        Request $request
    ): array
    {
        $user = $request->request->get('user');

        $results = $this->repository->getTasksByUser($user);

        return $taskDtoTransformer->transformIntoTaskDtoArray($results, $statusDtoTransformer, $userDtoTransformer);
    }

    public function fetchByStatus(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer,
        Request $request
    ): array
    {
        $status = $request->request->get('status');

        $results = $this->repository->getTasksByStatus($status);

        return $taskDtoTransformer->transformIntoTaskDtoArray($results, $statusDtoTransformer, $userDtoTransformer);
    }

    public function fetchByStatusAndUser(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer,
        Request $request
    ): array
    {
        $status = $request->request->get('status');
        $user = $request->request->get('user');

        $results = $this->repository->getTasksByStatusAndUser($status, $user);

        return $taskDtoTransformer->transformIntoTaskDtoArray($results, $statusDtoTransformer, $userDtoTransformer);
    }

    public function fetchByTitle(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer,
        Request $request
    ): array
    {
        $title = $request->request->get('title');
        $results = $this->repository->getTaskByTitle($title);
        return $taskDtoTransformer->transformIntoTaskDtoArray($results, $statusDtoTransformer, $userDtoTransformer);
    }

    public function storeTask(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer,
        Request $request
    ): string
    {
        $results['id'] = null;
        $results['title'] = $request->request->get('title');
        $results['description'] = null;
        $results['status'] = 'OPEN';
        $results['user'] = $request->request->get('user');
        $results['roles'] = null;
        $results['due_date'] = $request->request->get('duedate');


        if ($request->request->get('description')){
            $results['description'] = $request->request->get('description');
        }

        if ($request->request->get('status')){
            $results['status'] = $request->request->get('status');
        }

        $taskDTO = $taskDtoTransformer->transformIntoTaskDto($results, $statusDtoTransformer, $userDtoTransformer);

        return $this->repository->store($taskDTO);

    }

    public function renewTask(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer,
        Request $request
    ): string
    {
        $results['id'] = null;
        $results['title'] = null;
        $results['description'] = null;
        $results['status'] = 'OPEN';
        $results['user'] = 'lynch.nikolas';
        $results['roles'] = null;
        $results['due_date'] = date('Y-m-d');

        $updateField = $request->request->get('field');
        $updateValue = $request->request->get('value');
        $conditionalField = $request->request->get('conditionalField');
        $conditionalValue = $request->request->get('conditionalValue');
        $results[$updateField] = $updateValue;

        $taskDTO = $taskDtoTransformer->transformIntoTaskDto($results, $statusDtoTransformer, $userDtoTransformer);

        return $this->repository->update($taskDTO, $updateField, $conditionalField, $conditionalValue);
    }

    public function removeTask(
        TaskDtoTransformer $taskDtoTransformer,
        StatusDtoTransformer $statusDtoTransformer,
        UserDtoTransformer $userDtoTransformer,
        Request $request
    ): string
    {
        $results['id'] = null;
        $results['title'] = null;
        $results['description'] = null;
        $results['status'] = 'OPEN';
        $results['user'] = 'lynch.nikolas';
        $results['roles'] = null;
        $results['due_date'] = date('Y-m-d');

        $updateField = $request->request->get('field');
        $updateValue = $request->request->get('value');
        $results[$updateField] = $updateValue;

        $taskDTO = $taskDtoTransformer->transformIntoTaskDto($results, $statusDtoTransformer, $userDtoTransformer);

        return $this->repository->delete($taskDTO, $updateField);
    }
}
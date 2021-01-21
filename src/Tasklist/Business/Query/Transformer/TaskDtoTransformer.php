<?php

declare(strict_types=1);

namespace Tasklist\Business\Query\Transformer;

use Tasklist\Business\Query\TaskDTO;
use Tasklist\Business\Query\Transformer\StatusDtoTransformer;
use Tasklist\Business\Query\Transformer\UserDtoTransformer;

class TaskDtoTransformer
{
    public function transformIntoTaskDto($results, StatusDtoTransformer $statusDtoTransformer, UserDtoTransformer $userDtoTransformer): TaskDTO
    {
        $taskDTO              = new TaskDTO();
        $taskDTO->id          = (int)$results['id'];
        $taskDTO->title       = $results['title'];
        $taskDTO->description = $results['description'];
        $taskDTO->status      = $statusDtoTransformer->transformIntoStatusDto($results['status']);
        $taskDTO->user        = $userDtoTransformer->transformIntoUserDto($results['user'], $results['roles']);
        $dueDate              = \DateTimeImmutable::createFromFormat('Y-m-d', $results['due_date']);
        $taskDTO->dueDate     = $dueDate;

        return $taskDTO;
    }

    public function transformIntoTaskDtoArray($results, StatusDtoTransformer $statusDtoTransformer, UserDtoTransformer $userDtoTransformer): array
    {
        $dtoArray = [];

        foreach($results as $result){
            $dtoArray[] = $this->transformIntoTaskDto($result, $statusDtoTransformer, $userDtoTransformer);
        }

        return $dtoArray;
    }
}
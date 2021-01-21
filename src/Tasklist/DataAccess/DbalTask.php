<?php

declare(strict_types=1);

namespace Tasklist\DataAccess;

use Doctrine\DBAL\Exception;
use Tasklist\Business\Query\TaskDTO;
use Tasklist\Business\Domain\Task;
use DateTime;

class DbalTask extends DbalConnection implements TaskRepository
{
    public function getAllTasks(): array
    {
        $sqlStatement =
            'SELECT task.id, task.title, task.description, task.status_id, status.name AS status, task.user_id, user.username AS user, user.roles, user.password, task.due_date 
            FROM task 
            LEFT JOIN status 
            ON status.id=task.status_id 
            LEFT JOIN user 
            ON user.id = task.user_id';

        return $this->getResults($sqlStatement);
    }

    public function getTasksByDate($dueDate): array
    {
        $sqlStatement =
            'SELECT task.id, task.title, task.description, task.status_id, status.name AS status, task.user_id, user.username AS user, user.roles, user.password, task.due_date 
            FROM task 
            LEFT JOIN status 
            ON status.id=task.status_id 
            LEFT JOIN user 
            ON user.id = task.user_id 
            WHERE task.due_date = :dueDate';

        return $this->getResults($sqlStatement, 'dueDate', $dueDate);
    }

    public function getTodaysTasksByUser($user): array
    {
        $sqlStatement =
            'SELECT task.id, task.title, task.description, task.status_id, status.name AS status, task.user_id, user.username AS user, user.roles, user.password, task.due_date 
            FROM task 
            LEFT JOIN status 
            ON status.id=task.status_id 
            LEFT JOIN user 
            ON user.id = task.user_id
            WHERE user.username = :user
            AND  due_date = :dueDate';

        $dueDate = date('Y-m-d');

        return $this->getResults($sqlStatement, 'user', $user, 'dueDate', $dueDate);
    }

    public function getTodaysTasks(): array
    {
        $sqlStatement =
            'SELECT task.id, task.title, task.description, task.status_id, status.name AS status, task.user_id, user.username AS user, user.roles, user.password, task.due_date 
            FROM task 
            LEFT JOIN status 
            ON status.id=task.status_id 
            LEFT JOIN user 
            ON user.id = task.user_id
            WHERE due_date = :dueDate';

        $dueDate = date('Y-m-d');

        return $this->getResults($sqlStatement, 'dueDate', $dueDate);
    }

    public function getTasksByUser($user): array
    {
        $sqlStatement =
            'SELECT task.id, task.title, task.description, task.status_id, status.name AS status, task.user_id, user.username AS user, user.roles, user.password, task.due_date 
            FROM task 
            LEFT JOIN status 
            ON status.id=task.status_id 
            LEFT JOIN user 
            ON user.id = task.user_id
            WHERE user.username = :user';

        return $this->getResults($sqlStatement, 'user', $user);
    }

    public function getTasksByStatus(string $status): array
    {
        $sqlStatement =
            'SELECT task.id, task.title, task.description, task.status_id, status.name AS status, task.user_id, user.username AS user, user.roles, user.password, task.due_date 
            FROM task 
            LEFT JOIN status 
            ON status.id=task.status_id 
            LEFT JOIN user 
            ON user.id = task.user_id
            WHERE status.name = :status';

        return $this->getResults($sqlStatement, 'status', $status);
    }

    public function getTasksByStatusAndUser(string $status, string $user): array
    {
        $sqlStatement =
            'SELECT task.id, task.title, task.description, task.status_id, status.name AS status, task.user_id, user.username AS user, user.roles, user.password, task.due_date 
            FROM task 
            LEFT JOIN status 
            ON status.id=task.status_id 
            LEFT JOIN user 
            ON user.id = task.user_id
            WHERE status.name = :status
            AND user.username = :user';

        return $this->getResults($sqlStatement, 'status', $status, 'user', $user);
    }

    public function getTaskByTitle(string $title): array
    {
        $sqlStatement =
            'SELECT task.id, task.title, task.description, task.status_id, status.name AS status, task.user_id, user.username AS user, user.roles, user.password, task.due_date 
            FROM task 
            LEFT JOIN status 
            ON status.id=task.status_id 
            LEFT JOIN user 
            ON user.id = task.user_id 
            WHERE title = :title';

        return $this->getResults($sqlStatement, 'title', $title);
    }

    public function store(TaskDTO $taskDto): string
    {
        $sqlStatement =
            'INSERT INTO task (task.id, task.title, task.description, task.status_id, task.user_id, task.due_date)
             VALUES (null, :title, :description, (SELECT id FROM status WHERE status.name = :statusname), (SELECT id FROM user WHERE user.username = :username), :dueDate)';

        if (!$taskDto->description){
            $sqlStatement =
                'INSERT INTO task (task.id, task.title, task.description, task.status_id, task.user_id, task.due_date)
             VALUES (null, :title, null, (SELECT id FROM status WHERE status.name = :statusname), (SELECT id FROM user WHERE user.username = :username), :dueDate)';
        }

        return $this->executeStatement($sqlStatement, 'title', $taskDto->title, 'description', $taskDto->description, 'statusname', $taskDto->status->name, 'username', $taskDto->user->username, 'dueDate', $taskDto->dueDate->format('Y-m-d'));
    }

    public function update(TaskDTO $taskDto, $updateField, $conditionalField, $conditionalValue): string
    {
        $conn = $this->getConnection();

        try {
            $conn->update('task', [$updateField => $taskDto->$updateField], [$conditionalField => $conditionalValue]);
            return 'Success!';
        } catch (Exception $e) {
            return "Exception: $e";
        }

    }

    public function delete(TaskDTO $taskDto,  $updateField): string
    {
        $conn = $this->getConnection();

        try {
            $conn->delete('task', [$updateField => $taskDto->$updateField]);
            return 'Success!';
        } catch (Exception $e) {
            return "Exception: $e";
        }
      }
}
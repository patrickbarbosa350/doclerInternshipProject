<?php

declare(strict_types=1);

namespace Tasklist\DataAccess;

use Tasklist\Business\Query\TaskDTO;

interface TaskRepository
{
    public function getAllTasks(): array;
    public function getTodaysTasks(): array;
    public function getTodaysTasksByUser(string $user): array;
    public function getTasksByDate(string $dueDate): array;
    public function getTasksByUser(string $user): array;
    public function getTasksByStatus(string $status): array;
    public function getTasksByStatusAndUser(string $status, string $user): array;
    public function getTaskByTitle(string $title): array;
    public function store(TaskDTO $taskDto): string;
    public function update(TaskDTO $taskDto, $updateField, $conditionalField, $conditionalValue): string;
    public function delete(TaskDTO $taskDto, $updateField): string;
}

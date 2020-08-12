<?php


namespace App\Services\ProjectTasks\Repositories;

use App\Models\Project;
use App\Models\ProjectTask;

interface ProjectTasksRepositoryInterface
{
    public function find(int $id);

    public function search(int $limit = 20);

    public function createFromArray(array $data): ProjectTask;

    public function updateFromArray(ProjectTask $task, array $data): ProjectTask;

    public function delete(ProjectTask $task): ?bool;
}

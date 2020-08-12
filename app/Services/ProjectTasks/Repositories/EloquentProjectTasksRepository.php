<?php

namespace App\Services\ProjectTasks\Repositories;

use App\Models\ProjectTask;

class EloquentProjectTasksRepository implements ProjectTasksRepositoryInterface
{

    public function find(int $id)
    {
        return ProjectTask::whereId($id)->first();
    }

    public function search(int $limit = 20)
    {
        return ProjectTask::paginate($limit);
    }

    public function createFromArray(array $data): ProjectTask
    {
        return (new ProjectTask())->create($data);
    }

    public function updateFromArray(ProjectTask $task, array $data): ProjectTask
    {
        $task->update($data);

        return $task;
    }

    public function delete(ProjectTask $task): ?bool
    {
        return $task->delete();
    }
}

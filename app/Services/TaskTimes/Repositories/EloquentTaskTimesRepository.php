<?php

namespace App\Services\TaskTimes\Repositories;

use App\Models\TaskTimes;

class EloquentTaskTimesRepository implements TaskTimesRepositoryInterface
{

    public function createFromArray(array $data): TaskTimes
    {
        return (new TaskTimes())->create($data);
    }

    public function updateFromArray(TaskTimes $taskTimes, array $data): TaskTimes
    {
        $taskTimes->update($data);

        return $taskTimes;
    }
}

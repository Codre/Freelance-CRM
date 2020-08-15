<?php

namespace App\Services\TaskTimes\Repositories;

use App\Models\TaskTimes;

interface TaskTimesRepositoryInterface
{
    public function createFromArray(array $data): TaskTimes;
    public function updateFromArray(TaskTimes $taskTimes, array $data): TaskTimes;
}

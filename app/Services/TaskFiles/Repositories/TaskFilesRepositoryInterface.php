<?php

namespace App\Services\TaskFiles\Repositories;

use App\Models\TaskFile;

interface TaskFilesRepositoryInterface
{
    public function createFromArray(array $data): TaskFile;
    public function delete(TaskFile $file): ?bool;
}

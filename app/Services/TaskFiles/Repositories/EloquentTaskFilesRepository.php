<?php

namespace App\Services\TaskFiles\Repositories;

use App\Models\TaskFile;

class EloquentTaskFilesRepository implements TaskFilesRepositoryInterface
{

    public function createFromArray(array $data): TaskFile
    {
        return (new TaskFile())->create($data);
    }

    public function delete(TaskFile $file): ?bool
    {
        return $file->delete();
    }
}

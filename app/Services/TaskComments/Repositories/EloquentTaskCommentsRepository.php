<?php

namespace App\Services\TaskComments\Repositories;

use App\Models\TaskComment;

class EloquentTaskCommentsRepository implements TaskCommentsRepositoryInterface
{

    public function createFromArray(array $data): TaskComment
    {
        return (new TaskComment())->create($data);
    }
}

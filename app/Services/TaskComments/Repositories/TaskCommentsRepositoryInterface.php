<?php


namespace App\Services\TaskComments\Repositories;


use App\Models\TaskComment;

interface TaskCommentsRepositoryInterface
{
    public function createFromArray(array $data): TaskComment;
}

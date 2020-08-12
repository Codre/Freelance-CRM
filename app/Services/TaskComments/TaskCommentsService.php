<?php

namespace App\Services\TaskComments;

use App\Models\ProjectTask;
use App\Models\TaskComment;
use App\Services\TaskComments\Handlers\CreateCommentHandler;

class TaskCommentsService
{
    /**
     * @var CreateCommentHandler
     */
    private $commentHandler;

    /**
     * TaskCommentsService constructor.
     *
     * @param CreateCommentHandler $commentHandler
     */
    public function __construct(CreateCommentHandler $commentHandler)
    {
        $this->commentHandler = $commentHandler;
    }

    public function create(ProjectTask $task, array $data): TaskComment
    {
        return $this->commentHandler->handle($task, $data);
    }
}

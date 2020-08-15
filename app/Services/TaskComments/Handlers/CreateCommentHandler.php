<?php

namespace App\Services\TaskComments\Handlers;

use App\Jobs\Projects\CommentCreating;
use App\Jobs\Queue;
use App\Models\ProjectTask;
use App\Models\TaskComment;
use App\Services\TaskComments\Repositories\TaskCommentsRepositoryInterface;

class CreateCommentHandler
{
    /**
     * @var TaskCommentsRepositoryInterface
     */
    private $taskCommentsRepository;

    /**
     * CreateCommentHandler constructor.
     */
    public function __construct(TaskCommentsRepositoryInterface $taskCommentsRepository)
    {
        $this->taskCommentsRepository = $taskCommentsRepository;
    }

    public function handle(ProjectTask $task, array $data): TaskComment
    {
        $data['task_id'] = $task->id;
        $data['user_id'] = \Auth::id();

        $comment = $this->taskCommentsRepository->createFromArray($data);

        CommentCreating::dispatch($comment, \Auth::user())->onQueue(Queue::LOW);

        return $comment;
    }
}

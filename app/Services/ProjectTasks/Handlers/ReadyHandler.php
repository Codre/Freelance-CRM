<?php

namespace App\Services\ProjectTasks\Handlers;

use App\Jobs\Projects\TaskReady;
use App\Jobs\Queue;
use App\Models\ProjectTask;
use App\Services\ProjectTasks\Repositories\ProjectTasksRepositoryInterface;

/**
 * Class ReadyHandler
 *
 * @package App\Services\ProjectTasks\Handlers
 */
class ReadyHandler
{
    /**
     * @var ProjectTasksRepositoryInterface
     */
    private $projectTasksRepository;

    /**
     * FinishingHandler constructor.
     *
     * @param ProjectTasksRepositoryInterface $projectTasksRepository
     */
    public function __construct(
        ProjectTasksRepositoryInterface $projectTasksRepository
    ) {
        $this->projectTasksRepository = $projectTasksRepository;
    }

    /**
     * @param ProjectTask $task
     */
    public function handle(ProjectTask $task)
    {
        $this->projectTasksRepository->updateFromArray($task, ['status' => ProjectTask::STATUS_READY]);

        TaskReady::dispatch($task, \Auth::user())->onQueue(Queue::LOW);
    }
}

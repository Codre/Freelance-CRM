<?php


namespace App\Services\ProjectTasks\Handlers;

use App\Jobs\Projects\TaskUpdating;
use App\Jobs\Queue;
use App\Models\ProjectTask;
use App\Services\ProjectTasks\Repositories\ProjectTasksRepositoryInterface;

/**
 * Class UpdateTaskHandler
 *
 * @package App\Services\ProjectTasks\Handlers
 */
class UpdateTaskHandler
{
    /**
     * @var ProjectTasksRepositoryInterface
     */
    private $projectTasksRepository;

    /**
     * UpdateTaskHandler constructor.
     *
     * @param ProjectTasksRepositoryInterface $projectTasksRepository
     */
    public function __construct(ProjectTasksRepositoryInterface $projectTasksRepository)
    {
        $this->projectTasksRepository = $projectTasksRepository;
    }

    public function handle(ProjectTask $task, array $data): ProjectTask
    {
        $this->projectTasksRepository->updateFromArray($task, $data);

        # TaskUpdating::dispatch($task, \Auth::user())->onQueue(Queue::LOW);

        return $task;
    }
}

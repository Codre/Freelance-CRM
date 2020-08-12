<?php


namespace App\Services\ProjectTasks\Handlers;

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
        return $this->projectTasksRepository->updateFromArray($task, $data);
    }
}

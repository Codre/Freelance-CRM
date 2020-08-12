<?php


namespace App\Services\ProjectTasks\Handlers;

use App\Models\Project;
use App\Models\ProjectTask;
use App\Services\ProjectTasks\Repositories\ProjectTasksRepositoryInterface;

/**
 * Class CreateTaskHandler
 *
 * @package App\Services\ProjectTasks\Handlers
 */
class CreateTaskHandler
{
    /**
     * @var ProjectTasksRepositoryInterface
     */
    private $projectTasksRepository;

    /**
     * CreateTaskHandler constructor.
     *
     * @param ProjectTasksRepositoryInterface $projectTasksRepository
     */
    public function __construct(ProjectTasksRepositoryInterface $projectTasksRepository)
    {
        $this->projectTasksRepository = $projectTasksRepository;
    }

    public function handle(Project $project, array $data): ProjectTask
    {

        $data['project_id'] = $project->id;
        $data['user_id'] = \Auth::id();
        $data['status'] = ProjectTask::STATUS_NEW;

        return $this->projectTasksRepository->createFromArray($data);
    }
}
<?php

namespace App\Services\ProjectTasks\Handlers;

use App\Jobs\Projects\TaskCreating;
use App\Jobs\Queue;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Services\ProjectTasks\Repositories\ProjectTasksRepositoryInterface;
use App\Services\TaskFiles\TaskFilesService;

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
     * @var TaskFilesService
     */
    private $filesService;

    /**
     * CreateTaskHandler constructor.
     *
     * @param ProjectTasksRepositoryInterface $projectTasksRepository
     * @param TaskFilesService                $filesService
     */
    public function __construct(
        ProjectTasksRepositoryInterface $projectTasksRepository,
        TaskFilesService $filesService
    ) {
        $this->projectTasksRepository = $projectTasksRepository;
        $this->filesService = $filesService;
    }

    /**
     * @param Project $project
     * @param array   $data
     * @param array   $files
     *
     * @return ProjectTask
     */
    public function handle(Project $project, array $data, array $files = []): ProjectTask
    {
        $data['project_id'] = $project->id;
        $data['user_id'] = \Auth::id();
        $data['status'] = ProjectTask::STATUS_NEW;

        $task = $this->projectTasksRepository->createFromArray($data);

        TaskCreating::dispatch($task, \Auth::user())->onQueue(Queue::LOW);

        foreach ($files as $file) {
            $this->filesService->uploadFile($file, $task->id);
        }

        return $task;
    }
}

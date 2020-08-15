<?php

namespace App\Services\ProjectTasks;

use App\Models\Project;
use App\Models\ProjectTask;
use App\Services\ProjectTasks\Handlers\CreateTaskHandler;
use App\Services\ProjectTasks\Handlers\FinishingHandler;
use App\Services\ProjectTasks\Handlers\UpdateTaskHandler;
use App\Services\ProjectTasks\Repositories\ProjectTasksRepositoryInterface;

/**
 * Class ProjectTasksService
 *
 * Сервис для работы с тикетами проекта
 *
 * @package App\Services\ProjectTasks
 */
class ProjectTasksService
{
    /**
     * @var FinishingHandler
     */
    private $finishingHandler;
    /**
     * @var CreateTaskHandler
     */
    private $createTaskHandler;
    /**
     * @var UpdateTaskHandler
     */
    private $updateTaskHandler;
    /**
     * @var ProjectTasksRepositoryInterface
     */
    private $projectTasksRepository;

    /**
     * ProjectTasksService constructor.
     *
     * @param FinishingHandler                $finishingHandler
     * @param CreateTaskHandler               $createTaskHandler
     * @param UpdateTaskHandler               $updateTaskHandler
     * @param ProjectTasksRepositoryInterface $projectTasksRepository
     */
    public function __construct(
        FinishingHandler $finishingHandler,
        CreateTaskHandler $createTaskHandler,
        UpdateTaskHandler $updateTaskHandler,
        ProjectTasksRepositoryInterface $projectTasksRepository
    ) {
        $this->finishingHandler = $finishingHandler;
        $this->createTaskHandler = $createTaskHandler;
        $this->updateTaskHandler = $updateTaskHandler;
        $this->projectTasksRepository = $projectTasksRepository;
    }

    /**
     * Завершить тикет
     *
     * @param int $id
     */
    public function finished(int $id)
    {
        $this->finishingHandler->handle($id);
    }

    /**
     * @param Project $project
     * @param array   $data
     *
     * @return ProjectTask
     */
    public function create(Project $project, array $data): ProjectTask
    {
        return $this->createTaskHandler->handle($project, $data);
    }

    /**
     * @param ProjectTask $task
     * @param array       $data
     *
     * @return ProjectTask
     */
    public function update(ProjectTask $task, array $data): ProjectTask
    {
        return $this->updateTaskHandler->handle($task, $data);
    }

    /**
     * @param ProjectTask $task
     *
     * @return bool|null
     */
    public function delete(ProjectTask $task): ?bool
    {
        return $this->projectTasksRepository->delete($task);
    }

    /**
     * Установить статус в процессе
     * @param ProjectTask $task
     *
     * @return ProjectTask
     */
    public function setStatusProcess(ProjectTask $task): ProjectTask
    {
        return $this->projectTasksRepository->updateFromArray($task, [
            'status' => ProjectTask::STATUS_PROCESS
        ]);
    }

    /**
     * Установить статус остановлен
     *
     * @param ProjectTask $task
     *
     * @return ProjectTask
     */
    public function setStatusPause(ProjectTask $task): ProjectTask
    {
        return $this->projectTasksRepository->updateFromArray($task, [
            'status' => ProjectTask::STATUS_PAUSE
        ]);
    }
}

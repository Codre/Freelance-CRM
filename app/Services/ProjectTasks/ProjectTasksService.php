<?php

namespace App\Services\ProjectTasks;

use App\Models\Project;
use App\Models\ProjectTask;
use App\Services\ProjectTasks\Handlers\CreateTaskHandler;
use App\Services\ProjectTasks\Handlers\FinishingHandler;
use App\Services\ProjectTasks\Handlers\ReadyHandler;
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
     * @var ReadyHandler
     */
    private $readyHandler;

    /**
     * ProjectTasksService constructor.
     *
     * @param FinishingHandler                $finishingHandler
     * @param ReadyHandler                    $readyHandler
     * @param CreateTaskHandler               $createTaskHandler
     * @param UpdateTaskHandler               $updateTaskHandler
     * @param ProjectTasksRepositoryInterface $projectTasksRepository
     */
    public function __construct(
        FinishingHandler $finishingHandler,
        ReadyHandler $readyHandler,
        CreateTaskHandler $createTaskHandler,
        UpdateTaskHandler $updateTaskHandler,
        ProjectTasksRepositoryInterface $projectTasksRepository
    ) {
        $this->finishingHandler = $finishingHandler;
        $this->createTaskHandler = $createTaskHandler;
        $this->updateTaskHandler = $updateTaskHandler;
        $this->projectTasksRepository = $projectTasksRepository;
        $this->readyHandler = $readyHandler;
    }

    /**
     * Отправить тикет на проверку
     *
     * @param ProjectTask $task
     */
    public function ready(ProjectTask $task)
    {
        $this->readyHandler->handle($task);
    }

    /**
     * Завершить тикет
     *
     * @param ProjectTask $task
     */
    public function finished(ProjectTask $task)
    {
        $this->finishingHandler->handle($task);
    }

    /**
     * @param Project $project
     * @param array   $data
     *
     * @param array   $files
     *
     * @return ProjectTask
     */
    public function create(Project $project, array $data, array $files = []): ProjectTask
    {
        return $this->createTaskHandler->handle($project, $data, $files);
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

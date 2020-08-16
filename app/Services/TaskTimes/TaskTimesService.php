<?php

namespace App\Services\TaskTimes;

use App\Models\ProjectTask;
use App\Models\TaskTimes;
use App\Services\TaskTimes\Handlers\RunTaskHandler;
use App\Services\TaskTimes\Handlers\StopTaskHandler;
use App\Services\TaskTimes\Repositories\TaskTimesRepositoryInterface;

/**
 * Class TaskTimesService
 *
 * @package App\Services\TaskTimes
 */
class TaskTimesService
{
    /**
     * @var RunTaskHandler
     */
    private $runTaskHandler;
    /**
     * @var StopTaskHandler
     */
    private $stopTaskHandler;
    /**
     * @var TaskTimesRepositoryInterface
     */
    private $repository;

    /**
     * TaskTimesService constructor.
     *
     * @param RunTaskHandler               $runTaskHandler
     * @param StopTaskHandler              $stopTaskHandler
     * @param TaskTimesRepositoryInterface $repository
     */
    public function __construct(
        RunTaskHandler $runTaskHandler,
        StopTaskHandler $stopTaskHandler,
        TaskTimesRepositoryInterface $repository
    ) {
        $this->runTaskHandler = $runTaskHandler;
        $this->stopTaskHandler = $stopTaskHandler;
        $this->repository = $repository;
    }

    /**
     * Начать процесс выполнения задачи
     *
     * @param ProjectTask $task
     *
     * @return TaskTimes
     */
    public function run(ProjectTask $task): TaskTimes
    {
        return $this->runTaskHandler->handle($task);
    }

    /**
     * Остановить процесс выполнения задачи
     *
     * @param TaskTimes $taskTimes
     *
     * @return TaskTimes
     */
    public function stop(TaskTimes $taskTimes): TaskTimes
    {
        return $this->stopTaskHandler->handle($taskTimes);
    }

    /**
     * Обновить комментарий
     *
     * @param TaskTimes $taskTimes
     * @param string    $comment
     *
     * @return TaskTimes
     */
    public function updateComment(TaskTimes $taskTimes, string $comment): TaskTimes
    {
        return $this->repository->updateFromArray($taskTimes, ['comment' => $comment]);
    }
}

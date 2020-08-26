<?php

namespace App\Services\TaskTimes;

use App\Models\ProjectTask;
use App\Models\TaskTimes;
use App\Services\TaskTimes\Handlers\CalcTimeByTaskIds;
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
     * @var CalcTimeByTaskIds
     */
    private $calcTimeByTaskIds;

    /**
     * TaskTimesService constructor.
     *
     * @param RunTaskHandler               $runTaskHandler
     * @param StopTaskHandler              $stopTaskHandler
     * @param CalcTimeByTaskIds            $calcTimeByTaskIds
     * @param TaskTimesRepositoryInterface $repository
     */
    public function __construct(
        RunTaskHandler $runTaskHandler,
        StopTaskHandler $stopTaskHandler,
        CalcTimeByTaskIds $calcTimeByTaskIds,
        TaskTimesRepositoryInterface $repository
    ) {
        $this->runTaskHandler = $runTaskHandler;
        $this->stopTaskHandler = $stopTaskHandler;
        $this->repository = $repository;
        $this->calcTimeByTaskIds = $calcTimeByTaskIds;
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

    /**
     * Обновить время
     *
     * @param TaskTimes $taskTimes
     * @param string    $time
     *
     * @return TaskTimes
     */
    public function updateTime(TaskTimes $taskTimes, string $time): TaskTimes
    {
        $path = explode(':', $time);
        $total = (int)$path[0] * 60 + (int)$path[1];

        return $this->repository->updateFromArray($taskTimes, ['total' => $total]);
    }

    /**
     * Получить итоги времени по списку id тикетов
     *
     * @param array $taskIds
     *
     * @return array
     */
    public function calcTimeByTaskIds(array $taskIds): array
    {
        return $this->calcTimeByTaskIds->handle($taskIds);
    }

    /**
     * Получить итоги времени по списку id тикетов залогированных текущим пользователем
     *
     * @param array $taskIds
     *
     * @return array
     */
    public function calcTimeByTaskIdsByCurrentUser(array $taskIds): array
    {
        return $this->calcTimeByTaskIds->handle($taskIds, true);
    }
}

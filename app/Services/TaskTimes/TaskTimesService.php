<?php

namespace App\Services\TaskTimes;

use App\Models\ProjectTask;
use App\Models\TaskTimes;
use App\Services\TaskTimes\Handlers\RunTaskHandler;
use App\Services\TaskTimes\Handlers\StopTaskHandler;

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
     * TaskTimesService constructor.
     *
     * @param RunTaskHandler  $runTaskHandler
     * @param StopTaskHandler $stopTaskHandler
     */
    public function __construct(
        RunTaskHandler $runTaskHandler,
        StopTaskHandler $stopTaskHandler
    ) {
        $this->runTaskHandler = $runTaskHandler;
        $this->stopTaskHandler = $stopTaskHandler;
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
}

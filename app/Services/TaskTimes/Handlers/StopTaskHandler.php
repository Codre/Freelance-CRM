<?php

namespace App\Services\TaskTimes\Handlers;

use App\Models\TaskTimes;
use App\Services\ProjectTasks\ProjectTasksService;
use App\Services\TaskTimes\Repositories\TaskTimesRepositoryInterface;
use Carbon\Carbon;

/**
 * Class StopTaskHandler
 *
 * @package App\Services\TaskTimes\Handlers
 */
class StopTaskHandler
{
    /**
     * @var TaskTimesRepositoryInterface
     */
    private $repository;
    /**
     * @var ProjectTasksService
     */
    private $projectTasksService;

    /**
     * RunTaskHandler constructor.
     *
     * @param TaskTimesRepositoryInterface $repository
     * @param ProjectTasksService          $projectTasksService
     */
    public function __construct(
        TaskTimesRepositoryInterface $repository,
        ProjectTasksService $projectTasksService
    ) {
        $this->repository = $repository;
        $this->projectTasksService = $projectTasksService;
    }

    /**
     * @param TaskTimes $taskTimes
     *
     * @return TaskTimes
     */
    public function handle(TaskTimes $taskTimes): TaskTimes
    {
        $data = [
            'total' => $taskTimes->total + Carbon::now()->diffInMinutes($taskTimes->started, true) + 1,
            'ended' => Carbon::now(),
        ];

        $taskTimes = $this->repository->updateFromArray($taskTimes, $data);

        if (!$this->issetNotEnded($taskTimes->task_id)) {
            $this->projectTasksService->setStatusPause($taskTimes->task);
        }

        return $taskTimes;
    }

    /**
     * Проверить если ещё не завершённое время
     *
     * @param int $task_id
     *
     * @return bool
     */
    private function issetNotEnded(int $task_id): bool
    {
        return TaskTimes::where('task_id', '=', $task_id)->whereNull('ended')->count() > 0;
    }
}

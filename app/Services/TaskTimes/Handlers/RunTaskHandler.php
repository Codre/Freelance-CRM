<?php

namespace App\Services\TaskTimes\Handlers;

use App\Models\ProjectTask;
use App\Models\TaskTimes;
use App\Services\ProjectTasks\ProjectTasksService;
use App\Services\TaskTimes\Repositories\TaskTimesRepositoryInterface;
use Carbon\Carbon;

/**
 * Class RunTaskHandler
 *
 * @package App\Services\TaskTimes\Handlers
 */
class RunTaskHandler
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
     * @param ProjectTask $task
     *
     * @return TaskTimes
     */
    public function handle(ProjectTask $task): TaskTimes
    {

        $issetTime = $this->getIfIssetToDayUserTime($task);

        if ($issetTime) {
            $taskTimes = $this->update($issetTime);
        } else {
            $taskTimes = $this->create($task->id);
        }

        $this->projectTasksService->setStatusProcess($task);

        return $taskTimes;
    }

    /**
     * @param int $taskId
     *
     * @return TaskTimes
     */
    private function create(int $taskId)
    {
        $data = [
            'task_id' => $taskId,
            'user_id' => \Auth::id(),
            'started' => Carbon::now(),
            'total'   => 0,
            'comment' => '',
        ];

        return $this->repository->createFromArray($data);
    }

    /**
     * @param TaskTimes $time
     *
     * @return TaskTimes
     */
    private function update(TaskTimes $time): TaskTimes
    {
        return $this->repository->updateFromArray($time, [
            'started' => Carbon::now(),
            'ended' => null,
        ]);
    }

    /**
     * @param ProjectTask $task
     *
     * @return TaskTimes|null
     */
    private function getIfIssetToDayUserTime(ProjectTask $task): ?TaskTimes
    {
        return $task->times()
            ->where('user_id', '=', \Auth::id())
            ->whereBetween('ended', [
                Carbon::now()->setTime(0, 0, 0),
                Carbon::now()->setTime(23, 59, 59),
            ])
            ->get()->first();
    }
}

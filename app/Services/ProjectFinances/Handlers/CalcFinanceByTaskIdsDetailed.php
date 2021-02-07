<?php

namespace App\Services\ProjectFinances\Handlers;

use App\Models\Project;
use App\Models\ProjectFinance;
use App\Models\ProjectUser;
use App\Models\TaskTimes;
use App\Services\ProjectFinances\Repositories\ProjectFinancesRepositoryInterface;
use App\Services\TaskTimes\TaskTimesService;

/**
 * Class CalcFinanceByTaskIdsDetailed
 *
 * @package App\Services\ProjectFinances\Handlers
 */
class CalcFinanceByTaskIdsDetailed
{
    /**
     * @var ProjectFinancesRepositoryInterface
     */
    private $repository;
    /**
     * @var TaskTimesService
     */
    private $taskTimesService;

    /**
     * calcFinanceByTaskIds constructor.
     *
     * @param ProjectFinancesRepositoryInterface $repository
     * @param TaskTimesService                   $taskTimesService
     */
    public function __construct(
        ProjectFinancesRepositoryInterface $repository,
        TaskTimesService $taskTimesService
    ) {
        $this->repository = $repository;
        $this->taskTimesService = $taskTimesService;
    }

    /**
     * @param Project $project
     * @param array   $taskIds
     *
     * @return array
     */
    public function handle(Project $project, array $taskIds): array
    {
        /** @var ProjectFinance $projectFinance */
        $projectFinance = $this->repository->getByProject($project, null)
            ->where('user_id', '=', \Auth::id())->first();

        $taskFinances = ProjectFinance::whereIn('task_id', $taskIds)
            ->where('user_id', '=', \Auth::id())->get();

        if (!$projectFinance && !$taskFinances->toArray()) {
            return [];
        }

        $times = TaskTimes::whereIn('task_id', $taskIds)->get();

        $return = [];

        $finances = [];

        /** @var TaskTimes $time */
        foreach ($times as $time) {
            $finances[$time->task_id] = $finances[$time->task_id]
                ?? $taskFinances->firstWhere('task_id', '=', $time->task_id);

            $finance = $taskFinance ?? $projectFinance;

            $return[$time->task_id][$time->id] = round($finance->bet * ($time['total'] / 60), 2);
        }

        return $return;
    }
}

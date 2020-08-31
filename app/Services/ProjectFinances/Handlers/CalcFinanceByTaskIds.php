<?php

namespace App\Services\ProjectFinances\Handlers;

use App\Models\Project;
use App\Models\ProjectFinance;
use App\Models\ProjectUser;
use App\Services\ProjectFinances\Repositories\ProjectFinancesRepositoryInterface;
use App\Services\TaskTimes\TaskTimesService;

/**
 * Class calcFinanceByTaskIds
 *
 * @package App\Services\ProjectFinances\Handlers
 */
class CalcFinanceByTaskIds
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

        $userGroup = $project->users->find(\Auth::id())->pivot->group;

        if (in_array($userGroup, [ProjectUser::GROUP_EXECUTOR, ProjectUser::GROUP_MANAGER])) {
            $times = $this->taskTimesService->calcTimeByTaskIdsByCurrentUser($taskIds);
        } else {
            $times = $this->taskTimesService->calcTimeByTaskIds($taskIds);
        }

        $return = [];

        foreach ($times as $taskId => $time) {
            $taskFinance = $taskFinances->firstWhere('task_id', '=', $taskId);

            /** @var ProjectFinance $finance */
            $finance = $taskFinance ?? $projectFinance;

            $return[$taskId] = round($finance->bet * ($time['total'] / 60), 2);
        }

        return $return;
    }
}

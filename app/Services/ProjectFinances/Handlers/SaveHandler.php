<?php

namespace App\Services\ProjectFinances\Handlers;

use App\Models\Project;
use App\Models\ProjectTask;
use App\Services\ProjectFinances\Repositories\ProjectFinancesRepositoryInterface;

/**
 * Class SaveHandler
 *
 * @package App\Services\ProjectFinances\Handlers
 */
class SaveHandler
{
    /**
     * @var ProjectFinancesRepositoryInterface
     */
    private $repository;

    /**
     * SaveHandler constructor.
     *
     * @param ProjectFinancesRepositoryInterface $repository
     */
    public function __construct(ProjectFinancesRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array            $bets
     * @param Project          $project
     * @param ProjectTask|null $task
     */
    public function handle(array $bets, Project $project, ?ProjectTask $task)
    {
        $list = $this->repository->getByProject($project, $task);

        foreach ($bets as $memberId => $bet) {
            $item = $list->where('user_id', '=', $memberId)->first();
            if ($item) {
                $this->repository->updateFromArray($item, ['bet' => $bet ?? 0]);
            } elseif ($bet) {
                $this->repository->createFromArray([
                    'user_id'    => $memberId,
                    'project_id' => $project->id,
                    'task_id'    => $task->id,
                    'bet'        => $bet,
                ]);
            }
        }
    }
}

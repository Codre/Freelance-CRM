<?php

namespace App\Services\ProjectFinances;

use App\Models\Project;
use App\Models\ProjectTask;
use App\Services\ProjectFinances\Handlers\CalcFinanceByTaskIds;
use App\Services\ProjectFinances\Handlers\PayByTask;
use App\Services\ProjectFinances\Handlers\SaveHandler;
use App\Services\ProjectFinances\Repositories\ProjectFinancesRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ProjectFinancesService
 *
 * @package App\Services\ProjectFinances
 */
class ProjectFinancesService
{
    /**
     * @var ProjectFinancesRepositoryInterface
     */
    private $repository;
    /**
     * @var SaveHandler
     */
    private $saveHandler;
    /**
     * @var PayByTask
     */
    private $payByTask;
    /**
     * @var CalcFinanceByTaskIds
     */
    private $calcFinanceByTaskIds;

    /**
     * ProjectFinancesService constructor.
     *
     * @param ProjectFinancesRepositoryInterface $repository
     * @param SaveHandler                        $saveHandler
     * @param PayByTask                          $payByTask
     * @param CalcFinanceByTaskIds               $calcFinanceByTaskIds
     */
    public function __construct(
        ProjectFinancesRepositoryInterface $repository,
        SaveHandler $saveHandler,
        PayByTask $payByTask,
        CalcFinanceByTaskIds $calcFinanceByTaskIds
    ) {
        $this->repository = $repository;
        $this->saveHandler = $saveHandler;
        $this->payByTask = $payByTask;
        $this->calcFinanceByTaskIds = $calcFinanceByTaskIds;
    }

    /**
     * Получить список финансов по проекту (задаче)
     *
     * @param Project          $project
     * @param ProjectTask|null $task
     *
     * @return Collection
     */
    public function getProjectData(Project $project, ?ProjectTask $task): Collection
    {
        return $this->repository->getByProject($project, $task);
    }

    /**
     * Сохранить ставки
     *
     * @param array            $bets
     * @param Project          $project
     * @param ProjectTask|null $task
     */
    public function save(array $bets, Project $project, ?ProjectTask $task)
    {
        $this->saveHandler->handle($bets, $project, $task);
    }

    /**
     * Выплатить ставки по задаче
     *
     * @param ProjectTask $task
     */
    public function payByTask(ProjectTask $task)
    {
        $this->payByTask->handle($task);
    }

    /**
     * Получить финансы для текущего пользователя по списку задач
     *
     * @param Project $project
     * @param array   $taskIds
     *
     * @return array
     */
    public function calcFinanceByTaskIdsForCurrentUser(Project $project, array $taskIds): array
    {
        return $this->calcFinanceByTaskIds->handle($project, $taskIds);
    }
}

<?php

namespace App\Services\ProjectFinances;

use App\Models\Project;
use App\Models\ProjectFinance;
use App\Models\ProjectTask;
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
     * ProjectFinancesService constructor.
     *
     * @param ProjectFinancesRepositoryInterface $repository
     * @param SaveHandler                        $saveHandler
     */
    public function __construct(
        ProjectFinancesRepositoryInterface $repository,
        SaveHandler $saveHandler
    )
    {
        $this->repository = $repository;
        $this->saveHandler = $saveHandler;
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
}

<?php

namespace App\Services\ProjectFinances\Repositories;

use App\Models\Project;
use App\Models\ProjectFinance;
use App\Models\ProjectTask;
use Illuminate\Database\Eloquent\Collection;

class EloquentProjectFinancesRepository implements ProjectFinancesRepositoryInterface
{

    public function createFromArray(array $data): ProjectFinance
    {
        return (new ProjectFinance())->create($data);
    }

    public function updateFromArray(ProjectFinance $finance, array $data): ProjectFinance
    {
        $finance->update($data);

        return $finance;
    }

    public function getByProject(Project $project, ?ProjectTask $task): Collection
    {
        $query = ProjectFinance::whereProjectId($project->id);

        if ($task && $task->id) {
            $query->whereTaskId($task->id);
        } else {
            $query->whereNull('task_id');
        }

        return $query->get();
    }

    public function delete(ProjectFinance $finance): ?bool
    {
        return $finance->delete();
    }
}

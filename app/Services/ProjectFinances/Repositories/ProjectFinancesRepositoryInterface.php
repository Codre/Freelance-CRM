<?php

namespace App\Services\ProjectFinances\Repositories;

use App\Models\Project;
use App\Models\ProjectFinance;
use App\Models\ProjectTask;
use Illuminate\Database\Eloquent\Collection;

interface ProjectFinancesRepositoryInterface
{
    public function getByProject(Project $project, ?ProjectTask $task): Collection;
    public function createFromArray(array $data): ProjectFinance;
    public function updateFromArray(ProjectFinance $finance, array $data): ProjectFinance;
    public function delete(ProjectFinance $finance): ?bool;
}

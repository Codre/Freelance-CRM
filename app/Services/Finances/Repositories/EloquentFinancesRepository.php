<?php

namespace App\Services\Finances\Repositories;

use App\Models\Finance;

class EloquentFinancesRepository implements FinancesRepositoryInterface
{

    public function createFromArray(array $data): Finance
    {
        return (new Finance())->create($data);
    }

    public function updateFromArray(Finance $finance, array $data): Finance
    {
        $finance->update($data);

        return $finance;
    }

    public function delete(Finance $finance): ?bool
    {
        return $finance->delete();
    }
}

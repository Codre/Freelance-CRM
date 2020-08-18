<?php

namespace App\Services\Finances\Repositories;

use App\Models\Finance;

interface FinancesRepositoryInterface
{
    public function createFromArray(array $data): Finance;
    public function updateFromArray(Finance $finance, array $data): Finance;
    public function delete(Finance $finance): ?bool;
}

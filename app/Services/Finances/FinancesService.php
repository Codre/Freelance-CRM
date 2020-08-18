<?php

namespace App\Services\Finances;

use App\Models\Finance;
use App\Services\Finances\Handlers\CreateHandler;

/**
 * Class FinancesService
 *
 * @package App\Services\Finances
 */
class FinancesService
{
    /**
     * @var CreateHandler
     */
    private $createHandler;

    /**
     * FinancesService constructor.
     *
     * @param CreateHandler $createHandler
     */
    public function __construct(CreateHandler $createHandler)
    {
        $this->createHandler = $createHandler;
    }

    /**
     * Создать проводку в финансах
     *
     * @param array $data
     *
     * @return Finance
     */
    public function createFinance(array $data): Finance
    {
        return $this->createHandler->handler($data);
    }

}

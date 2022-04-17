<?php

namespace App\Services\Finances;

use App\Models\Finance;
use App\Models\ProjectTask;
use App\Services\Finances\Handlers\CreateInvoiceHandler;
use App\Services\Finances\Handlers\CreateHandler;
use App\Services\ProjectFinances\ProjectFinancesService;

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
    private CreateHandler $createHandler;
    /**
     * @var CreateInvoiceHandler
     */
    private CreateInvoiceHandler $createInvoiceHandler;
    private ProjectFinancesService $projectFinancesService;

    /**
     * FinancesService constructor.
     *
     * @param CreateHandler        $createHandler
     * @param CreateInvoiceHandler $createInvoiceHandler
     */
    public function __construct(
        CreateHandler $createHandler,
        CreateInvoiceHandler $createInvoiceHandler
    )
    {
        $this->createHandler = $createHandler;
        $this->createInvoiceHandler = $createInvoiceHandler;
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

    /**
     * Создать счёт на оплату
     *
     * @param ProjectTask $task
     *
     * @return void
     */
    public function createInvoice(ProjectTask $task): void
    {
        $this->createInvoiceHandler->handler($task);
    }
}

<?php

declare(strict_types=1);

namespace App\Services\Finances\Handlers;

use App\Models\Invoice;
use App\Models\ProjectFinance;
use App\Models\ProjectTask;
use App\Models\ProjectUser;
use App\Models\TaskTimes;
use App\Services\Finances\Exception\InvoiceAlreadyExistsException;
use Illuminate\Support\Collection;

final class CreateInvoiceHandler
{
    /**
     * @param ProjectTask $task
     * @return void
     */
    public function handler(ProjectTask $task): void
    {
        $invoice = Invoice::whereTaskId($task->id);

        if ($invoice->count()) {
            throw new InvoiceAlreadyExistsException($invoice->first()->id);
        }
        unset($invoice);

        if (!$task->times->count() || !$minutes = $task->times->sum('total')) {
            return;
        }

        /** @var ProjectUser $payer */
        $payer = ProjectUser::whereProjectId($task->project_id)->whereGroup(ProjectUser::GROUP_CUSTOMER)
            ->get()->first();
        $finances = $this->getFinancesByTask($task);

        foreach ($finances as $finance) {
            $this->makeInvoicesByFinance($task, $finance, $payer);
        }
    }

    /**
     * @param ProjectTask $task
     * @return ProjectFinance[]|Collection
     */
    public function getFinancesByTask(ProjectTask $task): Collection
    {
        $finances = ProjectFinance::whereProjectId($task->project->id)
            ->whereTaskId($task->id)->get();

        if ($finances->count()) {
            $userIds = $finances->pluck('user_id')->all();
            $financesTmp = ProjectFinance::whereProjectId($task->project->id)->whereNull('task_id')
                ->whereNotIn('user_id', $userIds)->get();
            $finances = $finances->merge($financesTmp);
        } else {
            $finances = ProjectFinance::whereProjectId($task->project->id)
                ->whereNull('task_id')->get();
        }

        return $finances;
    }

    /**
     * @param ProjectTask    $task
     * @param ProjectFinance $finance
     * @param ProjectUser    $payer
     * @return void
     */
    private function makeInvoicesByFinance(
        ProjectTask $task,
        ProjectFinance $finance,
        ProjectUser $payer
    ): void
    {
        $minutes = TaskTimes::whereUserId($finance->user_id)->whereTaskId($task->id)->sum('total') / 60;
        $sum = round($minutes * (float)$finance->bet, 2);

        $invoice = new Invoice();
        $invoice->user_id = $payer->user_id;
        $invoice->project_id = $task->project_id;
        $invoice->task_id = $task->id;
        $invoice->sum = $sum;
        $invoice->payed = 0;
        $invoice->save();
    }
}

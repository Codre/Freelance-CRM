<?php

namespace App\Services\ProjectFinances\Handlers;

use App\Models\ProjectFinance;
use App\Models\ProjectTask;
use App\Models\ProjectUser;
use App\Services\Finances\FinancesService;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PayByTask
 *
 * @package App\Services\ProjectFinances\Handlers
 */
class PayByTask
{

    /**
     * @var ProjectTask
     */
    private $task;
    /**
     * @var FinancesService
     */
    private $financesService;

    /**
     * PayByTask constructor.
     *
     * @param FinancesService $financesService
     */
    public function __construct(FinancesService $financesService)
    {
        $this->financesService = $financesService;
    }

    /**
     * @param ProjectTask $task
     */
    public function handle(ProjectTask $task)
    {
        if (!$task->times->count() || !$minutes = $task->times->sum('total')) {
            return;
        }

        $this->task = $task;

        $finances = $this->getFinances();

        if (!$finances->count()) {
            return;
        }

        $finances->with(['project', 'project.users']);

        $upData = $this->buildFinanceUpData($finances->get(), $minutes);

        foreach ($upData as $data) {
            $this->financesService->createFinance($data);
        }
    }

    /**
     * @return ProjectFinance|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    private function getFinances()
    {
        $finances = ProjectFinance::whereProjectId($this->task->project->id)
            ->whereTaskId($this->task->project->id);
        if (!$finances->count()) {
            $finances = ProjectFinance::whereProjectId($this->task->project->id)->whereNull('task_id');
        }

        return $finances;
    }

    /**
     * Подготовка данных для обновления финансов
     *
     * @param Collection $finances
     * @param int        $minutes
     *
     * @return array
     */
    private function buildFinanceUpData(Collection $finances, int $minutes): array
    {
        $return = [];

        $hours = $minutes / 60;

        /** @var ProjectFinance $finance */
        foreach ($finances as $finance) {
            if (round($finance->bet, 2) <= 0.00) {
                continue;
            }

            $group = $finance->project->users->find($finance->user_id)->pivot->group;

            $return[$finance->user_id] = [
                'user_id'   => $finance->user_id,
                'operation' => in_array($group, [ProjectUser::GROUP_CUSTOMER]) ? 0 : 1,
                'sum'       => round($finance->bet * $hours, 2),
                'comment'   => __('projects/finances.handlers.payByTask.comment', ['title' => $this->task->title]),
            ];
        }

        return $return;
    }
}

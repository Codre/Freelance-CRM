<?php

namespace App\Services\TaskTimes\Handlers;

use App\Models\TaskTimes;

/**
 * Class CalcTimeByTaskIds
 *
 * @package App\Services\TaskTimes\Handlers
 */
class CalcTimeByTaskIds
{

    /**
     * @param array $taskIds
     * @param bool  $forCurrentUser
     *
     * @return array
     */
    public function handle(array $taskIds, bool $forCurrentUser = false): array
    {
        $query = TaskTimes::whereIn('task_id', $taskIds);
        if ($forCurrentUser) {
            $query->where('user_id', '=', \Auth::id());
        }

        $times = $query->get();

        $return = [];

        foreach ($times as $time) {
            if (!isset($return[$time['task_id']])) {
                $return[$time['task_id']] = 0;
            }
            $return[$time['task_id']] += $time['total'];
        }

        foreach ($return as $taskId => $total) {
            $h = floor($total / 60);
            $m = $total - $h * 60;

            $return[$taskId] = [
                'total' => $total,
                'h'     => ($h < 10 ? '0' : '') . $h,
                'm'     => ($m < 10 ? '0' : '') . $m,
            ];
        }

        return $return;
    }
}

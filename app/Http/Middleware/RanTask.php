<?php

namespace App\Http\Middleware;

use App\Models\Group;
use App\Models\TaskTimes;
use Closure;

/**
 * Class RanTask
 * Подгружает информацию о выполняемом в данный момент таске в шаблон
 *
 * @package App\Http\Middleware
 */
class RanTask
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!\Auth::check() || !in_array(\Auth::user()->group_id, Group::STAFFS)) {
            return $next($request);
        }

        $runTask = TaskTimes::where('user_id', '=', \Auth::id())
            ->whereNull('ended')
            ->get()->first();

        view()->share([
            'runTask' => $runTask
        ]);

        return $next($request);
    }
}

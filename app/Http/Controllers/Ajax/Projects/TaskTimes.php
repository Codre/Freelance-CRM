<?php

namespace App\Http\Controllers\Ajax\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Services\TaskTimes\TaskTimesService;
use Illuminate\Http\Request;

class TaskTimes extends Controller
{
    /**
     * @var TaskTimesService
     */
    private $taskTimesService;

    /**
     * TaskComment constructor.
     *
     * @param TaskTimesService $taskTimesService
     */
    public function __construct(TaskTimesService $taskTimesService)
    {
        $this->taskTimesService = $taskTimesService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request               $request
     * @param Project               $project
     * @param ProjectTask           $task
     *
     * @param \App\Models\TaskTimes $time
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Project $project, ProjectTask $task, \App\Models\TaskTimes $time)
    {
        $this->authorize('projectTask.update', $task);


        $time = $this->taskTimesService->updateComment($time, $request->get('comment'));
        $time = $this->taskTimesService->updateTime($time, $request->get('time'));

        return response()->json(['status' => true, 'data' => $time]);
    }
}

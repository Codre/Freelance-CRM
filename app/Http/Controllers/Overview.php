<?php

namespace App\Http\Controllers;

use App\Models\ProjectTask;
use App\Services\Projects\ProjectsService;
use Illuminate\Support\Facades\Auth;

class Overview extends Controller
{
    /**
     * @var ProjectsService
     */
    private $projectsService;

    public function __construct(ProjectsService $projectsService)
    {
        $this->projectsService = $projectsService;
    }

    public function index()
    {
        $projects = $this->projectsService->searchProjects(10);
        $projects->load('tasks');

        $tasks = ProjectTask::whereIn('status', [ProjectTask::STATUS_PROCESS, ProjectTask::STATUS_PAUSE, ProjectTask::STATUS_NEW])
            ->whereIn('project_id', Auth::user()->projects()->get()->map->id)
            ->orderBy('updated_at', 'desc');

        $tasksCount = $tasks->count();

        return view('overview.index')->with([
            'title'      => __('overview/general.title'),
            'balance'    => Auth::user()->balance,
            // @todo ожидаемый доход
            'projects'   => $projects->items(),
            'tasks'      => $tasks->with(['project'])->limit(10)->get(),
            'tasksCount' => $tasksCount,
            'taskStatuses'   => ProjectTask::getStatuses(),
            'taskStatusColors'   => ProjectTask::getColors(),
        ]);
    }
}

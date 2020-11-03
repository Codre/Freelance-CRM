<?php

namespace App\Http\Controllers\Ajax\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Services\ProjectTasks\ProjectTasksService;
use Illuminate\Http\Request;

/**
 * Class ProjectTasks
 *
 * @package App\Http\Controllers\Ajax\Projects
 */
class ProjectTasks extends Controller
{
    /**
     * @var ProjectTasksService
     */
    private $projectTasksService;

    /**
     * ProjectTasks constructor.
     *
     * @param ProjectTasksService $projectTasksService
     */
    public function __construct(ProjectTasksService $projectTasksService)
    {
        $this->projectTasksService = $projectTasksService;
    }

    /**
     * @param Request     $request
     * @param Project     $project
     * @param ProjectTask $task
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function autoSave(Request $request, Project $project, ProjectTask $task)
    {
        $this->authorize('projectTask.update', $task);

        $task = $this->projectTasksService->update($task, ['description' => $request->get('description')]);

        return response()->json(['status' => true, 'data' => $task]);
    }
}

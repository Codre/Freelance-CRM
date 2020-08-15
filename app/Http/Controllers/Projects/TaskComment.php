<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Projects\Requests\StoreTaskCommentRequest;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Services\TaskComments\TaskCommentsService;

class TaskComment extends Controller
{

    /**
     * @var TaskCommentsService
     */
    private $taskCommentsService;

    /**
     * TaskComment constructor.
     *
     * @param TaskCommentsService $taskCommentsService
     */
    public function __construct(TaskCommentsService $taskCommentsService)
    {
        $this->taskCommentsService = $taskCommentsService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param StoreTaskCommentRequest $request
     * @param Project                 $project
     * @param ProjectTask             $task
     *
     * @return \Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreTaskCommentRequest $request, Project $project, ProjectTask $task)
    {
        $this->authorize('projectTask.view', $task);

        $this->taskCommentsService->create($task, $request->getFormData());

        return redirect(route('projects.tasks.show', ['project' => $project, 'task' => $task]));
    }
}

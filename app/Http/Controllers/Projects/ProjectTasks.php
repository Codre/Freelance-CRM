<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Projects\Requests\StoreProjectTaskRequest;
use App\Http\Controllers\Projects\Requests\UpdateProjectTaskRequest;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Services\ProjectTasks\ProjectTasksService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class ProjectTasks extends Controller
{

    /**
     * @var ProjectTasksService
     */
    private $projectTasksService;

    public function __construct(ProjectTasksService $projectTasksService)
    {
        $this->projectTasksService = $projectTasksService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Project $project
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create(Project $project)
    {
        $this->authorize('projectTask.create', $project);

        return view('projects.tasks.create')->with([
            'title'   => $project->name . " - " . __('projects/tasks.create.title'),
            'project' => $project,
            'back'    => route('projects.show', ['project' => $project]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectTaskRequest $request
     *
     * @param Project                 $project
     *
     * @return Redirector
     * @throws AuthorizationException
     */
    public function store(StoreProjectTaskRequest $request, Project $project)
    {
        $this->authorize('projectTask.create', $project);

        $task = $this->projectTasksService->create($project, $request->getFormData());

        return redirect(route('projects.tasks.show', ['project' => $project, 'task' => $task]));
    }

    /**
     * Display the specified resource.
     *
     * @param Project     $project
     * @param ProjectTask $task
     *
     * @return View
     * @throws AuthorizationException
     */
    public function show(Project $project, ProjectTask $task)
    {
        $this->authorize('projectTask.view', $task);

        $comments = $task->comments()->orderBy('created_at', 'desc')->with(['user'])->get();

        return view('projects.tasks.show')->with([
            'title'   => $project->name . " - " . $task->title,
            'project' => $project,
            'comments' => $comments,
            'task'    => $task,
            'back'    => route('projects.show', ['project' => $project]),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Project     $project
     * @param ProjectTask $task
     *
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Project $project, ProjectTask $task)
    {
        $this->authorize('projectTask.update', $task);

        return view('projects.tasks.edit')->with([
            'title'   => $project->name . " - " . __('projects/tasks.edit.title'),
            'project' => $project,
            'task'    => $task,
            'back'    => route('projects.tasks.show', ['project' => $project, 'task' => $task]),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectTaskRequest $request
     * @param Project                  $project
     * @param ProjectTask              $task
     *
     * @return Redirector
     * @throws AuthorizationException
     */
    public function update(UpdateProjectTaskRequest $request, Project $project, ProjectTask $task)
    {
        $this->authorize('projectTask.update', $task);

        $task = $this->projectTasksService->update($task, $request->getFormData());

        return redirect(route('projects.tasks.show', ['project' => $project, 'task' => $task]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project     $project
     * @param ProjectTask $task
     *
     * @return Redirector
     * @throws AuthorizationException
     */
    public function destroy(Project $project, ProjectTask $task)
    {
        $this->authorize('projectTask.delete', $task);

        $this->projectTasksService->delete($task);

        return redirect(route('projects.show', ['project' => $project]));
    }
}

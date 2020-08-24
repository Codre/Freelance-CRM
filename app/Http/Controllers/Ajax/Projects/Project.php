<?php

namespace App\Http\Controllers\Ajax\Projects;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Projects\Requests\UpdateProjectRequest;
use App\Services\Projects\ProjectsService;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * Class Project
 *
 * @package App\Http\Controllers\Ajax\Projects
 */
class Project extends Controller
{
    /**
     * @var ProjectsService
     */
    private $projectsService;

    /**
     * Project constructor.
     *
     * @param ProjectsService $projectsService
     */
    public function __construct(ProjectsService $projectsService)
    {
        $this->projectsService = $projectsService;
    }

    /**
     * @param \App\Models\Project $project
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(\App\Models\Project $project)
    {
        return response()->json($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectRequest $request
     * @param int                  $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateProjectRequest $request, $id)
    {
        $project = $this->projectsService->findProject($id);

        if (!$project) {
            abort(404);
        }

        $this->authorize('project.update', $project);

        $project = $this->projectsService->updateProject($project, $request->getFormData());

        return response()->json(['status' => true, 'data' => $project]);
    }
}

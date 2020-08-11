<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Projects\Requests\StoreProjectRequest;
use App\Http\Controllers\Projects\Requests\StoreProjectUserRequest;
use App\Http\Controllers\Projects\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Services\Projects\ProjectsService;
use App\Services\Projects\ProjectUsersService;

class ProjectMembers extends Controller
{

    /**
     * @var ProjectsService
     */
    private $projectsService;
    /**
     * @var ProjectUsersService
     */
    private $projectUsersService;

    public function __construct(ProjectsService $projectsService, ProjectUsersService $projectUsersService)
    {
        $this->projectsService = $projectsService;
        $this->projectUsersService = $projectUsersService;
    }

    /**
     * Можно ли редактировать участникков
     *
     * @param Project $project
     *
     * @return bool
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    private function checkEditPolicy(Project $project): bool
    {
        $this->authorize('project.view', $project);
        $canEdit = ProjectUser::canEdit($project);

        if (!$canEdit) {
            abort(401);
        }

        return true;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Project $project
     *
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Project $project)
    {
        $this->authorize('project.view', $project);

        $list = $project->users;

        return view('projects.members.index')->with([
            'list'   => $list,
            'title'  => $project->name . " - " . __("projects/members.index.title"),
            'groups' => ProjectUser::getGroups(),
            'canEdit' => ProjectUser::canEdit($project),
            'project' => $project
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Project $project
     *
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Project $project)
    {
        $this->checkEditPolicy($project);

        $availableForAdding = $this->projectUsersService->getAvailableForAdding($project);
        $availableForAdding = $availableForAdding->keyBy('id')->map(function ($item) {
            return $item['name'] . " [".$item['email']."]";
        });

        return view('projects.members.create')->with([
            'title'  => $project->name . " - " . __("projects/members.create.title"),
            'canEdit' => true,
            'project' => $project,
            'availableForAdding' => $availableForAdding,
            'groups' => ProjectUser::getGroups()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Project                 $project
     * @param StoreProjectUserRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Project $project, StoreProjectUserRequest $request)
    {
        $this->checkEditPolicy($project);

        $this->projectUsersService->storeMember($project, $request->getFormData());

        return redirect(route('projects.members.index', ['project' => $project->id]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(int $id)
    {
        // @todo
        return;
        $project = $this->projectsService->findProject($id);

        if (!$project) {
            abort(404);
        }

        $this->authorize('project.update', $project);

        return view('projects.edit')->with([
            'project' => $project,
            'title'   => __("projects/edit.title"),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectRequest $request
     * @param int                  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateProjectRequest $request, $id)
    {
        // @todo
        return;
        $project = $this->projectsService->findProject($id);

        if (!$project) {
            abort(404);
        }

        $this->authorize('project.update', $project);

        $this->projectsService->updateProject($project, $request->getFormData());

        return redirect(route('projects.show', ['project' => $project->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        // @todo
        return;
        $project = $this->projectsService->findProject($id);

        if (!$project) {
            abort(404);
        }

        $this->authorize('project.delete', $project);

        $this->projectsService->deleteProject($project);

        return redirect(route('projects.index'));
    }
}

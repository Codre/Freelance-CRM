<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Projects\Requests\StoreProjectUserRequest;
use App\Http\Controllers\Projects\Requests\UpdateProjectUserRequest;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use App\Services\Projects\ProjectUsersService;

class ProjectMembers extends Controller
{

    /**
     * @var ProjectUsersService
     */
    private $projectUsersService;

    public function __construct(ProjectUsersService $projectUsersService)
    {
        $this->projectUsersService = $projectUsersService;
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
            'list'    => $list,
            'title'   => $project->name . " - " . __("projects/members.index.title"),
            'groups'  => ProjectUser::getGroups(),
            'canEdit' => ProjectUser::canEdit($project),
            'project' => $project,
            'back'    => route('projects.index'),
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
            return $item['name'] . " [" . $item['email'] . "] | " . $item->group->name;
        });

        return view('projects.members.create')->with([
            'title'              => $project->name . " - " . __("projects/members.create.title"),
            'project'            => $project,
            'availableForAdding' => $availableForAdding,
            'groups'             => ProjectUser::getGroups(),
            'back'               => route('projects.members.index', ['project' => $project]),
        ]);
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
     * @param Project $project
     * @param User    $member
     *
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Project $project, User $member)
    {
        $this->checkEditPolicy($project);

        return view('projects.members.edit')->with([
            'title'   => $project->name . " - " . __("projects/members.edit.title"),
            'project' => $project,
            'member'  => $member,
            'groups'  => ProjectUser::getGroups(),
            'back'    => route('projects.members.index', ['project' => $project]),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectUserRequest $request
     * @param Project                  $project
     * @param User                     $member
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateProjectUserRequest $request, Project $project, User $member)
    {
        $this->checkEditPolicy($project);

        $this->projectUsersService->updateMember($project, $member, $request->getFormData());

        return redirect(route('projects.members.index', ['project' => $project->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @param User    $member
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Project $project, User $member)
    {
        $this->checkEditPolicy($project);

        $this->projectUsersService->deleteMember($project, $member);

        return redirect(route('projects.members.index', ['project' => $project->id]));
    }
}

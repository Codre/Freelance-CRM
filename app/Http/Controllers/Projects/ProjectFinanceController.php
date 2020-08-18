<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectFinance;
use App\Models\ProjectTask;
use App\Models\ProjectUser;
use App\Services\ProjectFinances\ProjectFinancesService;
use Illuminate\Http\Request;

/**
 * Class ProjectFinanceController
 *
 * @package App\Http\Controllers\Projects
 */
class ProjectFinanceController extends Controller
{
    /**
     * @var ProjectFinancesService
     */
    private $financesService;

    /**
     * ProjectFinanceController constructor.
     *
     * @param ProjectFinancesService $financesService
     */
    public function __construct(ProjectFinancesService $financesService)
    {
        $this->financesService = $financesService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Project          $project
     * @param ProjectTask|null $task
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Project $project, ?ProjectTask $task)
    {
        $this->authorize('projectFinance.create', [$project, $task]);

        $list = $this->financesService->getProjectData($project, $task);
        $projectList = null;
        $members = $project->users;

        if ($task->id) {
            $projectList = $this->financesService->getProjectData($project, null);
        }

        return view('projects.finances.create', [
            'list'    => $list,
            'projectList'    => $projectList,
            'project' => $project,
            'task'    => $task,
            'groups'  => ProjectUser::getGroups(),
            'members' => $members,
            'title'   => $project->name . ' - ' . __('projects/finances.create.title'),
            'back' => $task->id
                ? route('projects.tasks.show', ['project' => $project, 'task' => $task])
                : route('projects.show', ['project' => $project])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Project                  $project
     * @param ProjectTask|null         $task
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Project $project, ?ProjectTask $task)
    {
        $this->authorize('projectFinance.create', [$project, $task]);

        $this->financesService->save($request->get('bet'), $project, $task);

        if ($task->id) {
            return redirect(route('projects.tasks.show', ['project' => $project, 'task' => $task]));
        } else {
            return redirect(route('projects.show', ['project' => $project]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ProjectFinance $projectFinance
     * @param Project                    $project
     * @param ProjectTask                $task
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(ProjectFinance $projectFinance, Project $project, ProjectTask $task)
    {
        $this->authorize('projectFinance.delete', [$project, $task]);

        $this->financesService->delete($projectFinance);

        if ($task->id) {
            return redirect(route('projects.tasks.show', ['project' => $project, 'task' => $task]));
        } else {
            return redirect(route('projects.show', ['project' => $project]));
        }
    }
}

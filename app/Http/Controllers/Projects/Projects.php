<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Projects\Requests\StoreProjectRequest;
use App\Http\Controllers\Projects\Requests\UpdateProjectRequest;
use App\Models\ProjectTask;
use App\Services\ProjectFinances\ProjectFinancesService;
use App\Services\Projects\ProjectsService;
use App\Services\TaskTimes\TaskTimesService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class Projects extends Controller
{

    /**
     * @var ProjectsService
     */
    private $projectsService;
    /**
     * @var TaskTimesService
     */
    private $taskTimesService;
    /**
     * @var ProjectFinancesService
     */
    private $projectFinancesService;

    /**
     * Projects constructor.
     *
     * @param ProjectsService        $projectsService
     * @param TaskTimesService       $taskTimesService
     * @param ProjectFinancesService $projectFinancesService
     */
    public function __construct(
        ProjectsService $projectsService,
        TaskTimesService $taskTimesService,
        ProjectFinancesService $projectFinancesService
    ) {
        $this->projectsService = $projectsService;
        $this->taskTimesService = $taskTimesService;
        $this->projectFinancesService = $projectFinancesService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('project.viewAny');

        $list = $this->projectsService->searchProjects();

        return view('projects.index')->with([
            'list'  => $list,
            'title' => __("projects/general.title"),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectRequest $request
     *
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function store(StoreProjectRequest $request)
    {
        $this->authorize('project.create');

        $project = $this->projectsService->storeProject($request->getFormData());

        return redirect(route('projects.show', ['project' => $project->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return View
     * @throws AuthorizationException
     */
    public function show(int $id)
    {
        $project = $this->projectsService->findProject($id);

        if (!$project) {
            abort(404);
        }

        $this->authorize('project.view', $project);

        $tasks = $project->tasks()
            ->with(['user', 'project'])
            ->orderBy('creaed_at', 'desc')
            ->paginate(20);

        $taskIds = array_column($tasks->items(), 'id');

        $times = $this->taskTimesService->calcTimeByTaskIds($taskIds);
        $finances = $this->projectFinancesService->calcFinanceByTaskIdsForCurrentUser($project, $taskIds);

        return view('projects.show')->with([
            'project'  => $project,
            'title'    => $project->name,
            'statuses' => ProjectTask::getStatuses(),
            'tasks'    => $tasks,
            'finances' => $finances,
            'times'    => $times,
            'back'     => route('projects.index'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function destroy($id)
    {
        $project = $this->projectsService->findProject($id);

        if (!$project) {
            abort(404);
        }

        $this->authorize('project.delete', $project);

        $this->projectsService->deleteProject($project);

        return redirect(route('projects.index'));
    }
}

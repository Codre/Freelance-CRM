<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\TaskFile;
use App\Services\TaskFiles\TaskFilesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskFiles extends Controller
{
    /**
     * @var TaskFilesService
     */
    private $service;

    /**
     * TaskFiles constructor.
     *
     * @param TaskFilesService $service
     */
    public function __construct(TaskFilesService $service)
    {
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project, ProjectTask $task)
    {
        $this->authorize('taskFile.create', $project);

        // @todo save
    }

    /**
     * Display the specified resource.
     *
     * @param Project     $project
     * @param ProjectTask $task
     * @param TaskFile    $file
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Project $project, ProjectTask $task, TaskFile $file)
    {
        $this->authorize('taskFile.view', $file);

        return Storage::download(TaskFile::FILE_PATH . $file->file);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project     $project
     * @param ProjectTask $task
     * @param TaskFile    $file
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Project $project, ProjectTask $task, TaskFile $file)
    {
        $this->authorize('taskFile.delete', $file);

        $this->service->deleteFile($file);

        return redirect(route('projects.tasks.show', ['project' => $project, 'task' => $task]));
    }
}

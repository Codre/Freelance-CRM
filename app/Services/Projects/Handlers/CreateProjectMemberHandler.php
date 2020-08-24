<?php

namespace App\Services\Projects\Handlers;

use App\Jobs\Queue;
use App\Mail\ProjectMembers\CreatedMail;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use App\Services\Projects\Repositories\ProjectsRepositoryInterface;
use Illuminate\Support\Facades\Mail;

class CreateProjectMemberHandler
{
    /**
     * @var ProjectsRepositoryInterface
     */
    private $projectRepository;

    public function __construct(
        ProjectsRepositoryInterface $projectRepository
    ) {
        $this->projectRepository = $projectRepository;
    }


    public function handle(Project $project, array $data): ProjectUser
    {
        $data['project_id'] = $project->id;

        $projectUser = $this->projectRepository->createMemberFromArray($project, $data);

        $user = User::find($projectUser->user_id);

        Mail::to($user)->queue(
            (new CreatedMail($project, $user, \Auth::user()))->onQueue(Queue::EMAILS)
        );

        return $projectUser;
    }
}

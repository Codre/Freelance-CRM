<?php


namespace App\Services\Projects\Handlers;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Services\Projects\Repositories\ProjectsRepositoryInterface;
use Carbon\Carbon;

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

        return $this->projectRepository->createMemberFromArray($project, $data);
    }
}

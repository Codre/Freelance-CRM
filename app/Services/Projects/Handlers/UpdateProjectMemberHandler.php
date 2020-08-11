<?php

namespace App\Services\Projects\Handlers;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use App\Services\Projects\Repositories\ProjectsRepositoryInterface;

class UpdateProjectMemberHandler
{
    /**
     * @var ProjectsRepositoryInterface
     */
    private $projectRepository;

    public function __construct(
        ProjectsRepositoryInterface $projectRepository
    )
    {
        $this->projectRepository = $projectRepository;
    }


    public function handle(Project $project, User $user, array $data): ProjectUser
    {

        return $this->projectRepository->updateMemberFromArray($project, $user, [
            'group' => $data['group'] ?? 0,
        ]);
    }
}

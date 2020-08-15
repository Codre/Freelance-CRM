<?php

namespace App\Services\Projects;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use App\Services\Projects\Handlers\CreateProjectMemberHandler;
use App\Services\Projects\Handlers\UpdateProjectMemberHandler;
use App\Services\Projects\Repositories\ProjectsRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProjectUsersService
{

    /**
     * @var ProjectsRepositoryInterface
     */
    private $projectsRepository;
    /**
     * @var CreateProjectMemberHandler
     */
    private $createProjectMemberHandler;
    /**
     * @var UpdateProjectMemberHandler
     */
    private $updateProjectMemberHandler;

    public function __construct(
        ProjectsRepositoryInterface $projectsRepository,
        CreateProjectMemberHandler $createProjectMemberHandler,
        UpdateProjectMemberHandler $updateProjectMemberHandler
    ) {

        $this->projectsRepository = $projectsRepository;
        $this->createProjectMemberHandler = $createProjectMemberHandler;
        $this->updateProjectMemberHandler = $updateProjectMemberHandler;
    }

    public function getAvailableForAdding(Project $project): Collection
    {
        return $this->projectsRepository->getAvailableForAddingUsers($project);
    }

    public function storeMember(Project $project, array $data): ProjectUser
    {
        return $this->createProjectMemberHandler->handle($project, $data);
    }

    public function updateMember(Project $project, User $user, array $data): ProjectUser
    {
        return $this->updateProjectMemberHandler->handle($project, $user, $data);
    }

    public function deleteMember(Project $project, User $user): ?bool
    {
        return $this->projectsRepository->deleteMember($project, $user);
    }
}

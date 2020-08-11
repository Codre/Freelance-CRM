<?php


namespace App\Services\Projects;

use App\Models\Project;
use App\Services\Projects\Handlers\CreateProjectMemberHandler;
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

    public function __construct(
        ProjectsRepositoryInterface $projectsRepository,
        CreateProjectMemberHandler $createProjectMemberHandler
    ) {

        $this->projectsRepository = $projectsRepository;
        $this->createProjectMemberHandler = $createProjectMemberHandler;
    }

    public function getAvailableForAdding(Project $project): Collection
    {
        return $this->projectsRepository->getAvailableForAddingUsers($project);
    }

    public function storeMember(Project $project, array $data)
    {
        $this->createProjectMemberHandler->handle($project, $data);
    }
}

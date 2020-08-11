<?php


namespace App\Services\Projects\Handlers;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Services\Projects\Repositories\ProjectsRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CreateProjectHandler
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


    public function handle(array $data): Project
    {
        $data['created_at'] = Carbon::create()->subDay();

        $project = $this->projectRepository->createFromArray($data);

        Auth::user()->projects()->attach($project->id, ['group' => ProjectUser::GROUP_MANAGER]);

        return $project;
    }
}

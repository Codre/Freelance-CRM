<?php

namespace App\Services\Projects\Repositories;

use App\Builders\QueryBuilder;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class EloquentProjectsRepository implements ProjectsRepositoryInterface
{

    public function find(int $id)
    {
        return Project::whereId($id)->first();
    }

    public function search(int $limit = 20)
    {
        return Project::whereHas('users', function (Builder $query) {
            $query->where('user_id', '=', Auth::user()->id);
        })->with(['users'])->paginate($limit);
    }

    public function getBy(QueryBuilder $builder): Collection
    {
        $builder = $builder->build(Project::query());

        return $builder->get();
    }

    public function createFromArray(array $data): Project
    {
        return (new Project())->create($data);
    }

    public function updateFromArray(Project $project, array $data)
    {
        $project->update($data);

        return $project;
    }

    public function delete(Project $project): ?bool
    {
        return $project->delete();
    }

    public function getAvailableForAddingUsers(Project $project): Collection
    {
        return User::whereNotIn('id', $project->users->map->id->toArray())->get();
    }

    public function createMemberFromArray(Project $project, array $data): ProjectUser
    {
        return (new ProjectUser)->create($data);
    }

    public function updateMemberFromArray(Project $project, User $user, array $data): ProjectUser
    {
        $projectUser = ProjectUser::whereProjectId($project->id)->whereUserId($user->id);

        $projectUser->update($data);

        return $projectUser->first();
    }

    public function deleteMember(Project $project, User $user): ?bool
    {
        return (bool)$project->users()->detach($user->id);
    }
}

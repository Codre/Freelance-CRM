<?php


namespace App\Services\Projects\Repositories;

use App\Builders\QueryBuilder;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface ProjectsRepositoryInterface
{
    public function find(int $id);

    public function search(int $limit = 20);

    public function getBy(QueryBuilder $builder): Collection;

    public function createFromArray(array $data): Project;

    public function updateFromArray(Project $project, array $data);

    public function delete(Project $project): ?bool;

    public function getAvailableForAddingUsers(Project $project): Collection;

    public function createMemberFromArray(Project $project, array $data): ProjectUser;

    public function updateMemberFromArray(Project $project, User $user, array $data): ProjectUser;

    public function deleteMember(Project $project, User $user): ?bool;
}

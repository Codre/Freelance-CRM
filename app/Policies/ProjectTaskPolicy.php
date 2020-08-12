<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectTaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User    $user
     * @param Project $project
     *
     * @return mixed
     */
    public function viewAny(User $user, Project $project)
    {
        return (bool)$project->users->find($user->id);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User        $user
     * @param ProjectTask $projectTask
     *
     * @return mixed
     */
    public function view(User $user, ProjectTask $projectTask)
    {
        return (bool)$projectTask->project->users->find($user->id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User    $user
     * @param Project $project
     *
     * @return mixed
     */
    public function create(User $user, Project $project)
    {
        return in_array($project->users->find($user->id)->pivot->group, ProjectUser::CAN_CREATE_TASKS);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User        $user
     * @param ProjectTask $projectTask
     *
     * @return mixed
     */
    public function update(User $user, ProjectTask $projectTask)
    {
        return in_array($projectTask->project->users->find($user->id)->pivot->group, ProjectUser::CAN_CREATE_TASKS);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User        $user
     * @param ProjectTask $projectTask
     *
     * @return mixed
     */
    public function delete(User $user, ProjectTask $projectTask)
    {
        return $projectTask->status === ProjectTask::STATUS_NEW
            && $projectTask->project->users->find($user->id)->pivot->group === ProjectUser::GROUP_MANAGER;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User        $user
     * @param ProjectTask $projectTask
     *
     * @return mixed
     */
    public function restore(User $user, ProjectTask $projectTask)
    {
        return $user->group_id == Group::STAFF_ADMIN;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User        $user
     * @param ProjectTask $projectTask
     *
     * @return mixed
     */
    public function forceDelete(User $user, ProjectTask $projectTask)
    {
        return $user->group_id == Group::STAFF_ADMIN;
    }
}
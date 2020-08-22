<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\TaskFile;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskFilePolicy
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
     * @param User     $user
     * @param TaskFile $taskFile
     *
     * @return mixed
     */
    public function view(User $user, TaskFile $taskFile)
    {
        return (bool)$taskFile->task->project->users->find($user->id);
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
     * @param User     $user
     * @param TaskFile $taskFile
     *
     * @return mixed
     */
    public function update(User $user, TaskFile $taskFile)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User     $user
     * @param TaskFile $taskFile
     *
     * @return mixed
     */
    public function delete(User $user, TaskFile $taskFile)
    {
        return $taskFile->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User     $user
     * @param TaskFile $taskFile
     *
     * @return mixed
     */
    public function restore(User $user, TaskFile $taskFile)
    {
        return $user->group_id == Group::STAFF_ADMIN;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User     $user
     * @param TaskFile $taskFile
     *
     * @return mixed
     */
    public function forceDelete(User $user, TaskFile $taskFile)
    {
        return $user->group_id == Group::STAFF_ADMIN;
    }
}

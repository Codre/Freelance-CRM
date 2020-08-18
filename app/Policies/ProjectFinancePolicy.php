<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\Project;
use App\Models\ProjectFinance;
use App\Models\ProjectTask;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectFinancePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User             $user
     * @param Project          $project
     *
     * @param ProjectTask|null $task
     *
     * @return mixed
     */
    public function viewAny(User $user, Project $project, ?ProjectTask $task = null)
    {
        $group = $project->users->find($user->id)->pivot->group;

        if (!in_array($group, [ProjectUser::GROUP_MANAGER])) {
            return false;
        }

        if ($task && $task->id && in_array($task->status, [ProjectTask::STATUS_READY, ProjectTask::STATUS_FINISHED])) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User             $user
     * @param ProjectFinance   $projectFinance
     * @param ProjectTask|null $task
     *
     * @return mixed
     */
    public function view(User $user, ProjectFinance $projectFinance, ?ProjectTask $task = null)
    {
        $group = $projectFinance->project->users->find($user->id)->pivot->group;

        if (!in_array($group, [ProjectUser::GROUP_MANAGER])) {
            return false;
        }

        if ($task && $task->id && in_array($task->status, [ProjectTask::STATUS_READY, ProjectTask::STATUS_FINISHED])) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User             $user
     * @param Project          $project
     *
     * @param ProjectTask|null $task
     *
     * @return mixed
     */
    public function create(User $user, Project $project, ?ProjectTask $task = null)
    {
        $group = $project->users->find($user->id)->pivot->group;

        if (!in_array($group, [ProjectUser::GROUP_MANAGER])) {
            return false;
        }

        if ($task && $task->id && in_array($task->status, [ProjectTask::STATUS_READY, ProjectTask::STATUS_FINISHED])) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User             $user
     * @param ProjectFinance   $projectFinance
     * @param ProjectTask|null $task
     *
     * @return mixed
     */
    public function update(User $user, ProjectFinance $projectFinance, ?ProjectTask $task = null)
    {
        $group = $projectFinance->project->users->find($user->id)->pivot->group;

        if (!in_array($group, [ProjectUser::GROUP_MANAGER])) {
            return false;
        }

        if ($task && $task->id && in_array($task->status, [ProjectTask::STATUS_READY, ProjectTask::STATUS_FINISHED])) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User             $user
     * @param ProjectFinance   $projectFinance
     * @param ProjectTask|null $task
     *
     * @return mixed
     */
    public function delete(User $user, ProjectFinance $projectFinance, ?ProjectTask $task = null)
    {
        $group = $projectFinance->project->users->find($user->id)->pivot->group;

        if (!in_array($group, [ProjectUser::GROUP_MANAGER])) {
            return false;
        }

        if ($task && $task->id && in_array($task->status, [ProjectTask::STATUS_READY, ProjectTask::STATUS_FINISHED])) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User           $user
     * @param ProjectFinance $projectFinance
     *
     * @return mixed
     */
    public function restore(User $user, ProjectFinance $projectFinance)
    {
        return $user->group_id == Group::STAFF_ADMIN;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User           $user
     * @param ProjectFinance $projectFinance
     *
     * @return mixed
     */
    public function forceDelete(User $user, ProjectFinance $projectFinance)
    {
        return $user->group_id == Group::STAFF_ADMIN;
    }
}

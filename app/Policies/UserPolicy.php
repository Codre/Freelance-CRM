<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Может ли пополнять баланс
     *
     * @param User $user
     *
     * @return bool
     */
    public function pay(User $user): bool
    {
        return in_array($user->group_id, Group::CLIENTS);
    }
}

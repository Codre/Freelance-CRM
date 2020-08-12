<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\ProjectUser
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectUser newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProjectUser onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectUser query()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProjectUser withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProjectUser withoutTrashed()
 * @mixin \Eloquent
 * @property int                             $id
 * @property int                             $user_id
 * @property int                             $project_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectUser whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectUser whereUserId($value)
 * @property int $group
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectUser whereGroup($value)
 */
class ProjectUser extends Pivot
{
    use SoftDeletes, Rememberable;

    /** @var int Группа наблюдатель */
    const GROUP_OBSERVER = 0;
    /** @var int Группа заказчик */
    const GROUP_CUSTOMER = 1;
    /** @var int Группа менеджер */
    const GROUP_MANAGER = 2;
    /** @var int Группа исполнитель */
    const GROUP_EXECUTOR = 3;

    /** @var int[] Кто может создавать таски */
    const CAN_CREATE_TASKS = [
        self::GROUP_MANAGER, self::GROUP_EXECUTOR, self::GROUP_CUSTOMER
    ];

    /**
     * Получить список имён групп
     *
     * @return array
     */
    public static function getGroups()
    {
        return [
            self::GROUP_OBSERVER => __('projects/members.groups.' . self::GROUP_OBSERVER),
            self::GROUP_CUSTOMER => __('projects/members.groups.' . self::GROUP_CUSTOMER),
            self::GROUP_MANAGER  => __('projects/members.groups.' . self::GROUP_MANAGER),
            self::GROUP_EXECUTOR => __('projects/members.groups.' . self::GROUP_EXECUTOR),
        ];
    }

    /**
     * Может ли управлять участниками проекта
     *
     * @param Project $project
     *
     * @return bool
     */
    public static function canEdit(Project $project)
    {
        return in_array(self::getCurrentUserGroup($project), [
            self::GROUP_MANAGER,
        ]);
    }

    /**
     * Получить текущую группу пользователя по проекту
     *
     * @param Project $project
     *
     * @return mixed
     */
    public static function getCurrentUserGroup(Project $project)
    {
        return $project->users->find(Auth::user()->id)->pivot->group;
    }
}

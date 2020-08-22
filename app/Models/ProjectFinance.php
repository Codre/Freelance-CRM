<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ProjectFinance
 *
 * @property int $id
 * @property int $user_id
 * @property int $project_id
 * @property int|null $task_id
 * @property string $bet
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectFinance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectFinance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectFinance query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectFinance whereBet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectFinance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectFinance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectFinance whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectFinance whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectFinance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectFinance whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\ProjectTask|null $task
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|ProjectFinance onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProjectFinance withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProjectFinance withoutTrashed()
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectFinance whereDeletedAt($value)
 */
class ProjectFinance extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'project_id', 'task_id', 'bet'];

    /**
     * Получить проект
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Получить пользователя
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить задачу
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(ProjectTask::class, 'task_id');
    }


}

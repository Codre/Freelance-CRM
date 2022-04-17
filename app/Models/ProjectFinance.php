<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProjectFinance
 *
 * @property int $id
 * @property int $user_id
 * @property int $project_id
 * @property int|null $task_id
 * @property string $bet
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ProjectFinance newModelQuery()
 * @method static Builder|ProjectFinance newQuery()
 * @method static Builder|ProjectFinance query()
 * @method static Builder|ProjectFinance whereBet($value)
 * @method static Builder|ProjectFinance whereCreatedAt($value)
 * @method static Builder|ProjectFinance whereId($value)
 * @method static Builder|ProjectFinance whereProjectId($value)
 * @method static Builder|ProjectFinance whereTaskId($value)
 * @method static Builder|ProjectFinance whereUpdatedAt($value)
 * @method static Builder|ProjectFinance whereUserId($value)
 * @mixin Eloquent
 * @property-read Project          $project
 * @property-read ProjectTask|null $task
 * @property-read User             $user
 * @method static \Illuminate\Database\Query\Builder|ProjectFinance onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProjectFinance withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProjectFinance withoutTrashed()
 * @property Carbon|null           $deleted_at
 * @method static Builder|ProjectFinance whereDeletedAt($value)
 */
final class ProjectFinance extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'project_id', 'task_id', 'bet'];

    /**
     * Получить проект
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Получить пользователя
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить задачу
     * @return BelongsTo
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(ProjectTask::class, 'task_id');
    }


}

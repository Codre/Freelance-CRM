<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\TaskTimes
 *
 * @property int $id
 * @property int $task_id
 * @property int $user_id
 * @property string $started
 * @property int $total
 * @property string $ended
 * @property string $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\ProjectTask $task
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTimes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTimes newQuery()
 * @method static \Illuminate\Database\Query\Builder|TaskTimes onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTimes query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTimes whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTimes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTimes whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTimes whereEnded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTimes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTimes whereStarted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTimes whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTimes whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTimes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTimes whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|TaskTimes withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TaskTimes withoutTrashed()
 * @mixin \Eloquent
 */
class TaskTimes extends Model
{
    use SoftDeletes;

    protected $fillable = ['task_id', 'user_id', 'started', 'total', 'ended', 'comment'];

    protected $dates = [
        'created_at', 'updated_at', 'stared', 'ended'
    ];

    /**
     * Получить задачу к которой прикреплён файл
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(ProjectTask::class);
    }

    /**
     * Получить пользователя добавешего файл
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

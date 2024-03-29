<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ProjectTask
 *
 * @property int $id
 * @property int $project_id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectTask newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectTask newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProjectTask onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectTask query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectTask whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectTask whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectTask whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectTask whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectTask whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectTask whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectTask whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectTask whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProjectTask withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProjectTask withoutTrashed()
 * @mixin \Eloquent
 * @property string $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectTask whereStatus($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TaskComment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TaskTimes[] $times
 * @property-read int|null $times_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TaskFile[] $files
 * @property-read int|null $files_count
 */
class ProjectTask extends Model
{
    use SoftDeletes;

    const STATUS_NEW = 'new';
    const STATUS_PROCESS = 'process';
    const STATUS_PAUSE = 'pause';
    const STATUS_READY = 'ready';
    const STATUS_FINISHED = 'finished';

    protected $fillable = ['title', 'description', 'project_id', 'user_id', 'status'];

    /**
     * Получить список имён статусов
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_NEW      => __('projects/tasks.status_' . self::STATUS_NEW),
            self::STATUS_PROCESS  => __('projects/tasks.status_' . self::STATUS_PROCESS),
            self::STATUS_PAUSE    => __('projects/tasks.status_' . self::STATUS_PAUSE),
            self::STATUS_READY    => __('projects/tasks.status_' . self::STATUS_READY),
            self::STATUS_FINISHED => __('projects/tasks.status_' . self::STATUS_FINISHED),
        ];
    }

    /**
     * Получить список типов цветов статусов
     * @return array
     */
    public static function getColors()
    {
        return [
            self::STATUS_NEW      => 'info',
            self::STATUS_PROCESS  => 'primary',
            self::STATUS_PAUSE    => 'warning',
            self::STATUS_READY    => 'success',
            self::STATUS_FINISHED => 'secondary',
        ];
    }

    /**
     * Получить проект задачи
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Получить пользователя задачи
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить комментарии задачи
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function comments()
    {
        return $this->hasMany(TaskComment::class, 'task_id');
    }

    /**
     * Получить время таска
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function times()
    {
        return $this->hasMany(TaskTimes::class, 'task_id');
    }

    /**
     * Получить файлы
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany(TaskFile::class, 'task_id');
    }
}

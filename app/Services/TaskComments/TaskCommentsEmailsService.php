<?php

namespace App\Services\TaskComments;

use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\TaskComment;
use App\Models\User;
use App\Services\TaskComments\Handlers\SendCreatedEmail;

/**
 * Class TaskCommentsEmailsService
 *
 * @package App\Services\TaskComments
 */
class TaskCommentsEmailsService
{
    /**
     * @var SendCreatedEmail
     */
    private $sendCreatedEmail;


    /**
     * TaskCommentsEmailsService constructor.
     *
     * @param SendCreatedEmail $sendCreatedEmail
     */
    public function __construct(
        SendCreatedEmail $sendCreatedEmail
    ) {
        $this->sendCreatedEmail = $sendCreatedEmail;
    }

    /**
     * Отправить уведомление о новом комментарии
     *
     * @param TaskComment $comment
     * @param User        $who
     */
    public function createComment(TaskComment $comment, User $who)
    {
        foreach ($this->getSenders($comment, $who)->get() as $user) {
            $this->sendCreatedEmail->handle($comment, $user, $who);
        }
    }

    /**
     * Список получателей
     *
     * @param TaskComment $comment
     * @param User        $who
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    private function getSenders(TaskComment $comment, User $who)
    {
        return $comment->task->project->users()->whereNotIn('user_id', [$who->id]);
    }
}

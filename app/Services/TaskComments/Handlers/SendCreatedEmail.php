<?php

namespace App\Services\TaskComments\Handlers;

use App\Jobs\Queue;
use App\Mail\ProjectTasks\CommentCreatedMail;
use App\Models\TaskComment;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

/**
 * Class SendCreatedEmail
 *
 * Отправка e-mail уведомления о новом комментарии
 *
 * @package App\Services\ProjectTasks\Handlers
 */
class SendCreatedEmail
{

    /**
     * @param TaskComment $comment
     * @param User        $user
     * @param User        $who
     */
    public function handle(TaskComment $comment, User $user, User $who)
    {
        Mail::to($user)->queue(
            (new CommentCreatedMail($comment, $user, $who))->onQueue(Queue::EMAILS)
        );
    }

}

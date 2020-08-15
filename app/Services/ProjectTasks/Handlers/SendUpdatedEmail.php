<?php

namespace App\Services\ProjectTasks\Handlers;

use App\Jobs\Queue;
use App\Mail\ProjectTasks\UpdatedMail;
use App\Models\ProjectTask;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

/**
 * Class SendUpdatedEmail
 *
 * Отправка e-mail уведомления о обновление таска
 *
 * @package App\Services\ProjectTasks\Handlers
 */
class SendUpdatedEmail
{

    /**
     * @param ProjectTask $projectTask
     * @param User        $user
     * @param User        $who
     */
    public function handle(ProjectTask $projectTask, User $user, User $who)
    {
        Mail::to($user)->queue(
            (new UpdatedMail($projectTask, $user, $who))->onQueue(Queue::EMAILS)
        );
    }

}

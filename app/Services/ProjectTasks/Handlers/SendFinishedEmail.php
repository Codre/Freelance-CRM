<?php

namespace App\Services\ProjectTasks\Handlers;

use App\Jobs\Queue;
use App\Mail\ProjectTasks\FinishedMail;
use App\Models\ProjectTask;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

/**
 * Class SendFinishedEmail
 *
 * Отправка e-mail уведомления о завершение таска
 *
 * @package App\Services\ProjectTasks\Handlers
 */
class SendFinishedEmail
{

    /**
     * @param ProjectTask $projectTask
     * @param User        $user
     * @param User        $who
     */
    public function handle(ProjectTask $projectTask, User $user, User $who)
    {
        Mail::to($user)->queue(
            (new FinishedMail($projectTask, $user, $who))->onQueue(Queue::EMAILS)
        );
    }

}

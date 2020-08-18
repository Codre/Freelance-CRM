<?php

namespace App\Services\ProjectTasks\Handlers;

use App\Jobs\Queue;
use App\Mail\ProjectTasks\ReadyMail;
use App\Models\ProjectTask;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

/**
 * Class SendReadyEmail
 *
 * Отправка e-mail уведомления о готовности тикета к проверке
 *
 * @package App\Services\ProjectTasks\Handlers
 */
class SendReadyEmail
{

    /**
     * @param ProjectTask $projectTask
     * @param User        $user
     * @param User        $who
     */
    public function handle(ProjectTask $projectTask, User $user, User $who)
    {
        Mail::to($user)->queue(
            (new ReadyMail($projectTask, $user, $who))->onQueue(Queue::EMAILS)
        );
    }

}

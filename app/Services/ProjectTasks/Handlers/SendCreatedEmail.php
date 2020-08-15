<?php

namespace App\Services\ProjectTasks\Handlers;

use App\Jobs\Queue;
use App\Mail\ProjectTasks\CreatedMail;
use App\Mail\ProjectTasks\FinishedMail;
use App\Models\ProjectTask;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

/**
 * Class SendCreatedEmail
 *
 * Отправка e-mail уведомления о создание таска
 *
 * @package App\Services\ProjectTasks\Handlers
 */
class SendCreatedEmail
{

    /**
     * @param ProjectTask $projectTask
     * @param User        $user
     * @param User        $who
     */
    public function handle(ProjectTask $projectTask, User $user, User $who)
    {
        Mail::to($user)->queue(
            (new CreatedMail($projectTask, $user, $who))->onQueue(Queue::EMAILS)
        );
    }

}

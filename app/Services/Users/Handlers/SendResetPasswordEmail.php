<?php

namespace App\Services\Users\Handlers;

use App\Jobs\Queue;
use App\Mail\Users\UsersResetPasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

/**
 * Class SendResetPasswordEmail
 *
 * @package App\Services\Users\Handlers
 */
class SendResetPasswordEmail
{

    /**
     * @param User   $user
     * @param string $token
     */
    public function handler(User $user, string $token)
    {
        Mail::to($user)->queue(
            (new UsersResetPasswordMail($user, $token))->onQueue(Queue::EMAILS)
        );
    }
}

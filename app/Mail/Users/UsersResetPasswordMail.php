<?php

namespace App\Mail\Users;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class UsersBalanceMail
 * Письмо о состояние баланса пользователя
 *
 * @package App\Mail\Users
 */
class UsersResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * @var User
     */
    public $user;
    /**
     * @var string
     */
    public $token;

    /**
     * Create a new message instance.
     *
     * @param User   $user
     * @param string $token
     */
    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->subject = __('emails/users.reset_password.title');
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.users.reset_password');
    }
}

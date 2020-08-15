<?php

namespace App\Mail\Clients;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;


/**
 * Class ClientInviteMail
 * Письмо о состояние баланса пользователя
 *
 * @package App\Mail\Users
 */
class InviteMail extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * @var User
     */
    public $user;

    /**
     * @var string[]
     */
    public $routeParams;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->subject = __('emails/clients.invite.title');

        $key = Hash::make(app(\Faker\Generator::class)->password);
        $this->routeParams = [
            'id' => $user->id,
            'key' => $key,
            'hash' => Hash::make(join('|', [$user->id, $user->email, $key]))
        ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.clients.invite');
    }
}

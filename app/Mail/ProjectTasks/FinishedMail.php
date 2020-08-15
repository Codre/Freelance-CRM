<?php

namespace App\Mail\ProjectTasks;

use App\Models\ProjectTask;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FinishedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var ProjectTask
     */
    public $projectTask;
    /**
     * @var User
     */
    public $user;
    /**
     * @var User
     */
    public $who;

    /**
     * Create a new message instance.
     *
     * @param ProjectTask $projectTask
     * @param User        $user
     * @param User        $who
     */
    public function __construct(ProjectTask $projectTask, User $user, User $who)
    {
        $this->projectTask = $projectTask;
        $this->user = $user;
        $this->who = $who;

        $this->subject = __('emails/projects/tasks.finished.subject', ['task' => $this->projectTask->title]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.projectTasks.finished');
    }
}

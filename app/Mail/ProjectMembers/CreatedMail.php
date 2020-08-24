<?php

namespace App\Mail\ProjectMembers;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Project
     */
    public $project;
    /**
     * @var User
     */
    public $user;
    /**
     * @var User
     */
    public $who;
    /**
     * @var mixed
     */
    public $role;

    /**
     * Create a new message instance.
     *
     * @param Project $project
     * @param User        $user
     * @param User        $who
     */
    public function __construct(Project $project, User $user, User $who)
    {
        $this->project = $project;
        $this->user = $user;
        $this->who = $who;
        $this->role = ProjectUser::getGroups()[$project->users()->find($user->id)->pivot->group];

        $this->subject = __('emails/projects/members.created.subject', ['project' => $this->project->name]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.projectMembers.created');
    }
}

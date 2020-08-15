<?php

namespace App\Mail\ProjectTasks;

use App\Models\ProjectTask;
use App\Models\TaskComment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var TaskComment
     */
    public $comment;
    /**
     * @var User
     */
    public $user;
    /**
     * @var User
     */
    public $who;
    /**
     * @var ProjectTask
     */
    public $task;
    /**
     * @var mixed
     */
    public $project;

    /**
     * Create a new message instance.
     *
     * @param TaskComment $comment
     * @param User        $user
     * @param User        $who
     */
    public function __construct(TaskComment $comment, User $user, User $who)
    {
        $this->comment = $comment;
        $this->user = $user;
        $this->who = $who;

        $this->task = $comment->task;
        $this->project = $this->task->project;

        $this->subject = __('emails/projects/comments.created.subject', ['task' => $this->task->title]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.projectTasks.comments.created');
    }
}

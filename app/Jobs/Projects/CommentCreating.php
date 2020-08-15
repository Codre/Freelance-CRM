<?php

namespace App\Jobs\Projects;

use App\Models\TaskComment;
use App\Models\User;
use App\Services\TaskComments\TaskCommentsEmailsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CommentCreating implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var TaskComment
     */
    private $comment;
    /**
     * @var User
     */
    private $who;

    /**
     * Create a new job instance.
     *
     * @param TaskComment $comment
     * @param User        $who
     */
    public function __construct(TaskComment $comment, User $who)
    {
        $this->comment = $comment;
        $this->who = $who;
    }

    /**
     * Execute the job.
     *
     * @param TaskCommentsEmailsService $commentsEmailsService
     *
     * @return void
     */
    public function handle(
        TaskCommentsEmailsService $commentsEmailsService
    ) {

        $commentsEmailsService->createComment($this->comment, $this->who);
    }
}

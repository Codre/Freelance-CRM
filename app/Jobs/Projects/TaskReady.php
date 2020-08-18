<?php

namespace App\Jobs\Projects;

use App\Models\ProjectTask;
use App\Models\User;
use App\Services\ProjectTasks\Exceptions\AllProjectUsersMethodNotFoundException;
use App\Services\ProjectTasks\ProjectTasksEmailsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TaskReady implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var ProjectTask
     */
    private $task;
    /**
     * @var User
     */
    private $who;

    /**
     * Create a new job instance.
     *
     * @param ProjectTask $task
     * @param User        $who
     */
    public function __construct(ProjectTask $task, User $who)
    {
        $this->task = $task;
        $this->who = $who;
    }

    /**
     * Execute the job.
     *
     * @param ProjectTasksEmailsService $projectTasksEmailsService
     *
     * @return void
     * @throws AllProjectUsersMethodNotFoundException
     */
    public function handle(
        ProjectTasksEmailsService $projectTasksEmailsService
    ) {
        $projectTasksEmailsService->forAllProjectUsers($this->task, 'ready', $this->who);
    }
}

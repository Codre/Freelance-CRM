<?php

namespace App\Services\ProjectTasks;

use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\User;
use App\Services\ProjectTasks\Exceptions\AllProjectUsersMethodNotFoundException;
use App\Services\ProjectTasks\Handlers\SendCreatedEmail;
use App\Services\ProjectTasks\Handlers\SendFinishedEmail;
use App\Services\ProjectTasks\Handlers\SendReadyEmail;
use App\Services\ProjectTasks\Handlers\SendUpdatedEmail;

/**
 * Class ProjectTasksEmailsService
 *
 * @package App\Services\ProjectTasks
 */
class ProjectTasksEmailsService
{

    /**
     * @var SendFinishedEmail
     */
    private $sendFinishedEmail;
    /**
     * @var SendUpdatedEmail
     */
    private $sendUpdatedEmail;
    /**
     * @var SendCreatedEmail
     */
    private $sendCreatedEmail;
    /**
     * @var SendReadyEmail
     */
    private $sendReadyEmail;

    /**
     * ProjectTasksEmailsService constructor.
     *
     * @param SendFinishedEmail $sendFinishedEmail
     * @param SendReadyEmail    $sendReadyEmail
     * @param SendUpdatedEmail  $sendUpdatedEmail
     * @param SendCreatedEmail  $sendCreatedEmail
     */
    public function __construct(
        SendFinishedEmail $sendFinishedEmail,
        SendReadyEmail $sendReadyEmail,
        SendUpdatedEmail $sendUpdatedEmail,
        SendCreatedEmail $sendCreatedEmail
    ) {
        $this->sendFinishedEmail = $sendFinishedEmail;
        $this->sendUpdatedEmail = $sendUpdatedEmail;
        $this->sendCreatedEmail = $sendCreatedEmail;
        $this->sendReadyEmail = $sendReadyEmail;
    }

    /**
     * Отправить сообщения всем связанным с таском пользователям
     *
     * @param ProjectTask $projectTask
     * @param string      $method - метод текущего класса
     * @param User        $who
     *
     * @throws AllProjectUsersMethodNotFoundException
     */
    public function forAllProjectUsers(ProjectTask $projectTask, string $method, User $who)
    {
        if (!method_exists($this, $method)) {
            throw new AllProjectUsersMethodNotFoundException();
        }

        foreach ($projectTask->project->users()->whereNotIn('user_id', [$who->id])->get() as $user) {
            $this->{$method}($projectTask, $user, $who);
        }
    }

    /**
     * Отправить e-mail о готовности тикета к проверке пользователю
     *
     * @param ProjectTask $projectTask
     * @param User        $user
     * @param User        $who
     */
    public function ready(ProjectTask $projectTask, User $user, User $who)
    {
        $this->sendReadyEmail->handle($projectTask, $user, $who);
    }

    /**
     * Отправить e-mail о завершение таска пользователю
     *
     * @param ProjectTask $projectTask
     * @param User        $user
     * @param User        $who
     */
    public function finished(ProjectTask $projectTask, User $user, User $who)
    {
        $this->sendFinishedEmail->handle($projectTask, $user, $who);
    }

    /**
     * Отправить e-mail о создание таска пользователю
     *
     * @param ProjectTask $projectTask
     * @param User        $user
     * @param User        $who
     */
    public function created(ProjectTask $projectTask, User $user, User $who)
    {
        $this->sendCreatedEmail->handle($projectTask, $user, $who);
    }

    /**
     * Отправить e-mail об обновление таска пользователю
     *
     * @param ProjectTask $projectTask
     * @param User        $user
     * @param User        $who
     */
    public function updated(ProjectTask $projectTask, User $user, User $who)
    {
        $this->sendUpdatedEmail->handle($projectTask, $user, $who);
    }
}

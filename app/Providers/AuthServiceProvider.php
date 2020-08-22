<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\ProjectTask;
use App\Policies\ClientPolicy;
use App\Policies\ProjectFinancePolicy;
use App\Policies\ProjectPolicy;
use App\Policies\ProjectTaskPolicy;
use App\Policies\StaffPolicy;
use App\Policies\TaskFilePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Project::class     => ProjectPolicy::class,
        ProjectTask::class => ProjectTaskPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Gate::resource('staff', StaffPolicy::class);
        Gate::resource('client', ClientPolicy::class);
        Gate::resource('project', ProjectPolicy::class);
        Gate::resource('projectFinance', ProjectFinancePolicy::class);
        Gate::resource('taskFile', TaskFilePolicy::class);

        Gate::resource('projectTask', ProjectTaskPolicy::class);
        Gate::define('projectTask.run', ProjectTaskPolicy::class . '@run');
        Gate::define('projectTask.finishing', ProjectTaskPolicy::class . '@finishing');
        Gate::define('projectTask.ready', ProjectTaskPolicy::class . '@ready');
        Gate::define('projectTask.viewTime', ProjectTaskPolicy::class . '@viewTime');

        Gate::define('user.pay', UserPolicy::class . '@pay');
    }
}

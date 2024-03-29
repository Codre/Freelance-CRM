<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\User;
use App\Observers\ProjectObserver;
use App\Observers\UserObserver;
use App\Services\Finances\Repositories\EloquentFinancesRepository;
use App\Services\Finances\Repositories\FinancesRepositoryInterface;
use App\Services\ProjectFinances\Repositories\EloquentProjectFinancesRepository;
use App\Services\ProjectFinances\Repositories\ProjectFinancesRepositoryInterface;
use App\Services\Projects\Repositories\EloquentProjectsRepository;
use App\Services\Projects\Repositories\ProjectsRepositoryInterface;
use App\Services\ProjectTasks\Repositories\EloquentProjectTasksRepository;
use App\Services\ProjectTasks\Repositories\ProjectTasksRepositoryInterface;
use App\Services\TaskComments\Repositories\EloquentTaskCommentsRepository;
use App\Services\TaskComments\Repositories\TaskCommentsRepositoryInterface;
use App\Services\TaskFiles\Repositories\EloquentTaskFilesRepository;
use App\Services\TaskFiles\Repositories\TaskFilesRepositoryInterface;
use App\Services\TaskTimes\Repositories\EloquentTaskTimesRepository;
use App\Services\TaskTimes\Repositories\TaskTimesRepositoryInterface;
use App\Services\Users\Repositories\EloquentUsersRepository;
use App\Services\Users\Repositories\UsersRepositoryInterface;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
            $this->app->register(\Arcanedev\LogViewer\LogViewerServiceProvider::class);
        }

        $this->app->bind(UsersRepositoryInterface::class, EloquentUsersRepository::class);
        $this->app->bind(ProjectsRepositoryInterface::class, EloquentProjectsRepository::class);
        $this->app->bind(ProjectTasksRepositoryInterface::class, EloquentProjectTasksRepository::class);
        $this->app->bind(TaskCommentsRepositoryInterface::class, EloquentTaskCommentsRepository::class);
        $this->app->bind(TaskTimesRepositoryInterface::class, EloquentTaskTimesRepository::class);
        $this->app->bind(ProjectFinancesRepositoryInterface::class, EloquentProjectFinancesRepository::class);
        $this->app->bind(FinancesRepositoryInterface::class, EloquentFinancesRepository::class);
        $this->app->bind(TaskFilesRepositoryInterface::class, EloquentTaskFilesRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Blade::directive('moneyFormat', function ($money) {
            return "<?php echo number_format($money, 2, ',', ' ') . 'р.'; ?>";
        });

        User::observe(UserObserver::class);
        Project::observe(ProjectObserver::class);
    }
}

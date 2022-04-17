<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Models\ProjectTask;
use App\Services\Finances\FinancesService;
use Illuminate\Console\Command;

class MakeInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:make
                                {id : ID проекта или задачи}
                                {--P|--project : Создать счета для всех закрытых задач проекта}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создать счёт по задаче или всем задачам проекта';
    /**
     * @var FinancesService
     */
    private FinancesService $financesService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FinancesService $financesService)
    {
        parent::__construct();
        $this->financesService = $financesService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $id = (int)$this->argument('id');
        if ($this->option('project')) {
            /** @var Project $project */
            $project = Project::whereId($id)->get()->first();
            if (!$project) {
                $this->error('Проект не найден');
                return 0;
            }
            $tasks = $project->tasks->where('status', ProjectTask::STATUS_FINISHED);
            unset($project);
        } else {
            $tasks = ProjectTask::whereId($id)->get();
        }
        if (!$tasks || !$tasks->count()) {
            $this->error('Не удалось найти задачи');
            return 0;
        }

        /** @var ProjectTask $task */
        foreach ($tasks as $task) {
            $this->financesService->createInvoice($task);
            $this->info(sprintf('Счёт по задаче %d для проекта %d создан', $task->id, $task->project_id));
        }

        return 0;
    }
}

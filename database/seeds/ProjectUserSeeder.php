<?php

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::all() as $item) {
            if ($item->id == 1) {
                $projects = Project::all();
            } else {
                $projects = Project::all()->take(rand(3, 10));
            }
            foreach ($projects as $project) {
                (new ProjectUser([
                    'user_id' => $item->id,
                    'project_id' => $project->id,
                    'group' => [
                        ProjectUser::GROUP_OBSERVER,
                        ProjectUser::GROUP_CUSTOMER,
                        ProjectUser::GROUP_EXECUTOR,
                        ProjectUser::GROUP_MANAGER
                    ][rand(0, 3)]
                ]))->save();
            }
        }
    }
}

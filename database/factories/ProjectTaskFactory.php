<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProjectTask;
use Faker\Generator as Faker;

$factory->define(ProjectTask::class, function (Faker $faker) {
    $statuses = [
        ProjectTask::STATUS_NEW, ProjectTask::STATUS_FINISHED, ProjectTask::STATUS_PAUSE,
        ProjectTask::STATUS_PROCESS, ProjectTask::STATUS_READY,
    ];

    return [
        'title'       => $faker->jobTitle,
        'description' => $faker->text,
        'status'      => $statuses[rand(0, count($statuses) - 1)],
    ];
});

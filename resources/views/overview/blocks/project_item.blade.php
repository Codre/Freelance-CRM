<?php
/** @var \App\Models\Project $project */
?>

<a class="nav-link" href="{{ route('projects.show', ['project' => $project]) }}">
    <span class="float-right">
        <span class="badge badge-info" v-b-tooltip
              title="{{ __('overview/general.projects.hint.new') }}">
            {{ $project->tasks->whereIn('status', [\App\Models\ProjectTask::STATUS_NEW])->count() }}
        </span>
        <span class="badge badge-success" v-b-tooltip
              title="{{ __('overview/general.projects.hint.process') }}">
            {{ $project->tasks->whereIn(
                'status',
                [\App\Models\ProjectTask::STATUS_PAUSE, \App\Models\ProjectTask::STATUS_PROCESS]
            )->count() }}
        </span>
        <span class="badge badge-secondary" v-b-tooltip
              title="{{ __('overview/general.projects.hint.ended') }}">
            {{ $project->tasks->whereIn(
                    'status',
                    [\App\Models\ProjectTask::STATUS_READY, \App\Models\ProjectTask::STATUS_FINISHED]
            )->count() }}
        </span>
    </span>
    {{ $project->name }}
</a>

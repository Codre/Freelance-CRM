<?php
/** @var \App\Models\ProjectTask $task */
/** @var array $taskStatuses */
/** @var array $taskStatusColors */
?>

<a class="nav-link" href="{{ route('projects.tasks.show', ['project' => $task->project, 'task' => $task]) }}">
    <span class="float-right">
        <span class="badge badge-{{ $taskStatusColors[$task->status] }}">
            {{ $taskStatuses[$task->status] }}
        </span>
    </span>
    {{ $task->title }}<br />
    <small class="text-muted">{{ $task->project->name }}</small>
</a>

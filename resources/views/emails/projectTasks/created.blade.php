<?php
/** @var \App\Models\User $user */
/** @var \App\Models\User $who */
/** @var \App\Models\ProjectTask $projectTask */
?>
@extends('emails.layout')

@section('content')
<p>{{ __('emails/projects/tasks.created.hello', ['name' => $user->name]) }}</p>
<p>
    {!! __(
    'emails/projects/tasks.created.message',
    ['who' => $who->name, 'task' => $projectTask->title, 'project' => $projectTask->project->name]
    ) !!}
</p>
<p>
    <a style="padding: 8px 20px; border-radius: 2px;text-transform: uppercase;text-decoration: none;transition: box-shadow .28s cubic-bezier(.4,0,.2,1);   background-color: #4caf50;color: rgba(255,255,255,.84);font-size: 12px;line-height: 1.33;margin-bottom: 5px;"
       href="{{ route('projects.tasks.show', ['project' => $projectTask->project, 'task' => $projectTask]) }}">{{ __('emails/projects/tasks.created.link') }}</a>
</p>
@endsection

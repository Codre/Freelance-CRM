<?php
/** @var \App\Models\User $user */
/** @var \App\Models\User $who */
/** @var \App\Models\Project $project */
?>
@extends('emails.layout')

@section('content')
<p>{{ __('emails/projects/members.created.hello', ['name' => $user->name]) }}</p>
<p>
    {!! __(
    'emails/projects/members.created.message',
    ['who' => $who->name, 'project' => $project->name, 'role' => $role]
    ) !!}
</p>
<p>
    <a style="padding: 8px 20px; border-radius: 2px;text-transform: uppercase;text-decoration: none;transition: box-shadow .28s cubic-bezier(.4,0,.2,1);   background-color: #4caf50;color: rgba(255,255,255,.84);font-size: 12px;line-height: 1.33;margin-bottom: 5px;"
       href="{{ route('projects.show', ['project' => $project]) }}">{{ __('emails/projects/members.created.link') }}</a>
</p>
@endsection

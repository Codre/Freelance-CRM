@extends('layouts.app')

@section('content')
    @can('projectTask.update', $task)
        <div class="float-right">
            <a href="{{ route('projects.tasks.edit', ['project' => $project, 'task' => $task]) }}"
               class="btn btn-success m-1">{{ __('projects/tasks.show.change') }}</a>
        </div>
    @endcan
    <h1>{{ $title }}</h1>

    <div class="card profile">
        <div class="card-body">
            {!! $task->description !!}
        </div>
    </div>
@endsection

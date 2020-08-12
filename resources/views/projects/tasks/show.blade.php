@extends('layouts.app')

@section('content')
    @can('projectTask.update', $task)
        <div class="float-right">
            <a href="{{ route('projects.tasks.edit', ['project' => $project, 'task' => $task]) }}"
               class="btn btn-success m-1">{{ __('projects/tasks.show.change') }}</a>
        </div>
    @endcan
    <h1>{{ $title }}</h1>

    <div class="card">
        <div class="card-body">
            {!! $task->description !!}
        </div>
    </div>

    <h3 class="mt-2 mb-2">{{ __('projects/tasks.comments.title') }}</h3>

    <div class="card mb-2">
        {!! Form::open( ['route' => ['projects.tasks.comments.store', 'project' => $project, 'task' => $task], 'method' => 'POST']) !!}
        <div class="card-body">
            <div class="form-group">
                {!! Form::textarea('text', null, [
                        'style' => 'height: 120px',
                        'placeholder' => __('projects/tasks.comments.form.text.placeholder'),
                        'class' => 'form-control']) !!}
            </div>
        </div>
        <div class="card-footer">
            {!! Form::submit(__('projects/tasks.comments.form.submit'), ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    @foreach($comments as $comment)
        @include('projects.tasks.blocks.comment')
    @endforeach
@endsection

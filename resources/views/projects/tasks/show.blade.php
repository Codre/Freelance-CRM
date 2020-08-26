<?php
/** @var \App\Models\TaskTimes $timeStarted */
/** @var \App\Models\ProjectTask $task */
/** @var \App\Models\Project $project */
/** @var \Illuminate\Database\Eloquent\Collection $times */
/** @var \Illuminate\Database\Eloquent\Collection $files */
?>
@extends('layouts.app')

@section('content')
    @can('projectTask.update', $task)
        <div class="float-right">
            @can('projectTask.run', $task)
                <div class="d-inline-block">
                    {!! Form::open([
                        'route' => ['projects.tasks.run', 'project' => $project, 'task' => $task],
                         'method' => 'POST'
                      ]) !!}
                    @if ($timeStarted)
                        <button v-b-tooltip.hover
                                title="{{ __('projects/tasks.show.stop') }}"
                                class="btn btn-info m-1"
                                type="submit">
                            @materialicon('av', 'pause', 'white')
                        </button>
                    @else
                        <button v-b-tooltip.hover
                                title="{{ __('projects/tasks.show.run') }}"
                                class="btn btn-primary m-1"
                                type="submit">
                            @materialicon('av', 'play_arrow', 'white')
                        </button>
                    @endif
                    {!! Form::close() !!}
                </div>
            @endcan
            @can('projectTask.ready', $task)
                <div class="d-inline-block">
                    {!! Form::open([
                        'route' => ['projects.tasks.ready', 'project' => $project, 'task' => $task],
                         'method' => 'POST'
                      ]) !!}
                    <button v-b-tooltip.hover
                            title="{{ __('projects/tasks.show.ready') }}"
                            class="btn btn-primary m-1"
                            type="submit">
                        @materialicon('action', 'done', 'white')
                    </button>
                    {!! Form::close() !!}
                </div>
            @endcan
            @can('projectTask.finishing', $task)
                <div class="d-inline-block">
                    {!! Form::open([
                        'route' => ['projects.tasks.finishing', 'project' => $project, 'task' => $task],
                         'method' => 'POST'
                      ]) !!}
                    <button v-b-tooltip.hover
                            title="{{ __('projects/tasks.show.finishing') }}"
                            class="btn btn-primary m-1"
                            type="submit">
                        @materialicon('action', 'done_all', 'white')
                    </button>
                    {!! Form::close() !!}
                </div>
            @endcan
            <a href="{{ route('projects.tasks.edit', ['project' => $project, 'task' => $task]) }}"
               class="btn btn-success m-1">{{ __('projects/tasks.show.change') }}</a>
        </div>
    @endcan
    <h1>{{ $title }} <span class="badge badge-secondary" style="font-size: 14px">{{ $statuses[$task->status] }}</span>
    </h1>

    <div class="card">
        <div class="card-body">
            {!! $task->description !!}
        </div>
    </div>

    <div class="mt-2">
        <b-tabs>
            <b-tab title="{{ __('projects/tasks.comments.title') }}" active>
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
            </b-tab>
            @can('taskFile.viewAny', $project)
                <b-tab title="{{ __('projects/tasks.files.title') }}">
                    <h3 class="mt-2 mb-2">{{ __('projects/tasks.files.title') }}</h3>
                    <DropzoneUpload
                        action="{{ route('projects.tasks.files.store', ['project' => $project, 'task' => $task])}}"
                    ></DropzoneUpload>
                    @include('projects.tasks.blocks.files')
                </b-tab>
            @endcan
            @can('projectTask.viewTime', $project)
                <b-tab title="{{ __('projects/tasks.times.title') }}">
                    <h3 class="mt-2 mb-2">{{ __('projects/tasks.times.title') }}</h3>
                    <ProjectTaskTimeList
                        store_url="{{ route('ajax.projects.tasks.times.update', ['project' => $project, 'task' => $task, 'time' => 0]) }}"
                        user_id="{{ Auth::id() }}"
                        @can('projectTask.update', $task)
                        can="true"
                        @endcan
                        list='{!! $times->toJson() !!}'></ProjectTaskTimeList>
                </b-tab>
            @endcan
        </b-tabs>
    </div>
@endsection

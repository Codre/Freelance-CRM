@extends('layouts.app')

@section('content')
    <h1>{{ $title }}</h1>

    <div class="card profile">
        {!! Form::open( ['route' => ['projects.tasks.update', 'project' => $project, 'task' => $task], 'method' => 'PATCH']) !!}
        <div class="card-body">
            <div class="form-group">
                {!! Form::label('title', __('projects/tasks.edit.form.title.label')) !!}
                {!! Form::text('title', $task->title, ['class' => 'form-control', 'placeholder' => __('projects/tasks.create.form.title.placeholder')]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', __('projects/tasks.edit.form.description.label')) !!}
                {!! Form::textarea('description', $task->description, [
                        'class' => 'form-control', 'data-summernote' => '']) !!}
            </div>
        </div>
        <div class="card-footer">
            {!! Form::submit(__('projects/tasks.edit.form.submit'), ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@endsection

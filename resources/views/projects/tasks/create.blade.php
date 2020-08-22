@extends('layouts.app')

@section('content')
    <h1>{{ $title }}</h1>

    <div class="card">
        {!! Form::open( ['route' => ['projects.tasks.store', 'project' => $project], 'method' => 'POST', 'files' => true]) !!}
        <div class="card-body">
            <div class="form-group">
                {!! Form::label('title', __('projects/tasks.create.form.title.label')) !!}
                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('projects/tasks.create.form.title.placeholder')]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', __('projects/tasks.create.form.description.label')) !!}
                {!! Form::textarea('description', null, [
                        'class' => 'form-control', 'data-summernote' => '']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('files', __('projects/tasks.create.form.files.label')) !!}
                {!! Form::file('files[]', [
                        'class' => 'form-control',
                        'multiple'
                        ]) !!}
            </div>
        </div>
        <div class="card-footer">
            {!! Form::submit(__('projects/tasks.create.form.submit'), ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@endsection

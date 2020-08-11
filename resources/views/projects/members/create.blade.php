<?php
/** @var \Illuminate\Database\Eloquent\Collection $availableForAdding */
?>
@extends('layouts.app')

@section('content')
    <h1>{{ $title }}</h1>

    <div class="card profile">
        {!! Form::open( ['route' => ['projects.members.store', 'project' => $project], 'method' => 'POST']) !!}
        <div class="card-body">
            <div class="form-group">
                <ProjectMembersCreateUserDataList
                    options='{!! $availableForAdding->toJson() !!}'
                    label="{{ __('projects/members.create.user.label') }}"
                    placeholder="{{ __('projects/members.create.user.placeholder') }}"
                    name="user_id"></ProjectMembersCreateUserDataList>
            </div>
            <div class="form-group">
                {!! Form::label('group', __('projects/members.create.group.label')) !!}
                {!! Form::select('group', $groups , null , ['class' => 'form-control', 'placeholder' => __('projects/members.create.group.placeholder')]) !!}
            </div>
        </div>
        <div class="card-footer">
            {!! Form::submit(__('projects/members.create.submit'), ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@endsection

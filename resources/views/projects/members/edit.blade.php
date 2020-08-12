<?php
/** @var \App\Models\User $member */
/** @var \App\Models\Project $project */
?>
@extends('layouts.app')

@section('content')
    <h1>{{ $title }}</h1>

    <div class="card">
        {!! Form::open( ['route' => ['projects.members.update', 'project' => $project, 'member' => $member], 'method' => 'PATCH']) !!}
        <div class="card-body">
            <div class="form-group">
                {!! Form::label('user_id', __('projects/members.edit.user.label')) !!}
                <div>
                    <b>{{ $member->name }} [{{ $member->email }}]</b>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('group', __('projects/members.edit.group.label')) !!}
                {!! Form::select('group', $groups , $project->users->find($member->id)->pivot->group, ['class' => 'form-control', 'placeholder' => __('projects/members.edit.group.placeholder')]) !!}
            </div>
        </div>
        <div class="card-footer">
            {!! Form::submit(__('projects/members.edit.submit'), ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@endsection

<?php
/** @var bool $canEdit */
/** @var \App\Models\Project $project */
?>
@extends('layouts.app')

@section('content')

    @if($canEdit)
        <div class="float-right">
            <a href="{{ route('projects.members.create', ['project' => $project]) }}" class="btn btn-primary m-1">
                {{ __('projects/members.index.create') }}
            </a>
        </div>
    @endif
    <h1>{{ $title }}</h1>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>{{__('projects/members.index.table.name')}}</th>
                    <th>{{__('projects/members.index.table.group')}}</th>
                    @if($canEdit)
                        <th></th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @forelse ($list as $item)
                    @include('projects.members.blocks.list_item')
                @empty
                    <tr>
                        <td class="text-center" colspan="{{ $canEdit ? '3' : '2' }}">{{__('projects/members.index.table.empty')}}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

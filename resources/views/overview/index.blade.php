<?php
/** @var float $balance */
/** @var int $tasksCount */
/** @var \Illuminate\Database\Eloquent\Collection $tasks */
?>
@extends('layouts.app')

@section('content')
    <h1>{{ $title }}</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="float-right mt-2 mr-1">
                        {!! __('overview/general.tasks.all', ['count' => $tasksCount]) !!}
                    </div>
                    <h3>{{ __('overview/general.tasks.title') }}</h3>
                </div>
                <div class="card-body">
                    @foreach($tasks as $task)
                        @include('overview.blocks.task_item')
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('overview/general.projects.title') }}</h3>
                </div>
                <div class="card-body">
                    <div class="nav flex-column nav-pills">
                        @foreach($projects as $project)
                            @include('overview.blocks.project_item')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('overview/general.balance.title') }}</h3>
                </div>
                <div class="card-body">
                    <h4 class="{{ $balance >= 0 ? 'text-success' : 'text-danger' }} text-center">
                        @moneyFormat($balance)
                    </h4>
                </div>
                @can('user.pay')
                <div class="card-footer">
                    <p class="text-center">
                        <a href="#" class="btn btn-success">{{ __('overview/general.balance.deposit') }}</a>
                    </p>
                </div>
                @endcan
            </div>
        </div>
    </div>
@endsection

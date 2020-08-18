<?php
/** @var \App\Models\Project $project */
/** @var \App\Models\ProjectTask $task */
/** @var array $groups */
/** @var \Illuminate\Database\Eloquent\Collection $list */
/** @var \Illuminate\Database\Eloquent\Collection|null $projectList */
?>
@extends('layouts.app')

@section('content')
    <h1>{{ $title }}</h1>

    <div class="card">
        @if ($task->id)
            {!! Form::open( ['route' => ['projects.tasks.finances.store', 'project' => $project, 'task' => $task], 'method' => 'POST']) !!}
        @else
            {!! Form::open( ['route' => ['projects.finances.store', 'project' => $project], 'method' => 'POST']) !!}
        @endif
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>{{ __('projects/finances.create.thead.member')  }}</th>
                    @if ($projectList)
                        <th>{{ __('projects/finances.create.thead.project')  }}</th>
                    @endif
                    <th>{{ __('projects/finances.create.thead.bet')  }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($members as $member)
                    @php
                        $current = $list->where('user_id', '=', $member->id)->first();
                    @endphp
                    <tr>
                        <td>
                            <b>{{ $member->name }}</b> ({{ $groups[$member->pivot->group] }})
                        </td>
                        @if ($projectList)
                            <td>
                                {{ $projectList->where('user_id', '=', $member->id)->first()->bet ?? '-' }}
                                {{ __('projects/finances.create.bet.currency') }}
                            </td>
                        @endif
                        <td>
                            <div class="input-group">
                                {!! Form::number(
                                    'bet['.$member->id.']',
                                    $current->bet ?? '',
                                    [
                                        'min' => 0,
                                        'step' => '0.01',
                                        'class' => 'form-control',
                                        'placeholder' => __('projects/finances.create.bet.placeholder')
                                    ]
                                ) !!}
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ __('projects/finances.create.bet.currency') }}</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {!! Form::submit(__('projects/finances.create.submit'), ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
@endsection

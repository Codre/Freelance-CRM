@extends('layouts.app')

@section('content')
    @can('project.update', $project)
        <div class="float-right">
            @can('projectTask.create', $project)
                <a href="{{ route('projects.tasks.create', ['project' => $project['id']]) }}"
                   class="btn btn-success m-1">{{ __('projects/show.create_task') }}</a>
            @endcan
            <a href="{{ route('projects.edit', ['project' => $project['id']]) }}"
               class="btn btn-primary m-1">{{ __('projects/show.change') }}</a>
        </div>
    @endcan
    <h1>{{ $title }}</h1>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-center">{{ $tasks->links() }}</div>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th class="text-center">{{__('projects/show.table.id')}}</th>
                    <th>{{__('projects/show.table.name')}}</th>
                    <th class="text-center">{{__('projects/show.table.status')}}</th>
                    <th class="text-center">{{__('projects/show.table.time')}}</th>
                    <th class="text-center">{{__('projects/show.table.finances')}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($tasks as $item)
                    @include('projects.blocks.show_item')
                @empty
                    <tr>
                        <td class="text-center" colspan="6">{{__('projects/show.table.empty')}}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">{{ $tasks->links() }}</div>
        </div>
    </div>
@endsection

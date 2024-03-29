@extends('layouts.app')

@section('content')
    @can('project.update', $project)
        <div class="float-right">
            @can('projectTask.create', $project)
                <a href="{{ route('projects.tasks.create', ['project' => $project['id']]) }}"
                   class="btn btn-success m-1">{{ __('projects/show.create_task') }}</a>
            @endcan
            @can('projectFinance.viewAny', $project)
                <a href="{{ route('projects.finances.create', ['project' => $project]) }}"
                   class="btn btn-secondary btn-sm"
                   v-b-tooltip.hover title="{{ __('projects/show.finances') }}">
                    @materialicon('editor', 'monetization_on', 'white')
                </a>
            @endcan
            @can('project.update', $project)
                <ProjectsEditPopupBtn
                    btn_class=""
                    id="{{ $project->id }}"
                    route_edit="{{ route('ajax.projects.edit', ['project' => $project]) }}"
                    route_update="{{ route('ajax.projects.update', ['project' => $project]) }}"
                >{{ __('projects/show.change') }}</ProjectsEditPopupBtn>
            @endcan
        </div>
    @endcan
    <h1 class="js-project-name" data-id="{{ $project->id }}">{{ $title }}</h1>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-center">{{ $tasks->links() }}</div>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th class="text-center">{{__('projects/show.table.id')}}</th>
                    <th>{{__('projects/show.table.name')}}</th>
                    <th class="text-center">{{__('projects/show.table.status')}}</th>
                    @can('projectTask.viewTime', $project)
                        <th class="text-center">{{__('projects/show.table.time')}}</th>
                    @endcan
                    <th class="text-center">{{__('projects/show.table.finances')}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($tasks as $item)
                    @include('projects.blocks.show_item')
                @empty
                    <tr>
                        <td @can('projectTask.viewTime', $project)
                            colspan="6"
                            @else
                            colspan="7"
                            @endcan
                            class="text-center">{{__('projects/show.table.empty')}}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">{{ $tasks->links() }}</div>
        </div>
    </div>
@endsection

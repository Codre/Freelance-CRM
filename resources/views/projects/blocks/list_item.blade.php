<?php
/** @var \App\Models\Project $item */
?>
<tr>
    <td class="text-center">
        @can('project.view', $item)
            {{ link_to(route('projects.show', ['project' => $item->id]), $item->id) }}
        @else
            {{ $item->id }}
        @endcan
    <td>
        @can('project.view', $item)
            {{ link_to(route('projects.show', ['project' => $item->id]), $item->name, [
                'class' => 'js-project-name',
                'data-id' => $item->id
            ]) }}
        @else
            <b class="js-project-name" data-id="{{ $item->id }}">{{ $item->name }}</b>
        @endcan
    </td>
    <td class="text-center">
        @can('project.view', $item)
            <a href="{{ route('projects.members.index', ['project' => $item->id]) }}" class="btn btn-info btn-sm"
               v-b-tooltip.hover title="{{ __('projects/general.index.item.members') }}">
                @materialicon('action', 'supervisor_account', 'white')
                <span class="badge">{{ $item->users->count()  }}</span>
            </a>
        @endcan
    </td>
    <td>
        @can('projectFinance.viewAny', $item)
            <a href="{{ route('projects.finances.create', ['project' => $item]) }}" class="btn btn-secondary btn-sm"
               v-b-tooltip.hover title="{{ __('projects/general.index.item.finances') }}">
                @materialicon('editor', 'monetization_on', 'white')
            </a>
        @endcan
        @can('project.update', $item)
            <ProjectsEditPopupBtn
                id="{{ $item->id }}"
                btn_class="btn-sm"
                route_edit="{{ route('ajax.projects.edit', ['project' => $item]) }}"
                route_update="{{ route('ajax.projects.update', ['project' => $item]) }}"
            >@materialicon('content', 'create', 'white')</ProjectsEditPopupBtn>
        @endcan
        @can('project.delete', $item)
            {{ Form::open(['route' => ['projects.destroy', 'project' => $item->id], 'method' => 'delete', 'class' => 'd-inline-block'])}}
            <button type="submit" class="btn btn-danger btn-sm js-confirm"
                    v-b-tooltip.hover title="{{ __('projects/general.index.item.delete') }}">@materialicon('action', 'delete', 'white')</button>
            {{ Form::close() }}
        @endcan
    </td>
</tr>

<?php
/** @var \App\Models\Project $item */
?>
<tr>
    <td class="text-center">{{ $item->id }}</td>
    <td>
        @can('project.view', $item)
            {{ link_to(route('projects.show', ['project' => $item->id]), $item->name) }}
        @else
            <b>{{ $item->name }}</b>
        @endcan
    </td>
    <td>
        @can('project.view', $item)
            <a href="{{ route('projects.members.index', ['project' => $item->id]) }}" class="btn btn-info btn-sm"
               v-b-tooltip.hover title="{{ __('projects/general.index.item.members') }}">
                @materialicon('action', 'supervisor_account', 'white')
                <span class="badge">{{ $item->users->count()  }}</span>
            </a>
        @endcan
        @can('project.update', $item)
            <a href="{{ route('projects.edit', ['project' => $item->id]) }}" class="btn btn-primary btn-sm"
               v-b-tooltip.hover title="{{ __('projects/general.index.item.edit') }}">
                @materialicon('content', 'create', 'white')
            </a>
        @endcan
        @can('project.delete', $item)
            {{ Form::open(['route' => ['projects.destroy', 'project' => $item->id], 'method' => 'delete', 'class' => 'd-inline-block'])}}
            <button type="submit" class="btn btn-danger btn-sm"
                    v-b-tooltip.hover title="{{ __('projects/general.index.item.delete') }}">@materialicon('action', 'delete', 'white')</button>
            {{ Form::close() }}
        @endcan
    </td>
</tr>

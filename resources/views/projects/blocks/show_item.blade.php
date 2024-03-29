<?php
/** @var \App\Models\ProjectTask $item */
/** @var \App\Models\Project $project */
/** @var array $times */
/** @var array $finances */
?>
<tr>
    <td class="text-center">
        @can('projectTask.view', $item)
            {{ link_to(route('projects.tasks.show', ['project' => $project, 'task' => $item]), $item->id) }}
        @else
            {{ $item->id }}
        @endcan
    </td>
    <td>
        @can('projectTask.view', $item)
            {{ link_to(route('projects.tasks.show', ['project' => $project, 'task' => $item]), $item->title) }}
        @else
            <b>{{ $item->title }}</b>
        @endcan
        <div>
            <small>({{ $item->user->name }})</small>
        </div>
    </td>
    <td class="text-center">
        {{ $statuses[$item->status] }}
    </td>
    @can('projectTask.viewTime', $project)
    <td class="text-center">
        @if(empty($times[$item->id]))
            -
        @else
            {{ $times[$item->id]['h'] }}:{{ $times[$item->id]['m'] }}
        @endif
    </td>
    @endcan
    <td class="text-center">
        @if(empty($finances[$item->id]))
            -
        @else
            @moneyFormat($finances[$item->id])
        @endif
    </td>
    <td>
        @can('projectFinance.viewAny', [$project, $item])
            <a href="{{ route('projects.tasks.finances.create', ['project' => $project, 'task' => $item]) }}"
               class="btn btn-secondary btn-sm" v-b-tooltip.hover title="{{ __('projects/show.item.finances') }}">
                @materialicon('editor', 'monetization_on', 'white')
            </a>
        @endcan
        @can('projectTask.update', $item)
            <a href="{{ route('projects.tasks.edit', ['project' => $project, 'task' => $item]) }}" class="btn btn-primary btn-sm"
               v-b-tooltip.hover title="{{ __('projects/show.item.edit') }}">
                @materialicon('content', 'create', 'white')
            </a>
        @endcan
        @can('projectTask.delete', $item)
            {{ Form::open(['route' => ['projects.tasks.destroy', 'project' => $project, 'task' => $item], 'method' => 'delete', 'class' => 'd-inline-block'])}}
            <button type="submit" class="btn btn-danger btn-sm js-confirm"
                    v-b-tooltip.hover title="{{ __('projects/show.item.delete') }}">@materialicon('action', 'delete', 'white')</button>
            {{ Form::close() }}
        @endcan
    </td>
</tr>

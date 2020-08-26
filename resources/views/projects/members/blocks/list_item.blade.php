<?php
/** @var \App\Models\ProjectUser $item */
/** @var \App\Models\Project $project */
/** @var bool $canEdit */
?>
<tr>
    <td><b>{{ $item->name }}</b> (<a target="_blank" href="mailto:{{ $item->email }}">{{ $item->email }}</a>)</td>
    <td>
        <b>{{ $groups[$item->pivot->group] }}</b>
    </td>
    @if($canEdit)
        <td>
            @if($item->id !== $user['id'])
                <a href="{{ route('projects.members.edit', ['project' => $project, 'member' => $item]) }}" class="btn btn-primary btn-sm"
                   v-b-tooltip.hover title="{{ __('projects/members.index.item.edit') }}">
                    @materialicon('content', 'create', 'white')
                </a>
                {{ Form::open(['route' => ['projects.members.destroy', 'project' => $project, 'member' => $item], 'method' => 'delete', 'class' => 'd-inline-block'])}}
                <button type="submit" class="btn btn-danger btn-sm js-confirm"
                        v-b-tooltip.hover title="{{ __('projects/members.index.item.delete') }}">@materialicon('action',
                    'delete', 'white')
                </button>
                {{ Form::close() }}
            @endif
        </td>
    @endif
</tr>

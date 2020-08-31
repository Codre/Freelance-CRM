<?php
/** @var \Illuminate\Database\Eloquent\Collection $files */
/** @var \App\Models\TaskFile $file */
?>
<table class="table table-hover table-bordered">
    <thead>
    <tr>
        <th>{{ __('projects/tasks.files.thead.file') }}</th>
        <th class="text-center">{{ __('projects/tasks.files.thead.who') }}</th>
        <th class="text-center">{{ __('projects/tasks.files.thead.date') }}</th>
        @can('projectTask.update', $task)
            <th class="text-center"></th>
        @endcan
    </tr>
    </thead>
    <tbody>
    @foreach($files as $file)
        <tr>
            <td>
                <a href="{{ route('projects.tasks.files.show', ['project' => $project, 'task' => $task, 'file' => $file]) }}"
                   v-b-tooltip title="{{ __('projects/tasks.files.item.download') }}"
                   target="_blank">{{ str_replace($task->id . '/', '', $file->file) }}</a>
            </td>
            <td class="text-center">
                {{ $file->user->name }}
            </td>
            <td class="text-center">
                {{ $file->updated_at }}
            </td>
            @can('projectTask.update', $task)
                <td class="text-center">
                    @can('taskFile.delete', $file)
                        {{ Form::open(['route' => ['projects.tasks.files.destroy', 'project' => $project, 'task' => $task, 'file' => $file], 'method' => 'delete', 'class' => 'd-inline-block'])}}
                        <button type="submit" class="btn btn-danger btn-sm"
                                v-b-tooltip.hover title="{{ __('projects/tasks.files.item.delete') }}">
                            @materialicon('action', 'delete', 'white')
                        </button>
                        {{ Form::close() }}
                    @endcan
                </td>
            @endcan
        </tr>
    @endforeach
    </tbody>
</table>

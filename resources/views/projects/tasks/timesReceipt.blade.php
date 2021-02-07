<?php
/** @var \App\Models\ProjectTask $task */
/** @var \App\Models\Project $project */
/** @var \Illuminate\Database\Eloquent\Collection $times */
/** @var \App\Models\TaskTimes $time */
/** @var array $finances */
?>
<h2>{{ __('projects/tasks.timesReceipt.title') }} "{{ $task->title }}"</h2>
<p>
    {{ __('projects/tasks.timesReceipt.project') }}: <b>{{ $project->name }}</b><br />
    {{ __('projects/tasks.timesReceipt.taskCreate') }}: <b>{{ $task->created_at->toDateTimeString() }}</b><br />
    {{ __('projects/tasks.timesReceipt.date') }}: <b>{{ now()->toDateTimeString() }}</b><br />
    {{ __('projects/tasks.timesReceipt.total') }}: <b>@moneyFormat(array_sum($finances[$task->id]))</b><br />
</p>

<table style="width: 100%;" border="1">
    <thead>
        <tr>
            <th>{{ __('projects/tasks.timesReceipt.table.date') }}</th>
            <th>{{ __('projects/tasks.timesReceipt.table.time') }}</th>
            <th>{{ __('projects/tasks.timesReceipt.table.comment') }}</th>
            <th>{{ __('projects/tasks.timesReceipt.table.user') }}</th>
            <th>{{ __('projects/tasks.timesReceipt.table.price') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($times as $time)
            <tr>
                <td style="text-align: center">
                    {{ $time->updated_at->toDateTimeString() }}
                </td>
                <td style="text-align: center">
                    {{ $time->getTimeView() }}
                </td>
                <td>
                    {{ $time->comment }}
                </td>
                <td>
                    {{ $time->user->name }}
                </td>
                <td style="text-align: center">
                    @moneyFormat($finances[$task->id][$time->id])
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th style="text-align: right" colspan="4">{{ __('projects/tasks.timesReceipt.table.total') }}:</th>
            <th>@moneyFormat(array_sum($finances[$task->id]))</th>
        </tr>
    </tfoot>
</table>

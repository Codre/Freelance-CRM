<?php
/** @var \App\Models\TaskTimes|null $runTask */
/** @var bool $isClient */
?>
<div>
    @if(!empty($runTask))
        {!! Form::open([
            'route' => ['projects.tasks.run', 'project' => $runTask->task->project, 'task' => $runTask->task],
             'method' => 'POST',
             'class' => 'd-inline-block'
          ]) !!}
            <button class="btn btn-info btn-animate" type="submit" v-b-tooltip.hover title="{{ __('blocks/navbar.user.task_end') }}">
                @materialicon('av', 'pause', 'white')
            </button>
        {!! Form::close() !!}
    @endif
    @if ($isClient)
        <a href="{{ route('clients.show', ['client' => $user['id']]) }}" v-b-tooltip.hover title="{{ __('blocks/navbar.user.profile') }}">
            @materialicon('action', 'account_box')
        </a>
    @else
        <a class="btn btn-link" href="{{ route('staffs.show', ['staff' => $user['id']]) }}" v-b-tooltip.hover title="{{ __('blocks/navbar.user.profile') }}">
            @materialicon('action', 'account_box')
        </a>
    @endif
    <form method="POST" action="{{ route('logout') }}" class="d-inline">
        @csrf
        <button class="btn btn-link" type="submit" v-b-tooltip.hover title="{{ __('blocks/navbar.user.logout') }}">@materialicon('action', 'exit_to_app')</button>
    </form>
</div>

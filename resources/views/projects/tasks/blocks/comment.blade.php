<?php
/** @var \App\Http\Controllers\Projects\TaskComment $comment */
?>
<div class="card mb-2">
    <div class="card-body">
        <div class="text-muted float-right">{{ \Carbon\Carbon::parse($comment->create_at)->format('d.m.Y H:i:s')}}</div>
        <h5 class="card-title">{{ $comment->user->name }}</h5>
        <div>{!! $comment->text !!}</div>
    </div>
</div>

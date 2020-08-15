<?php
/** @var \App\Models\TaskComment $comment */
?>
<div class="mb-2">
    <div class="card  d-inline-block {{ $comment->user->id === $user['id'] ? 'float-right bg-light' : ''  }}"
         style="width: 80%">
        <div class="card-body">
            <div class="text-muted float-right">{{ $comment->created_at->toDateTimeString() }}</div>
            <h5 class="card-title">{{ $comment->user->name }}</h5>
            <div>{!! nl2br($comment->text) !!}</div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

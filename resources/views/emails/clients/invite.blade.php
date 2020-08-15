<?php
/** @var \App\Models\User $user */
/** @var array $routeParams */
?>
@extends('emails.layout')

@section('content')
    <p>{{ __('emails/clients.invite.hello', ['name' => $user->name]) }}</p>
    <p>{!! __('emails/clients.invite.message') !!}</p>

    <p style="text-align: center">
        <a href="{{ route('client.invite', $routeParams) }}" style="padding: 8px 30px; border-radius: 2px;text-transform: uppercase;text-decoration: none;transition: box-shadow .28s cubic-bezier(.4,0,.2,1); background-color: #009587;color: rgba(255,255,255,.84);font-size: 18px;
line-height: 1.33;margin-bottom: 5px;">{{ __('emails/clients.invite.link') }}</a><br />
    </p>
    <p><small>{{ __('emails/clients.invite.attention') }}</small></p>
    <p><small>{{ __('emails/clients.invite.mistake') }}</small></p>
@endsection


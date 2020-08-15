@extends('layouts.app')

@section('content')
    <h1>{{ $title }}</h1>
    <div class="card profile">
        {!! Form::open( ['route' => ['client.invite.store', $requestParams], 'method' => 'POST']) !!}
        <div class="card-body">
            {!! __('clients/invite.message', ['name' => $user->name, 'email' => $user->email]) !!}
            <div class="form-group">
                {!! Form::label('password', __('clients/invite.password.label')) !!}
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => __('clients/invite.password.placeholder')]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('password_confirmation', __('clients/invite.password.check.label')) !!}
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => __('clients/invite.password.check.placeholder')]) !!}
            </div>
        </div>
        <div class="card-footer">
            {!! Form::submit(__('clients/invite.submit'), ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@endsection

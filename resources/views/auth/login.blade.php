@extends('layouts.app')

@section('content')
    <div class="auth-block">
        <h1>{{ $title }}</h1>
        {!! Form::open(['route' => ['login'], 'method' => 'POST']) !!}
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        @materialicon('action', 'perm_identity', 'icon-sm')
                    </span>
                </div>
                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => __('auth/general.form.email.placeholder')]) !!}
            </div>
        </div>
        <div class="form-group mb-2">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        @materialicon('action', 'lock', 'icon-sm')
                    </span>
                </div>
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => __('auth/general.form.password.placeholder')]) !!}
            </div>
            @if (Route::has('password.request'))
                <div class="float-right">
                    <small class="form-text">
                        <a href="{{ route('password.request') }}">{{ __('auth/general.form.recover') }}</a>
                    </small>
                </div>
            @endif
        </div>
        {!! Form::hidden('remember', '1', ['id' => 'remember']) !!}
        {!! Form::submit(__('auth/general.form.submit'), ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
@endsection

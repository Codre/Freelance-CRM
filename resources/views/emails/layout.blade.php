<div style="box-shadow: 0 3px 10px rgba(0,0,0,.23),0 3px 10px rgba(0,0,0,.16);border-radius: 2px;padding: 10px; margin: 20px; background: white;">
    <img style="float: right; margin: 5px; max-width:200px; max-height: 100px" src="{{ asset('/img/logo.png') }}" />
    <h1 style="color: #333">{{ __('emails/layout.site.name') }}</h1>
    @yield('content')
    <div style="margin-top:20px">
        <small>{!! __('emails/layout.footer.info') !!}</small>
    </div>
</div>

@extends('layouts.app')

@section('content')
    @can('doc.company.create')
        <div class="float-right">
            <a href="{{ route('docs_company.create') }}" class="btn btn-primary m-1">{{ __('docs/company.index.create.company') }}</a>
        </div>
    @endcan
    <h1>{{ $title }}</h1>
@endsection

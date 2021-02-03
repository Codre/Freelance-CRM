@extends('layouts.app')

@section('content')
    @can('doc.company.create')
        <div class="float-right">
            <DocumentsCompanyCreatePopupBtn route="{{ route('docs_company.create') }}">@csrf</DocumentsCompanyCreatePopupBtn>
        </div>
    @endcan
    <h1>{{ $title }}</h1>
@endsection
<script>
    import DocumentsCompanyCreatePopupBtn from "../../js/components/DocumentsCompanyCreatePopupBtn";
    export default {
        components: {DocumentsCompanyCreatePopupBtn}
    }
</script>

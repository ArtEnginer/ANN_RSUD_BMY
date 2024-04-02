@extends('layouts.panel.main')

@section('content')
    <div class="stack-parent">
        <div class="stack-header">
            <div class="stack-title active" data-stack="main">LPLPO</div>
        </div>
        <div class="stack-body">
            <div class="stack-page" data-stack="main">
                <div id="lplpo"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/pages/panel/laporan.js') }}"></script>
@endpush

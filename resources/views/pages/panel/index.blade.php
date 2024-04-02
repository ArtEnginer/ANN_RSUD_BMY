@extends('layouts.panel.main')

@section('content')
    <div class="row">
        <div class="col m4 s12">
            <div class="card" style="border-radius: 2rem">
                <div class="card-content center">
                    <h4>Total Obat</h4>
                    <h1 class="counter" data-count="obat">0</h1>
                </div>
            </div>
        </div>
        <div class="col m4 s12">
            <div class="card" style="border-radius: 2rem">
                <div class="card-content center">
                    <h4>Total Prediksi</h4>
                    <h1 class="counter" data-count="prediksi">0</h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/pages/panel/dashboard.js') }}"></script>
@endpush

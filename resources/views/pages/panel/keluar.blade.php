@extends('layouts.panel.main')

@section('content')
    <div class="stack-parent">
        <div class="stack-header">
            <div class="stack-navbar" data-stack="form">
                <a href="#!" class="stack-navigator grey" data-stack="close.form" data-stack-prev="main"><i
                        class="material-icons">arrow_back</i></a>
            </div>
            <div class="stack-title" data-stack="form"></div>
            <div class="stack-title active" data-stack="main">Obat Keluar</div>
            <div class="stack-navbar active" data-stack="main">
                <a href="#!" class="stack-navigator" data-stack="open.form" data-stack-title="Tambah Obat Keluar"><i
                        class="material-icons">add</i></a>
            </div>
        </div>
        <div class="stack-body">
            <div class="stack-page" data-stack="main">
                <table class="highlight striped" style="width: 100%" id="keluar">
                    <thead>
                        <tr>
                            <th>Tanggal Keluar</th>
                            <th>Nama Obat</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="stack-page" data-stack="form">
                <div class="row">
                    <form class="col offset-m3 m6 s12" id="form-keluar" method="POST">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="tgl_keluar" name="tgl_keluar" type="text" class="datepicker validate" required>
                                <label for="tgl_keluar">Tanggal Keluar</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <select name="id_obat">
                                    <option value="" disabled selected>Pilih Obat</option>
                                    @foreach ($obat as $o)
                                        <option value="{{ $o->id }}">{{ $o->nama }}</option>
                                    @endforeach
                                </select>
                                <label>Obat Keluar</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="qty" name="qty" type="number" class="validate" required>
                                <label for="qty">Jumlah Obat Keluar</label>
                            </div>
                        </div
                        {{-- submit button --}}
                        <div class="row">
                            <div class="input-field col s12 center">
                                <button class="btn waves-effect waves-light" type="submit" name="action">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/pages/panel/keluar.js') }}"></script>
@endpush


@extends('layouts.panel.main')

@section('content')
    <div class="stack-parent">
        <div class="stack-header">
            <div class="stack-navbar" data-stack="form">
                <a href="#!" class="stack-navigator grey" data-stack="close.form" data-stack-prev="main"><i
                        class="material-icons">arrow_back</i></a>
            </div>
            <div class="stack-title" data-stack="form"></div>
            <div class="stack-title active" data-stack="main">Data Obat</div>
            <div class="stack-navbar active" data-stack="main">
                <a href="#!" class="stack-navigator" data-stack="open.form" data-stack-title="Tambah Data Obat"><i
                        class="material-icons">add</i></a>
            </div>
        </div>
        <div class="stack-body">
            <div class="stack-page" data-stack="main">
                <table class="highlight striped" style="width: 100%" id="obat">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jenis</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="stack-page" data-stack="form">
                <div class="row">
                    <form class="col offset-m3 m6 s12" id="form-obat" method="POST">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="nama" name="nama" type="text" class="validate" required>
                                <label for="nama">Nama Obat</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <select name="jenis">
                                    <option value="" disabled selected>Pilih jenis obat</option>
                                    <option value="Analgesik">Analgesik</option>
                                    <option value="Antibiotik">Antibiotik</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                <label>Jenis Obat</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="satuan" name="satuan" type="text" class="validate" required>
                                <label for="satuan">Satuan Obat</label>
                            </div>
                        </div>
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
    <script src="{{ asset('js/pages/panel/obat.js') }}"></script>
@endpush

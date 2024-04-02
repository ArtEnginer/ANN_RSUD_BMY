@extends('layouts.panel.main')

@section('content')
    <div class="stack-parent">
        <div class="stack-header">
            <div class="stack-navbar" data-stack="form">
                <a href="#!" class="stack-navigator grey" data-stack="close.form" data-stack-prev="main"><i
                        class="material-icons">arrow_back</i></a>
            </div>
            <div class="stack-navbar" data-stack="result">
                <a href="#!" class="stack-navigator grey" data-stack="close.result" data-stack-prev="main"><i
                        class="material-icons">arrow_back</i></a>
            </div>
            <div class="stack-title" data-stack="form"></div>
            <div class="stack-title active" data-stack="main">Proses Prediksi</div>
            <div class="stack-title" data-stack="result">Hasil Prediksi</div>
            @can('group', 'gudang')
                <div class="stack-navbar active" data-stack="main">
                    <a href="#!" class="stack-navigator" data-stack="open.form" data-stack-title="Tambah Prediksi Baru"><i
                            class="material-icons">add</i></a>
                </div>
            @endcan
        </div>
        <div class="stack-body">
            <div class="stack-page" data-stack="main">
                <table class="highlight striped" style="width: 100%" id="prediksi">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Obat</th>
                            <th>Neuron</th>
                            <th>Epoch</th>
                            <th>MAPE</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>
            @can('group', 'gudang')
                <div class="stack-page" data-stack="form">
                    <div class="row">
                        <form class="col offset-m3 m6 s12" id="form-prediksi" method="POST">
                            @csrf
                            <input type="hidden" name="id">
                            <div class="row">
                                <div class="input-field col s12">
                                    <select name="id_obat">
                                        <option value="" disabled selected>Pilih Obat</option>
                                        @foreach ($obat as $o)
                                            <option value="{{ $o->id }}">{{ $o->nama }}</option>
                                        @endforeach
                                    </select>
                                    <label>Obat</label>
                                </div>
                            </div>
                            <p class="center">Hidden Layer</p>
                            <div class="row">
                                <div class="input-field col s10">
                                    <input name="layer[]" type="number" class="validate" required>
                                </div>
                                <div class="input-field col s2">
                                    <button class="btn waves-effect waves-light red remove-layer" type="button"><i
                                            class="material-icons">delete</i></button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 center">
                                    <button class="btn waves-effect waves-light btn-layer" type="button" name="action">Tambah
                                        Layer</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="epoch" name="epoch" type="number" class="validate" required>
                                    <label for="epoch">Jumlah Epoch</label>
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
            @endcan
            <div class="stack-page" data-stack="result">
                <div class="container">
                    <div class="row">
                        <div class="col s12">
                            <h4 class="center">Data Riwayat Obat Keluar</h4>
                            <table class="responsive" id="result-data">
                                <thead>
                                    <tr>
                                        <th>-</th>
                                        <th>2001</th>
                                        <th>2021</th>
                                        <th>-</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Januari</th>
                                        <td>a</td>
                                    </tr>
                                    <tr>
                                        <th>Februari</th>
                                    </tr>
                                    <tr>
                                        <th>Maret</th>
                                    </tr>
                                    <tr>
                                        <th>April</th>
                                    </tr>
                                    <tr>
                                        <th>Mei</th>
                                    </tr>
                                    <tr>
                                        <th>Juni</th>
                                    </tr>
                                    <tr>
                                        <th>Juli</th>
                                    </tr>
                                    <tr>
                                        <th>Agustus</th>
                                    </tr>
                                    <tr>
                                        <th>September</th>
                                    </tr>
                                    <tr>
                                        <th>Oktober</th>
                                    </tr>
                                    <tr>
                                        <th>November</th>
                                    </tr>
                                    <tr>
                                        <th>Desember</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <h4 class="center">Dataset (x & y)</h4>
                            <table class="responsive" id="result-dataset">
                                <thead>
                                    <tr>
                                        <th>Data ke</th>
                                        <th>x1</th>
                                        <th>x2</th>
                                        <th>x3</th>
                                        <th>x4</th>
                                        <th>x5</th>
                                        <th>x6</th>
                                        <th>x7</th>
                                        <th>x8</th>
                                        <th>x9</th>
                                        <th>x10</th>
                                        <th>x11</th>
                                        <th>x12</th>
                                        <th>y</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <h4 class="center">Hasil Prediksi</h4>
                            <table class="responsive" id="result-predict">
                                <thead>
                                    <tr>
                                        <th>Epoch ke</th>
                                        <th>Nilai Aktual</th>
                                        <th>Nilai Prediksi</th>
                                        <th>Jarak</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <canvas class="col s12" id="result-mape">
                        </canvas>
                    </div>
                    <div class="row">
                        <canvas class="col s12" id="result-graph">
                        </canvas>
                    </div>
                    <div class="row">
                        <div class="col s12 center">
                            <h4>Prediksi Bulan Selanjutnya</h4>
                            <h3 class="green-text text-darken-2" id="forecast"></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/pages/panel/prediksi.js') }}"></script>
@endpush

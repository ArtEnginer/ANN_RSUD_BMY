@extends('layouts.panel.main')

@section('content')
    <div class="stack-parent">
        <div class="stack-header">
            <div class="stack-navbar" data-stack="form">
                <a href="#!" class="stack-navigator grey" data-stack="close.form" data-stack-prev="main"><i
                        class="material-icons">arrow_back</i></a>
            </div>
            <div class="stack-title" data-stack="form"></div>
            <div class="stack-title active" data-stack="main">Data Pengguna</div>
            <div class="stack-navbar active" data-stack="main">
                <a href="#!" class="stack-navigator" data-stack="open.form" data-stack-title="Tambah Data Pengguna"><i
                        class="material-icons">add</i></a>
            </div>
        </div>
        <div class="stack-body">
            <div class="stack-page" data-stack="main">
                <table class="highlight striped" style="width: 100%" id="pengguna">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Grup</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="stack-page" data-stack="form">
                <div class="row">
                    <form class="col offset-m3 m6 s12" id="form-pengguna" method="POST">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="name" name="name" type="text" class="validate" required>
                                <label for="name">Nama Pengguna</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="email" name="email" type="email" class="validate" required>
                                <label for="email">Email Pengguna (unik)</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <select name="group">
                                    <option value="" disabled selected>Pilih Level Pengguna</option>
                                    <option value="admin">Admin</option>
                                    <option value="gudang">Penanggung Jawab Gudang</option>
                                    <option value="kepala">Gudang Puskesmas</option>
                                </select>
                                <label>Group Pengguna</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="password" name="password" type="password" class="validate" required>
                                <label for="password">Kata sandi</label>
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
    <script src="{{ asset('js/pages/panel/pengguna.js') }}"></script>
@endpush

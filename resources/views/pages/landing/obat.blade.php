@extends('layouts.landing.main')

@section('content')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">Data Obat</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="row" id="obats">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(async function() {
            await cloud.add(baseUrl + '/api/v2/obat', {
                name: "obat"
            });
            $('#obats').empty();
            cloud.get("obat").forEach(obat => {
                $('#obats').append(`<div class="col s6">
                            <div class="card">
                                <div class="card-image" style="padding-top: 100%; position: relative;">
                                    <img src="{{ url('img/obat1.jpg') }}" alt="Gambar Obat"
                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div class="card-content">
                                    <table>
                                        <tr>
                                            <th>Nama Obat</th>
                                            <td>: ${obat.nama}</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Obat</th>
                                            <td>: ${obat.jenis}</td>
                                        </tr>
                                        <tr>
                                            <th>Stok</th>
                                            <td>: ${obat.stok} ${obat.satuan}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>`);
            })
        })
    </script>
@endpush

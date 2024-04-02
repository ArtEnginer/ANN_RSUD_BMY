<div class="sidebar-top">
    <img src="{{ asset('img/logo/logo.png') }}" alt="logo" width="80">
    <p>RSUD<br>BUMIAYU</p>
</div>
<h5 class="center">{{ Auth::user()->name }}</h5>
<div class="menu-wrapper">
    <a href="{{ url('/panel') }}" class="navbar-item sidebar-menu" data-page="panel-dashboard">Dashboard</a>
    @can('group', 'admin')
    <a href="{{ url('/panel/obat') }}" class="navbar-item sidebar-menu" data-page="panel-obat">Data Obat</a>
    <a href="{{ url('/panel/prediksi') }}" class="navbar-item sidebar-menu" data-page="panel-prediksi">Proses
        Prediksi</a>
    <a href="{{ url('/panel/masuk') }}" class="navbar-item sidebar-menu" data-page="panel-masuk">Obat Masuk</a>
    <a href="{{ url('/panel/keluar') }}" class="navbar-item sidebar-menu" data-page="panel-keluar">Obat Keluar</a>
    <a href="{{ url('/panel/laporan') }}" class="navbar-item sidebar-menu" data-page="panel-laporan">LPLPO</a>
    <a href="{{ url('/panel/pengguna') }}" class="navbar-item sidebar-menu" data-page="panel-pengguna">Data Pengguna</a>
    @endcan
    @can('group', 'gudang')
    <a href="{{ url('/panel/obat') }}" class="navbar-item sidebar-menu" data-page="panel-obat">Data Obat</a>
    <a href="{{ url('/panel/prediksi') }}" class="navbar-item sidebar-menu" data-page="panel-prediksi">Proses
        Prediksi</a>
    <a href="{{ url('/panel/masuk') }}" class="navbar-item sidebar-menu" data-page="panel-masuk">Obat Masuk</a>
    <a href="{{ url('/panel/keluar') }}" class="navbar-item sidebar-menu" data-page="panel-keluar">Obat Keluar</a>
    <a href="{{ url('/panel/laporan') }}" class="navbar-item sidebar-menu" data-page="panel-laporan">LPLPO</a>
    @endcan
    @can('group', 'kepala')
    <a href="{{ url('/panel/laporan') }}" class="navbar-item sidebar-menu" data-page="panel-laporan">LPLPO</a>
    @endcan
</div>
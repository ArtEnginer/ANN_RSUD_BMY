<!DOCTYPE html>
<html>

<head>
    <!--Import Google Icon Font-->
    @section('title', 'Gudang Farmasi')
    @include('layouts/head')
    @stack('head')
    @include('layouts/style')
    <link type="text/css" rel="stylesheet" href="{{ asset('css/handsontable.full.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('css/pages/panel.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
</head>

<body>
    <div class="parent-wrapper">
        <div class="sidebar-wrapper">
            @include("layouts.panel.sidebar")
        </div>
        <div class="sidebar-overlay"></div>
        <div class="content-wrapper">
            <div class="topbar-wrapper">
                <div>
                    <a href="#!" class="menu-toggler"><i class="material-icons">menu</i></a>
                </div>
                <a href="{{ route('logout') }}" class="btn-logout">Logout</a>
            </div>
            <div class="content">
                @yield('content', 'Isi Konten')
            </div>
        </div>
    </div>
    <!--JavaScript at end of body for optimized loading-->
    @include('layouts/script')
    <script src="{{ asset('js/chart.umd.min.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/handsontable.full.min.js') }}"></script>
    <script src="{{ asset('js/pages/panel/main.js') }}"></script>
    <script>
        const page = '{{ $page ?? 'landing-home' }}';
        const baseUrl = '{{ url('/') }}';
    </script>
    @stack('scripts')
</body>

</html>

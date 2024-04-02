<!DOCTYPE html>
<html>

<head>
    <!--Import Google Icon Font-->
    @section('title', 'Gudang Farmasi')
    @include('layouts/head')
    @stack('head')
    @include('layouts/style')
    <link type="text/css" rel="stylesheet" href="{{ asset('css/pages/landing.css') }}" />
    @stack('styles')
</head>

<body>
    <div class="parent-wrapper">
        <div class="header-wrapper">
            <h4>
                RSUD BUMIAYU
            </h4>
            @include('layouts.landing.navbar')
        </div>
        <div class="content-wrapper">
            @yield('content', 'Isi Konten')
        </div>
    </div>
    <!--JavaScript at end of body for optimized loading-->
    @include('layouts/script')
    <script>
        const page = '{{ $page ?? "landing-home" }}';
        const baseUrl = '{{ url("/") }}';
    </script>
    @stack('scripts')
</body>

</html>
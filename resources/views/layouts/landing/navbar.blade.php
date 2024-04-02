<div class="navbar-wrapper">
    <a href="{{ url('/') }}" class="navbar-item" data-page="landing-home">Home</a>
    <a href="{{ url('/about') }}" class="navbar-item" data-page="landing-about">About</a>
    <a href="{{ url('/obat') }}" class="navbar-item" data-page="landing-obat">Data Obat</a>
    @auth
        <a href="{{ url('/panel') }}" class="navbar-item">Dashboard</a>
    @endauth
    @guest
        <a href="{{ url('/login') }}" class="navbar-item">Log in</a>
    @endguest
</div>

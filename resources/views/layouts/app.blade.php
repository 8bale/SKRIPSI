{{-- Layout Utama Aplikasi Inventory Spare PT Garuda Yamato Steel --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mechanic Engineer Inventory | PT Garuda Yamato Steel')</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo-gys.png') }}">

    {{-- Google Font: Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap 5.3 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- CSS Kustom Aplikasi --}}
    <link rel="stylesheet" href="{{ asset('css/barang.css') }}">

    {{-- Slot untuk CSS tambahan per halaman --}}
    @stack('styles')
</head>

<body>

    {{-- ===== NAVBAR ATAS ===== --}}
    <nav class="navbar navbar-expand-lg navbar-app sticky-top py-2">
        <div class="container-xl">

            {{-- Brand / Logo --}}
            <a class="navbar-brand d-flex align-items-center gap-3 py-1 me-4" href="{{ route('barang.index') }}">
                <img src="{{ asset('images/logo-gys.png') }}" alt="Logo PT Garuda Yamato Steel" class="brand-logo-img">
                <div class="brand-divider d-none d-sm-block"></div>
                <div class="d-flex flex-column">
                    <span class="brand-title">Garuda Yamato Steel</span>
                    <span class="brand-subtitle">Mechanic Engineer Inventory</span>
                </div>
            </a>

            {{-- Mobile Toggler --}}
            <button class="navbar-toggler border-0 p-1 text-secondary" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarMainContent" aria-controls="navbarMainContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fa-solid fa-bars fs-5"></i>
            </button>

            {{-- Navbar Menu Links & User Profile --}}
            <div class="collapse navbar-collapse mt-2 mt-lg-0" id="navbarMainContent">
                @auth
                    {{-- Nav Links --}}
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
                        <li class="nav-item">
                            <a class="nav-link-gys {{ request()->routeIs('barang.*') ? 'active' : '' }}"
                                href="{{ route('barang.index') }}">
                                <i class="fa-solid fa-boxes-stacked"></i>
                                <span>Data Barang</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-gys {{ request()->routeIs('rack.*') ? 'active' : '' }}"
                                href="{{ route('rack.index') }}">
                                <i class="fa-solid fa-layer-group"></i>
                                <span>Titik Rak</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-gys {{ request()->routeIs('pengurangan.*') ? 'active' : '' }}"
                                href="{{ route('pengurangan.index') }}">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                                <span>{{ auth()->user()->isAdmin() ? 'Log Riwayat' : 'Riwayat Pengambilan' }}</span>
                            </a>
                        </li>
                    </ul>

                    {{-- User Profile & Actions --}}
                    <div class="d-flex align-items-center gap-3 ms-lg-auto pt-2 pt-lg-0 border-top border-lg-top-0">
                        {{-- Badge mode halaman (opsional, diisi tiap view) --}}
                        @if (View::hasSection('nav_badge'))
                            <div class="d-none d-xl-flex">
                                @yield('nav_badge')
                            </div>
                        @endif

                        {{-- User Avatar Pill --}}
                        <div class="user-avatar-pill">
                            <div class="user-avatar-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="d-flex flex-column text-start pe-1">
                                <span class="fw-bold text-dark lh-1" style="font-size: 12.5px;">{{ auth()->user()->name }}</span>
                                @if (auth()->user()->isAdmin())
                                    <span class="text-danger fw-semibold" style="font-size: 10.5px;">
                                        <i class="fa-solid fa-shield-halved me-1"></i> Administrator
                                    </span>
                                @else
                                    <span class="text-primary fw-semibold" style="font-size: 10.5px;">
                                        <i class="fa-solid fa-wrench me-1"></i> Staff Mekanik
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Tombol Logout --}}
                        <form action="{{ route('logout') }}" method="POST" class="d-inline m-0">
                            @csrf
                            <button type="submit"
                                class="btn btn-outline-danger btn-sm d-inline-flex align-items-center gap-1 px-2.5 py-1.5"
                                style="font-size: 12px; font-weight: 600; border-radius: 8px;"
                                title="Keluar dari Sistem">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span class="d-none d-sm-inline">Logout</span>
                            </button>
                        </form>
                    </div>
                @endauth
            </div>

        </div>
    </nav>

    {{-- ===== KONTEN UTAMA ===== --}}
    <main class="main-content container-xl py-4">
        @yield('content')
    </main>

    {{-- ===== FOOTER ELEGAN ===== --}}
    <footer class="app-footer">
        <div class="container-xl d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
            <div class="d-flex align-items-center gap-2">
                <span class="status-indicator-dot" title="Server Online"></span>
                <span>
                    Sistem Inventaris Spare &copy; {{ date('Y') }} &mdash; <strong>PT Garuda Yamato Steel</strong>
                </span>
            </div>
            <div class="d-flex align-items-center gap-2 text-muted">
                <i class="fa-solid fa-screwdriver-wrench text-secondary" style="font-size: 11px;"></i>
                <span>Mechanic Engineering Workshop</span>
            </div>
        </div>
    </footer>

    {{-- Bootstrap Bundle JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    {{-- Slot untuk script tambahan per halaman --}}
    @stack('scripts')

</body>

</html>

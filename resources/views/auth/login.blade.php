{{-- filepath: resources/views/auth/login.blade.php --}}
@extends('layouts.guest')

@section('title', 'Login - Mechanic Engineer Inventory | PT Garuda Yamato Steel')

@section('content')
    <div class="login-wrapper">
        <div class="login-card">

            {{-- Header Kartu Login --}}
            <div class="login-header">
                <img src="{{ asset('images/logo-gys.png') }}" alt="Logo PT Garuda Yamato Steel"
                    class="brand-logo-img mx-auto mb-3" style="height: 54px;">
                <h4 class="fw-bold text-dark mb-1" style="font-size: 21px; letter-spacing: -0.02em;">Inventory Spare Parts</h4>
                <p class="text-secondary small mb-0 fw-medium">
                    PT Garuda Yamato Steel &bull; Mechanic Engineer
                </p>
            </div>

            {{-- Body Kartu Login --}}
            <div class="login-body">

                {{-- Flash Messages --}}
                @if (session('success'))
                    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-2 mb-4 py-2.5 px-3 rounded-3" role="alert">
                        <i class="fa-solid fa-circle-check text-success fs-5"></i>
                        <div class="small fw-semibold">{{ session('success') }}</div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center gap-2 mb-4 py-2.5 px-3 rounded-3" role="alert">
                        <i class="fa-solid fa-circle-exclamation text-danger fs-5"></i>
                        <div class="small fw-semibold">{{ session('error') }}</div>
                    </div>
                @endif

                {{-- Form Login --}}
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold text-dark small mb-1.5">
                            Alamat Email <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-icon-box">
                                <i class="fa-solid fa-envelope"></i>
                            </span>
                            <input type="email"
                                class="form-control form-control-custom @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}"
                                placeholder="nama@gmail.com" required autofocus>
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1.5 fw-medium">
                                <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold text-dark small mb-1.5">
                            Kata Sandi <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-icon-box">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password"
                                class="form-control form-control-custom @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="••••••••" required>
                            <button class="btn btn-outline-secondary border-start-0" type="button" id="btnTogglePassword"
                                style="border-color: #cbd5e1; border-top-right-radius: 8px; border-bottom-right-radius: 8px;"
                                title="Tampilkan / Sembunyikan Kata Sandi">
                                <i class="fa-regular fa-eye text-muted" id="iconTogglePassword"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1.5 fw-medium">
                                <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }} style="cursor: pointer;">
                            <label class="form-check-label text-secondary small user-select-none" for="remember" style="cursor: pointer;">
                                Ingat sesi login saya
                            </label>
                        </div>
                        <span class="badge bg-light text-secondary border px-2 py-1" style="font-size: 11px;">
                            <i class="fa-solid fa-shield-halved text-success me-1"></i> Secure Session
                        </span>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="btn btn-primary w-100 py-2.5 fw-bold d-inline-flex align-items-center justify-content-center gap-2 shadow-sm"
                        style="font-size: 14px; letter-spacing: 0.02em;">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span>MASUK KE SISTEM</span>
                    </button>
                </form>

                <hr class="my-4 border-light-subtle">

                {{-- Info Akun Demo / Pengujian --}}
                <div class="demo-box text-secondary">
                    <div class="fw-bold text-dark d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-users text-primary"></i>
                            <span style="font-size: 12.5px;">Akun Pengujian (Klik untuk Isi Cepat):</span>
                        </div>
                        <span class="badge bg-white text-secondary border" style="font-size: 10px;">5 Akun Aktif</span>
                    </div>

                    <div class="d-flex flex-column gap-1.5" style="font-size: 11.5px;">
                        @php
                            $demoAccounts = [
                                ['role' => 'Admin',    'color' => 'danger',    'email' => 'admin@gmail.com',    'pass' => 'admin123'],
                                ['role' => 'Regu 1',   'color' => 'warning',   'email' => 'regu1@gmail.com',    'pass' => 'regu123'],
                                ['role' => 'Regu 2',   'color' => 'primary',   'email' => 'regu2@gmail.com',    'pass' => 'regu2123'],
                                ['role' => 'Regu 3',   'color' => 'info',      'email' => 'regu3@gmail.com',    'pass' => 'regu3123'],
                                ['role' => 'Non-Shift','color' => 'secondary', 'email' => 'nonshift@gmail.com', 'pass' => 'nonshift123'],
                            ];
                        @endphp

                        @foreach ($demoAccounts as $i => $acc)
                            <div class="demo-account-item d-flex justify-content-between align-items-center py-1.5 px-2 rounded-2"
                                style="cursor: pointer;"
                                onclick="fillDemo('{{ $acc['email'] }}', '{{ $acc['pass'] }}')"
                                title="Klik untuk otomatis mengisi akun {{ $acc['role'] }}">
                                <div class="d-flex align-items-center gap-1.5">
                                    <span class="badge bg-{{ $acc['color'] }}-subtle text-{{ $acc['color'] === 'warning' || $acc['color'] === 'info' ? 'dark' : $acc['color'] }} border border-{{ $acc['color'] }}-subtle"
                                        style="font-size: 10px; min-width: 62px; text-align: center;">
                                        {{ $acc['role'] }}
                                    </span>
                                    <span class="text-dark fw-medium">{{ $acc['email'] }}</span>
                                </div>
                                <span class="text-muted font-monospace fw-semibold small">
                                    <i class="fa-solid fa-arrow-right-to-bracket text-primary opacity-50 me-1"></i>
                                    {{ $acc['pass'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-muted mt-2 pt-2 border-top" style="font-size: 11px;">
                        <i class="fa-solid fa-circle-info me-1 text-primary"></i>
                        <strong>Tips Sidang:</strong> Klik salah satu akun di atas untuk mengisi formulir login secara instan.
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Toggle Password Visibility
    document.addEventListener('DOMContentLoaded', function () {
        const btnToggle = document.getElementById('btnTogglePassword');
        const passwordInput = document.getElementById('password');
        const iconToggle = document.getElementById('iconTogglePassword');

        if (btnToggle && passwordInput && iconToggle) {
            btnToggle.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                iconToggle.classList.toggle('fa-eye', !isPassword);
                iconToggle.classList.toggle('fa-eye-slash', isPassword);
            });
        }
    });

    // Quick Autofill Demo
    function fillDemo(email, pass) {
        const emailInput = document.getElementById('email');
        const passInput  = document.getElementById('password');
        if (emailInput && passInput) {
            emailInput.value = email;
            passInput.value  = pass;
            emailInput.focus();
        }
    }
</script>
@endpush

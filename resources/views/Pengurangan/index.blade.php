{{-- filepath: resources/views/Pengurangan/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Log Riwayat Pengambilan - Mechanic Engineer Inventory | PT Garuda Yamato Steel')

@section('content')
    {{-- Breadcrumb --}}
    <ul class="breadcrumb-custom">
        <li>
            <a href="{{ route('barang.index') }}" class="d-inline-flex align-items-center gap-1.5">
                <i class="fa-solid fa-house"></i>
                <span>Beranda</span>
            </a>
        </li>
        <li class="separator"><i class="fa-solid fa-chevron-right"></i></li>
        <li class="active">{{ auth()->user()->isAdmin() ? 'Log Riwayat Pengambilan' : 'Riwayat Pengambilan Saya' }}</li>
    </ul>

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h1 class="page-title mb-0">
                    {{ auth()->user()->isAdmin() ? 'Log Riwayat Pengambilan Suku Cadang' : 'Riwayat Pengambilan Suku Cadang Saya' }}
                </h1>
                @if (auth()->user()->isAdmin())
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1 rounded-pill fw-bold" style="font-size: 11px;">
                        <i class="fa-solid fa-shield-halved me-1"></i> Seluruh Mekanik
                    </span>
                @else
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 rounded-pill fw-bold" style="font-size: 11px;">
                        <i class="fa-solid fa-user me-1"></i> Data Pribadi
                    </span>
                @endif
            </div>
            <p class="page-subtitle">
                {{ auth()->user()->isAdmin()
                    ? 'Catatan audit pengambilan spare part oleh seluruh tim mekanik untuk perbaikan dan perawatan mesin workshop.'
                    : 'Daftar suku cadang yang telah Anda ambil dari gudang beserta status shift dan peruntukan mesin.' }}
            </p>
        </div>
        <a href="{{ route('barang.index') }}"
            class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 px-3.5 py-2 fw-semibold shadow-sm"
            style="font-size: 13px;">
            <i class="fa-solid fa-boxes-stacked text-primary"></i>
            <span>Katalog Suku Cadang</span>
        </a>
    </div>

    {{-- Flash Alert --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2.5 mb-4 py-3 px-3.5 rounded-3" role="alert">
            <i class="fa-solid fa-circle-check fs-5 text-success"></i>
            <div class="fw-semibold text-dark">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2.5 mb-4 py-3 px-3.5 rounded-3" role="alert">
            <i class="fa-solid fa-circle-exclamation fs-5 text-danger"></i>
            <div class="fw-semibold text-dark">{{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    {{-- KPI Ringkasan --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card h-100 kpi-card">
                <div class="card-body d-flex align-items-center gap-3 p-3.5">
                    <div class="kpi-icon-wrapper" style="background-color: #fef2f2; color: #dc2626;">
                        <i class="fa-solid fa-arrow-trend-down"></i>
                    </div>
                    <div>
                        <div class="kpi-label">Total Transaksi</div>
                        <div class="kpi-value">{{ number_format($riwayats->count(), 0, ',', '.') }}</div>
                        <div class="kpi-subtext">
                            <i class="fa-solid fa-clock-rotate-left text-danger" style="font-size: 9px;"></i>
                            Kali Pengambilan
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card h-100 kpi-card">
                <div class="card-body d-flex align-items-center gap-3 p-3.5">
                    <div class="kpi-icon-wrapper" style="background-color: #fffbeb; color: #d97706;">
                        <i class="fa-solid fa-boxes-packing"></i>
                    </div>
                    <div>
                        <div class="kpi-label">Total Unit Keluar</div>
                        <div class="kpi-value">{{ number_format($totalItemDiambil, 0, ',', '.') }}</div>
                        <div class="kpi-subtext">
                            <i class="fa-solid fa-cubes-stacked text-warning" style="font-size: 9px;"></i>
                            Unit Suku Cadang Terpakai
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Riwayat --}}
    <div class="card main-data-card">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div class="search-gys-wrapper">
                <i class="fa-solid fa-magnifying-glass search-gys-icon"></i>
                <input type="text" id="logSearchInput" class="search-gys-input"
                    placeholder="Cari part, mekanik, shift, atau catatan..." aria-label="Cari Log Riwayat">
            </div>
            <div class="d-flex align-items-center gap-2 small text-secondary">
                <span class="fw-medium">Total Catatan:</span>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-bold px-2.5 py-1 rounded-pill" id="logRowCount">
                    {{ $riwayats->count() }} Data
                </span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table-gys align-middle mb-0" id="logTable">
                <thead>
                    <tr>
                        <th class="ps-3 text-center" style="width: 50px;">No</th>
                        <th style="width: 155px;">Waktu & Tanggal</th>
                        <th>Suku Cadang Terpakai</th>
                        <th style="width: 140px;">Jumlah Diambil</th>
                        <th>Mekanik Pengambil</th>
                        <th style="width: 130px;">Shift</th>
                        <th>Peruntukan / Keperluan</th>
                        @if (auth()->user()->isAdmin())
                            <th style="width: 140px;">Akun Login</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayats as $index => $riwayat)
                        <tr class="log-row">
                            <td class="ps-3 text-center text-muted fw-bold" style="font-size: 12px;">{{ $index + 1 }}</td>

                            {{-- Waktu & Tanggal --}}
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark" style="font-size: 12.5px;">
                                        {{ $riwayat->tanggal_ambil ? $riwayat->tanggal_ambil->format('d/m/Y') : '-' }}
                                    </span>
                                    <span class="text-muted" style="font-size: 11px;">
                                        <i class="fa-regular fa-clock me-1 text-secondary"></i>
                                        {{ $riwayat->tanggal_ambil ? $riwayat->tanggal_ambil->format('H:i') . ' WIB' : '-' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Spare Part --}}
                            <td>
                                <div class="d-flex align-items-center gap-2.5">
                                    <div class="item-icon-box" style="width: 34px; height: 34px; background-color: #f1f5f9; color: var(--gys-primary); border: none;">
                                        <i class="fa-solid fa-box" style="font-size: 13px;"></i>
                                    </div>
                                    <div>
                                        <div class="item-title">
                                            {{ $riwayat->barang?->nama_barang ?? 'Barang Telah Dihapus' }}
                                        </div>
                                        <div class="text-muted" style="font-size: 11px;">
                                            Rak: <strong class="text-secondary">{{ $riwayat->barang?->rack?->nama_rack ?? '-' }}</strong>
                                            &bull; Area: {{ $riwayat->barang?->rack?->lokasi ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Jumlah Diambil --}}
                            <td>
                                <span class="badge-stock badge-stock-danger" style="font-size: 12px; font-weight: 700;">
                                    -{{ $riwayat->jumlah }} Unit
                                </span>
                            </td>

                            {{-- Nama Mekanik --}}
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="item-icon-box" style="width: 26px; height: 26px; background-color: #eff6ff; color: var(--gys-primary); border-radius: 50%; font-size: 10px;">
                                        <i class="fa-solid fa-user-gear"></i>
                                    </div>
                                    <span class="fw-bold text-dark" style="font-size: 12.5px;">{{ $riwayat->nama_mekanik }}</span>
                                </div>
                            </td>

                            {{-- Shift --}}
                            <td>
                                <span class="badge bg-light text-dark border px-2.5 py-1 rounded-pill" style="font-size: 11.5px; font-weight: 600;">
                                    <i class="fa-regular fa-clock me-1 text-primary"></i>
                                    {{ $riwayat->shift ?: 'Non-Shift' }}
                                </span>
                            </td>

                            {{-- Keperluan / Note --}}
                            <td>
                                <span class="text-secondary small fw-medium">{{ $riwayat->keperluan ?: '-' }}</span>
                            </td>

                            {{-- Akun Login (Admin only) --}}
                            @if (auth()->user()->isAdmin())
                                <td>
                                    <span class="badge bg-white text-secondary border px-2 py-1" style="font-size: 11px;">
                                        <i class="fa-solid fa-circle-user text-primary me-1"></i>
                                        {{ $riwayat->user?->name ?? 'User Terhapus' }}
                                    </span>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isAdmin() ? 8 : 7 }}" class="p-0">
                                <div class="table-empty-box">
                                    <div class="table-empty-icon">
                                        <i class="fa-solid fa-clipboard-check"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">Belum Ada Riwayat Pengambilan</h6>
                                    <p class="text-secondary small mb-3">Belum ada suku cadang yang dicatat pengambilannya di sistem.</p>
                                    <a href="{{ route('barang.index') }}" class="btn btn-primary btn-sm px-3.5 py-2 fw-semibold">
                                        <i class="fa-solid fa-boxes-stacked me-1"></i> Buka Katalog Barang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Pencarian instan di tabel riwayat pengambilan
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('logSearchInput');
        const tableRows   = document.querySelectorAll('#logTable tbody tr.log-row');
        const counter     = document.getElementById('logRowCount');

        if (searchInput && tableRows.length) {
            searchInput.addEventListener('input', function () {
                const query = this.value.toLowerCase().trim();
                let visible = 0;

                tableRows.forEach(function (row) {
                    const match = row.innerText.toLowerCase().includes(query);
                    row.style.display = match ? '' : 'none';
                    if (match) visible++;
                });

                if (counter) {
                    counter.textContent = visible + ' Data';
                }
            });
        }
    });
</script>
@endpush

{{-- filepath: resources/views/barang/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Stok Spare Part - Mechanic Engineer Inventory | PT Garuda Yamato Steel')

@section('content')
    {{-- Breadcrumb --}}
    <ul class="breadcrumb-custom">
        <li class="active d-inline-flex align-items-center gap-1.5">
            <i class="fa-solid fa-house"></i>
            <span>Beranda</span>
        </li>
        <li class="separator"><i class="fa-solid fa-chevron-right"></i></li>
        <li class="active">Katalog Spare Part</li>
    </ul>

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="page-title">Katalog & Stok Spare Part Mekanik</h1>
            <p class="page-subtitle">Monitoring ketersediaan suku cadang dan lokasi penyimpanan workshop PT Garuda Yamato Steel.</p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            @if (auth()->user()->isAdmin())
                <a href="{{ route('barang.create') }}"
                    class="btn btn-primary d-inline-flex align-items-center gap-2 px-3 py-2 fw-semibold shadow-sm"
                    style="font-size: 13px;">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah Barang</span>
                </a>
                <a href="{{ route('rack.index') }}"
                    class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 px-3 py-2 fw-semibold shadow-sm"
                    style="font-size: 13px;">
                    <i class="fa-solid fa-layer-group text-primary"></i>
                    <span>Kelola Rak</span>
                </a>
                <a href="{{ route('pengurangan.index') }}"
                    class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 px-3 py-2 fw-semibold shadow-sm"
                    style="font-size: 13px;">
                    <i class="fa-solid fa-clock-rotate-left text-warning"></i>
                    <span>Log Riwayat</span>
                </a>
            @else
                <a href="{{ route('pengurangan.index') }}"
                    class="btn btn-primary d-inline-flex align-items-center gap-2 px-3 py-2 fw-semibold shadow-sm"
                    style="font-size: 13px;">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Riwayat Pengambilan Saya</span>
                </a>
                <a href="{{ route('rack.index') }}"
                    class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 px-3 py-2 fw-semibold shadow-sm"
                    style="font-size: 13px;">
                    <i class="fa-solid fa-layer-group text-primary"></i>
                    <span>Lihat Rak</span>
                </a>
            @endif
        </div>
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

    {{-- KPI Summary Cards --}}
    @php
        $totalJenis = $barangs->count();
        $totalStok  = $barangs->sum('stock');
        $stokMenipis = $barangs->where('stock', '<=', 10)->count();
        $totalRak   = $barangs->pluck('id_rack')->unique()->filter()->count();
    @endphp

    <div class="row g-3 mb-4">
        {{-- KPI: Total Jenis Barang --}}
        <div class="col-sm-6 col-lg-3">
            <div class="card h-100 kpi-card">
                <div class="card-body d-flex align-items-center gap-3 p-3.5">
                    <div class="kpi-icon-wrapper" style="background-color: #eff6ff; color: #1d4ed8;">
                        <i class="fa-solid fa-box-archive"></i>
                    </div>
                    <div>
                        <div class="kpi-label">Total Jenis Part</div>
                        <div class="kpi-value">{{ number_format($totalJenis, 0, ',', '.') }}</div>
                        <div class="kpi-subtext">
                            <i class="fa-solid fa-circle-check text-primary" style="font-size: 9px;"></i>
                            Item terdaftar
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KPI: Total Unit Fisik --}}
        <div class="col-sm-6 col-lg-3">
            <div class="card h-100 kpi-card">
                <div class="card-body d-flex align-items-center gap-3 p-3.5">
                    <div class="kpi-icon-wrapper" style="background-color: #ecfdf5; color: #059669;">
                        <i class="fa-solid fa-cubes-stacked"></i>
                    </div>
                    <div>
                        <div class="kpi-label">Akumulasi Unit Fisik</div>
                        <div class="kpi-value">{{ number_format($totalStok, 0, ',', '.') }}</div>
                        <div class="kpi-subtext">
                            <i class="fa-solid fa-shield text-success" style="font-size: 9px;"></i>
                            Total unit tersedia
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KPI: Stok Menipis --}}
        <div class="col-sm-6 col-lg-3">
            <div class="card h-100 kpi-card">
                <div class="card-body d-flex align-items-center gap-3 p-3.5">
                    <div class="kpi-icon-wrapper" style="background-color: #fffbeb; color: #d97706;">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <div class="kpi-label">Perlu Restock</div>
                        <div class="kpi-value">{{ number_format($stokMenipis, 0, ',', '.') }}</div>
                        <div class="kpi-subtext">
                            <i class="fa-solid fa-circle-exclamation text-warning" style="font-size: 9px;"></i>
                            Stok &le; 10 unit
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KPI: Rak Terpakai --}}
        <div class="col-sm-6 col-lg-3">
            <div class="card h-100 kpi-card">
                <div class="card-body d-flex align-items-center gap-3 p-3.5">
                    <div class="kpi-icon-wrapper" style="background-color: #faf5ff; color: #7e22ce;">
                        <i class="fa-solid fa-warehouse"></i>
                    </div>
                    <div>
                        <div class="kpi-label">Titik Rak Aktif</div>
                        <div class="kpi-value">{{ number_format($totalRak, 0, ',', '.') }}</div>
                        <div class="kpi-subtext">
                            <i class="fa-solid fa-location-dot text-purple" style="font-size: 9px;"></i>
                            Zonasi gudang aktif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Data Barang --}}
    <div class="card main-data-card">

        {{-- Toolbar & Pencarian --}}
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div class="search-gys-wrapper">
                <i class="fa-solid fa-magnifying-glass search-gys-icon"></i>
                <input type="text" id="tableSearchInput" class="search-gys-input"
                    placeholder="Cari suku cadang, rak, atau spesifikasi..." aria-label="Cari Suku Cadang">
            </div>
            <div class="d-flex align-items-center gap-2 small text-secondary">
                <span class="fw-medium">Total Menampilkan:</span>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-bold px-2.5 py-1 rounded-pill" id="activeRowCount">
                    {{ $barangs->count() }} Item
                </span>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="table-responsive">
            <table class="table-gys align-middle mb-0" id="inventoryTable">
                <thead>
                    <tr>
                        <th class="ps-3 text-center" style="width: 55px;">No</th>
                        <th>Nama Suku Cadang / Material</th>
                        <th style="width: 175px;">Stok Gudang</th>
                        <th style="width: 185px;">Posisi Rak</th>
                        <th style="width: 210px;">Area / Lokasi</th>
                        <th class="text-center pe-3" style="width: {{ auth()->user()->isAdmin() ? '220px' : '110px' }};">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barangs as $index => $barang)
                        <tr class="inventory-row">
                            <td class="ps-3 text-center text-muted fw-bold" style="font-size: 12px;">{{ $index + 1 }}</td>

                            {{-- Nama & Deskripsi Barang --}}
                            <td>
                                <div class="item-title">{{ $barang->nama_barang }}</div>
                                @if ($barang->deskripsi)
                                    <div class="item-desc text-truncate" style="max-width: 340px;" title="{{ $barang->deskripsi }}">
                                        <i class="fa-solid fa-info-circle text-primary opacity-75 me-1" style="font-size: 10px;"></i>
                                        {{ $barang->deskripsi }}
                                    </div>
                                @else
                                    <div class="text-muted" style="font-size: 11px;">Belum ada spesifikasi teknis</div>
                                @endif
                            </td>

                            {{-- Jumlah Stok + Badge Status --}}
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bold text-dark fs-6">{{ $barang->stock }}</span>
                                    @if ($barang->stock > 10)
                                        <span class="badge-stock badge-stock-safe">Tersedia</span>
                                    @elseif ($barang->stock > 0)
                                        <span class="badge-stock badge-stock-warning">Menipis</span>
                                    @else
                                        <span class="badge-stock badge-stock-danger">Habis</span>
                                    @endif
                                </div>
                            </td>

                            {{-- Rak --}}
                            <td>
                                <span class="badge-rack-pill">
                                    <i class="fa-solid fa-inbox text-secondary" style="font-size: 11px;"></i>
                                    <span>{{ $barang->rack?->nama_rack ?? 'Belum Diatur' }}</span>
                                </span>
                            </td>

                            {{-- Lokasi --}}
                            <td>
                                <span class="text-secondary small d-inline-flex align-items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-danger opacity-75" style="font-size: 11px;"></i>
                                    <span>{{ $barang->rack?->lokasi ?? '-' }}</span>
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td class="text-center pe-3">
                                <div class="d-inline-flex align-items-center gap-1.5">

                                    {{-- Tombol Ambil (semua user yang login) --}}
                                    @if ($barang->stock > 0)
                                        <a href="{{ route('pengurangan.create', $barang->id_barang) }}"
                                            class="btn-action-take"
                                            title="Ambil Suku Cadang">
                                            <i class="fa-solid fa-hand-holding-box"></i>
                                            <span>Ambil</span>
                                        </a>
                                    @else
                                        <button class="btn btn-light btn-sm d-inline-flex align-items-center gap-1 px-2 py-1 text-muted border"
                                            disabled title="Stok habis (0 unit)" style="font-size: 11.5px;">
                                            <i class="fa-solid fa-ban text-danger"></i>
                                            <span>Habis</span>
                                        </button>
                                    @endif

                                    {{-- Tombol Edit & Hapus (khusus Admin) --}}
                                    @if (auth()->user()->isAdmin())
                                        <a href="{{ route('barang.edit', $barang->id_barang) }}"
                                            class="btn-action-edit"
                                            title="Edit Data Barang">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span>Edit</span>
                                        </a>
                                        <form action="{{ route('barang.destroy', $barang->id_barang) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang \'{{ addslashes($barang->nama_barang) }}\'?');"
                                            class="d-inline m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-action-delete border-0"
                                                type="submit" title="Hapus Data Barang">
                                                <i class="fa-solid fa-trash-can"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-0">
                                <div class="table-empty-box">
                                    <div class="table-empty-icon">
                                        <i class="fa-solid fa-box-open"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">Belum Ada Data Suku Cadang</h6>
                                    <p class="text-secondary small mb-3">Katalog inventaris suku cadang masih belum memiliki data.</p>
                                    @if (auth()->user()->isAdmin())
                                        <a href="{{ route('barang.create') }}" class="btn btn-primary btn-sm px-3.5 py-2 fw-semibold">
                                            <i class="fa-solid fa-plus me-1"></i> Tambah Barang Pertama
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Legenda --}}
        <div class="card-footer d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 small text-secondary">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <span class="fw-bold text-dark">Status Stok:</span>
                <span class="d-inline-flex align-items-center gap-1.5">
                    <span class="badge-stock badge-stock-safe" style="padding: 2px 8px; font-size: 11px;">Aman</span>
                    <span>&gt; 10 unit</span>
                </span>
                <span class="d-inline-flex align-items-center gap-1.5">
                    <span class="badge-stock badge-stock-warning" style="padding: 2px 8px; font-size: 11px;">Menipis</span>
                    <span>1 - 10 unit</span>
                </span>
                <span class="d-inline-flex align-items-center gap-1.5">
                    <span class="badge-stock badge-stock-danger" style="padding: 2px 8px; font-size: 11px;">Habis</span>
                    <span>0 unit</span>
                </span>
            </div>
            <div class="text-muted d-flex align-items-center gap-1.5">
                <i class="fa-solid fa-circle-check text-success"></i>
                <span>Database Sinkronisasi Realtime</span>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Pencarian instan di tabel barang
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('tableSearchInput');
        const tableRows   = document.querySelectorAll('#inventoryTable tbody tr.inventory-row');
        const counter     = document.getElementById('activeRowCount');

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
                    counter.textContent = visible + ' Item';
                }
            });
        }
    });
</script>
@endpush

{{-- filepath: resources/views/Rack/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Titik Rak - Mechanic Engineer Inventory | PT Garuda Yamato Steel')

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
        <li class="active">Manajemen Titik Rak</li>
    </ul>

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="page-title">Manajemen Titik Rak Penyimpanan</h1>
            <p class="page-subtitle">Katalog penomoran rak dan zonasi area penyimpanan suku cadang workshop mekanik.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('barang.index') }}"
                class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 px-3.5 py-2 fw-semibold shadow-sm"
                style="font-size: 13px;">
                <i class="fa-solid fa-boxes-stacked text-primary"></i>
                <span>Katalog Barang</span>
            </a>
            @if (auth()->user()->isAdmin())
                <a href="{{ route('rack.create') }}"
                    class="btn btn-primary d-inline-flex align-items-center gap-2 px-3.5 py-2 fw-semibold shadow-sm"
                    style="font-size: 13px;">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah Rak Baru</span>
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

    {{-- Tabel Data Rak --}}
    <div class="card main-data-card">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div class="search-gys-wrapper">
                <i class="fa-solid fa-magnifying-glass search-gys-icon"></i>
                <input type="text" id="rackSearchInput" class="search-gys-input"
                    placeholder="Cari nama rak atau lokasi area..." aria-label="Cari Titik Rak">
            </div>
            <div class="d-flex align-items-center gap-2 small text-secondary">
                <span class="fw-medium">Total Titik Rak:</span>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-bold px-2.5 py-1 rounded-pill" id="rackRowCount">
                    {{ $racks->count() }} Rak Aktif
                </span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table-gys align-middle mb-0" id="rackTable">
                <thead>
                    <tr>
                        <th class="ps-3 text-center" style="width: 55px;">No</th>
                        <th>Kode / Nama Titik Rak</th>
                        <th>Lokasi / Zonasi Workshop</th>
                        <th style="width: 200px;">Barang Tersimpan</th>
                        @if (auth()->user()->isAdmin())
                            <th class="text-center pe-3" style="width: 170px;">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($racks as $index => $rack)
                        <tr class="rack-row">
                            <td class="ps-3 text-center text-muted fw-bold" style="font-size: 12px;">{{ $index + 1 }}</td>

                            {{-- Nama Rak --}}
                            <td>
                                <div class="d-flex align-items-center gap-2.5">
                                    <div class="item-icon-box" style="width: 34px; height: 34px; background-color: #faf5ff; color: #7e22ce; border: none;">
                                        <i class="fa-solid fa-warehouse" style="font-size: 13px;"></i>
                                    </div>
                                    <div>
                                        <div class="item-title">{{ $rack->nama_rack }}</div>
                                        <span class="text-muted font-monospace" style="font-size: 11px;">#ID-{{ $rack->id_rack }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- Lokasi --}}
                            <td>
                                <span class="text-secondary small d-inline-flex align-items-center gap-1.5 fw-medium">
                                    <i class="fa-solid fa-location-dot text-danger opacity-75" style="font-size: 11.5px;"></i>
                                    <span>{{ $rack->lokasi ?: 'Belum diatur' }}</span>
                                </span>
                            </td>

                            {{-- Jumlah Barang --}}
                            <td>
                                @if ($rack->barangs_count > 0)
                                    <span class="badge-stock badge-stock-safe" style="font-size: 12px;">
                                        <i class="fa-solid fa-boxes-stacked me-1" style="font-size: 10px;"></i>
                                        {{ $rack->barangs_count }} Jenis Part
                                    </span>
                                @else
                                    <span class="badge bg-light text-secondary border px-2.5 py-1 rounded-pill" style="font-size: 11px;">
                                        Kosong (0 Part)
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi (Admin only) --}}
                            @if (auth()->user()->isAdmin())
                                <td class="text-center pe-3">
                                    <div class="d-inline-flex align-items-center gap-1.5">
                                        <a href="{{ route('rack.edit', $rack->id_rack) }}"
                                            class="btn-action-edit"
                                            title="Edit Titik Rak">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span>Edit</span>
                                        </a>
                                        <form action="{{ route('rack.destroy', $rack->id_rack) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus rak \'{{ addslashes($rack->nama_rack) }}\'?');"
                                            class="d-inline m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-action-delete border-0"
                                                type="submit" title="{{ $rack->barangs_count > 0 ? 'Tidak bisa dihapus: masih ada barang di rak ini' : 'Hapus Titik Rak' }}"
                                                {{ $rack->barangs_count > 0 ? 'disabled style="opacity: 0.5; cursor: not-allowed;"' : '' }}>
                                                <i class="fa-solid fa-trash-can"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isAdmin() ? 5 : 4 }}" class="p-0">
                                <div class="table-empty-box">
                                    <div class="table-empty-icon">
                                        <i class="fa-solid fa-warehouse"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">Belum Ada Titik Rak</h6>
                                    <p class="text-secondary small mb-3">Data titik rak penyimpanan workshop masih kosong.</p>
                                    @if (auth()->user()->isAdmin())
                                        <a href="{{ route('rack.create') }}" class="btn btn-primary btn-sm px-3.5 py-2 fw-semibold">
                                            <i class="fa-solid fa-plus me-1"></i> Tambah Rak Pertama
                                        </a>
                                    @endif
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
    // Pencarian instan di tabel rak
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('rackSearchInput');
        const tableRows   = document.querySelectorAll('#rackTable tbody tr.rack-row');
        const counter     = document.getElementById('rackRowCount');

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
                    counter.textContent = visible + ' Rak Aktif';
                }
            });
        }
    });
</script>
@endpush

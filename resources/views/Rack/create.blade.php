{{-- filepath: resources/views/Rack/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Titik Rak - Mechanic Engineer Inventory | PT Garuda Yamato Steel')

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
        <li><a href="{{ route('rack.index') }}">Manajemen Titik Rak</a></li>
        <li class="separator"><i class="fa-solid fa-chevron-right"></i></li>
        <li class="active">Tambah Titik Rak</li>
    </ul>

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="page-title">Tambah Titik Rak Penyimpanan</h1>
            <p class="page-subtitle">Daftarkan kode atau nama rak fisik baru beserta zonasi area gudang workshop mekanik.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('rack.index') }}"
                class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 px-3.5 py-2 fw-semibold shadow-sm"
                style="font-size: 13px;">
                <i class="fa-solid fa-layer-group text-primary"></i>
                <span>Daftar Rak</span>
            </a>
            <a href="{{ route('barang.index') }}"
                class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 px-3.5 py-2 fw-semibold shadow-sm"
                style="font-size: 13px;">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Katalog Barang</span>
            </a>
        </div>
    </div>

    {{-- Validasi Error --}}
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-start gap-3 mb-4 p-3 rounded-3" role="alert">
            <i class="fa-solid fa-circle-exclamation fs-5 text-danger mt-0.5"></i>
            <div class="flex-grow-1">
                <div class="fw-bold mb-1 text-dark" style="font-size: 13.5px;">Terdapat kesalahan pada isian formulir:</div>
                <ul class="mb-0 ps-3 small text-danger fw-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="row g-4">

        {{-- Kolom Kiri: Formulir Tambah Rak --}}
        <div class="col-lg-7">
            <div class="card form-card-clean">
                <div class="card-header bg-white p-3.5 border-bottom d-flex align-items-center gap-3">
                    <div class="item-icon-box" style="width: 38px; height: 38px; background-color: #faf5ff; color: #7e22ce; border: none;">
                        <i class="fa-solid fa-warehouse fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Formulir Titik Rak Baru</h6>
                        <span class="text-muted small">Tambahkan nomor dan area fisik rak workshop.</span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('rack.store') }}" method="POST">
                        @csrf

                        {{-- Nama Rak --}}
                        <div class="mb-4">
                            <label for="nama_rack" class="form-label-gys">
                                <span>Nama / Kode Rak <span class="text-danger">*</span></span>
                            </label>
                            <div class="input-group">
                                <span class="input-icon-box"><i class="fa-solid fa-inbox"></i></span>
                                <input type="text"
                                    class="form-control form-control-custom @error('nama_rack') is-invalid @enderror"
                                    id="nama_rack" name="nama_rack" value="{{ old('nama_rack') }}"
                                    placeholder="Contoh: RAK BEARING A1 / RAK VALVE HYDRAULIC"
                                    required autofocus>
                            </div>
                            @error('nama_rack')
                                <div class="text-danger small mt-1.5 fw-medium">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $message }}
                                </div>
                            @else
                                <div class="form-hint">
                                    Gunakan nama atau label yang terpasang fisik di rak workshop.
                                </div>
                            @enderror
                        </div>

                        {{-- Lokasi Gudang --}}
                        <div class="mb-4">
                            <label for="lokasi" class="form-label-gys">
                                <span>Lokasi Gudang / Zonasi Workshop <span class="text-danger">*</span></span>
                            </label>
                            <div class="input-group">
                                <span class="input-icon-box"><i class="fa-solid fa-location-dot"></i></span>
                                <input type="text"
                                    class="form-control form-control-custom @error('lokasi') is-invalid @enderror"
                                    id="lokasi" name="lokasi" value="{{ old('lokasi') }}"
                                    placeholder="Contoh: Area Barat Zona A1 / Lantai 2 Workshop Mekanik"
                                    required>
                            </div>
                            @error('lokasi')
                                <div class="text-danger small mt-1.5 fw-medium">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $message }}
                                </div>
                            @else
                                <div class="form-hint">
                                    Penjelasan lokasi mempermudah pencarian suku cadang darurat di lapangan.
                                </div>
                            @enderror
                        </div>

                        <hr class="my-4 border-light-subtle">

                        {{-- Tombol Aksi --}}
                        <div class="d-flex flex-column-reverse flex-sm-row justify-content-between align-items-center gap-3">
                            <a href="{{ route('rack.index') }}"
                                class="btn btn-outline-secondary px-4 py-2 fw-semibold w-100 w-sm-auto" style="font-size: 13px;">
                                <i class="fa-solid fa-xmark me-1"></i> Batal
                            </a>
                            <button type="submit"
                                class="btn btn-primary px-4 py-2.5 fw-bold shadow-sm w-100 w-sm-auto d-inline-flex align-items-center justify-content-center gap-2"
                                style="font-size: 13px;">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span>Simpan Titik Rak</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Daftar Rak yang Sudah Terdaftar --}}
        <div class="col-lg-5">
            <div class="card form-card-clean">
                <div class="card-header bg-white p-3 border-bottom d-flex align-items-center justify-content-between">
                    <span class="fw-bold text-dark small d-inline-flex align-items-center gap-2">
                        <i class="fa-solid fa-layer-group text-primary"></i>
                        <span>Rak Terdaftar Saat Ini</span>
                    </span>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-bold px-2 py-1">
                        {{ $existingRacks->count() }} Rak
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush small" style="max-height: 380px; overflow-y: auto;">
                        @forelse ($existingRacks as $rack)
                            <div class="list-group-item px-3 py-2.5 d-flex align-items-center justify-content-between border-bottom">
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 12.5px;">{{ $rack->nama_rack }}</div>
                                    <div class="text-muted" style="font-size: 11px;">
                                        <i class="fa-solid fa-location-dot text-danger opacity-75 me-1"></i>
                                        Area: {{ $rack->lokasi ?: 'Lokasi belum diisi' }}
                                    </div>
                                </div>
                                <span class="badge bg-light text-secondary border font-monospace" style="font-size: 10.5px;">
                                    #ID-{{ $rack->id_rack }}
                                </span>
                            </div>
                        @empty
                            <div class="p-4 text-center text-muted">
                                <i class="fa-solid fa-warehouse fs-4 mb-2 d-block opacity-50"></i>
                                <span>Belum ada rak terdaftar di sistem.</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
